export default {
    props: {
        field: {
            type: Object,
            required: true,
        },
        validationErrors: {
            type: Array
        }
    },

    data() {
        return {
            value: ''
        }
    },

    computed: {
        hasValidationErrors() {
            return this.validationErrors.length >= 1;
        }
    },

    watch: {
        field() {
            this.setInitialValue();
            this.field.fill = this.fill
        },
        value() {
            this.$emit('input', this.value)
        }
    },

    mounted() {
        this.setInitialValue();
        this.field.fill = this.fill
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
         * Provide a function that fills the FormData object with the current value
         * of the field. It will be bound to the shared field definition object.
         * This way the form component can gather the values.
         */
        fill(data) {
            data[this.field.name] = this.value;

            return data;
        }
    }
}
