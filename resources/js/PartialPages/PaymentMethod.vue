<template>
    <Modal title="Métodos de pagamento" id="modal-show-payment-methods" :closeCallback="closeCallback">
        <form action="" class="flex flex-row mb-2 items-end">
            <div class="grow-14 mr-2">
                <label
                    for="countries"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                    >Métodos</label
                >
                <select
                    id="countries"
                    class="uppercase bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    v-if="list_values.payment_method"
                    v-model="list_values.payment_method_insert"
                >
                    
                    <option
                        v-for="value in list_values.payment_method"
                        :value="value"
                    >
                        {{ value.name }}
                    </option>
                </select>
            </div>
            <div class="grow mr-2">
                <div class="mr-2">
                    <Input
                        type="text"
                        label="Valor (R$)"
                        id="value_monthly_fee"
                        :isInputRequired="true"
                        :isInputMask="true"
                        :maskDecimalBr="2"
                        v-model="list_values.value"
                    />
                    <div
                        v-if="form.errors.value_monthly_fee"
                        class="text-red-500"
                    >
                        {{ form.errors.value_monthly_fee }}
                    </div>
                </div>
            </div>
            <div class="relative top-1 self-center">
                <Button
                    text="Adicionar"
                    type="submit"
                    typeButton="primary"
                    class="relative top-1.5 self-end"
                    @click.prevent="_addPaymentMethod"
                ></Button>
            </div>
        </form>
        <!-- TABELA -->
        <div class="relative overflow-y-auto max-h-100">
            <table
                class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400"
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
                        class="uppercase bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200"
                        v-for="value in list_all"
                        v-if="list_all"
                    >
                        <td class="px-6 py-4">
                            {{ value["payment_method"].name }}
                        </td>
                        <td class="px-6 py-4">{{ value["value"] }}</td>
                        <td class="px-6 py-4">
                            <Button
                                text="Excluir"
                                type="button"
                                typeButton="red"
                                class="relative top-1.5 self-end"
                                @click="_removePaymentMethod(value)"
                            ></Button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- FIM TABELA -->
        <!-- DADOS DE VALOR E REFERÊNCIA -->
        <div>
            <ul>
                <li>
                    <span>Empresa - UUID:</span>
                </li>
                <li>
                    <span>Mês referente:</span>
                </li>
            </ul>
        </div>
        <div>
            <h2 class="text-right text-blue-700 text-3xl">
                R$ 125,99 | <span class="text-black">R$ 125,99</span>
            </h2>
            <h2 class="text-right text-green-700 text-xl">Troco: R$ 125,99</h2>
        </div>
        <!-- FIM DADOS DE VALOR E REFERÊNCIA -->
        <div class="flex justify-end">
            <Button
                text="Pagar"
                type="button"
                typeButton="green"
                class="relative top-1.5 self-end"
            ></Button>
        </div>
        <!-- ALERTA DE ERRO OU EXCEÇÕES -->
        <div
            class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400"
            role="alert"
        >
            <span class="font-medium">Danger alert!</span> Change a few things
            up and try submitting again.
        </div>
        <!-- FIM ALERTA DE ERRO OU EXCEÇÕES -->
        <div></div>
        <template #footer>
            <button
                data-modal-hide="modal-show-payment-methods"
                type="button"
                class="cursor-pointer py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700"
                @click.prevent="closeCallback"
                >
                Fechar
            </button>
        </template>
    </Modal>
</template>
<script setup>
import { onMounted, reactive, ref } from "vue";
import { useForm, usePage, router } from "@inertiajs/vue3";
import { route } from "ziggy-js";
import Modal from "@/components/Modal.vue";
import Button from "@/components/Button.vue";
import Input from "@/components/Input.vue";

const page = usePage();
const list_values = reactive({
    payment_method: {},
    payment_method_insert: {},
    value: null,
});
let list_all = ref([]);

const form = useForm({
    value_monthly_fee: null,
});

function _addPaymentMethod() {
    if (!list_values.payment_method || !list_values.value) {
        return;
    }
    list_all.value.push({
        payment_method: list_values.payment_method_insert,
        value: list_values.value,
    });
    list_values.payment_method_insert = null;
    list_values.value = null;
}

function _removePaymentMethod(paymentMethodToRemove) {
    list_all.value = list_all.value.filter(
        (paymentMethod) => paymentMethod !== paymentMethodToRemove
    );
}

function _loadData() {
    axios
        .get(route("payment_method.getPaymentMethods"))
        .then(function (response) {
            let data = response.data;
            list_values.payment_method = data.payment_methods;
        });
}


function closeCallback(){
    list_values.payment_method_insert = null;
    list_values.value = null;
    list_all.value = [];
}

onMounted(() => {
    _loadData();
});
</script>
