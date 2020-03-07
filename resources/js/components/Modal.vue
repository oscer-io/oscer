<template>
    <div v-if="visible" class="fixed bottom-0 inset-x-0 px-4 pb-4 sm:inset-0 sm:flex sm:items-center sm:justify-center">
        <div class="fixed inset-0 transition-opacity" @click="close">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>

        <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full">
            <slot/>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            visible: {
                required: true,
                type: Boolean
            }
        },
        methods: {
            close() {
                this.$emit('close');
            }
        }
    }
</script>
