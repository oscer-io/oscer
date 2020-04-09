<template>
    <field-wrapper  :name="field.name" :label="field.label || field.name" :errors="validationErrors">
        <input
            class="form-input block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5"
            :class="{'border-red-600': !!hasValidationErrors}"
            :id="field.name"
            :name="field.name"
            v-model="value"
            :type="inputType"
        />
    </field-wrapper>
</template>
<script>
    import FormField from "../../lib/mixins/FormField";

    export default {
        mixins: [FormField],
        computed: {
            inputType() {
                return this.field.attributes && this.field.attributes.type
                    ? this.field.attributes.type
                    : 'text';
            }
        }
    }
</script>
