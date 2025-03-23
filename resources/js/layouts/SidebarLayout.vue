<template>
    <SideBar>
        <slot></slot>
    </SideBar>
</template>
<script setup>
import SideBar from "../components/SideBar.vue";
import { onMounted, onUnmounted, ref } from "vue";
import { initFlowbite } from "flowbite";
import { router } from "@inertiajs/vue3";
import { useToast } from "vue-toast-notification";

const toast = useToast();

function _showToast(event) {
    let messageToast = event.detail.page.props.response_data.toast;
    let instance = toast.open({
        message: messageToast.message,
        type: messageToast.type,
        duration: messageToast.duration,
    });
}

// initialize components based on data attribute selectors - FLOWBITE
onMounted(() => {
    initFlowbite();
    router.on("success", (event) => {
        _showToast(event);
    });

});
onUnmounted(() => {
    initFlowbite();
});
</script>
