<template>
    <Head title="Cadastro Empresa" />
    <h2 class="font-bold text-2xl underline mb-2">Cadastrar Empresa</h2>
    <div class="xl:w-200">
        <form @submit.prevent="_submit">
            <div class="relative">
                <Input
                    type="text"
                    label="Código (UUID)"
                    id="uuid"
                    name="uuid"
                    min="1"
                    max="31"
                    readonly
                    class="cs_readonly"
                    :isInputRequired="true"
                    v-model="form.uuid"
                />
                <div class="absolute flex gap-3 top-0 right-2.5 uppercase underline text-[12px] font-bold cursor-pointer">
                    <span class="text-green-600 hover:text-green-800" @click="_copyText($page.props.uuid)">Cópiar</span>
                </div>
            </div>
            <div class="flex">
                <div class="flex flex-col w-full mr-1">
                    <Input
                        type="number"
                        label="Pagamento dia"
                        id="payment_day"
                        name="payment_day"
                        min="1"
                        max="31"
                        :isInputRequired="true"
                        v-model="form.payment_day"
                    />
                    <div v-if="form.errors.payment_day" class="text-red-500">
                        {{ form.errors.payment_day }}
                    </div>
                </div>
                <div class="flex flex-col w-full ml-1">
                    <Input
                        type="text"
                        label="Pagamento valor (R$)"
                        id="value_monthly_fee"
                        :isInputRequired="true"
                        :isInputMask="true"
                        :maskDecimalBr="2"
                        v-model="form.value_monthly_fee"
                    />
                    <div v-if="form.errors.value_monthly_fee" class="text-red-500">
                        {{ form.errors.value_monthly_fee }}
                    </div>
                </div>
            </div>
            <div>
                <label
                    for="systems_useds"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                    >Escolha o sistemas (CTRL + clique)
                    <span class="text-red-600 font-bold tex-lg">*</span>
                </label>
                <select
                    id="systems_useds"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    multiple
                    size="5"
                    v-model="form.systems_useds"
                >
                    <option value="" selected>-----------------</option>
                    <option style="text-transform: uppercase"  v-for="(value, index) in $page.props.systems_for_sale" :value="value" :key="index">{{ value }}</option>
                </select>
            </div>
            <div class="mt-2">
                <label
                    for="monthly_fee_status"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                    >STATUS
                    <span class="text-red-600 font-bold tex-lg">*</span>
                </label>
                <select
                    id="monthly_fee_status"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 uppercase"
                    v-model="form.monthly_fee_status"
                >
                    <option value="" selected>❌</option>
                    <option style="text-transform: uppercase" v-for="(value, key, index) in $page.props.monthly_fee_status" :value="key" :key="index"> {{ value }}</option>
                </select>
            </div>
            <div class="mt-2">
                <label
                    for="group_company_id"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                    >Associar Grupo
                    <span class="text-red-600 font-bold tex-lg">*</span>
                </label>
                <select
                    id="group_company_id"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 uppercase"
                    v-model="form.group_company_id"
                >
                    <option value="" selected>❌</option>
                   <option style="text-transform: uppercase"  v-for="value in $page.props.groups_company" :value="value.id" :key="value.id">{{ value.name }}</option>
                </select>
            </div>
            <div class="mt-2">
                <div class="flex items-center">
                    <input
                        checked
                        name="activated"
                        id="checked-checkbox"
                        type="checkbox"
                        value=""
                        class="w-4.5 h-4.5 cursor-pointer text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                        v-model="form.activated"
                    />
                    <label
                        for="checked-checkbox"
                        class="ms-2 text-sm cursor-pointer uppercase font-medium text-gray-900 dark:text-gray-300"
                        >Ativar</label
                    >
                </div>
                <div class="flex items-center">
                    <input
                        name="activated"
                        id="checked-fiscal"
                        type="checkbox"
                        value=""
                        disabled
                        class="w-4.5 h-4.5 cursor-pointer  text-red-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-red-500 dark:focus:ring-red-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                        v-model="form.isFiscal"
                    />
                    <label
                        for="checked-fiscal"
                        class="ms-2 text-sm cursor-pointer uppercase font-medium text-gray-900 dark:text-gray-300"
                        >Fiscal</label
                    >
                </div>
            </div>
            <div class="flex justify-end">
                <Button
                    text="Salvar"
                    type="submit"
                    typeButton="primary"
                    :isDisable="form.processing"
                    :isLoading="form.processing"
                ></Button>
            </div>
        </form>
    </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import { useForm, usePage } from "@inertiajs/vue3";
import { route } from "ziggy-js";
import { _copyText } from "@utils/functions";
//COMPONENTS
import SidebarLayout from "@/layouts/SidebarLayout.vue";
import Input from "@/components/Input.vue";
import Button from "@/components/Button.vue";

//CODE
const page = usePage();
const form = useForm({
    uuid: page.props.uuid,
    monthly_fee_status: '',
    payment_day: '',
    value_monthly_fee: '',
    isFiscal: false,
    activated: true,
    systems_useds: [],
    group_company_id: null,

});

function _submit() {
    console.log(form.data());
    // form.post(route("company.create"));
}


onMounted(() => {});
defineOptions({
    layout: SidebarLayout,
});
</script>
