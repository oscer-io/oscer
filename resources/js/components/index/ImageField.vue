<template>
        <img class="rounded w-10 h-10"
             :class="{'rounded-full': field.rounded}" :src="field.value" alt=""/>
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
