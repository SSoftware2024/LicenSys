<template>
    <div
        class="absolute w-full h-full flex justify-center align-items-center"
    >
        <div class="relative w-100 h-auto flex flex-col justify-center">
            <Card>
                <h2 class="text-center font-semibold text-2xl">{{ title }}</h2>
                <div>
                    <slot></slot>
                </div>
            </Card>
        </div>
    </div>
</template>
<script setup>
import Card from "@/components/Card.vue";
defineProps({
    title: {
        type: String,
        require: true
    }
});
</script>
