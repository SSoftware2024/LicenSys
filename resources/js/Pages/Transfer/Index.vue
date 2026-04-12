<template>
    <Head title="Empresas" />
    <h2 class="font-bold text-2xl underline mb-2">Transferências</h2>
    <div>
        <!-- FILTERS -->
        <div class="xl:w-250"></div>

        <!-- END FILTERS -->
        <!-- TABLE -->
        <div class="relative overflow-x-auto">
            <table
                :class="{
                    'w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400': true,
                    'mb-80': isShowDropDown,
                }"
            >
                <thead
                    class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"
                >
                    <tr>
                        <th scope="col" class="px-6 py-3">Empresa</th>
                        <th scope="col" class="px-6 py-3">Valor</th>
                        <th scope="col" class="px-6 py-3">Enviado</th>
                        <th scope="col" class="px-6 py-3">Comprovante</th>
                        <th scope="col" class="px-6 py-3">Mês referente</th>
                        <th scope="col" class="px-6 py-3">Status</th>
                        <th scope="col" class="px-6 py-3">Enviado</th>
                        <th scope="col" class="px-6 py-3">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200"
                        v-if="$page.props.transfers"
                        v-for="value in $page.props.transfers"
                    >
                        <th
                            scope="row"
                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                        >
                            {{ value.company.company_name }}
                        </th>
                        <td class="px-6 py-4">
                            {{
                                formatMoneyBr(
                                    value.historic_company.amount_paid,
                                )
                            }}
                        </td>
                        <td class="px-6 py-4">{{ value.pix_origin_name }}</td>
                        <td class="px-6 py-4 text-blue-600 underline">
                            <a
                                href="#"
                                @click.prevent="_openStatment(value.id)"
                                >CLIQUE AQUI</a
                            >
                        </td>
                        <!-- <td class="px-6 py-4">{{ value.pix_receipt_photo }}</td> -->
                        <td class="px-6 py-4">
                            {{
                                _dateISOBrOnlyData(
                                    value.historic_company.pay_date,
                                )
                            }}
                        </td>
                        <td class="px-6 py-4">
                            <span
                                class="inline-flex items-center rounded-md bg-red-50 px-2 py-1 text-xs font-medium text-red-700 ring-1 ring-red-600/20 ring-inset"
                                v-if="
                                    value.historic_company.monthly_fee_status ==
                                    'pay'
                                "
                                >PAGAR</span
                            >
                            <span
                                class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-green-600/10 ring-inset"
                                v-else-if="
                                    value.historic_company.monthly_fee_status ==
                                    'paid'
                                "
                                >PAGO</span
                            >
                            <span
                                class="inline-flex items-center rounded-md bg-yellow-50 px-2 py-1 text-xs font-medium text-yellow-700 ring-1 ring-yellow-600/10 ring-inset"
                                v-else-if="
                                    value.historic_company.monthly_fee_status ==
                                    'late'
                                "
                                >ATRASADO</span
                            >
                            <span
                                class="inline-flex items-center rounded-md bg-purple-200 px-2 py-1 text-xs font-medium text-purple-700 ring-1 ring-purple-600/10 ring-inset"
                                v-else-if="
                                    value.historic_company.monthly_fee_status ==
                                    'overdue'
                                "
                                >VENCIDA</span
                            >
                        </td>
                        <td class="px-6 py-4">
                            {{ _dateISOBrOnlyData(value.created_at) }}
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
                                class="z-10 hidden fixed bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-44 dark:bg-gray-700 dark:divide-gray-600 uppercase"
                            >
                                <ul
                                    class="py-2 text-sm text-gray-700 dark:text-gray-200"
                                    aria-labelledby="dropdownMenuIconButton"
                                >
                                    <li>
                                        <a
                                            href="#"
                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
                                        >
                                            Baixa
                                        </a>
                                    </li>
                                </ul>
                                <div class="py-2">
                                    <a
                                        class="block px-4 py-2 text-sm text-red-600 font-bold hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white"
                                        >Remover</a
                                    >
                                </div>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <!-- END TABLE -->
    </div>
</template>

<script setup>
import { onMounted, onUnmounted, ref } from "vue";
import { route } from "ziggy-js";
import { router, usePage } from "@inertiajs/vue3";
import {
    formatMoneyBr,
    moneyBrToNumber,
    _dateISOBrOnlyData,
} from "@utils/functions";
import SidebarLayout from "@/layouts/SidebarLayout.vue";
import Button from "@/components/Button.vue";

const page = usePage();

const isShowDropDown = ref(false);

function _delete(id) {}

function _showDropDown() {
    isShowDropDown.value = true;
}

function _openStatment(id) {
    axios({
        method: "GET",
        url: route("transfer.pixReceiptPhotoUrl"),
        params: {
            id: id,
        },
    }).then((result) => {
        window.open(result.data.statement_url);
    });
}

function handleClickOutside(event) {
    // Fecha o dropdown se clicar fora de qualquer elemento com ID dropdownDots e dropdownMenuIconButton...
    if (
        !event.target.closest("[id^='dropdownDots']") &&
        !event.target.closest("#dropdownMenuIconButton")
    ) {
        isShowDropDown.value = false;
    }
}

onMounted(() => {
    document.addEventListener("click", handleClickOutside);
});

onUnmounted(() => {
    document.removeEventListener("click", handleClickOutside);
});

defineOptions({
    layout: SidebarLayout,
});
</script>
