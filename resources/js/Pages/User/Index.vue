<template>
    <Head title="Usuários" />
    <h2 class="font-bold text-2xl underline mb-2">
        Usuários
        <span class="uppercase">{{
            $page.props.type_user == "admin"
                ? ` - ${$page.props.type_user}`
                : ""
        }}</span>
    </h2>
    <div>
        <!-- FILTERS -->
        <div class="xl:w-200">
            <form
                class="flex flex-row mb-2 items-end"
                @submit.prevent="_search"
            >
                <div class="relative grow mr-2">
                    <Input
                        type="text"
                        label="Nome / E-mail"
                        id="name_email"
                        name="name_email"
                        v-model="form.name_email"
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
                        :isDisable="loading"
                        :isLoading="loading"
                    ></Button>
                    <Button
                        text="Novo"
                        type="button"
                        typeButton="green"
                        class="relative top-1.5"
                        @click="
                            router.get(
                                route('user.saveView', {
                                    type: $page.props.type_user ?? '',
                                    operation: 'create',
                                })
                            )
                        "
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
                        <th scope="col" class="px-6 py-3">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200"
                        v-for="(user, index) in page.props.users.data"
                        :key="index"
                    >
                        <th
                            scope="row"
                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                        >
                            {{ user.name }}
                        </th>
                        <td class="px-6 py-4">{{ user.email }}</td>
                        <td class="px-6 py-4">
                            <span
                                class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-green-600/20 ring-inset"
                                v-if="user.email_verified_at"
                                >VERIFICADO</span
                            >
                            <span
                                class="inline-flex items-center rounded-md bg-red-50 px-2 py-1 text-xs font-medium text-red-700 ring-1 ring-red-600/10 ring-inset"
                                v-else
                                >NÃO</span
                            >
                        </td>
                        <td class="px-6 py-4">
                            <span
                                class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-green-600/20 ring-inset"
                                v-if="user.two_factor_confirmed_at"
                                >ATIVO</span
                            >
                            <span
                                class="inline-flex items-center rounded-md bg-red-50 px-2 py-1 text-xs font-medium text-red-700 ring-1 ring-red-600/10 ring-inset"
                                v-else
                                >INATIVO</span
                            >
                        </td>
                        <td class="px-6 py-4">
                            <span
                                class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-green-600/20 ring-inset"
                                v-if="user.activated"
                                >ATIVO</span
                            >
                            <span
                                class="inline-flex items-center rounded-md bg-red-50 px-2 py-1 text-xs font-medium text-red-700 ring-1 ring-red-600/10 ring-inset"
                                v-else
                                >INATIVO</span
                            >
                        </td>
                        <td class="px-6 py-4">
                            <button
                                id="dropdownMenuIconButton"
                                :data-dropdown-toggle="`dropdownDots${index}`"
                                class="cursor-pointer inline-flex items-center p-2 text-sm font-medium text-center text-gray-900 bg-white rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none dark:text-white focus:ring-gray-50 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
                                type="button"
                            >
                                <svg
                                    class="w-5 h-5"
                                    aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="currentColor"
                                    viewBox="0 0 4 15"
                                >
                                    <path
                                        d="M3.5 1.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 6.041a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 5.959a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z"
                                    />
                                </svg>
                            </button>

                            <!-- Dropdown menu -->
                            <div
                                :id="`dropdownDots${index}`"
                                class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-44 dark:bg-gray-700 dark:divide-gray-600 uppercase"
                            >
                                <ul
                                    class="py-2 text-sm text-gray-700 dark:text-gray-200"
                                    aria-labelledby="dropdownMenuIconButton"
                                >
                                    <li>
                                        <Link
                                            :href="
                                                route('user.saveView', {
                                                    type: $page.props.type_user,
                                                    operation: 'update',
                                                    id: user.id,
                                                })
                                            "
                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
                                        >
                                            Editar
                                        </Link>
                                    </li>
                                    <li>
                                        <a
                                            href="#"
                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
                                            v-if="user.activated"
                                            @click="
                                                _toggleActivete(user.id, true)
                                            "
                                            >Desativar</a
                                        >
                                        <a
                                            href="#"
                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
                                            v-else
                                            @click="
                                                _toggleActivete(user.id, false)
                                            "
                                            >Ativar</a
                                        >
                                    </li>
                                    <li>
                                        <a
                                            href="#"
                                            class="block px-4 py-2 text-red-600 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
                                            >Remover 2FA</a
                                        >
                                    </li>
                                </ul>
                                <div class="py-2">
                                    <a
                                        href="#"
                                        @click="_deleteAlert(user.id)"
                                        class="block px-4 py-2 text-sm text-red-600 font-bold hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white"
                                        >Deletar</a
                                    >
                                </div>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <!-- END TABLE -->
        <!-- ACTIONS -->
        <Paginate
            :pagination="$page.props.users"
            :onEachSize="3"
            @paginate="paginate"
        ></Paginate>
        <!-- END ACTIONS -->
    </div>
</template>

<script setup>
import { onMounted, ref } from "vue";
import Swal from "sweetalert2";
import { route } from "ziggy-js";
import { router, usePage, useForm } from "@inertiajs/vue3";
import SidebarLayout from "@/layouts/SidebarLayout.vue";
import Input from "@/components/Input.vue";
import Button from "@/components/Button.vue";
import Paginate from "../../components/Paginate.vue";

const page = usePage();
const loading = ref(false)
const form = useForm({
    name_email: "",
});
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

function _deleteAlert(id) {
    Swal.fire({
        title: "Deseja prosseguir com deleção de usuário?",
        showCancelButton: true,
        confirmButtonText: "SIM",
        cancelButtonText: "NÃO",
    }).then((result) => {
        if (result.isConfirmed) {
            router.delete(route("user.delete", [id]));
        }
    });
}

function _toggleActivete(id, value) {
    router.patch(
        route("user.toggleActivete"),
        {
            id: id,
            value: value,
        },
        {
            preserveState: false,
        }
    );
}

function _search() {
    loading.value = true;
    router.get(
        route("user", [page.props.type_user]),
        {
            name_email: form.name_email,
        },
        {
            preserveState: true,
            onFinish: () => (loading.value = false),
        }
    );
}

defineOptions({
    layout: SidebarLayout,
});
</script>
