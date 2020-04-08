<template>
    <div class="pt-2 mb-2">
        <label :for="name" v-text="label" class="block text-sm font-medium leading-5 text-gray-700"></label>
        <div class="mt-1" :class="{'rounded-md shadow-sm': withShadow}">
            <slot/>
        </div>
        <p v-if="errors && errors.length >= 1" class="mt-2 text-sm text-red-600">{{ errors[0] }}</p>
    </div>
</template>
<script>
    export default {
        props: {
            name:{
                type: String,
                required: true,
            },
            label:{
                type: String,
                required: true,
            },
            errors:{
                required:false
            },
            withShadow:{
                type: Boolean,
                required: false,
                default: true,
            }
        }
    }
</script>
