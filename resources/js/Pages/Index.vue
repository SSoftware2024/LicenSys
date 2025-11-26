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
                >
                    <h5 class="text-white text-2xl">PAGAR</h5>
                    <h1 class="text-white text-6xl">{{ $page.props.monthly_fee_status_count.pay }}</h1>
                </div>
                <!-- FIM CARD 01 -->
                <!-- CARD 02 -->
                <div
                    class="flex flex-col items-center w-50 p-5 rounded-md bg-green-700 cursor-pointer hover:bg-green-800"
                >
                    <h5 class="text-white text-2xl">PAGA</h5>
                    <h1 class="text-white text-6xl">{{ $page.props.monthly_fee_status_count.paid }}</h1>
                </div>
                <!-- FIM CARD 02 -->
                <!-- CARD 03 -->
                <div
                    class="flex flex-col items-center w-50 p-5 rounded-md bg-yellow-500 cursor-pointer hover:bg-yellow-600"
                >
                    <h5 class="text-white text-2xl">ATRASADA</h5>
                    <h1 class="text-white text-6xl">{{ $page.props.monthly_fee_status_count.late }}</h1>
                </div>
                <!-- FIM CARD 03 -->
                <!-- CARD 04 -->
                <div
                    class="flex flex-col items-center w-50 p-5 rounded-md bg-slate-700 cursor-pointer hover:bg-slate-800"
                >
                    <h5 class="text-white text-2xl">VENCIDA</h5>
                    <h1 class="text-white text-6xl">{{ $page.props.monthly_fee_status_count.overdue }}</h1>
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
                            class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200 cursor-pointer hover:bg-gray-100"
                            v-for="(value, index) in $page.props.array_days_max_values"
                            :key="value"
                        >
                            <th
                                scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                            >
                               {{ index }}
                            </th>
                            <td class="px-6 py-4">{{ value }}</td>

                        </tr>
                    </tbody>
                </table>
            </div>
            <div>
            <h3 class="text-md"><span class="text-blue-600 font-medium">Recebido/Total:</span> <span class="font-bold">R$ {{ $page.props.total_recieve }} | {{ $page.props.total_value }}</span></h3>
            </div>
        </div>
        <!-- FIM TABELA DIAS RECEBER -->
    </div>
</template>

<script setup>
import { ref } from "vue";
import { useForm, router } from "@inertiajs/vue3";
import { route } from "ziggy-js";
import SidebarLayout from "../layouts/SidebarLayout.vue";
import Input from "@/components/Input.vue";
import Button from "@/components/Button.vue";

const form = useForm({
    date_month: new Date().toISOString().slice(0, 7), //pega só até primeiro hífen YYYY-MM
});

function _filter() {
    // lógica para filtrar o dashboard com base na data selecionada
    router.get(route("index"),{
        date_month: form.date_month,
    }, {
        preserveState: true,
    });
}

defineOptions({
    layout: SidebarLayout,
});
</script>
