<template>
    <Head title="Usuários" />
    <h2 class="font-bold text-2xl underline mb-2">Usuários</h2>
    <div>
        <!-- FILTERS -->
        <div class="xl:w-200">
            <form class="flex flex-row mb-2 items-end">
                <div class="relative grow mr-2">
                    <Input
                        type="text"
                        label="Nome / E-mail"
                        id="name_email"
                        name="name_email"
                    >
                        <template #icon>
                                <svg
                                    class="w-4 h-4 text-gray-500 dark:text-gray-400"
                                    aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 20 20"
                                >
                                    <path
                                        stroke="currentColor"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"
                                    />
                                </svg>
                        </template>
                    </Input>
                </div>
                <div>
                    <Button
                        text="Buscar"
                        type="submit"
                        typeButton="dark"
                        class="relative top-1.5"
                    ></Button>
                </div>
            </form>
        </div>

        <!-- END FILTERS -->
        <!-- TABLE -->
        <div class="relative overflow-x-auto">
            <table
                class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400"
            >
                <thead
                    class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"
                >
                    <tr>
                        <th scope="col" class="px-6 py-3">Nome</th>
                        <th scope="col" class="px-6 py-3">Email</th>
                        <th scope="col" class="px-6 py-3">
                            Email verificado - admin
                        </th>
                        <th scope="col" class="px-6 py-3">TW.FA</th>
                        <th scope="col" class="px-6 py-3">Ativado</th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200"
                    >
                        <th
                            scope="row"
                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                        >
                            Apple MacBook Pro 17"
                        </th>
                        <td class="px-6 py-4">teste@email.com</td>
                        <td class="px-6 py-4">true</td>
                        <td class="px-6 py-4">$true</td>
                        <td class="px-6 py-4">$true</td>
                    </tr>
                    <tr
                        class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200"
                    >
                        <th
                            scope="row"
                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                        >
                            Apple MacBook Pro 17"
                        </th>
                        <td class="px-6 py-4">teste@email.com</td>
                        <td class="px-6 py-4">true</td>
                        <td class="px-6 py-4">$true</td>
                        <td class="px-6 py-4">$true</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <!-- END TABLE -->
        <!-- ACTIONS -->
        <!-- END ACTIONS -->
    </div>
</template>

<script setup>
import { ref } from "vue";
import { route } from "ziggy-js";
import SidebarLayout from "@/layouts/SidebarLayout.vue";
import Input from "@/components/Input.vue";
import Button from "@/components/Button.vue";
defineOptions({
    layout: SidebarLayout,
});
</script>
