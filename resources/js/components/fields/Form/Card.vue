<template>
    <div class="px-2" :class="field.width">

        <div class="p-6 bg-white rounded mb-8">
            <p v-text="field.name" class="text-gray-800 font-bold mb-3"></p>
            <component
                v-for="(subField, index) in field.fields"
                :key="subField.name + index"
                :ref="`${subField.name}-field`"
                :is="`Form${subField.component}`"
                :field="subField"
                :validation-errors="validationErrors[subField.name] || []"
                @componentChange="componentChange"
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
            },
            validationErrors: {
                required: true
            }
        },
        methods: {
            componentChange(field, value) {
                this.$emit('componentChange', field, value);
            },
            fill(data) {
                this.field.fields.each(field => {
                    data[field.name] = field.fill(data)
                })
                return data
            }
        }

    }
</script>
