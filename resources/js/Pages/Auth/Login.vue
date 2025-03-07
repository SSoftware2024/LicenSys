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
                    type="passwrod"
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
                <button
                    type="submit"
                    class="cursor-pointer text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                >
                    <div role="status" v-if="form.processing">
                        <svg
                            aria-hidden="true"
                            class="inline w-8 h-8 text-gray-200 animate-spin dark:text-gray-600 fill-gray-600 dark:fill-gray-300"
                            viewBox="0 0 100 101"
                            fill="none"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <path
                                d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                                fill="currentColor"
                            />
                            <path
                                d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                                fill="currentFill"
                            />
                        </svg>
                        <span class="sr-only">Loading...</span>
                    </div>
                    <span v-else> LOGIN </span>
                </button>
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
