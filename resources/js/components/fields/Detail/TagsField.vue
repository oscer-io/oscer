<template>
    <FieldWrapper
        :name="field.name"
        :label="field.label"
        :with-shadow="false"
    >
        <span class="py-1 px-2 rounded bg-indigo-500 mr-2 text-white" v-for="tag in field.value" v-text="tag"></span>
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
