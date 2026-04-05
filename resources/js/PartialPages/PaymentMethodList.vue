<template>
    <Modal
        title="Métodos de pagamento"
        id="modal-show-payment-methods-list"
        ref="modal_payment_methods_list"
        :closeClearCallback="closeCallback"
    >
        <!-- TABELA -->
        <div class="relative overflow-y-auto max-h-100">
            <table
                class="w-full text-sm text-left rtl:text-right text-gray-500 border border-gray-200 dark:text-gray-400"
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
                        <td class="px-6 py-4">teste</td>
                        <td class="px-6 py-4">teste</td>
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
        </div>

        <!-- FIM TABELA -->
        <!-- DADOS DE VALOR E REFERÊNCIA -->
        <div>
            <ul>
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
        <div>
            <!-- <h2 class="text-right text-blue-700 text-3xl">
                R$ {{ formatMoneyBr(list_values.all_value) }} |
                <span class="text-black">R$ {{ total_value_formated }}</span>
            </h2>
            <h2
                class="text-right text-green-700 text-xl"
                v-if="cashBackData.showCashBack"
            >
                Troco: R$ {{ formatMoneyBr(cashBackData.value) }}
            </h2> -->
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

const props = defineProps({
    dataModal: {
        type: Object,
        required: true,
    },
});
const modal_payment_methods_list = ref(null);

const list_payment_methods_list = ref({});

const cashBackData = reactive({
    showCashBack: false,
    value: 0,
});

function _cashBack(value) {}

function _sumValues(value) {}

function _loadData() {
    axios({
        method: "GET",
        url: route("historic_company.getMethodsPaymentByMonth"),
        params: {
            historic_company_id: props.dataModal.historic_company_id,
        },
    })
        .then((response) => {
            let data = response.data;
            console.log(response);
        })
        .catch((error) => {
            console.log(error);
        });
}

function closeCallback() {
    // list_values.payment_method_insert = null;
    // list_values.value = null;
    // list_values.all_value = 0;
    // list_all.value = [];
    // page.props.errors = {};
    // _cashBack(list_values.all_value);
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
