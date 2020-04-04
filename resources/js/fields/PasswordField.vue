<template>
    <div>
        <field-wrapper :name="field.name" :label="field.label || field.name" :errors="validationErrors">
            <input class="form-input block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5"
                   :class="{'border-red-600': !! hasValidationErrors}"
                   :id="field.name"
                   :name="field.name"
                   v-model="value"
                   type="password"
            />
        </field-wrapper>

        <field-wrapper v-if="field.confirm"
                       :name="field.confirmAttributes.name"
                       :label="field.confirmAttributes.label || field.confirmAttributes.name">
            <input class="form-input block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5"
                   :id="field.confirmAttributes.name"
                   :name="field.confirmAttributes.name"
                   v-model="confirmedValue"
                   type="password"
            />
        </field-wrapper>
    </div>
</template>
<script>
    import FormField from "../lib/mixins/FormField";

    export default {
        mixins: [FormField],

        data() {
            return {
                confirmedValue: ''
            }
        },

        methods: {
            getValue() {
                if (this.field.confirm === true) {
                    let value = {};
                    value[this.field.name] = this.value;
                    value[this.field.confirmAttributes.name] = this.confirmedValue;

                    return value;
                }
                return this.value;
            }
        }
    }
</script>
