<template>
    <Head title="Grupo Empresa" />
    <h2 class="font-bold text-2xl underline mb-2">Grupo de Empresas</h2>
    <div>
        <!-- FILTERS -->
        <div class="xl:w-200">
            <form :class="['flex flex-row mb-2', !!form.errors.name ? 'items-center':'items-end']">
                <div class="relative grow mr-2">
                    <Input
                        type="text"
                        label="Consultar / Cadastrar"
                        id="name"
                        name="name"
                        :isInvalid="!!form.errors.name"
                        v-model="form.name"
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
                    <div v-if="form.errors.name" class="text-red-500">
                        {{ form.errors.name }}
                    </div>
                </div>
                <div class="flex flex-row">
                    <Button
                        text="Buscar"
                        type="submit"
                        typeButton="dark"
                        class="relative top-1.5"
                    ></Button>
                    <Button
                        text="Cadastrar"
                        type="submit"
                        typeButton="green"
                        class="relative top-1.5"
                        @click.prevent="_create()"
                        :isDisable="form.processing"
                        :isLoading="form.processing"
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
                        <th scope="col" class="px-6 py-3">Ações</th>
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
                            Nome
                        </th>

                        <td class="px-6 py-4">ACTIONS</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <!-- END TABLE -->
        <!-- ACTIONS -->
        <!-- <Paginate
            :pagination="$page.props.users"
            :onEachSize="3"
            @paginate="paginate"
        ></Paginate> -->
        <!-- END ACTIONS -->
    </div>
</template>

<script setup>
import SidebarLayout from "@/layouts/SidebarLayout.vue";
import Input from "@/components/Input.vue";
import Button from "@/components/Button.vue";
import Paginate from "@/components/Paginate.vue";
import { usePage, useForm } from "@inertiajs/vue3";
import { route } from "ziggy-js";
const form = useForm({
    name: "",
});

function _create() {
    form.post(route("company_group.create"));
}

defineOptions({
    layout: SidebarLayout,
});
</script>
