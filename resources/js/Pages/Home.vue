<template>
    <p>{{ page }}</p>
    <Link :href="route('index')" class="text-blue-400">To Index</Link>
</template>

<script setup>
import { ref } from "vue";
import { route } from 'ziggy-js';
const page = ref('home');
</script>
