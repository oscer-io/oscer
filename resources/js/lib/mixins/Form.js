import _ from "lodash";

export default {
    props: {
        append: {
            type: Object,
            default: () => {
            }
        }
    },
    data() {
        return {
            validationErrors: {}
        }
    },
    methods: {

        getFormData(){
            let formData = {};

            _.each(this.fields, field => {
                const value = field.getValue();
                if (Array.isArray(value)) {
                   formData[field.name] = value
                } else if (typeof value === 'object') {
                    Object.assign(formData, value);
                } else {
                   formData[field.name] = value
                }
            });

            Object.assign(formData, this.append);

            if (this.removeNullValues === true) {
               formData = _.pickBy(formData)
            }

            return formData;
        },

        getValidationErrors(field) {
            return this.$data.validationErrors[field.name] || [];
        }
    }
}
