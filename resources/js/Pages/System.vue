<template>
    <Head title="Sistema" />
    <h2 class="font-bold text-2xl underline mb-2">Sistema</h2>
    <div class="xl:w-200">
        <form @submit.prevent="">
            <Input
                type="number"
                label="Limite de dias (expiração)"
                id="number_days"
                :isInputRequired="true"
            />
            <div class="flex sm:flex-wrap md:flex-nowrap">
                <div class="flex flex-col w-full m-1">
                    <Input
                        type="text"
                        label="Cód. Acesso API"
                        id="code_access_api"
                        :isInputRequired="true"
                    />
                </div>
                <div class="flex flex-col w-full m-1">
                    <Input
                        type="text"
                        label="Cód. Acesso API - Genéricos"
                        id="code_access_api_generic"
                        :isInputRequired="true"
                    />
                </div>
            </div>
            <div class="flex">
                <div class="flex flex-col w-full m-1">
                    <Input
                        type="text"
                        label="Cód. Acesso API - (Apenas leitura)"
                        id="code_access_api_readonly"
                        class="bg-gray-200"
                        readonly
                    />
                </div>
                <div class="flex flex-col w-full m-1">
                    <Input
                        type="text"
                        label="Cód. Acesso API - Genéricos - (Apenas leitura)"
                        id="code_access_api_generic_readonly"
                        class="bg-gray-200"
                        readonly
                    />
                </div>
            </div>
            <div class="flex justify-end">
                <Button text="Salvar" type="submit" typeButton='primary' :isDisable="form.processing" :isLoading="form.processing"></Button>
            </div>
        </form>
    </div>
</template>

<script setup>
import { ref } from "vue";
import { route } from "ziggy-js";
import { useForm } from "@inertiajs/vue3";
//COMPONENTS E LAYOUTS
import SidebarLayout from "../layouts/SidebarLayout.vue";
import Input from "@/components/Input.vue";
import Button from "@/components/Button.vue";
defineOptions({
    layout: SidebarLayout,
});

const form = useForm({
    limit_days: 0
});
</script>
