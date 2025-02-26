<template>
    <p>{{ page }}</p>
    <Link href="/" class="text-blue-400">To Index</Link>
</template>

<script setup>
import { ref } from "vue";
const page = ref('home');
</script>
