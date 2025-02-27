<template>
    <div>
        <Link :href="route('index')" class="font-bold">Index</Link>
    </div>
</template>

<script setup>
import { ref } from "vue";
import { route } from "ziggy-js";
import SidebarLayout from "../layouts/SidebarLayout.vue";
defineOptions({ layout: SidebarLayout });
</script>
