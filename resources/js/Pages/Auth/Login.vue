<template>
    <Head title="Login" />
    <AuthLayout title="Login">
        <div class="w-full flex justify-center mt-2">
            <img :src="$page.props.logo" alt="" class="w-30 rounded-full">
        </div>
        <form action="">
            <div>
                <label
                    for="email"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                    >Email
                </label>
                <input
                    type="email"
                    id="email"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="name@flowbite.com"
                />
                <label
                    for="password"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                    >Senha
                </label>
                <input
                    type="password"
                    id="password"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    required
                />
            </div>
            <div class="my-1">
                <input
                    id="remember"
                    type="checkbox"
                    value=""
                    class="w-4 h-4 cursor-pointer border border-gray-300 rounded-sm bg-gray-50 focus:ring-3 focus:ring-blue-300 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800"
                    required
                />
                <label
                    for="remember"
                    class="ms-2 text-sm font-medium cursor-pointer text-gray-900 dark:text-gray-300"
                >
                    Lembrar de mim
                </label>
            </div>
            <div class="mt-1 flex justify-end">
                <button
                    type="submit"
                    class="cursor-pointer text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                >
                    LOGIN
                </button>
            </div>
        </form>
    </AuthLayout>
</template>
<script setup>
// import { onMounted } from 'vue'
import AuthLayout from "../../layouts/AuthLayout.vue";
</script>
