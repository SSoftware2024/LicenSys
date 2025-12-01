<template>
    <Head title="Save User" />
    <h2 class="font-bold text-2xl underline mb-2">Confirmar email</h2>
    <p>
    Administrador récem cadastrado por favor, confirme seu email ou reenvie link para ativação. <br/>
    As <span class="text-red-500 font-bold">páginas</span> ficarão <span class="text-red-500 font-bold">inacessíveis</span> até ativação do mesmo.<br/>
    O e-mail é válido por 60 minutos após o envio.
    </p>
    <div class="xl:w-200">
        <form @submit.prevent="_sendEmail">
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
import Button from "@/components/Button.vue";
import { useToast } from "vue-toast-notification";
const page = usePage();
const form = useForm({});
const toast = useToast();

function _sendEmail() {
    form.post(route("verification.send"), {
        preserveScroll: true,
        onSuccess: () => {
            toast.info('E-mail de verificação reenviado com sucesso! Por favor, verifique sua caixa de entrada.', {
                position: 'top-right',
            });
        },
    });
}


onMounted(() => {
});
defineOptions({
    layout: SidebarLayout,
});
</script>
