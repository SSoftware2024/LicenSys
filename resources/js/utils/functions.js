import { useToast } from "vue-toast-notification";
const toast = useToast();

function _copyText(text) {
    navigator.clipboard.writeText(text).then(
        function () {
            toast.info("Texto copiado para área de transferência!");
        },
        function (err) {
            toast.error(err);
        }
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
    return new Date(date).toLocaleDateString("pt-BR", {
        day: "2-digit",
        month: "2-digit",
        year: "numeric",
        hour: "2-digit",
        minute: "2-digit",
        second: "2-digit",
        hour12: false, // formato 24 horas
    }).replace(', ', ' - ');
}

export { _copyText, _errorLaravelArrayElements,_dateISOBr };
