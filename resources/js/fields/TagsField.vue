<template>
    <field-wrapper :name="field.name" :label="field.label" :errors="validationErrors">
        <VueSelect taggable multiple
                   class="form-input block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5"
                   :class="{'border-red-600': !!hasValidationErrors}"
                   :id="field.name"
                   v-model="value"
                   :options="field.suggestions"
        />
    </field-wrapper>
</template>

<script>
    import {VueSelect} from 'vue-select';
    import FormField from "../lib/mixins/FormField";

    export default {
        mixins: [FormField],
        components: {
            VueSelect,
        },
        methods: {
            // // We have to override the fill method because this.value is an array.
            // fill(formData) {
            //     this.value.forEach(tag => {
            //         formData.append(`${this.field.name}[]`, tag)
            //     })
            // }
        }
    };
</script>
