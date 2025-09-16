<template>
    <Head title="Cadastro Empresa" />
    <h2 class="font-bold text-2xl underline mb-2">Cadastrar Empresa</h2>
    <div class="xl:w-200">
        <form>
            <div class="relative">
                <Input
                    type="text"
                    label="Código"
                    id="email"
                    name="email"
                    min="1"
                    max="31"
                    readonly
                    class="cs_readonly"
                    :isInputRequired="true"
                    v-model="form.vinculation_code"
                />
                <div class="absolute flex gap-3 top-0 right-2.5 uppercase underline text-[12px] font-bold cursor-pointer">
                    <span class="text-blue-600  hover:text-blue-800">Gerar código</span>
                    <span class="text-red-600 hover:text-red-800">Cópiar</span>
                </div>
            </div>
            <div class="flex">
                <div class="flex flex-col w-full mr-1">
                    <Input
                        type="number"
                        label="Pagamento dia"
                        id="email"
                        name="email"
                        min="1"
                        max="31"
                        :isInputRequired="true"
                    />
                    <div v-if="form.errors.password" class="text-red-500">
                        {{ form.errors.password }}
                    </div>
                </div>
                <div class="flex flex-col w-full ml-1">
                    <Input
                        type="text"
                        label="Pagamento valor (R$)"
                        id="password_confirmation"
                        :isInputRequired="true"
                        :isInputMask="true"
                        :maskDecimalBr="2"
                        v-model="mask"
                    />
                </div>
            </div>
            <div>
                <label
                    for="countries"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                    >Escolha o sistemas (CTRL + clique)
                    <span class="text-red-600 font-bold tex-lg">*</span>
                </label>
                <select
                    id="countries"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    multiple
                    size="5"
                >
                    <option value="" selected>-----------------</option>
                    <option style="text-transform: uppercase"  v-for="(value, index) in $page.props.systems_for_sale" :value="value" :key="index">{{ value }}</option>
                </select>
            </div>
            <div class="mt-2">
                <label
                    for="countries"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                    >STATUS
                    <span class="text-red-600 font-bold tex-lg">*</span>
                </label>
                <select
                    id="countries"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                >
                    <option value="" selected>❌</option>
                    <option style="text-transform: uppercase" v-for="(value, key, index) in $page.props.monthly_fee_status" :value="key" :key="index"> {{ value }}</option>
                </select>
            </div>
            <div class="mt-2">
                <label
                    for="countries"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                    >Associar Grupo
                    <span class="text-red-600 font-bold tex-lg">*</span>
                </label>
                <select
                    id="countries"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
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
import SidebarLayout from "@/layouts/SidebarLayout.vue";
import Input from "@/components/Input.vue";
import Button from "@/components/Button.vue";
const page = usePage();
const form = useForm({
    'vinculation_code': page.props.vinculation_code,
});

const mask = ref('');

onMounted(() => {});
defineOptions({
    layout: SidebarLayout,
});
</script>
