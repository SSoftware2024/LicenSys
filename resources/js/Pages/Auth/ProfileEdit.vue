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
                <div
                    v-if="form.errors?.updateProfileInformation?.name"
                    class="text-red-500"
                >
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
                <div
                    v-if="form.errors?.updateProfileInformation?.email"
                    class="text-red-500"
                >
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
                    :isInvalid="
                        !!form_password.errors?.updatePassword?.current_password
                    "
                    v-model="form_password.current_password"
                />
                <div
                    v-if="
                        form_password.errors?.updatePassword?.current_password
                    "
                    class="text-red-500"
                >
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
                        :isInvalid="
                            !!form_password.errors?.updatePassword?.password
                        "
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
                            !!form_password.errors?.updatePassword
                                ?.password_confirmation
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

        <div class="w-full h-0.5 bg-black mt-2 mb-2"></div>

        <!-- AUTENTICAÇÃO DOIS FATORES -->
        <div class="w-full">
            <div
                class="flex justify-start mt-2"
                v-if="!$page.props.twofa_status.enabled"
            >
                <Button
                    text="Habilitar 2FA"
                    type="submit"
                    typeButton="primary"
                    @click.prevent="_enable2FA"
                ></Button>
            </div>
            <div
                class="flex justify-start mt-2 gap-1"
                v-if="
                    $page.props.twofa_status.enabled &&
                    $page.props.twofa_status.cofirmed
                "
            >
                <Button
                    text="Desabilitar 2FA"
                    type="button"
                    typeButton="red"
                    @click.prevent="_disable2FA"
                ></Button>
                <Button
                    text="Novos Códigos"
                    type="button"
                    typeButton="dark"
                    @click.prevent="_newRecoveryCodes"
                ></Button>
                <Button
                    text="Resgatar Códigos"
                    type="button"
                    typeButton="dark"
                    @click.prevent="_showRecoveryCodes"
                ></Button>
            </div>
        </div>
        <div
            v-if="
                $page.props.twofa_status.enabled &&
                !$page.props.twofa_status.cofirmed
            "
        >
            <form>
                <div>
                    <Button
                        text="Confirmar 2FA"
                        type="submit"
                        typeButton="primary"
                        @click.prevent="_confirm2FA"
                    ></Button>
                </div>
                <div class="flex flex-col w-full ml-1 mt-2 mb-2">
                    <Input
                        type="text"
                        id="twofa_code_confirmation"
                        name="twofa_code_confirmation"
                        maxlength="6"
                        :isInputRequired="true"
                        v-model="twofa_code"
                    />
                </div>
                <div
                    v-if="
                        $page.props.errors?.confirmTwoFactorAuthentication?.code
                    "
                    class="text-red-500"
                >
                    {{
                        $page.props.errors?.confirmTwoFactorAuthentication?.code
                    }}
                </div>
            </form>
        </div>
        <div class="w-full">
            <div
                class="inline-block p-2 mt-4 bg-white"
                v-html="twofa.qrCode"
                v-if="twofa.qrCode"
            ></div>
        </div>
        <div v-if="twofa.setupKey" class="max-w-xl mt-4 text-sm text-gray-600">
            <p class="text-xl font-semibold dark:text-neutral-50">
                Alternativa QrCode (chave secreta):
                <span v-html="twofa.setupKey"></span>
            </p>
        </div>
        <div v-if="twofa.recoveryCodes.length > 0 && !confirming">
            <div
                class="max-w-xl mt-4 text-sm text-gray-600 dark:text-neutral-50"
            >
                <p class="font-semibold">
                    Armazene esses códigos de recuperação em um gerenciador de
                    senhas seguras. Eles podem ser usados para recuperar o
                    acesso à sua conta se o seu dispositivo de autenticação de
                    dois fatores for perdido.
                </p>
            </div>

            <div
                class="grid max-w-xl gap-1 px-4 py-4 mt-4 font-mono text-sm bg-gray-100 rounded-lg dark:bg-zinc-600 dark:text-neutral-50"
            >
                <div v-for="code in twofa.recoveryCodes" :key="code">
                    {{ code }}
                </div>
            </div>
            <div class="flex justify-start mt-2">
                <Button
                    text="Baixar Códigos"
                    type="submit"
                    typeButton="dark"
                    @click.prevent="_downloadRecoveryCodes"
                ></Button>
            </div>
        </div>

        <!-- FIM AUTENTICAÇÃO DOIS FATORES -->
    </div>
</template>

<script setup>
import { ref, onMounted, reactive } from "vue";
import { router, useForm, usePage } from "@inertiajs/vue3";
import { route } from "ziggy-js";
import { _confirmPassword } from "@utils/functions";
import SidebarLayout from "@/layouts/SidebarLayout.vue";
import Input from "@/components/Input.vue";
import Button from "@/components/Button.vue";
const page = usePage();
const twofa_code = ref("");
const form = useForm({
    name: "",
    email: "",
});

const twofa = reactive({
    qrCode: "",
    setupKey: "",
    recoveryCodes: "",
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

function _enable2FA() {
    _confirmPassword(() => {
        router.post(
            page.props.routes_fortify.two_factor_authentication_enable_post,
            {},
            {
                onSuccess: () => {
                    _loadDataTwoFA();
                },
            },
        );
    });
}

function _loadDataTwoFA() {
    _showQrCode();
    _showSetupKey();
    _showRecoveryCodes();
}

function _showQrCode() {
    return axios.get(route("two-factor.qr-code")).then((response) => {
        twofa.qrCode = response.data.svg;
    });
}
function _showSetupKey() {
    return axios.get(route("two-factor.secret-key")).then((response) => {
        twofa.setupKey = response.data.secretKey;
    });
}
function _showRecoveryCodes() {
    return axios.get(route("two-factor.recovery-codes")).then((response) => {
        twofa.recoveryCodes = response.data;
    });
}
function _newRecoveryCodes() {
    router.post(route('two-factor.regenerate-recovery-codes'),{}, {
        onSuccess: () => {
            _showRecoveryCodes();
        }
    });
}
function _downloadRecoveryCodes() {
    try {
        axios.get(route("two-factor.recovery-codes")).then((response) => {
            const codes = response.data;

            const blob = new Blob([codes.join("\n")], {
                type: "text/plain",
            });

            const url = window.URL.createObjectURL(blob);
            const a = document.createElement("a");
            a.href = url;
            a.download = "2fa-recovery-codes.txt";
            document.body.appendChild(a);
            a.click();
            a.remove();

            window.URL.revokeObjectURL(url);
        });
    } catch (error) {
        console.error("Erro ao baixar códigos", error);
    }
}

function _confirm2FA() {
    router.post(
        route("two-factor.confirm"),
        {
            code: twofa_code.value,
        },
        {
            onSuccess: () => {
                twofa.qrCode = "";
                twofa.setupKey = "";
                twofa.recoveryCodes = "";
            },
            onFinish: (pages) => {
                twofa_code.value = "";
            },
        },
    );
}
function _disable2FA() {
    router.delete(route("two-factor.disable"));
}

function _verifyTwoFaStatus() {
    if (page.props.twofa_status.enabled && !page.props.twofa_status.cofirmed) {
        _loadDataTwoFA();
    }
}

onMounted(() => {
    _loadUserData();
    _verifyTwoFaStatus();
});
defineOptions({
    layout: SidebarLayout,
});
</script>
