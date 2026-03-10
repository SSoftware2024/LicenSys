<template>
    <Head title="Código 2FA" />
    <AuthLayout title="Código 2FA">
        <div class="w-full flex justify-center mt-2">
            <img :src="$page.props.logo" alt="" class="w-30 rounded-full" />
        </div>
        <form @submit.prevent="submitCode">
            <div class="flex justify-center gap-2 my-6">
                <input
                    v-for="(digit, index) in code"
                    :key="index"
                    type="text"
                    inputmode="numeric"
                    maxlength="1"
                    class="w-12 h-12 text-center text-xl border rounded-lg focus:ring-2 focus:ring-blue-500"
                    v-model="code[index]"
                    @input="handleInput(index)"
                    @keydown.backspace="handleBackspace(index)"
                    :ref="(el) => (inputs[index] = el)"
                />
            </div>
        </form>
    </AuthLayout>
</template>
<script setup>
import { ref } from "vue";

const code = ref(["", "", "", "", "", ""]);
const inputs = ref([]);

function handleInput(index) {
    if (!/^[0-9]$/.test(code.value[index])) {
        code.value[index] = "";
        return;
    }

    if (index < 5) {
        inputs.value[index + 1].focus();
    } else {
        submitCode();
    }
}

function handleBackspace(index) {
    if (code.value[index] === "" && index > 0) {
        inputs.value[index - 1].focus();
    }
}

function submitCode() {
    const otp = code.value.join("");
    console.log("Código:", otp);

    // aqui você pode enviar com inertia
    // form.post(...)
}
</script>
