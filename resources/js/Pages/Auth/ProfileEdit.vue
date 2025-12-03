<template>
    <Head title="Save User" />
    <h2 class="font-bold text-2xl underline mb-2">Atualizar Perfil</h2>
    <div class="xl:w-200">
        <form @submit.prevent="_updateProfile">
            <div>
                <Input
                    type="text"
                    label="Nome"
                    id="name"
                    name="name"
                    :isInputRequired="true"
                    :isInvalid="!!form.errors?.name"
                    v-model="form.name"
                />
                <div v-if="form.errors?.updateProfileInformation?.name" class="text-red-500">
                    {{ form.errors?.updateProfileInformation?.name }}
                </div>
            </div>
            <div>
                <Input
                    type="email"
                    label="E-mail"
                    id="email"
                    name="email"
                    :isInputRequired="true"
                    :isInvalid="!!form.errors?.email"
                    v-model="form.email"
                />
                <div v-if="form.errors?.updateProfileInformation?.email" class="text-red-500">
                    {{ form.errors?.updateProfileInformation?.email }}
                </div>
            </div>
            <div class="flex justify-end mt-2">
                <Button
                    text="Salvar"
                    type="submit"
                    typeButton="primary"
                    :isDisable="form.processing"
                    :isLoading="form.processing"
                ></Button>
            </div>
        </form>

        <div class="w-full h-0.5 bg-black mt-2 mb-2"></div>

        <form @submit.prevent="_updatePassword">
            <div>
                <Input
                    type="password"
                    label="Senha antiga"
                    id="old_password"
                    name="old_password"
                    :isInputRequired="true"
                    :isInvalid="!!form_password.errors?.updatePassword?.current_password"
                    v-model="form_password.current_password"
                />
                <div v-if="form_password.errors?.updatePassword?.current_password" class="text-red-500">
                    {{ form_password.errors?.updatePassword?.current_password }}
                </div>
            </div>
            <div class="flex">
                <div class="flex flex-col w-full mr-1">
                    <Input
                        type="password"
                        label="Nova senha"
                        id="password"
                        name="password"
                        :isInputRequired="true"
                        :isInvalid="!!form_password.errors?.updatePassword?.password"
                        v-model="form_password.password"
                    />
                    <div
                        v-if="form_password.errors?.updatePassword?.password"
                        class="text-red-500"
                    >
                        {{ form_password.errors?.updatePassword?.password }}
                    </div>
                </div>
                <div class="flex flex-col w-full ml-1">
                    <Input
                        type="password"
                        label="Confirmar senha"
                        id="password_confirmation"
                        name="password_confirmation"
                        :isInputRequired="true"
                        :isInvalid="
                            !!form_password.errors?.updatePassword?.password_confirmation
                        "
                        v-model="form_password.password_confirmation"
                    />
                </div>
            </div>
            <div class="flex justify-end mt-2">
                <Button
                    text="Atualizar senha"
                    type="submit"
                    typeButton="dark"
                    :isDisable="form_password.processing"
                    :isLoading="form_password.processing"
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
    name: "",
    email: "",
});

const form_password = useForm({
    password: "",
    current_password: "",
    password_confirmation: "",
});

function _loadUserData() {
    form.name = page.props.user.name;
    form.email = page.props.user.email;
}

function _updateProfile() {
    form.patch(route("user.profileEdit"));
}
function _updatePassword() {
    form_password.patch(route("user.updatePassword"), {
        onSuccess: () => {
            form_password.reset();
        },
    });
}

onMounted(() => {
    _loadUserData();
});
defineOptions({
    layout: SidebarLayout,
});
</script>
