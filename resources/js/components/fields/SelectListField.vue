<template>
    <div>
        <field-wrapper :name="field.name" :label="field.label || field.name" :errors="validationErrors">
            <select
                class="form-multiselect h-64 px-0 py-0 w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5"
                :class="{'border-red-600': !!hasValidationErrors}"
                :name="field.name"
                :errors="validationErrors"
                :size="field.options.length"
                v-model="value"
            >
                <option
                    v-for="(item, index) in field.options"
                    :name="item.name"
                    :key="index"
                    :label="item.label || item.name"
                    class="p-2"
                    :class="{'border-red-600': !!hasValidationErrors}"
                    :id="item.name"
                    :value="item.value"
                ></option>
            </select>
        </field-wrapper>
    </div>
</template>
<script>
    import FormField from "../../lib/mixins/FormField";

    export default {
        mixins: [FormField],

        methods: {
            fill(data) {
                if (!_.isArray(this.value) && this.value !== 'default') {
                    data[this.field.name] = this.value;
                }

                return data;
            }
        }
    }
</script>
