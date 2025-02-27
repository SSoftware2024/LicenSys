<template>
    <SidebarLayout>
        <Link :href="route('home')" class="font-bold">Home</Link>
    </SidebarLayout>
</template>

<script setup>
import { ref } from "vue";
import { route } from "ziggy-js";
import SidebarLayout from '../layouts/SidebarLayout.vue';

</script>
