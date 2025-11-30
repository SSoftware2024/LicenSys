<template>
    <Head title="Save User" />
    <h2 class="font-bold text-2xl underline mb-2">Atualizar Perfil</h2>
    <div class="xl:w-200">
        <form>
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
import { ref, onMounted } from "vue";
import { useForm, usePage } from "@inertiajs/vue3";
import { route } from "ziggy-js";
import SidebarLayout from "@/layouts/SidebarLayout.vue";
import Input from "@/components/Input.vue";
import Button from "@/components/Button.vue";
const page = usePage();
const form = useForm({
    id: 0,
    name: "",
    email: "",
    password: "",
    password_confirmation: "",
});


onMounted(() => {
});
defineOptions({
    layout: SidebarLayout,
});
</script>
