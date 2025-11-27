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
                        v-model="form.company_uuid"
                    >
                        <option value="empty">❌</option>
                        <option
                            :value="value.uuid"
                            v-for="(value, key, index) in $page.props.companies"
                            :key="index"
                            style="text-transform: uppercase"
                            :selected="form.company_uuid == value.uuid"
                        >
                            {{ `${value.company_name} - ${value.uuid}` }}
                        </option>
                    </select>
                    <div
                        v-if="form.errors.company_uuid"
                        class="text-red-500"
                    >
                        {{ form.errors.company_uuid }}
                    </div>
                </div>
                <div class="mr-2">
                <Input
                        type="number"
                        min="0"
                        max="12"
                        label="Mês"
                        id="month"
                        name="month"
                        v-model="form.month"
                    />
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
                        <option value="all" selected>TODOS</option>
                        <option
                            :value="value"
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
                        <option value="all" selected>TODOS</option>
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
        <div class="relative overflow-x-auto" v-if="isShowTable">
            <table
                :class="{
                    'w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400': true,
                    'mb-80':isShowDropDown,
                }"
            >
                <thead
                    class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"
                >
                    <tr>
                        <th scope="col" class="px-6 py-3">Empresa</th>
                        <th scope="col" class="px-6 py-3">Data pagamento</th>
                        <th scope="col" class="px-6 py-3">Data pago</th>
                        <th scope="col" class="px-6 py-3">Valor</th>
                        <th scope="col" class="px-6 py-3">Status</th>
                        <th scope="col" class="px-6 py-3">Ações</th>
                    </tr>
                </thead>
                <tbody>

                    <tr
                        class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200"
                        v-for="(value, index) in $page.props.historicCompany?.data"
                    >
                        <td class="px-6 py-4">{{ value.company.company_name ?? 'NULO' }}</td>

                        <th
                            scope="row"
                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                        >
                            {{ _dateISOBrOnlyData(value.pay_date) }}

                        </th>
                        <td class="px-6 py-4">{{ _dateISOBrOnlyData(value.date_paid) }}</td>

                        <td class="px-6 py-4">{{ value.amount_paid }}</td>
                        <td class="px-6 py-4">
                            <span
                                class="inline-flex items-center rounded-md bg-red-50 px-2 py-1 text-xs font-medium text-red-700 ring-1 ring-red-600/20 ring-inset"
                                v-if="value.monthly_fee_status == 'pay'"
                                >PAGAR</span
                            >
                            <span
                                class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-green-600/10 ring-inset"
                                v-else-if="value.monthly_fee_status == 'paid'"
                                >PAGO</span
                            >
                            <span
                                class="inline-flex items-center rounded-md bg-yellow-50 px-2 py-1 text-xs font-medium text-yellow-700 ring-1 ring-yellow-600/10 ring-inset"
                                v-else-if="value.monthly_fee_status == 'late'"
                                >ATRASADO</span
                            >
                            <span
                                class="inline-flex items-center rounded-md bg-slate-50 px-2 py-1 text-xs font-medium text-slate-700 ring-1 ring-slate-600/10 ring-inset"
                                v-else-if="
                                    value.monthly_fee_status == 'overdue'
                                "
                                >VENCIDA</span
                            >
                        </td>

                        <td class="px-6 py-4">
                            <button
                                id="dropdownMenuIconButton"
                                :data-dropdown-toggle="`dropdownDots${index}`"
                                class="cursor-pointer inline-flex items-center p-2 text-sm font-medium text-center text-gray-900 bg-white rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none dark:text-white focus:ring-gray-50 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
                                type="button"
                                @click="_showDropDown"
                            >
                                <svg
                                    class="w-5 h-5"
                                    aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="currentColor"
                                    viewBox="0 0 4 15"
                                >
                                    <path
                                        d="M3.5 1.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 6.041a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 5.959a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z"
                                    />
                                </svg>
                            </button>

                            <!-- Dropdown menu -->
                            <div
                                :id="`dropdownDots${index}`"
                                class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-44 dark:bg-gray-700 dark:divide-gray-600 uppercase"

                            >
                                <ul
                                    class="py-2 text-sm text-gray-700 dark:text-gray-200"
                                    aria-labelledby="dropdownMenuIconButton"
                                >
                                    <li>
                                        <a
                                            href="#"
                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
                                           @click="_pay(value.id)"
                                        >
                                            Pagar
                                        </a>
                                    </li>
                                    <li>
                                        <a
                                            href="#"
                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
                                             @click="_removePayment(value.id)"
                                        >
                                            Remover pagamento
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <!-- END TABLE -->
        <!-- ACTIONS -->
        <Paginate
            :pagination="$page.props.historicCompany"
            :onEachSize="3"
            @paginate="paginate"
            v-if="$page.props.historicCompany"
        ></Paginate>
        <!-- END ACTIONS -->
    </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from "vue";
import { router, usePage, useForm } from "@inertiajs/vue3";
import { _copyText, _dateISOBrOnlyData, _confirmPassword} from "@utils/functions";
import { route } from "ziggy-js";
import SidebarLayout from "@/layouts/SidebarLayout.vue";
import Button from "@/components/Button.vue";
import Input from "@/components/Input.vue";
import Paginate from "@/components/Paginate.vue";


const isShowTable = ref(false);
const isShowDropDown = ref(false);

const page = usePage();

const form = useForm({
    company_uuid: page.props.company_uuid,
    year: page.props.year,
    month_status: page.props.month_status,
    month: page.props.month
});

function _showDropDown(){
    isShowDropDown.value = true;
}
function handleClickOutside(event) {
    // Fecha o dropdown se clicar fora de qualquer elemento com ID dropdownDots e dropdownMenuIconButton...
    if (!event.target.closest("[id^='dropdownDots']") && !event.target.closest("#dropdownMenuIconButton")) {
        isShowDropDown.value = false;
    }
}

function _showTableHistoricCompany() {
    form.transform((data) => ({
        ...data,
        company_uuid: form.company_uuid ? form.company_uuid : _getUUIDURLParam(),
    })).get(route("historic_company"), {
        onSuccess: () => {
            isShowTable.value = true;
        },
        onError: () => {
            isShowTable.value = false;
        },
        preserveState:true,
    });
}

function _getUUIDURLParam(){
    const url = new URL(window.location.href);
    let uuid = url.searchParams.get("company_uuid")
    return uuid;
}

function _filterCompanyByUrlUUID(){
    let uuid = _getUUIDURLParam();
    if(uuid){
        form.company_uuid = uuid;
        _showTableHistoricCompany();
    }
}

function _pay(historic_company_id){
    router.patch(route('historic_company.pay'), {
        historic_company_id: historic_company_id,
    },{
        // onSuccess: () => {
        //     _showTableHistoricCompany();
        // },
    });

}
function _removePayment(historic_company_id){
    router.patch(route('historic_company.removePayment'), {
        historic_company_id: historic_company_id,
    },{
        // onSuccess: () => {
        //     _showTableHistoricCompany();
        // },
    });

}

function paginate(page_link) {
    router.get(
        page.url,
        {
            page: page_link,
        },
        {
            preserveState: true,
        }
    );
}


onMounted(() => {
    document.addEventListener("click", handleClickOutside);
    _filterCompanyByUrlUUID();
});

onUnmounted(() => {
    document.removeEventListener("click", handleClickOutside);
});

defineOptions({
    layout: SidebarLayout,
});
</script>
