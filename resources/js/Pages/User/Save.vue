<template>
    <Head title="Save User"/>
    <div>
        Save user {{ $page.props.type_user ? ` - ${$page.props.type_user}` : '' }}
    </div>
</template>

<script setup>
import { ref } from "vue";
import { route } from "ziggy-js";
import SidebarLayout from "@/layouts/SidebarLayout.vue";
defineOptions({
    layout: SidebarLayout,
});
</script>
