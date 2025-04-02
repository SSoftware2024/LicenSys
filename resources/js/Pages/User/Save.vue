<template>
    <Head title="Save User" />
    <!-- Save user {{ $page.props.type_user ? ` - ${$page.props.type_user}` : '' }} -->
    <h2 class="font-bold text-2xl underline mb-2">
        {{ $page.props.operation == "create" ? "Cadastrar" : "Editar" }}
        <span class="uppercase">
            {{ $page.props.type_user == 'admin' ? ` - ${$page.props.type_user}` : "" }}
        </span>
    </h2>
    <div class="xl:w-200">
        <form @submit.prevent="save">
            <div>
                <Input
                    type="text"
                    label="Nome"
                    id="name"
                    name="name"
                    :isInputRequired="true"
                    :isInvalid="!!form.errors.name"
                    v-model="form.name"
                />
                <div v-if="form.errors.name" class="text-red-500">
                    {{ form.errors.name }}
                </div>
            </div>
            <div>
                <Input
                    type="email"
                    label="E-mail"
                    id="email"
                    name="email"
                    :isInputRequired="true"
                    :isInvalid="!!form.errors.email"
                    v-model="form.email"
                />
                <div v-if="form.errors.email" class="text-red-500">
                    {{ form.errors.email }}
                </div>
            </div>
            <div class="flex">
                <div class="flex flex-col w-full mr-1">
                    <Input
                        type="password"
                        label="Senha"
                        id="password"
                        name="password"
                        :isInputRequired="true"
                        :isInvalid="!!form.errors.password"
                        v-model="form.password"
                    />
                    <div v-if="form.errors.password" class="text-red-500">
                        {{ form.errors.password }}
                    </div>
                </div>
                <div class="flex flex-col w-full ml-1">
                    <Input
                        type="password"
                        label="Confirmar senha"
                        id="password_confirmation"
                        name="password_confirmation"
                        :isInputRequired="true"
                        :isInvalid="!!form.errors.password_confirmation"
                        v-model="form.password_confirmation"
                    />
                </div>
            </div>
            <div class="mt-2">
                <div class="flex items-center">
                    <input
                        checked
                        v-model="form.activated"
                        name="activated"
                        id="checked-checkbox"
                        type="checkbox"
                        value=""
                        class="w-4.5 h-4.5 cursor-pointer text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                    />
                    <label
                        for="checked-checkbox"
                        class="ms-2 text-sm cursor-pointer uppercase font-medium text-gray-900 dark:text-gray-300"
                        >Ativar</label
                    >
                </div>
            </div>
            <div class="flex justify-end">
                <Button
                    text="Salvar"
                    type="submit"
                    typeButton="primary"
                    :isDisable="form.processing"
                    :isLoading="form.processing"
                ></Button>
            </div>
        </form>
    </div>
</template>

<script setup>
import { ref } from "vue";
import { useForm, usePage } from "@inertiajs/vue3";
import { route } from "ziggy-js";
import SidebarLayout from "@/layouts/SidebarLayout.vue";
import Input from "@/components/Input.vue";
import Button from "@/components/Button.vue";
const page = usePage();
const form = useForm({
    name: "",
    email: "",
    password: "",
    password_confirmation: "",
    activated: true,
});
function save() {
    form.transform((data) => ({
        ...data,
        operation: page.props.operation,
        type: page.props.type_user,
    })).post(route("user.save"), {
        onSuccess: () => form.reset('password','password_confirmation')
    });
}
defineOptions({
    layout: SidebarLayout,
});
</script>
