<template>
    <Head title="Save User" />
    <h2 class="font-bold text-2xl underline mb-2">Confirmar email</h2>
    <p>
    Administrador récem cadastrado por favor, confirme seu email ou reenvie link para ativação. <br/>
    As <span class="text-red-500 font-bold">páginas</span> ficarão <span class="text-red-500 font-bold">inacessíveis</span> até ativação do mesmo.
    </p>
    <div class="xl:w-200">
        <form>
            <div class="flex justify-end mt-3">
                <Button
                    text="Enviar e-mail"
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
