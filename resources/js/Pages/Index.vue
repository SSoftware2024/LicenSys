<template>
    <p>{{ page }}</p>
    <Link :href="route('home')"class="text-blue-400">To Home</Link>
</template>

<script setup>
import { ref } from "vue";
import { route } from 'ziggy-js';
const page = ref('index');
</script>
