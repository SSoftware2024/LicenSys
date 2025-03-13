<template>
    <Head title="Login" />
    <AuthLayout title="Login">
        <div class="w-full flex justify-center mt-2">
            <img :src="$page.props.logo" alt="" class="w-30 rounded-full" />
        </div>
        <form @submit.prevent="login">
            <div>
                <Input
                    type="email"
                    label="Email"
                    id="email"
                    v-model="form.email"
                    :isInvalid="!!form.errors.email"
                    :isInputRequired="true"
                />
                <div v-if="form.errors.email" class="text-red-500">
                    {{ form.errors.email }}
                </div>
                <Input
                    type="password"
                    label="Senha"
                    id="senha"
                    v-model="form.password"
                    :isInvalid="!!form.errors.password"
                    :isInputRequired="true"
                />
                <div v-if="form.errors.password" class="text-red-500">
                    {{ form.errors.password }}
                </div>
            </div>
            <div class="my-1">
                <input
                    id="remember"
                    type="checkbox"
                    value=""
                    class="w-4 h-4 cursor-pointer border border-gray-300 rounded-sm bg-gray-50 focus:ring-3 focus:ring-blue-300 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800"
                    v-model="form.remember"
                />
                <label
                    for="remember"
                    class="ms-2 text-sm font-medium cursor-pointer text-gray-900 dark:text-gray-300"
                >
                    Lembrar de mim
                </label>
            </div>
            <div class="mt-1 flex justify-between">
                <a
                    href="#"
                    class="font-medium text-blue-600 dark:text-blue-500 hover:underline"
                    >Esqueci a senha!</a
                >
                <Button text="login" type="submit" :typeButton="TypeButton.PRIMARY" :isDisable="form.processing" :isLoading="form.processing"></Button>
            </div>
        </form>
    </AuthLayout>
</template>
<script setup>
// import { onMounted } from 'vue'
import { useForm, usePage } from "@inertiajs/vue3";
import { route } from "ziggy-js";
import { TypeButton } from '@/utils/enum';
//LAYOUTS E COMPONENTS
import AuthLayout from "../../layouts/AuthLayout.vue";
import Input from "@/components/Input.vue";
import Button from "@/components/Button.vue";
const page = usePage();
const form = useForm({
    email: "",
    password: "",
    remember: false,
});

function login() {
    form.post(page.props.routes_fortify.login_post);
}
</script>
