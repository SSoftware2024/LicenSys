<template>
    <SideBar>
        <slot></slot>
    </SideBar>
</template>
<script setup>
import SideBar from "../components/SideBar.vue";
import { onMounted, onUnmounted, ref } from "vue";
import { router } from "@inertiajs/vue3";
import { useToast } from "vue-toast-notification";
import { initFlowbite, initModals } from "flowbite";
const toast = useToast();

function _showToast(event) {
    let messageToast = event.detail.page.props.response_data?.toast;
    if (messageToast) {
        
        messageToast.forEach((value) => {
            toast.open({
                message: value.message,
                type: value.type,
                duration: value.duration,
            });
        });
        // let instance = toast.open({
        //     message: messageToast.message,
        //     type: messageToast.type,
        //     duration: messageToast.duration,
        // });
    }
}

// initialize components based on data attribute selectors - FLOWBITE
let router_success;
let router_finish;

onMounted(() => {
    router_success = router.on("success", (event) => {
        _showToast(event);
    });
    router_finish = router.on("finish", async (event) => {
        initFlowbite();
    });
});
onUnmounted(() => {
    if (router_success) router_success();
    if (router_finish) router_finish();
});
</script>
