<template>
    <Head title="Grupo Empresa" />
    <h2 class="font-bold text-2xl underline mb-2">Grupo de Empresas</h2>
    <div>
        <!-- FILTERS -->
        <div class="xl:w-200">
            <form
                :class="[
                    'flex flex-row mb-2',
                    !!form.errors.name ? 'items-center' : 'items-end',
                ]"
            >
                <div class="relative grow mr-2">
                    <Input
                        type="text"
                        label="Consultar / Cadastrar"
                        id="name"
                        name="name"
                        ref="input_group"
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
                        @click.prevent="_search()"
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
                        v-for="(value, index) in $page.props.company_groups
                            .data"
                    >
                        <th
                            scope="row"
                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                            v-if="editIndex !== index"
                        >
                            {{ value.name }}
                        </th>
                        <th
                            scope="row"
                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                            v-else
                        >
                            <Input
                                type="text"
                                id="name_update"
                                :isInvalid="!!form_update.errors.name"
                                v-model="form_update.name"
                            ></Input>
                            <div
                                v-if="form_update.errors.name"
                                class="text-red-500"
                            >
                                {{ form_update.errors.name }}
                            </div>
                        </th>

                        <td class="px-6 py-4" v-if="editIndex !== index">
                            <Button
                                text="EDITAR"
                                type="button"
                                typeButton="yellow"
                                class="relative top-1.5"
                                @click="showInputUpdate(value, index)"
                            ></Button>
                            <Button
                                text="DELETAR"
                                type="button"
                                typeButton="red"
                                class="relative top-1.5"
                                @click="
                                    _deleteAlert(value.id, value.company_count)
                                "
                            ></Button>
                        </td>
                        <td class="px-6 py-4" v-else>
                            <Button
                                text="CANCELAR"
                                type="button"
                                typeButton="red"
                                class="relative top-1.5"
                                @click="_cancelUpdate"
                                :isDisable="form_update.processing"
                            ></Button>
                            <Button
                                text="SALVAR"
                                type="button"
                                typeButton="green"
                                class="relative top-1.5"
                                @click.prevent="_save"
                                :isDisable="form_update.processing"
                                :isLoading="form_update.processing"
                            ></Button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <!-- END TABLE -->
        <!-- ACTIONS -->
        <Paginate
            :pagination="$page.props.company_groups"
            :onEachSize="3"
            @paginate="paginate"
        ></Paginate>
        <!-- END ACTIONS -->
    </div>
</template>

<script setup>
import { ref } from "vue";
import Paginate from "@/components/Paginate.vue";
import { usePage, useForm, router } from "@inertiajs/vue3";
import { route } from "ziggy-js";
//libs
import Swal from "sweetalert2";
//components
import SidebarLayout from "@/layouts/SidebarLayout.vue";
import Input from "@/components/Input.vue";
import Button from "@/components/Button.vue";

//refs html
const input_group = ref(null);
const page = usePage();
const form = useForm({
    name: "",
});
const form_update = useForm({
    id: 0,
    name: "",
});

//lets
let editIndex = ref(null);
function _create() {
    form.post(route("company_group.create"), {
        onSuccess: () => {
            form.reset("name");
            input_group.value.focus();
        },
    });
}
function _save() {
    form_update.patch(route("company_group.update"), {
        onSuccess: () => {
            _cancelUpdate();
        },
    });
}

function showInputUpdate(group_company, index) {
    editIndex.value = index;
    form_update.id = group_company.id;
    form_update.name = group_company.name;
}

function _cancelUpdate() {
    editIndex.value = null;
    form_update.reset();
}

function _deleteAlert(id, company_count) {
    Swal.fire({
        title: "Deseja realmente proceder com a exclusão?",
        text: `O grupo possui ${company_count} empresas vinculadas.`,
        showCancelButton: true,
        confirmButtonText: "SIM",
        cancelButtonText: "NÃO",
    }).then((result) => {
        if (result.isConfirmed) {
            router.delete(route("company_group.delete", [id]));
        }
    });
}

function paginate(page_link) {
    router.get(
        page.url,
        {
            page: page_link,
        },
        {
            preserveState: true,
        }
    );
}

function _search() {
    router.get(
        route("company_group"),
        {
            name: form.name,
        },
        {
            preserveState: true,
        }
    );
}

defineOptions({
    layout: SidebarLayout,
});
</script>
