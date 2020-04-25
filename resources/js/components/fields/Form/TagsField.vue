<template>
    <FieldWrapper
        :name="field.name"
        :label="field.label"
        :errors="validationErrors"
    >
        <VueSelect
            taggable
            multiple
            class="form-input block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5"
            :class="{'border-red-600': !!hasValidationErrors}"
            :id="field.name"
            v-model="value"
            :options="field.suggestions"
        />
    </FieldWrapper>
</template>

<script>
    import {VueSelect} from 'vue-select';
    import FormField from "@/lib/mixins/FormField";

    export default {
        mixins: [FormField],
        components: {
            VueSelect,
        }
    };
</script>
