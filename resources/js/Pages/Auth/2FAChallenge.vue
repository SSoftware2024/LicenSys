<template>
    <Head title="Código 2FA" />
    <AuthLayout title="Código 2FA">
        <div class="w-full flex justify-center mt-2">
            <img :src="$page.props.logo" alt="" class="w-30 rounded-full" />
        </div>
        <form @submit.prevent="submitCode">
            <div class="flex justify-center gap-2 my-6">
                <input
                    v-for="(digit, index) in form.code_prepare"
                    :key="index"
                    type="text"
                    inputmode="numeric"
                    maxlength="1"
                    class="w-12 h-12 text-center text-xl border rounded-lg focus:ring-2 focus:ring-blue-500"
                    v-model="form.code_prepare[index]"
                    @input="handleInput(index)"
                    @keydown.backspace="handleBackspace(index)"
                    :ref="(el) => (inputs[index] = el)"
                />
            </div>
            <h2 class="text-center">OU</h2>
            <div class="w-full">
                <Input
                    type="text"
                    id="email"
                    label="Código de recuperação"
                    maxlength="21"
                    minlength="21"
                    v-model="form.recovery_code"
                />
            </div>
            <div v-if="$page.props.errors.code || $page.props.errors.recovery_code " class="text-red-500">
                {{ $page.props.errors.code || $page.props.errors.recovery_code }}
            </div>
            <div class="flex justify-center mt-1">
                <Button
                    text="Enviar"
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
import { ref } from "vue";
import { useForm } from "@inertiajs/vue3";
import { route } from "ziggy-js";
import AuthLayout from "../../layouts/AuthLayout.vue";
import Input from "@/components/Input.vue";
import Button from "@/components/Button.vue";
const form = useForm({
    code_prepare: ["", "", "", "", "", ""],
    code: '',
    recovery_code: "",
});
const inputs = ref([]);

function handleInput(index) {
    if (!/^[0-9]$/.test(form.code_prepare[index])) {
        form.code_prepare[index] = "";
        return;
    }

    if (index < 5) {
        inputs.value[index + 1].focus();
    } else {
        submitCode();
    }
}

function handleBackspace(index) {
    if (form.code_prepare[index] === "" && index > 0) {
        inputs.value[index - 1].focus();
    }
}

function submitCode() {
    form.code = form.code_prepare.join("");
    form.post(route("two-factor.login.store"), {
        onError: () => {
            form.defaults();
        }
    });
}
</script>
