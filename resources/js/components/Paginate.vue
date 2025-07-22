<template>


    <div class="w-full flex flex-col gap-3 mt-6">
        <!-- Mostrando de X a Y -->
        <div class="text-sm text-gray-600">
            Mostrando
            <span class="font-semibold">{{ showingFrom }}</span>
            até
            <span class="font-semibold">{{ showingTo }}</span>
            de
            <span class="font-semibold">{{ totalResults }}</span>
            resultados
        </div>

        <!-- Navegação -->
        <div class="flex items-center justify-end gap-1 flex-wrap">
            <!-- Botão anterior -->
            <button
                class="px-3 py-1 rounded border text-sm disabled:opacity-50 cursor-pointer disabled:cursor-not-allowed hover:bg-gray-100"
                :disabled="!pagination.prev_page_url"
                @click="goTo(pagination.current_page - 1)"
            >
                Anterior
            </button>

            <!-- Números de página -->
            <button
                v-for="page in pages"
                :key="page"
                @click="goTo(page)"
                class="px-3 py-1 rounded border text-sm hover:bg-blue-100 cursor-pointer"
                :class="
                    page === pagination.current_page
                        ? 'bg-blue-500 text-white border-blue-500'
                        : 'border-gray-300 text-gray-700'
                "
            >
                {{ page }}
            </button>

            <!-- Botão próximo -->
            <button
                class="px-3 py-1 rounded border text-sm disabled:opacity-50 disabled:cursor-not-allowed hover:bg-gray-100 cursor-pointer"
                :disabled="!pagination.next_page_url"
                @click="goTo(pagination.current_page + 1)"
            >
                Próximo
            </button>
        </div>
    </div>
</template>

<script setup>
import { computed } from "vue";

const props = defineProps({
    pagination: {
        type: Object,
        required: true,
    },
    onEachSize: {
        type: Number,
        default: 2,
    },
});

const emit = defineEmits(["paginate"]);

// calcula intervalo de páginas visíveis
const pages = computed(() => {
    const current = props.pagination.current_page;
    const last = props.pagination.last_page;
    const size = props.onEachSize;

    let start = Math.max(1, current - size);
    let end = Math.min(last, current + size);

    const arr = [];
    for (let i = start; i <= end; i++) {
        arr.push(i);
    }
    return arr;
});

const showingFrom = computed(() => {
    // Laravel paginator normalmente tem: from, to, total
    return props.pagination.from;
});

const showingTo = computed(() => {
    return props.pagination.to;
});

const totalResults = computed(() => {
    return props.pagination.total;
});

function goTo(page) {
    if (page !== props.pagination.current_page) {
        emit("paginate", page);
    }
}
</script>
