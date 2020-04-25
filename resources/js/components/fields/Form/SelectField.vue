<template>
    <div>
        <FieldWrapper :name="field.name" :label="field.label || field.name" :errors="validationErrors">
            <VueSelect
                :placeholder="field.placeholder || $t('selectfield.default_placeholder')"
                class="vue-select form-input transition duration-150 ease-in-out sm:text-sm sm:leading-5"
                :class="{'border-red-600': !!hasValidationErrors}"
                :id="field.name"
                v-model="value"
                :options="field.options"
                label="label"
                :reduce="option => option.value"
                :searchable="field.searchable"
                :filterable="field.filterable"
                :multiple="field.multiple"
            />
        </FieldWrapper>
    </div>
</template>
<script>
    import FormField from "@/lib/mixins/FormField";
    import {VueSelect} from 'vue-select';

    export default {
        mixins: [FormField],

        components: {
            VueSelect,
        }
    }
</script>
<style>
    .vue-select .vs__actions {
        padding: 0;
    }

    .vue-select .vs__open-indicator:hover {
        cursor: pointer;
    }

    .vue-select .vs__search::placeholder,
    .vue-select .vs__dropdown-toggle,
    .vue-select .vs__dropdown-menu {
        border: none;
        background: #fff;
    }

    .vue-select .vs__dropdown-toggle,
    .vue-select .vs__selected-options {
        padding: 0;
    }

    .vue-select .vs__selected-options {
        flex-wrap: nowrap;
    }

    .vue-select .vs__selected{
        padding: 0;
        margin: 0;
    }

    .vue-select .vs__search,
    .vue-select .vs__search:focus {
        padding-left: 0;
        padding-top: 0;
        padding-bottom: 0;
        margin: 0;
        border: none;
    }

    /* Fix content jumping... */
    .vue-select.vs--single.vs--open .vs__selected {
        position: static;
    }
</style>
