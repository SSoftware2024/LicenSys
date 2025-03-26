<template>
    <label
        v-if="label"
        :for="id"
        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
    >
        {{ label }}
        <span class="text-red-600 font-bold tex-lg" v-if="isInputRequired"
            >*</span
        >
    </label>
    <div class="relative">
        <div v-if="!!$slots.icon" class="absolute left-2 top-3">
            <slot name="icon"></slot>
        </div>
        <input
            v-bind="$attrs"
            :id="id"
            :class="{
                'pl-7.5': !!$slots.icon,
                'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500':
                    !isInvalid,
                'bg-red-50 border border-red-500 text-red-900 placeholder-red-700 text-sm rounded-lg focus:ring-red-500 dark:bg-gray-700 focus:border-red-500 block w-full p-2.5 dark:text-red-500 dark:placeholder-red-500 dark:border-red-500':
                    isInvalid,
            }"
            v-model="model"
        />
    </div>
</template>
<script setup>
defineProps({
    label: {
        type: String,
        required: false,
    },
    isInputRequired: {
        type: Boolean,
        default: false,
    },
    id: String,
    isInvalid: {
        type: Boolean,
        default: false,
    },
});

const model = defineModel();
</script>
