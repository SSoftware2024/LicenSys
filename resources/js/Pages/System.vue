<template>
    <Head title="Index"/>
    <div>
        System page
    </div>
</template>

<script setup>
import { ref } from "vue";
import { route } from "ziggy-js";
import SidebarLayout from "../layouts/SidebarLayout.vue";
defineOptions({
    layout: SidebarLayout,
});
</script>
