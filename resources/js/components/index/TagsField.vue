<template>
    <div>
        <span v-for="tag in field.values" v-text="tag"></span>
    </div>
</template>
<script>
    export default {
        props: {
            field: {
                type: Object,
                required: true
            }
        }
    }
</script>
