<template>
    <SideBar>
        <slot></slot>
    </SideBar>
</template>
<script setup>
import SideBar from "../components/SideBar.vue";
import { onMounted, onUnmounted, ref } from "vue";
import { initFlowbite } from "flowbite";

// initialize components based on data attribute selectors
onMounted(() => {
    initFlowbite();
});
onUnmounted(() => {
    initFlowbite();
});
</script>
