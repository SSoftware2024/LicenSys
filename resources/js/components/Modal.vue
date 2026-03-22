<template>
    <Teleport to="body">
        <div class="backdrop" :id="backdrop_id"></div>
        <div class="container-modal" :id="props.id">
            <div class="modal">
                <div class="container-title">
                    <h2 class="text-xl border-b-2 border-gray-300">
                        {{ props.title }}
                    </h2>
                    <div class="close" @click.prevent="close">❌</div>
                </div>

                <div class="border-b-2 border-gray-300 px-5 py-3">
                    <slot></slot>
                </div>
                <div class="footer mt-2">
                    <div class="w-full flex justify-end">
                        <slot name="buttons"></slot>
                        <button
                            @click.prevent="close()"
                            type="button"
                            class="cursor-pointer py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700"
                        >
                            Fechar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </Teleport>
</template>
<script setup>
const backdrop_id = "backdrop-modal";
const props = defineProps({
    id: {
        type: String,
        required: true,
    },
    title: {
        type: String,
        required: true,
    },
    closeClearCallback: {
        type: Function,
        default: null
    }
});

function open() {
    let modal = document.getElementById(props.id);
    let backdrop = document.getElementById(backdrop_id);
    modal.style.display = "flex";
    backdrop.style.display = "block";
}
function close() {
    let modal = document.getElementById(props.id);
    let backdrop = document.getElementById(backdrop_id);
    modal.style.display = "none";
    backdrop.style.display = "none";
    if(props.closeClearCallback){
        props.closeClearCallback();
    }
}

defineExpose({
    open,
    close,
});
</script>
<style scoped>
.backdrop {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    z-index: 49;
    display: none; /** block */
}
.container-modal {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    display: none; /* flex */
    justify-content: center;
    align-items: center;
    z-index: 50;
    overflow-y: auto;
}

.modal {
    position: relative;
    box-sizing: border-box;
    width: 750px;
    max-width: calc(100% - 300px);
    height: calc(100% - 5rem);
    max-height: 100%;
    height: auto;
    background-color: white;
    padding: 10px 15px;
    box-shadow: rgba(0, 0, 0, 0.15) 0px 2px 8px;
    overflow-y: auto;
    border-radius: 4px;
}
.container-title {
    position: relative;
}
.container-title .close {
    position: absolute;
    right: 3px;
    top: 0px;
    cursor: pointer;
}
</style>
