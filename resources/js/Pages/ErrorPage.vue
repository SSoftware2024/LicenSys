<script setup>
import { computed } from 'vue'

const props = defineProps({
    status: Number,
    message: String
})

const title = computed(() => {
    return {
        503: '503 — Service Unavailable',
        500: '500 — Server Error',
        404: '404 — Page Not Found',
        403: '403 — Forbidden',
    }[props.status] ?? 'Error'
})

const description = computed(() => {
    return {
        503: 'Desculpe, estamos em manutenção. Tente novamente mais tarde.',
        500: 'Ops! Algo inesperado aconteceu em nossos servidores.',
        404: 'A página que você procura não foi encontrada.',
        403: 'Você não tem permissão para acessar esta página.',
    }[props.status] ?? 'Algo inesperado aconteceu.'
})
</script>

<template>
    <Head :title="title" />
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900 flex items-center justify-center px-6">
        <div
            class="text-center max-w-xl animate-fade-in"
        >
            <!-- STATUS NUMBER -->
            <h1
                class="text-7xl md:text-8xl font-extrabold bg-gradient-to-r
                       from-red-500 via-orange-500 to-yellow-500
                       bg-clip-text text-transparent drop-shadow-lg"
            >
                {{ props.status }}
            </h1>

            <!-- TITLE -->
            <h2 class="mt-4 text-2xl md:text-3xl font-semibold text-gray-800 dark:text-gray-200">
                {{ title }}
            </h2>

            <!-- DESCRIPTION -->
            <p class="mt-2 text-gray-600 dark:text-gray-400 text-lg">
                {{ description }}
            </p>


        </div>
    </div>
</template>

<style>
/* Animação suave */
@keyframes fade-in {
  0% { opacity: 0; transform: translateY(10px); }
  100% { opacity: 1; transform: translateY(0); }
}

.animate-fade-in {
  animation: fade-in 0.5s ease-out;
}
</style>
