<template>
    <FieldWrapper
        :name="field.name"
        :label="field.label || field.name"
        :with-shadow="false"
    >
        <img class="rounded w-40 h-40"
             :class="{'rounded-full': field.rounded}" :src="field.value" alt=""/>
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
