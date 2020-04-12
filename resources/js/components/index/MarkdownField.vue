<template>
    <div v-text="asMarkdown(field.value)"></div>
</template>
<script>
    import marked from 'marked';
    export default {
        props: {
            field: {
                type: Object,
                required: true
            }
        },
        methods: {
            asMarkdown(value) {
                return marked(value).substring(0, 100);
            },
        }
    }
</script>
