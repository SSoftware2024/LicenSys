<template>
    <!-- BUTTON SIDEBAR -->
    <!-- mude sidebar hide aqui: md:hidden, onde tem a classe de screen -->
    <button
        data-drawer-target="sidebar-multi-level-sidebar"
        data-drawer-toggle="sidebar-multi-level-sidebar"
        aria-controls="sidebar-multi-level-sidebar"
        type="button"
        class="inline-flex items-center p-2 mt-2 ms-3 text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
    >
        <span class="sr-only">Open sidebar</span>
        <svg
            class="w-6 h-6"
            aria-hidden="true"
            fill="currentColor"
            viewBox="0 0 20 20"
            xmlns="http://www.w3.org/2000/svg"
        >
            <path
                clip-rule="evenodd"
                fill-rule="evenodd"
                d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"
            ></path>
        </svg>
    </button>
    <!-- END BUTTON SIDEBAR -->

    <!-- SIDEBAR -->

    <!-- mude sidebar hide aqui: md:translate-x-0, onde tem a classe de screen  -->
    <aside
        id="sidebar-multi-level-sidebar"
        data-drawer-backdrop="true"
        class="fixed top-0 left-0 z-40 w-64 h-screen transition-transform -translate-x-full md:translate-x-0"
        aria-label="Sidebar"
    >
        <div
            class="h-full px-3 py-4 overflow-y-auto bg-gradient-to-r from-gray-100 to-zinc-100 dark:bg-gray-800 dark:bg-none"
        >
            <ul class="space-y-2 font-medium">
                <li class="lg:hidden">
                    <a
                        href="#"
                        class="flex items-center p-2 text-yellow-900 rounded-lg dark:yellow-white hover:bg-yellow-100 dark:hover:bg-yellow-700 group"
                        @click="_closeSidebar"
                    >
                        <svg
                            class="w-6 h-6 text-yellow-800 dark:yellow-white"
                            aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg"
                            width="24"
                            height="24"
                            fill="none"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke="currentColor"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="m17 16-4-4 4-4m-6 8-4-4 4-4"
                            />
                        </svg>

                        <span class="ms-3"> Fechar Sidebar </span>
                    </a>
                </li>
                <li>
                    <Link
                        :href="route('index')"
                        :class="{
                            'flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group': true,
                            'text-lime-700': route().current('index'),
                        }"
                    >
                        <svg
                            :class="{
                                'w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white': true,
                                'text-lime-700 group-hover:text-lime-900':
                                    route().current('index'),
                            }"
                            aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="currentColor"
                            viewBox="0 0 22 21"
                        >
                            <path
                                d="M16.975 11H10V4.025a1 1 0 0 0-1.066-.998 8.5 8.5 0 1 0 9.039 9.039.999.999 0 0 0-1-1.066h.002Z"
                            />
                            <path
                                d="M12.5 0c-.157 0-.311.01-.565.027A1 1 0 0 0 11 1.02V10h8.975a1 1 0 0 0 1-.935c.013-.188.028-.374.028-.565A8.51 8.51 0 0 0 12.5 0Z"
                            />
                        </svg>
                        <span class="ms-3"> Dashboard </span>
                    </Link>
                </li>
                <li>
                    <Link
                        :href="route('system')"
                        :class="{
                            'flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group': true,
                            'text-lime-700': route().current('system'),
                        }"
                    >
                        <svg
                            :class="{
                                'w-6 h-6 text-gray-800 dark:text-white': true,
                                'text-lime-700 group-hover:text-lime-900':
                                    route().current('system'),
                            }"
                            aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg"
                            width="24"
                            height="24"
                            fill="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                fill-rule="evenodd"
                                d="M4 5.78571C4 4.80909 4.78639 4 5.77778 4H18.2222C19.2136 4 20 4.80909 20 5.78571V15H4V5.78571ZM12 12c0-.5523.4477-1 1-1h2c.5523 0 1 .4477 1 1s-.4477 1-1 1h-2c-.5523 0-1-.4477-1-1ZM8.27586 6.31035c.38089-.39993 1.01387-.41537 1.4138-.03449l2.62504 2.5c.1981.18875.3103.45047.3103.72414 0 .27368-.1122.5354-.3103.7241l-2.62504 2.5c-.39993.3809-1.03291.3655-1.4138-.0344-.38088-.4-.36544-1.033.03449-1.4138L10.175 9.5 8.31035 7.72414c-.39993-.38089-.41537-1.01386-.03449-1.41379Z"
                                clip-rule="evenodd"
                            />
                            <path
                                d="M2 17v1c0 1.1046.89543 2 2 2h16c1.1046 0 2-.8954 2-2v-1H2Z"
                            />
                        </svg>

                        <span class="flex-1 ms-3 whitespace-nowrap">
                            Sistema
                        </span>
                    </Link>
                </li>
                <li>
                    <button
                        type="button"
                        class="flex items-center w-full p-2 text-base text-gray-900 transition duration-75 rounded-lg group cursor-pointer hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                        aria-controls="dropdown-example"
                        data-collapse-toggle="dropdown-example"
                    >
                        <svg
                            class="w-6 h-6 text-gray-800 dark:text-white"
                            aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg"
                            width="24"
                            height="24"
                            fill="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                fill-rule="evenodd"
                                d="M12 6a3.5 3.5 0 1 0 0 7 3.5 3.5 0 0 0 0-7Zm-1.5 8a4 4 0 0 0-4 4 2 2 0 0 0 2 2h7a2 2 0 0 0 2-2 4 4 0 0 0-4-4h-3Zm6.82-3.096a5.51 5.51 0 0 0-2.797-6.293 3.5 3.5 0 1 1 2.796 6.292ZM19.5 18h.5a2 2 0 0 0 2-2 4 4 0 0 0-4-4h-1.1a5.503 5.503 0 0 1-.471.762A5.998 5.998 0 0 1 19.5 18ZM4 7.5a3.5 3.5 0 0 1 5.477-2.889 5.5 5.5 0 0 0-2.796 6.293A3.501 3.501 0 0 1 4 7.5ZM7.1 12H6a4 4 0 0 0-4 4 2 2 0 0 0 2 2h.5a5.998 5.998 0 0 1 3.071-5.238A5.505 5.505 0 0 1 7.1 12Z"
                                clip-rule="evenodd"
                            />
                        </svg>

                        <span
                            class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap"
                            >Usuários</span
                        >
                        <svg
                            class="w-3 h-3"
                            aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 10 6"
                        >
                            <path
                                stroke="currentColor"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="m1 1 4 4 4-4"
                            />
                        </svg>
                    </button>
                    <ul id="dropdown-example" class="hidden py-2 space-y-2">
                        <li>
                            <Link
                                :href="route('user', { type: 'default' })"
                                :class="{
                                    'flex pl-11 items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group': true,
                                    'text-lime-700': route().current('user', {
                                        type: 'default',
                                    }),
                                }"
                            >
                                Comum
                            </Link>
                        </li>
                        <li>
                            <Link
                                :href="route('user', { type: 'admin' })"
                                :class="{
                                    'flex pl-11 items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group': true,
                                    'text-lime-700': route().current('user', {
                                        type: 'admin',
                                    }),
                                }"
                            >
                                Administrador
                            </Link>
                        </li>
                    </ul>
                </li>
                <li>
                    <Link
                        :href="route('company')"
                        :class="{
                            'flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group': true,
                            'text-lime-700': route().current('company'),
                        }"
                    >
                        <svg
                            :class="{
                                'w-6 h-6 text-gray-800 dark:text-white': true,
                                'text-lime-700 group-hover:text-lime-900':
                                    route().current('company'),
                            }"
                            aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg"
                            width="24"
                            height="24"
                            fill="none"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke="currentColor"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M6 4h12M6 4v16M6 4H5m13 0v16m0-16h1m-1 16H6m12 0h1M6 20H5M9 7h1v1H9V7Zm5 0h1v1h-1V7Zm-5 4h1v1H9v-1Zm5 0h1v1h-1v-1Zm-3 4h2a1 1 0 0 1 1 1v4h-4v-4a1 1 0 0 1 1-1Z"
                            />
                        </svg>

                        <span class="flex-1 ms-3 whitespace-nowrap"
                            >Empresas</span
                        >
                    </Link>
                </li>
                <li>
                    <Link
                        :href="route('company_group')"
                        :class="{
                            'flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group': true,
                            'text-lime-700': route().current('company_group'),
                        }"
                    >
                        <svg
                            :class="{
                                'w-6 h-6 text-gray-800 dark:text-white': true,
                                'text-lime-700 group-hover:text-lime-900':
                                    route().current('company_group'),
                            }"
                            aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg"
                            width="24"
                            height="24"
                            fill="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                fill-rule="evenodd"
                                d="M3 6a2 2 0 0 1 2-2h5.532a2 2 0 0 1 1.536.72l1.9 2.28H3V6Zm0 3v10a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V9H3Z"
                                clip-rule="evenodd"
                            />
                        </svg>

                        <span class="flex-1 ms-3 whitespace-nowrap"
                            >Grupo Empresa</span
                        >
                    </Link>
                </li>
                <li>
                    <button
                        type="button"
                        class="flex items-center w-full p-2 text-base text-gray-900 transition duration-75 rounded-lg group cursor-pointer hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                        aria-controls="dropdown-examples"
                        data-collapse-toggle="dropdown-examples"
                    >
                        <svg
                            class="w-6 h-6 text-gray-800 dark:text-white"
                            aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg"
                            width="24"
                            height="24"
                            fill="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                fill-rule="evenodd"
                                d="M5.617 2.076a1 1 0 0 1 1.09.217L8 3.586l1.293-1.293a1 1 0 0 1 1.414 0L12 3.586l1.293-1.293a1 1 0 0 1 1.414 0L16 3.586l1.293-1.293A1 1 0 0 1 19 3v18a1 1 0 0 1-1.707.707L16 20.414l-1.293 1.293a1 1 0 0 1-1.414 0L12 20.414l-1.293 1.293a1 1 0 0 1-1.414 0L8 20.414l-1.293 1.293A1 1 0 0 1 5 21V3a1 1 0 0 1 .617-.924ZM9 7a1 1 0 0 0 0 2h6a1 1 0 1 0 0-2H9Zm0 4a1 1 0 1 0 0 2h6a1 1 0 1 0 0-2H9Zm0 4a1 1 0 1 0 0 2h6a1 1 0 1 0 0-2H9Z"
                                clip-rule="evenodd"
                            />
                        </svg>

                        <span
                            class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap"
                            >Mensalidade</span
                        >
                        <svg
                            class="w-3 h-3"
                            aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 10 6"
                        >
                            <path
                                stroke="currentColor"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="m1 1 4 4 4-4"
                            />
                        </svg>
                    </button>
                    <ul id="dropdown-examples" class="hidden py-2 space-y-2">
                        <li>
                            <Link
                                :href="route('historic_company')"
                                :class="{
                                    'flex pl-11 items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group': true,
                                    'text-lime-700': route().current('historic_company'),
                                }"
                            >
                                Mensalidade
                            </Link>
                        </li>
                        <li>
                            <a
                                href="#"
                                class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                                >Receber</a
                            >
                        </li>
                    </ul>
                </li>

                <li>
                    <a
                        href="#"
                        class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group"
                    >
                        <svg
                            class="w-6 h-6 text-gray-800 dark:text-white"
                            aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg"
                            width="24"
                            height="24"
                            fill="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                fill-rule="evenodd"
                                d="M5 8a4 4 0 1 1 7.796 1.263l-2.533 2.534A4 4 0 0 1 5 8Zm4.06 5H7a4 4 0 0 0-4 4v1a2 2 0 0 0 2 2h2.172a2.999 2.999 0 0 1-.114-1.588l.674-3.372a3 3 0 0 1 .82-1.533L9.06 13Zm9.032-5a2.907 2.907 0 0 0-2.056.852L9.967 14.92a1 1 0 0 0-.273.51l-.675 3.373a1 1 0 0 0 1.177 1.177l3.372-.675a1 1 0 0 0 .511-.273l6.07-6.07a2.91 2.91 0 0 0-.944-4.742A2.907 2.907 0 0 0 18.092 8Z"
                                clip-rule="evenodd"
                            />
                        </svg>

                        <span class="flex-1 ms-3 whitespace-nowrap"
                            >Perfil</span
                        >
                    </a>
                </li>
                <li>
                    <a
                        href="#"
                        @click="logout"
                        class="flex items-center p-2 text-gray-900 hover:text-red-500 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group"
                    >
                        <svg
                            class="shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-red-500 dark:group-hover:text-white"
                            aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 18 16"
                        >
                            <path
                                stroke="currentColor"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M1 8h11m0 0L8 4m4 4-4 4m4-11h3a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-3"
                            />
                        </svg>
                        <span class="flex-1 ms-3 whitespace-nowrap">Sair</span>
                    </a>
                </li>
            </ul>
        </div>
    </aside>

    <!-- END SIDEBAR -->

    <!-- CONTENT -->
    <div class="px-4 py-2 md:ml-64">
        <div class="container m-auto">
            <Card>
                <slot></slot>
            </Card>
        </div>
    </div>
    <!-- END CONTENT -->
</template>
<script setup>
import { usePage, router, Link } from "@inertiajs/vue3";
import { route } from "ziggy-js";

//LAYOUTS E COMPONENTS
import Card from "@/components/Card.vue";

const page = usePage();

function logout() {
    router.post(page.props.routes_fortify.logout_post, {
        onSuccess: () => router.get(page.props.routes_fortify.login_get),
    });
}

function _closeSidebar() {
    const escEvent = new KeyboardEvent("keydown", { key: "Escape" });
    document.dispatchEvent(escEvent);
}
</script>
