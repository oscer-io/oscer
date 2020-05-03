<template>
    <div>
        <Tag v-for="tag in field.value" :key="tag" :label="tag"></Tag>
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
