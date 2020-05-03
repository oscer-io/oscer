<template>
    <span v-if="field.value" v-text="`${field.value.substring(0,20)}...`"></span>
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
