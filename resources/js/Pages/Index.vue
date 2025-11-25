<template>
    <Head title="Index" />
    <div>
        <!-- FILTRO CENTRAL DASHBOARD -->
        <div class="xl:w-200">
            <form action="" class="flex items-end">
                <div class="grow">
                    <Input
                        type="date"
                        label="Data do dashboard"
                        id="value_monthly_fee"
                    />
                </div>

                <div class="grow-1">
                    <Button
                        text="APLICAR"
                        type="submit"
                        typeButton="primary"
                        class="ml-3"
                    ></Button>
                </div>
            </form>
        </div>

        <!-- FIM FILTRO CENTRAL DASHBOARD -->

        <!-- CARDS -->

        <!-- FIM CARDS -->

        <!-- TABELA DIAS RECEBER -->
        <!-- FIM TABELA DIAS RECEBER -->
    </div>
</template>

<script setup>
import { ref } from "vue";
import { route } from "ziggy-js";
import SidebarLayout from "../layouts/SidebarLayout.vue";
import Input from "@/components/Input.vue";
import Button from "@/components/Button.vue";

defineOptions({
    layout: SidebarLayout,
});
</script>
