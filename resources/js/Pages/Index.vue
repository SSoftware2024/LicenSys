<template>
    <Head title="Index" />
    <div>
        <!-- FILTRO CENTRAL DASHBOARD -->
        <div class="xl:w-200">
            <form @submit.prevent="_filter" class="flex items-end">
                <div class="grow">
                    <Input
                        type="month"
                        label="Data do dashboard"
                        id="value_monthly_fee"
                        v-model="form.date_month"
                    />
                </div>

                <div class="grow-1">
                    <Button
                        text="APLICAR"
                        type="submit"
                        typeButton="primary"
                        class="ml-3"
                    ></Button>
                </div>
            </form>
        </div>

        <!-- FIM FILTRO CENTRAL DASHBOARD -->

        <!-- CARDS -->
        <div class="mt-3">
            <div>
                <h3 class="text-xl">Quantidade de empresas, situação:</h3>
            </div>
            <div class="flex flex-row gap-1">
                <!-- CARD 01 -->
                <div
                    class="flex flex-col items-center w-50 p-5 rounded-md bg-red-700 cursor-pointer hover:bg-red-800"
                    @click.prevent="_linkCards('pay')"
                >
                    <h5 class="text-white text-2xl">PAGAR</h5>
                    <h1 class="text-white text-6xl">
                        {{ $page.props.monthly_fee_status_count.pay }}
                    </h1>
                </div>
                <!-- FIM CARD 01 -->
                <!-- CARD 02 -->
                <div
                    class="flex flex-col items-center w-50 p-5 rounded-md bg-green-700 cursor-pointer hover:bg-green-800"
                    @click.prevent="_linkCards('paid')"
                >
                    <h5 class="text-white text-2xl">PAGA</h5>
                    <h1 class="text-white text-6xl">
                        {{ $page.props.monthly_fee_status_count.paid }}
                    </h1>
                </div>
                <!-- FIM CARD 02 -->
                <!-- CARD 03 -->
                <div
                    class="flex flex-col items-center w-50 p-5 rounded-md bg-yellow-500 cursor-pointer hover:bg-yellow-600"
                    @click.prevent="_linkCards('late')"
                >
                    <h5 class="text-white text-2xl">ATRASADA</h5>
                    <h1 class="text-white text-6xl">
                        {{ $page.props.monthly_fee_status_count.late }}
                    </h1>
                </div>
                <!-- FIM CARD 03 -->
                <!-- CARD 04 -->
                <div
                    class="flex flex-col items-center w-50 p-5 rounded-md bg-slate-700 cursor-pointer hover:bg-slate-800"
                    @click.prevent="_linkCards('overdue')"
                >
                    <h5 class="text-white text-2xl">VENCIDA</h5>
                    <h1 class="text-white text-6xl">
                        {{ $page.props.monthly_fee_status_count.overdue }}
                    </h1>
                </div>
                <!-- FIM CARD 04 -->
            </div>
        </div>
        <!-- FIM CARDS -->

        <!-- TABELA DIAS RECEBER -->
        <div class="mt-3">
            <div>
                <h3 class="text-xl">Valor a receber a cada dia, por mês</h3>
            </div>
            <div class="relative overflow-x-auto h-[500px]">
                <table
                    class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400"
                >
                    <thead
                        class="sticky top-0 z-10 text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"
                    >
                        <tr>
                            <th scope="col" class="px-6 py-3">Dia</th>
                            <th scope="col" class="px-6 py-3">Valor</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            :class="{
                                'bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200 cursor-pointer hover:bg-gray-100': true,
                                 '!bg-green-500 font-bold text-white':value.higher_value
                            }"
                            v-for="(value, index) in $page.props
                                .array_days_max_values"
                            :key="value"
                            data-modal-target="modal-company-in-day"
                            data-modal-toggle="modal-company-in-day"
                            @click="_companiesTheDay(index)"
                        >
                            <th
                                scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                            >
                                {{ index }}
                            </th>
                            <td class="px-6 py-4">{{ value.formatted }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div>
                <h3 class="text-md">
                    <span class="text-blue-600 font-medium"
                        >Recebido/Total:</span
                    >
                    <span class="font-bold"
                        >R$ {{ $page.props.total_recieve }} |
                        {{ $page.props.total_value }}</span
                    >
                </h3>
            </div>
        </div>
        <!-- FIM TABELA DIAS RECEBER -->
    </div>

    <Modal :title="`Empresas do dia: ${title_modal}`" id="modal-company-in-day">
        <div class="flex justify-center" v-if="load_table_company_in_day">
            <img :src="$page.props.images.load_gif" alt="" class="w-25" />
        </div>
        <div class="relative overflow-x-auto h-[500px]" v-else>
            <table
                class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400"
            >
                <thead
                    class="sticky top-0 z-10 text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"
                >
                    <tr>
                        <th scope="col" class="px-6 py-3">Nome</th>
                        <th scope="col" class="px-6 py-3">UUID</th>
                        <th scope="col" class="px-6 py-3">Valor</th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200 cursor-pointer hover:bg-gray-100"
                        v-for="(value, index) in $page.props.companies"
                        :key="index"
                        data-modal-target="modal-company-in-day"
                        data-modal-toggle="modal-company-in-day"
                    >
                        <th
                            scope="row"
                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                        >
                            {{ value?.company_name }}
                        </th>
                        <td class="px-6 py-4">
                            <Button
                                text="Copiar UUID"
                                type="button"
                                typeButton="primary"
                                class="relative top-1.5"
                                @click="_copyText(value?.uuid)"
                            ></Button>
                        </td>
                        <td class="px-6 py-4">{{ value?.historic_company?.amount_paid_formated }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <template #footer>
            <button
                data-modal-hide="modal-company-in-day"
                type="button"
                class="cursor-pointer py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700"
            >
                Fechar
            </button>
        </template>
    </Modal>
</template>

<script setup>
import { ref } from "vue";
import { useForm, router, usePage } from "@inertiajs/vue3";
import { route } from "ziggy-js";
import {_copyText} from "@utils/functions.js"
import SidebarLayout from "../layouts/SidebarLayout.vue";
import Input from "@/components/Input.vue";
import Modal from "@/components/Modal.vue";
import Button from "@/components/Button.vue";

const page = usePage();
const form = useForm({
    date_month: page.props.date_month, //pega só até primeiro hífen YYYY-MM
});

const title_modal = ref("");
const load_table_company_in_day = ref(true);

function _filter() {
    // lógica para filtrar o dashboard com base na data selecionada
    router.get(
        route("index"),
        {
            date_month: form.date_month,
        },
        {
            preserveState: true,
        }
    );
}

function _companiesTheDay(day) {
    title_modal.value = day;
    load_table_company_in_day.value = true;
    router.get(
        route("index"),
        {
            companies_the_day: day,
            date_month: form.date_month,
        },
        {
            onSuccess: (page) => {
                load_table_company_in_day.value = false;
            },
            preserveState:true,
        }
    );
}

function _linkCards(month_status) {
    router.get(
        route("historic_company"),
        {
            year: page.props.year,
            month: page.props.month,
            company_uuid: "empty",
            month_status: [month_status],
        },
        {
            preserveState: true,
        }
    );
}



defineOptions({
    layout: SidebarLayout,
});
</script>
