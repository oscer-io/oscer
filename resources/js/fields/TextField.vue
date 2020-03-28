<template>
    <field-wrapper :name="field.name" :label="field.label || field.name" :errors="validationErrors">
        <input
            class="form-input block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5"
            :class="{'border-red-600': !!validationErrors}"
            :id="field.name"
            :name="field.name"
            v-model="value"
        />
    </field-wrapper>
</template>
<script>
    import FormField from "../lib/mixins/FormField";

    export default {
        mixins: [FormField],
        props: ['field']
    }
</script>
