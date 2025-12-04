<template>
    <Head title="Esqueci a senha" />
    <AuthLayout title="Informe o e-mail">
        <div class="w-full flex justify-center mt-2">
            <img :src="$page.props.logo" alt="" class="w-30 rounded-full" />
        </div>
        <form @submit.prevent="_sendEmail">
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

            </div>
            <div class="mt-1 flex justify-between">
                <a
                    :href="route('index')"
                    class="font-medium text-blue-600 dark:text-blue-500 hover:underline"
                    >Login</a
                >
                <Button text="Enviar e-mail" type="submit" typeButton='primary' :isDisable="form.processing" :isLoading="form.processing"></Button>
            </div>
        </form>
    </AuthLayout>
</template>
<script setup>
// import { onMounted } from 'vue'
import { useForm, usePage } from "@inertiajs/vue3";
import { route } from "ziggy-js";
//LAYOUTS E COMPONENTS
import AuthLayout from "../../layouts/AuthLayout.vue";
import Input from "@/components/Input.vue";
import Button from "@/components/Button.vue";
const page = usePage();
const form = useForm({
    email: "",
});

function _sendEmail() {
    form.post(page.props.routes_fortify.forgot_password_post);

}
</script>
