<template>
    <Head title="Empresas" />
    <h2 class="font-bold text-2xl underline mb-2">Empresas</h2>
    <div>
        <!-- FILTERS -->
        <div class="xl:w-250">
            <form class="flex flex-row mb-2 items-end">
                <div class="relative grow mr-2">
                    <Input
                        type="text"
                        label="Código"
                        id="code"
                        name="code"
                        placeholder="Código"
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
                <div class="relative grow mr-2">
                    <Input
                        type="text"
                        label="Nome"
                        id="name"
                        name="name"
                        placeholder="Nome"
                    >
                    </Input>
                </div>
                <div class="grow-1 mr-2">
                    <label
                        for="countries"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >STATUS <i>(mês atual)</i></label
                    >
                    <select
                        id="countries"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    >
                        <option value="" selected>❌</option>
                        <option
                            :value="key"
                            v-for="(value, key, index) in $page.props
                                .monthly_fee_status"
                            :key="index"
                            style="text-transform: uppercase"
                        >
                            {{ value }}
                        </option>
                    </select>
                </div>
                <div class="grow-1 mr-2">
                    <label
                        for="countries"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                        >Grupo Empresa</label
                    >
                    <select
                        id="countries"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    >
                        <option value="" selected>❌</option>
                        <option
                            v-if="$page.props.groups_company.length > 0"
                            v-for="value in $page.props.groups_company"
                            :value="value.id"
                            style="text-transform: uppercase"
                        >
                            {{ value.name }}
                        </option>
                    </select>
                </div>
                <div>
                    <Button
                        text="Buscar"
                        type="submit"
                        typeButton="dark"
                        class="relative top-1.5"
                    ></Button>
                    <Button
                        text="Novo"
                        type="button"
                        typeButton="green"
                        class="relative top-1.5"
                        @click="() => router.get(route('company.createView'))"
                    ></Button>
                </div>
            </form>
        </div>

        <!-- END FILTERS -->
        <!-- TABLE -->
        <div class="relative overflow-x-auto">
            <table
                class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 mb-[500px]"
            >
                <thead
                    class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"
                >
                    <tr>
                        <th scope="col" class="px-6 py-3">CÓD</th>
                        <th scope="col" class="px-6 py-3">Nome</th>
                        <th scope="col" class="px-6 py-3">Dono</th>
                        <th scope="col" class="px-6 py-3">Grupo</th>
                        <th scope="col" class="px-6 py-3">Pagamento</th>
                        <th scope="col" class="px-6 py-3">Status</th>
                        <th scope="col" class="px-6 py-3">Ativado</th>
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
                            NXpk3@comC#
                        </th>
                        <td class="px-6 py-4">NOME</td>
                        <td class="px-6 py-4">DONO</td>
                        <td class="px-6 py-4">GRUPO</td>
                        <td class="px-6 py-4">12/12/2024</td>
                        <td class="px-6 py-4">
                            <span
                                class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-green-600/20 ring-inset"
                                v-if="true"
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
                                v-if="true"
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
                                data-dropdown-toggle="`dropdownDots${index}`"
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
                                id="`dropdownDots${index}`"
                                class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-44 dark:bg-gray-700 dark:divide-gray-600 uppercase"
                            >
                                <ul
                                    class="py-2 text-sm text-gray-700 dark:text-gray-200"
                                    aria-labelledby="dropdownMenuIconButton"
                                >
                                    <li>
                                        <Link
                                            href="#"
                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
                                        >
                                            Cópiar CÓD
                                        </Link>
                                    </li>
                                    <li>
                                        <a
                                            href="#"
                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
                                            data-modal-target="look-more-company"
                                            data-modal-toggle="look-more-company"
                                        >
                                            Ver tudo
                                        </a>
                                    </li>
                                    <li>
                                        <Link
                                            href="#"
                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
                                        >
                                            Editar
                                        </Link>
                                    </li>
                                    <li>
                                        <a
                                            href="#"
                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
                                            v-if="true"
                                            >Desativar</a
                                        >
                                        <a
                                            href="#"
                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
                                            v-else
                                            >Ativar</a
                                        >
                                    </li>
                                </ul>
                                <div class="py-2">
                                    <a
                                        href="#"
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
        <!-- <Paginate
            :pagination="$page.props.users"
            :onEachSize="3"
            @paginate="paginate"
        ></Paginate> -->
        <!-- END ACTIONS -->
    </div>

    <Modal title="Detalhes empresa" id="look-more-company">
        <ul>
            <li>Nome</li>
            <li>Dono</li>
            <li>Grupo</li>
            <li>Dia pagamento</li>
            <li>isFiscal</li>
            <li>status</li>
            <li>ativado</li>
            <li>criado data</li>
            <li>criado por</li>
            <li>ultima atualização por</li>
            <li>valor mensalidade R$100,00</li>
            <li>Sistemas usados</li>
        </ul>
        <template #footer>
            <button
                data-modal-hide="look-more-company"
                type="button"
                class="cursor-pointer py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700"
            >
                Fechar
            </button>
        </template>
    </Modal>
</template>

<script setup>
import { onMounted, ref } from "vue";
import Swal from "sweetalert2";
import { route } from "ziggy-js";
import { router, usePage, useForm } from "@inertiajs/vue3";
import SidebarLayout from "@/layouts/SidebarLayout.vue";
import Input from "@/components/Input.vue";
import Button from "@/components/Button.vue";
import Modal from "@/components/Modal.vue";
import Paginate from "../../components/Paginate.vue";

const page = usePage();
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

defineOptions({
    layout: SidebarLayout,
});
</script>
