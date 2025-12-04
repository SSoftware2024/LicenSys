<template>
    <Head title="Resetar senha" />
    <AuthLayout title="Nova Senha">
        <div class="w-full flex justify-center mt-2">
            <img :src="$page.props.logo" alt="" class="w-30 rounded-full" />
        </div>
        <form @submit.prevent="_resetPassoword">
            <div>
                <Input
                    type="password"
                    label="Nova senha"
                    id="password"
                    v-model="form.password"
                    :isInvalid="!!form.errors.password"
                    :isInputRequired="true"
                />
                <div v-if="form.errors.password" class="text-red-500">
                    {{ form.errors.password }}
                </div>
                <Input
                    type="password"
                    label="Confirmar senha"
                    id="password"
                    v-model="form.password_confirmation"
                    :isInvalid="!!form.errors.password_confirmation"
                    :isInputRequired="true"
                />
                <div v-if="form.errors.password_confirmation" class="text-red-500">
                    {{ form.errors.password_confirmation }}
                </div>
            </div>
            <div class="mt-1 flex justify-end">
                <Button
                    text="Salvar"
                    type="submit"
                    typeButton="primary"
                    :isDisable="form.processing"
                    :isLoading="form.processing"
                ></Button>
            </div>
        </form>
    </AuthLayout>
</template>
<script setup>
// import { onMounted } from 'vue'
import { useForm, usePage } from "@inertiajs/vue3";
import { route } from "ziggy-js";
import { getNormalUrlParamter } from "@/utils/functions.js";
//LAYOUTS E COMPONENTS
import AuthLayout from "../../layouts/AuthLayout.vue";
import Input from "@/components/Input.vue";
import Button from "@/components/Button.vue";
const page = usePage();
const form = useForm({
    password: "",
    password_confirmation: "",
});

function _resetPassoword() {
    form.transform((data) => ({
        ...data,
        token: route().params.token,
        email: route().params.email,
    })).post(route("password.update"));
}
</script>
