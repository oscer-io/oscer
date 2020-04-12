<template>
    <span v-text="`${field.value.substring(0,100)}...`"></span>
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
