<template>
    <Head title="Faturamento" />
    <h2 class="font-bold text-2xl underline mb-2">Faturamento</h2>
    <div class="xl:w-200">
        content
    </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import { route } from "ziggy-js";
import { useForm, usePage } from "@inertiajs/vue3";
import dateObject from "@/utils/date";

//COMPONENTS E LAYOUTS
import SidebarLayout from "../../layouts/SidebarLayout.vue";
import Input from "@/components/Input.vue";
import Button from "@/components/Button.vue";
;

defineOptions({
    layout: SidebarLayout,
});
</script>
