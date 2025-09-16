import { useToast } from "vue-toast-notification";
const toast = useToast();

function _copyText(text) {
    navigator.clipboard.writeText(text).then(
        function () {
            toast.info('Texto copiado para área de transferência!');
        },
        function (err) {
            toast.error(err);
        }
    );
}

export {
    _copyText
};
