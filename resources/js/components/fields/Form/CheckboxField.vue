<template>
    <FieldWrapper
        :name="field.name"
        :label="field.label || field.name"
        :errors="validationErrors"
    >
        <input
            class="form-checkbox transition duration-150 ease-in-out sm:text-sm sm:leading-5"
            :class="{'border-red-600': !!hasValidationErrors}"
            :id="field.name"
            :name="field.name"
            v-model="value"
            type="checkbox"
        />
    </FieldWrapper>
</template>
<script>
    import FormField from "@/lib/mixins/FormField";

    export default {
        mixins: [FormField]
    }
</script>
