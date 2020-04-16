<template>
    <FieldWrapper
        :name="field.name"
        :label="field.label || field.name"
        :with-shadow="false"
    >
        <img v-if="field.value" class="rounded w-40 h-40"
             :class="{'rounded-full': field.rounded}" :src="field.value" alt=""/>
        <p v-else>No image set</p>
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
