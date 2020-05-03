<template>
    <div class="px-2" :class="width">

    <div class="p-6 bg-white rounded mb-8">
        <p v-text="name" class="text-gray-800 font-bold mb-3"></p>
        <component
            v-for="(field, index) in fields"
            v-if="field.active"
            :key="field.name + index"
            :ref="`${field.name}-field`"
            :is="`Form${field.component}`"
            :field="field"
            :validation-errors="validationErrors[field.name] || []"
            @componentChange="componentChange"
        />
    </div>
    </div>
</template>

<script>
    export default {
        props: {
            name: {
                type: String,
                required: true
            },
            width: {
                type: String,
                required: true
            },
            fields: {
                type: Array,
                required: true
            },
            validationErrors: {
                type: Object,
                required: true
            }
        },
        methods:{
            componentChange(field, value){
                this.$emit('componentChange', field, value);
            }
        }

    }
</script>
