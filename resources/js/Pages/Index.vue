<template>
    <p>{{ page }}</p>
    <Link href="/home" class="text-blue-400">To Home</Link>
</template>

<script setup>
import { ref } from "vue";
const page = ref('index');
</script>
