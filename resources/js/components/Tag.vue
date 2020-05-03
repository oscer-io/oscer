<template>
    <span class="py-1 px-2 rounded bg-indigo-500 mr-2 text-white" v-text="label"></span>
</template>

<script>
    export default {
        props: {
            label: {
                type: String,
                required: true
            }
        }
    }
</script>
