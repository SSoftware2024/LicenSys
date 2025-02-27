<template>
    <SidebarLayout>
        <Link :href="route('index')" class="font-bold">Index</Link>
    </SidebarLayout>
</template>

<script setup>
import { ref } from "vue";
import { route } from "ziggy-js";
import SidebarLayout from '../layouts/SidebarLayout.vue';

</script>
