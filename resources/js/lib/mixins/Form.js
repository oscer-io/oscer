import _ from "lodash";
import api from "../api";

export default {
    props: {
        apiRoute: {
            type: Object,
            required: true
        },
        removeNullValues: {
            type: Boolean,
            default: false
        },
        append: {
            type: Object,
            default: () => {
            }
        },
        successMethod: {
            type: Function
        }
    },
    data() {
        return {
            payload: {},
            validationErrors: {}
        }
    },
    methods: {
        async handleSubmit() {
            _.each(this.fields, field => {
                const value = field.getValue();
                if (Array.isArray(value)) {
                    this.payload[field.name] = value
                }else if (typeof value === 'object') {
                    Object.assign(this.payload, value);
                } else {
                    this.payload[field.name] = value
                }
            });

            Object.assign(this.payload, this.append);

            if (this.removeNullValues === true) {
                this.payload = _.pickBy(this.payload)
            }

            try {
                const response = await api({
                    ...this.route(this.apiRoute.name, this.apiRoute.params),
                    data: this.payload
                });

                this.successMethod
                    ? this.successMethod(response.data.data)
                    : this.$emit('success', response.data.data);

            } catch (error) {
                console.log(error);
                if (error.response.status === 422) {
                    this.validationErrors = error.response.data.errors;
                    Cms.flash('error', 'There are validation errors in the form.')
                }
            }
        },
        getValidationErrors(field) {
            return this.$data.validationErrors[field.name] || false;
        }
    }
}
