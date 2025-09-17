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

export { _copyText, _errorLaravelArrayElements };
