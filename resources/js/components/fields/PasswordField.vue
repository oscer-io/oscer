<template>
    <div>
        <FieldWrapper
            :name="field.name"
            :label="field.label || field.name"
            :errors="validationErrors"
        >
            <input
                class="form-input block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5"
                :class="{'border-red-600': !! hasValidationErrors}"
                :id="field.name"
                :name="field.name"
                v-model="value"
                type="password"
            />
        </FieldWrapper>
        <FieldWrapper
            v-if="field.confirm"
            :name="field.confirmAttributes.name"
            :label="field.confirmAttributes.label || field.confirmAttributes.name"
        >
            <input
                class="form-input block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5"
                :id="field.confirmAttributes.name"
                :name="field.confirmAttributes.name"
                v-model="confirmedValue"
                type="password"
            />
        </FieldWrapper>
    </div>
</template>
<script>
    import FormField from "../../lib/mixins/FormField";

    export default {
        mixins: [FormField],

        data() {
            return {
                confirmedValue: ''
            }
        },

        methods: {
            fill(data) {
                data[this.field.name] = this.value;

                // Append the confirmation field if this.confirm is true
                if (this.field.confirm === true) {
                    data[this.field.confirmAttributes.name] = this.confirmedValue;
                }

                return data;
            }
        }
    }
</script>
