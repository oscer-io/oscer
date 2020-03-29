export default {
    props: ['field', 'validationErrors'],

    data() {
        return {
            value: ''
        }
    },

    watch: {
        value() {
            this.$emit('input', this.value)
        }
    },

    mounted() {
        this.setInitialValue();
        this.field.getValue = this.getValue
    },

    methods: {
        /**
         * Set the initial value for the field
         */
        setInitialValue() {
            this.value = !(this.field.value === undefined || this.field.value === null)
                ? this.field.value
                : ''
        },

        /**
         * Provide a function that returns the current value of the field.
         * It will be bound to the shared field definition object.
         * This way the form component can gather the values.
         */
        getValue() {
            return String(this.value)
        }
    }
}
