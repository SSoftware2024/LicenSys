import "./bootstrap";
import { createApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/vue3";
import { Link, Head } from "@inertiajs/vue3";
import ToastPlugin from 'vue-toast-notification';
import "flowbite";


const appName = import.meta.env.VITE_APP_NAME ?? 'LicenceSys';
createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => {
        const pages = import.meta.glob("./Pages/**/*.vue", { eager: true });
        return pages[`./Pages/${name}.vue`];
    },
    setup({ el, App, props, plugin }) {
        const app = createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ToastPlugin)
            .component("Link", Link)
            .component("Head", Head)
            .mount(el);
    },
});
