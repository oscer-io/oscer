<template>
    <FieldWrapper
        :name="field.name"
        :label="field.label || field.name"
        :with-shadow="false"
    >
        <div v-html="asMarkdown(field.value)"></div>
    </FieldWrapper>
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
                return marked(value);
            },
        }
    }
</script>
