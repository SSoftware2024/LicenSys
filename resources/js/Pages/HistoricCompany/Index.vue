<template>
    <Head title="Mensalidade Empresas" />
    <h2 class="font-bold text-2xl underline mb-2">Mensalidades Empresas</h2>
    <div>
        <!-- FILTERS -->
        <div class="xl:w-250">
            <form
                class="flex flex-row mb-2 items-end"
                @submit.prevent="_showTableHistoricCompany"
            >
                <div class="grow-2 mr-2">
                    <label
                        for="countries"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >Empresas</label
                    >
                    <select
                        id="countries"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        v-model="form.company_id"
                    >
                        <option value="" selected>❌</option>
                        <option
                            :value="value.id"
                            v-for="(value, key, index) in $page.props.companies"
                            :key="index"
                            style="text-transform: uppercase"
                        >
                            {{ `${value.uuid} - ${value.name}` }}
                        </option>
                    </select>
                </div>
                <div class="grow mr-2">
                    <label
                        for="countries"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >Ano</label
                    >
                    <select
                        id="countries"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        v-model="form.year"
                    >
                        <option value="0" selected>TODOS</option>
                        <option
                            :value="key"
                            v-for="(value, key, index) in $page.props.allYears"
                            :key="index"
                            style="text-transform: uppercase"
                        >
                            {{ value }}
                        </option>
                    </select>
                </div>
                <div class="grow-4 mr-2 self-end">
                    <label
                        for="countries"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >STATUS</label
                    >
                    <select
                        id="countries"
                        multiple
                        size="5"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        v-model="form.month_status"
                    >
                        <option value="" selected>TODOS</option>
                        <option
                            :value="key"
                            v-for="(value, key, index) in $page.props
                                .monthly_fee_status"
                            :key="index"
                            style="text-transform: uppercase"
                        >
                            {{ value }}
                        </option>
                    </select>
                </div>
                <div>
                    <Button
                        text="Buscar"
                        type="submit"
                        typeButton="dark"
                        class="relative top-1.5 self-end"
                        :isDisable="form.processing"
                        :isLoading="form.processing"
                    ></Button>
                </div>
            </form>
        </div>
        <!-- END FILTERS -->
        <!-- TABLE -->

        <!-- END TABLE -->
        <!-- ACTIONS -->
        <!-- <Paginate
            :pagination="$page.props.users"
            :onEachSize="3"
            @paginate="paginate"
        ></Paginate> -->
        <!-- END ACTIONS -->
    </div>
</template>

<script setup>
import { router, usePage, useForm } from "@inertiajs/vue3";
import SidebarLayout from "@/layouts/SidebarLayout.vue";
import { route } from "ziggy-js";
import Button from "@/components/Button.vue";
import Modal from "@/components/Modal.vue";
import Paginate from "../../components/Paginate.vue";

const form = useForm({
    company_id: 0,
    year: 0,
    month_status: null,
});

function _showTableHistoricCompany() {
    form.post(route("historic_company.loadHistoric"));
}

defineOptions({
    layout: SidebarLayout,
});
</script>
