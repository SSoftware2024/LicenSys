<template>
    <Head title="Empresas" />
    <h2 class="font-bold text-2xl underline mb-2">Empresas</h2>
    <div>
        <!-- FILTERS -->
        <div class="xl:w-250">
            <form class="flex flex-row mb-2 items-end" @submit.prevent="_search">
                <div class="relative grow mr-2">
                    <Input
                        type="text"
                        label="Código"
                        id="uuid"
                        name="uuid"
                        placeholder="Código"
                        v-model="form.uuid"
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
                        v-model="form.company_name"
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
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 uppercase"
                        v-model="form.monthly_fee_status"
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
                        v-model="form.group_company"
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
                    <Button
                        text="Vincular dados"
                        type="button"
                        typeButton="primary"
                        class="relative top-1.5"
                        @click="_linkAllCompanies"
                    ></Button>
                </div>
            </form>
        </div>

        <!-- END FILTERS -->
        <!-- TABLE -->
        <div class="relative overflow-x-auto">
            <table
                :class="{
                    'w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400': true,
                    'mb-80':isShowDropDown,
                }"
            >
                <thead
                    class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"
                >
                    <tr>
                        <th scope="col" class="px-6 py-3">CÓD</th>
                        <th scope="col" class="px-6 py-3">Nome</th>
                        <th scope="col" class="px-6 py-3">Grupo</th>
                        <th scope="col" class="px-6 py-3">Pagamento</th>
                        <th scope="col" class="px-6 py-3">Status(mês atual)</th>
                        <th scope="col" class="px-6 py-3">Ativado</th>
                        <th scope="col" class="px-6 py-3">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200"
                        v-for="(data, index) in $page.props.companies.data"
                        :key="index"
                    >
                        <th
                            scope="row"
                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                        >
                            {{ data.uuid }}
                        </th>
                        <td class="px-6 py-4">-</td>
                        <td class="px-6 py-4 uppercase">
                            {{ data.group_company?.name }}
                        </td>
                        <td class="px-6 py-4">
                            <span>
                                {{ _getPaymentDayDate(data.payment_day) }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <span
                                class="inline-flex items-center rounded-md bg-red-50 px-2 py-1 text-xs font-medium text-red-700 ring-1 ring-red-600/20 ring-inset"
                                v-if="data.current_month_status == 'pay'"
                                >PAGAR</span
                            >
                            <span
                                class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-green-600/10 ring-inset"
                                v-else-if="data.current_month_status == 'paid'"
                                >PAGO</span
                            >
                            <span
                                class="inline-flex items-center rounded-md bg-yellow-50 px-2 py-1 text-xs font-medium text-yellow-700 ring-1 ring-yellow-600/10 ring-inset"
                                v-else-if="data.current_month_status == 'late'"
                                >ATRASADO</span
                            >
                            <span
                                class="inline-flex items-center rounded-md bg-slate-50 px-2 py-1 text-xs font-medium text-slate-700 ring-1 ring-slate-600/10 ring-inset"
                                v-else-if="
                                    data.current_month_status == 'overdue'
                                "
                                >VENCIDA</span
                            >
                        </td>
                        <td class="px-6 py-4">
                            <span
                                class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-green-600/20 ring-inset"
                                v-if="data.activated"
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
                                @click="_showDropDown"
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
                                class="z-10 hidden fixed bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-44 dark:bg-gray-700 dark:divide-gray-600 uppercase"
                            >
                                <ul
                                    class="py-2 text-sm text-gray-700 dark:text-gray-200"
                                    aria-labelledby="dropdownMenuIconButton"
                                >
                                    <li>
                                        <a
                                            href="#"
                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
                                            @click.prevent="
                                                _copyText(data.uuid)
                                            "
                                        >
                                            Cópiar CÓD
                                        </a>
                                    </li>
                                    <li>
                                        <a
                                            href="#"
                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
                                            @click.prevent="_loadData(data.id)"
                                        >
                                            Vincular dados
                                        </a>
                                    </li>
                                    <li>
                                        <Link
                                            :href="
                                                route(
                                                    'historic_company',
                                                    { company_uuid: data.uuid }
                                                )
                                            "
                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
                                        >
                                            Mensalidades
                                        </Link>
                                    </li>
                                    <li>
                                        <a
                                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white cursor-pointer"
                                            data-modal-target="look-more-company"
                                            data-modal-toggle="look-more-company"
                                            @click.prevent="_loadModal(data)"
                                        >
                                            Visualizar empresa
                                        </a>
                                    </li>
                                    <li>
                                        <Link
                                            :href="
                                                route(
                                                    'company.updateView',
                                                    data.id
                                                )
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
                                            v-if="true"
                                            @click.prevent="
                                                _toggleActive(data.id)
                                            "
                                            >{{
                                                data.activated
                                                    ? "Desativar"
                                                    : "Ativar"
                                            }}</a
                                        >
                                    </li>
                                </ul>
                                <div class="py-2">
                                    <a
                                        class="block px-4 py-2 text-sm text-red-600 font-bold hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white"
                                        @click.prevent="_delete(data.id)"
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
            :pagination="$page.props.companies"
            :onEachSize="3"
            @paginate="paginate"
        ></Paginate>
        <!-- END ACTIONS -->
    </div>

    <Modal title="Detalhes empresa" id="look-more-company">
        <ul>
            <li>
                <span class="font-semibold">Nome: </span>
                {{ data_modal?.name }}
            </li>
            <li>
                <span class="font-semibold">Dono: </span>
                {{ data_modal?.owner }}
            </li>
            <li>
                <span class="font-semibold">Grupo: </span>
                <span class="uppercase">
                    {{ data_modal?.group_company?.name }}</span
                >
            </li>
            <li>
                <span class="font-semibold">Dia pagamento: </span>
                {{
                    data_modal?.payment_day
                        ? _getPaymentDayDate(data_modal?.payment_day)
                        : null
                }}
            </li>
            <li>
                <span class="font-semibold">Fiscal: </span>
                <span
                    v-if="!data_modal?.isFiscal"
                    class="inline-flex items-center rounded-md bg-red-50 px-2 py-1 text-xs font-medium text-red-700 ring-1 ring-red-600/20 ring-inset"
                    >NÃO</span
                >
                <span
                    class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-green-600/10 ring-inset"
                    v-else
                    >SIM</span
                >
            </li>
            <li>
                <span class="font-semibold">Mês atual status: </span>
                <span
                    class="inline-flex items-center rounded-md bg-red-50 px-2 py-1 text-xs font-medium text-red-700 ring-1 ring-red-600/20 ring-inset"
                    v-if="data_modal?.current_month_status == 'pay'"
                    >PAGAR</span
                >
                <span
                    class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-green-600/10 ring-inset"
                    v-else-if="data_modal?.current_month_status == 'paid'"
                    >PAGO</span
                >
                <span
                    class="inline-flex items-center rounded-md bg-yellow-50 px-2 py-1 text-xs font-medium text-yellow-700 ring-1 ring-yellow-600/10 ring-inset"
                    v-else-if="data_modal?.current_month_status == 'late'"
                    >ATRASADO</span
                >
                <span
                    class="inline-flex items-center rounded-md bg-slate-50 px-2 py-1 text-xs font-medium text-slate-700 ring-1 ring-slate-600/10 ring-inset"
                    v-else-if="data_modal?.current_month_status == 'overdue'"
                    >VENCIDA</span
                >
            </li>
            <li>
                <span class="font-semibold">Ativado: </span>
                <span
                    v-if="!data_modal?.activated"
                    class="inline-flex items-center rounded-md bg-red-50 px-2 py-1 text-xs font-medium text-red-700 ring-1 ring-red-600/20 ring-inset"
                    >NÃO</span
                >
                <span
                    class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-green-600/10 ring-inset"
                    v-else
                    >SIM</span
                >
            </li>
            <li>
                <span class="font-semibold">Cadastro por e data: </span>
                <br />
                {{ data_modal?.created_by_user_name ?? "ID Nulo" }} <br />
                {{ _dateISOBr(data_modal?.created_at) }}
            </li>

            <li>
                <span class="font-semibold">Atualizada por e data: </span>
                <br />
                {{ data_modal?.updated_by_user_name ?? "ID Nulo" }} <br />
                {{ _dateISOBr(data_modal?.updated_at) }}
            </li>
            <li>
                <span class="font-semibold"
                    >Mensalidade, valor atual (R$):</span
                >
                {{ data_modal?.value_monthly_fee_formated }}
            </li>
            <li>
                <span class="font-semibold">Sistemas usados:</span>
                <ul class="list-disc ml-10">
                    <li v-for="value in data_modal?.systems_useds">
                        {{ value }}
                    </li>
                </ul>
            </li>
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
import { onMounted, onUnmounted, ref } from "vue";
import Swal from "sweetalert2";
import { route } from "ziggy-js";
import { router, usePage, useForm } from "@inertiajs/vue3";
import { _copyText, _dateISOBr, _confirmPassword, getNormalUrlParamter } from "@utils/functions";
import SidebarLayout from "@/layouts/SidebarLayout.vue";
import Input from "@/components/Input.vue";
import Button from "@/components/Button.vue";
import Modal from "@/components/Modal.vue";
import Paginate from "../../components/Paginate.vue";

const page = usePage();
const form = useForm({
    uuid: null,
    company_name: null,
    monthly_fee_status:"",
    group_company:"",
});
const data_modal = ref({});

const isShowDropDown = ref(false);

function _getPaymentDayDate(day) {
    let date = new Date();
    date.setDate(day);
    return date.toLocaleDateString("pt-BR", {
        day: "2-digit",
        month: "2-digit",
        year: "numeric",
    });
}

function _loadModal(company) {
    data_modal.value = company;
    data_modal.value.name = "";
    data_modal.value.owner = "";
}

function _toggleActive(id) {
    router.patch(route("company.toggleActive", id));
}

function _delete(id) {
    _confirmPassword(() => {
        router.delete(route("company.delete", [id]));
    });
}
function _loadData(id) {
    router.post(route("company.loadData"), { id: id });
}
function _loadAllData() {
    router.post(route("company.loadAllData"));
}

function _search(){
    form.get(route('company'), {}, {
        preserveState: true
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

function _showDropDown(){
    isShowDropDown.value = true;
}

function handleClickOutside(event) {
    // Fecha o dropdown se clicar fora de qualquer elemento com ID dropdownDots e dropdownMenuIconButton...
    if (!event.target.closest("[id^='dropdownDots']") && !event.target.closest("#dropdownMenuIconButton")) {
        isShowDropDown.value = false;
    }
}

function _linkAllCompanies() {
    alert("Vincular todas empresas: nome");
}

function _loadForm(){
    form.company_name = getNormalUrlParamter('company_name') ?? null;
    form.uuid = getNormalUrlParamter('uuid') ?? null;
    form.monthly_fee_status = getNormalUrlParamter('monthly_fee_status') ?? "";
    form.group_company = getNormalUrlParamter('group_company') ?? "";
}

onMounted(() => {
    document.addEventListener("click", handleClickOutside);
    _loadForm();
});

onUnmounted(() => {
    document.removeEventListener("click", handleClickOutside);
});

defineOptions({
    layout: SidebarLayout,
});
</script>
