<template>
    <Head title="Index"/>
    <div>
        Index page

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
