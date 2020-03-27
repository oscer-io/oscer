<template>
    <div class="pt-2 mb-2">
        <label :for="name" v-text="label" class="block text-sm font-medium leading-5 text-gray-700"></label>
        <div class="mt-1 rounded-md shadow-sm">
            <slot/>
        </div>
    </div>
</template>
<script>
    export default {
        props: ['name', 'label']
    }
</script>
