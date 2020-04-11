<template>
    <div>
        <field-wrapper :name="field.name" :label="field.label || field.name" :errors="validationErrors">
            <select
                class="form-select w-full leading-tight pr-8 rounded-md w-fullfocus:outline-none focus:shadow-outline transition duration-150 ease-in-out"
                :class="{'border-red-600': !!hasValidationErrors}"
                :name="field.name"
                :errors="validationErrors"
                v-model="value"
            >
                <option value="default">
                    {{$t('select.default_value') }}
                </option>
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

        data() {
            return {
                value: 'default'
            }
        },
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
