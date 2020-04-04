<template>
    <form @submit.prevent="submitResourceForm">
        <component
            v-for="(field, index) in fields"
            :key="field.name + index"
            :ref="`${field.name}-field`"
            :is="field.component"
            :field="field"
            :validation-errors="getValidationErrors(field)"
        />
        <div class="mt-8 border-t border-gray-200 pt-5">
            <div class="flex justify-end">
                        <span class="inline-flex rounded-md shadow-sm">
                            <button type="button" @click="$emit('cancel')"
                                    class="py-2 px-4 border border-gray-300 rounded-md text-sm leading-5 font-medium text-gray-700 hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-50 active:text-gray-800 transition duration-150 ease-in-out">
                                {{this.cancelText}}
                            </button>
                        </span>
                <span class="ml-3 inline-flex rounded-md shadow-sm">
                            <button type="submit"
                                    class="btn">
                                {{this.submitText}}
                            </button>
                        </span>
            </div>
        </div>
    </form>
</template>
<script>
    import api from "../lib/api";
    import Form from "../lib/mixins/Form";

    export default {
        mixins: [Form],
        props: {
            resource: {
                type: String,
                required: true
            },
            resourceId: {
                required: false,
                default: null
            },
            resetOnSuccess: {
                required: false,
                default: false
            },
            cancelText: {
                type: String,
                default: 'Cancel'
            },
            submitText: {
                type: String,
                default: 'Submit'
            },
        },
        data() {
            return {
                fields: [],
                removeNullValues: false,
            }
        },
        watch:{
            resourceId(){
                this.fetchResourceForm();
            }
        },
        created() {
            this.fetchResourceForm();
        },
        methods: {
            prepareParams(){
                // Filter null values. This way we can handle create and update
                return [this.resource, this.resourceId].filter(el => el !== null)
            },
            async fetchResourceForm() {
                // fetch the form definition from the backend.
                const response = await api(Cms.route('cms.api.forms.show', this.prepareParams()));

                this.fields = response.data.data.fields;
                this.removeNullValues = response.data.data.removeNullValues;
            },
            async submitResourceForm() {
                // Submit the form. If we get validation errors, they will be passed to the fields.
                try {
                    const response = await api({
                        ...Cms.route('cms.api.forms.store', this.prepareParams()),
                        data: this.getFormData()
                    });

                    // Emit success event with the data from the successful response
                    this.$emit('success', response.data.data);

                    // Reset form by fetching the fields again. Only if resetOnSuccess prop is true
                    this.resetOnSuccess && this.fetchResourceForm();
                } catch (error) {
                    if (error.response.status === 422) {
                        this.validationErrors = error.response.data.errors;
                        Cms.flash('error', 'There are validation errors in the form.')
                    }
                }
            }
        }
    }
</script>
