<template>
    <FieldWrapper
        :name="field.name"
        :label="field.label"
        :with-shadow="false"
    >
        <span v-for="tag in field.values" v-text="tag"></span>
    </FieldWrapper>
</template>
<script>
    export default{
        props:{
            field:{
                type:Object,
                required: true
            }
        }
    }
</script>
