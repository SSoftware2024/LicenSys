<template>
    <div>
        <Link :href="route('home')" class="font-bold">Home</Link>
    </div>
</template>

<script setup>
import { ref } from "vue";
import { route } from "ziggy-js";
import SidebarLayout from "../layouts/SidebarLayout.vue";
import Home from "./Home.vue";
defineOptions({
    layout: SidebarLayout,
});
defineProps({
    footer: Home
});
</script>
