<template>
    <div class="px-2" :class="field.width">

        <div class="p-6 bg-white rounded mb-8">
            <p v-text="field.name" class="text-gray-800 font-bold mb-3"></p>
            <component
                v-for="(field, index) in field.fields"
                :is="`Detail${field.component}`"
                :key="index"
                :field="field"
            />
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            field: {
                type: Object,
                required: true
            }
        }
    }
</script>
