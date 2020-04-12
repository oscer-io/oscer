<template>
    <FieldWrapper
        :name="field.name"
        :label="field.label || field.name"
        :with-shadow="false"
    >
        <p>{{field.value}}</p>
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
