<template>
    <Head title="Sistema" />
    <h2 class="font-bold text-2xl underline mb-2">Sistema</h2>
    <div class="xl:w-200">
        <form @submit.prevent="save">
            <Input
                type="number"
                label="Limite de dias (expiração)"
                id="number_days"
                name="limit_days"
                :isInputRequired="true"
                :isInvalid="!!form.errors.limit_days"
                v-model="form.limit_days"
            />
            <div v-if="form.errors.limit_days" class="text-red-500">
                {{ form.errors.limit_days }}
            </div>
            <div class="flex sm:flex-wrap md:flex-nowrap">
                <div class="flex flex-col w-full m-1">
                    <Input
                        type="text"
                        label="Cód. Acesso API"
                        id="code_access_api"
                        name="code_access_api"
                        :isInputRequired="true"
                        :isInvalid="!!form.errors.code_access_api"
                        v-model="form.code_access_api"
                    />
                    <div
                        v-if="form.errors.code_access_api"
                        class="text-red-500"
                    >
                        {{ form.errors.code_access_api }}
                    </div>
                </div>

                <div class="flex flex-col w-full m-1">
                    <Input
                        type="text"
                        label="Cód. Acesso API - Genéricos"
                        id="code_access_api_generics_systems"
                        name="code_access_api_generics_systems"
                        :isInputRequired="true"
                        :isInvalid="
                            !!form.errors.code_access_api_generics_systems
                        "
                        v-model="form.code_access_api_generics_systems"
                    />
                    <div
                        v-if="form.errors.code_access_api_generics_systems"
                        class="text-red-500"
                    >
                        {{ form.errors.code_access_api_generics_systems }}
                    </div>
                </div>
            </div>
            <div class="flex">
                <div class="flex flex-col w-full m-1">
                    <Input
                        type="text"
                        label="Cód. Acesso API - (Apenas leitura)"
                        id="code_access_api_readonly"
                        class="bg-gray-200"
                        readonly
                        v-model="form.code_access_api_readonly"
                    />
                </div>
                <div class="flex flex-col w-full m-1">
                    <Input
                        type="text"
                        label="Cód. Acesso API - Genéricos - (Apenas leitura)"
                        id="code_access_api_generics_systems_readonly"
                        class="bg-gray-200"
                        readonly
                        v-model="form.code_access_api_generics_systems_readonly"
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
            <div>
                <p>
                    Última edição: <span>{{ last_edition }}</span>
                </p>
            </div>
        </form>
    </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import { route } from "ziggy-js";
import { useForm, usePage } from "@inertiajs/vue3";
import dateObject from "@/utils/date";

//COMPONENTS E LAYOUTS
import SidebarLayout from "../layouts/SidebarLayout.vue";
import Input from "@/components/Input.vue";
import Button from "@/components/Button.vue";

const last_edition = ref("");

const page = usePage();
const form = useForm({
    limit_days: 0,
    code_access_api: "",
    code_access_api_generics_systems: "",
    code_access_api_readonly: "",
    code_access_api_generics_systems_readonly: "",
});

function save() {
    form.post(route("system.save"), {
        onSuccess: () => _loadForm(),
    });
}


function _loadForm() {
    const data = page.props.system_saved;
    if (data) {
        form.limit_days = data.limit_days;
        form.code_access_api = data.code_access_api;
        form.code_access_api_generics_systems =
            data.code_access_api_generics_systems;
        form.code_access_api_readonly = data.code_access_api_cripty;
        form.code_access_api_generics_systems_readonly =
            data.code_access_api_generics_systems_cripty;
        last_edition.value = dateObject.formatDate(data.updated_at);
    }
}

onMounted(() => {
    _loadForm();
});

defineOptions({
    layout: SidebarLayout,
});
</script>
