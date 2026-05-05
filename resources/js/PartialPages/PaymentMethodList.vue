<template>
    <Modal
        title="Lista de pagamentos"
        id="modal-show-payment-methods-list"
        ref="modal_payment_methods_list"
    >
        <!-- TABELA -->
        <div class="relative overflow-y-auto max-h-100">
            <table
                class="w-full text-sm text-left rtl:text-right text-gray-500 border border-gray-200 dark:text-gray-400"
                v-if="!isLoading"
            >
                <thead
                    class="sticky top-0 z-10 text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"
                >
                    <tr>
                        <th scope="col" class="px-6 py-3">Método</th>
                        <th scope="col" class="px-6 py-3">Valor</th>
                        <th scope="col" class="px-6 py-3"></th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        class="uppercase bg-white border-b border border-gray-200 dark:bg-gray-800 dark:border-gray-700"
                        v-if="list_payment_methods_list"
                        v-for="value in list_payment_methods_list"
                    >
                        <td class="px-6 py-4">
                            {{ value.payment_method.name }}
                        </td>
                        <td class="px-6 py-4">
                            {{ formatMoneyBr(value.value_paid) }}
                        </td>

                        <!-- <td class="px-6 py-4">
                            <Button
                                text="Excluir"
                                type="button"
                                typeButton="red"
                                class="relative top-1.5 self-end"
                                @click.prevent="_removePaymentMethod(index)"
                            ></Button>
                        </td> -->
                    </tr>
                </tbody>
            </table>
            <h2 v-else class="text-4xl">Carregando...</h2>
        </div>

        <!-- FIM TABELA -->
        <!-- DADOS DE VALOR E REFERÊNCIA -->
        <div>
            <ul>
                <li>
                    <span class="font-medium">Total / Mensalidade = Troco -> </span>
                    {{ `${formatMoneyBr(cashData.sumValues)} - ${props.dataModal.amount_paid_formated} = ${formatMoneyBr(cashData.value_cash)}` }}
                </li>
                <li>
                    <span class="font-medium">Empresa:</span>
                    {{ props.dataModal.company_name }}
                </li>
                <li>
                    <span class="font-medium">Data(mês) referente:</span>
                    {{
                        _dateISOBrOnlyData(
                            props.dataModal.historic_company_pay_date,
                        )
                    }}
                </li>
            </ul>
        </div>
        <!-- FIM DADOS DE VALOR E REFERÊNCIA -->
    </Modal>
</template>
<script setup>
import { onMounted, reactive, ref, watch } from "vue";
import { useForm, usePage, router } from "@inertiajs/vue3";
import { route } from "ziggy-js";
import {
    formatMoneyBr,
    moneyBrToNumber,
    _dateISOBrOnlyData,
    objectIsEmpty,
} from "@utils/functions";
import Modal from "@/components/Modal.vue";
import Button from "@/components/Button.vue";
import Input from "@/components/Input.vue";

const isLoading = ref(false);

const defaultCashData = () => ({
    cashBack: 0,
    sumValues: 0,
    value_cash: 0,
    showCashBack: false
});

const cashData = reactive(defaultCashData());

const props = defineProps({
    dataModal: {
        type: Object,
        required: true,
    },
});
const modal_payment_methods_list = ref(null);

const list_payment_methods_list = ref({});


function _cashBack(value) {
    let value_paid = props.dataModal.amount_paid; //já esta formatado
    if (value > value_paid) {
        cashData.showCashBack = true;
        cashData.value_cash = value - value_paid;
    } else {
        cashData.showCashBack = false;
        cashData.value = 0;
    }
}

function _sumValues(value) {
    cashData.sumValues += value;
}

function _loadData() {
    Object.assign(cashData, defaultCashData());
    list_payment_methods_list.value = null;
    isLoading.value = true;
    axios({
        method: "GET",
        url: route("historic_company.getMethodsPaymentByMonth"),
        params: {
            historic_company_id: props.dataModal.historic_company_id,
        },
    })
        .then((response) => {
            let data = response.data;
            list_payment_methods_list.value = data;
            list_payment_methods_list.value.forEach(element => {
                _sumValues(parseFloat(element.value_paid));
            });
        })
        .finally(function () {
            isLoading.value = false;
            console.log(cashData.sumValues);
            _cashBack(cashData.sumValues);
        });
}

watch(
    () => props.dataModal,
    (new_value) => {
        _loadData();
    },
    { deep: true },
);

defineExpose({
    modal_payment_methods_list,
});

onMounted(() => {});
</script>
