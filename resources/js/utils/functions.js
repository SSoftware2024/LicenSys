import { useToast } from "vue-toast-notification";
import { route } from "ziggy-js";
import { router, usePage } from "@inertiajs/vue3";
import Swal from "sweetalert2";
const toast = useToast();
const page = usePage();

function _copyText(text) {
    navigator.clipboard.writeText(text).then(
        function () {
            toast.info("Texto copiado para área de transferência!");
        },
        function (err) {
            toast.error(err);
        },
    );
}

function _errorLaravelArrayElements(key_field, errors) {
    if (errors && !errors[key_field]) {
        const errorsArray = Object.entries(errors);
        let newErrorsArray = [];
        errorsArray.forEach(([key, value]) => {
            key.startsWith(key_field) ? newErrorsArray.push(value) : null;
        });
        return newErrorsArray.flat();
    }
    return [];
}

function _dateISOBr(date) {
    return new Date(date)
        .toLocaleDateString("pt-BR", {
            day: "2-digit",
            month: "2-digit",
            year: "numeric",
            hour: "2-digit",
            minute: "2-digit",
            second: "2-digit",
            hour12: false, // formato 24 horas
        })
        .replace(", ", " - ");
}
function _dateISOBrOnlyData(date) {
    //apenas dia,mes,ano e correção timezone
    let dateReturn = "";
    if (date) {
        const dateOnly = date.includes("T") ? date.split("T")[0] : date;
        dateReturn = new Date(dateOnly + "T00:00:00")
            .toLocaleDateString("pt-BR", {
                day: "2-digit",
                month: "2-digit",
                year: "numeric",
            });
    }
    return dateReturn;
}

function getNormalUrlParamter(paramter) {
    const url = new URL(window.location.href);
    let value = url.searchParams.get(paramter);
    return value;
}

function _confirmPassword(confirmPasswordCallback) {
    Swal.fire({
        title: "Confirmar senha!",
        text: "Confirme sua senha para continuar.",
        input: "password",
        inputAttributes: {
            autocapitalize: "off",
        },
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Confirmar!",
        cancelButtonText: "Cancelar",
        allowOutsideClick: () => !Swal.isLoading(),
    }).then((result) => {
        if (result.isConfirmed) {
            router.post(
                route("password_confirm_custom"),
                {
                    password: result.value,
                },
                {
                    onSuccess: (page) => {
                        confirmPasswordCallback();
                    },
                    onError: () => {
                        Swal.fire({
                            icon: "error",
                            title: "Erro!",
                            text: "Senha fornecida está incorreta!",
                        });
                    },
                },
            );
        }
    });
}

function formatMoneyBr(value) {
    return new Intl.NumberFormat("pt-BR", {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2,
    }).format(value);
}

function moneyBrToNumber(value) {
    return parseFloat(value.replace(".", "").replace(",", "."));
}

function objectIsEmpty(object){
    return Object.keys(object).length === 0;
}

export {
    _copyText,
    _errorLaravelArrayElements,
    _dateISOBr,
    _dateISOBrOnlyData,
    _confirmPassword,
    getNormalUrlParamter,
    formatMoneyBr,
    moneyBrToNumber,
    objectIsEmpty
};
