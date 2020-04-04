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
    import _ from 'lodash';
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
                fields: []
            }
        },
        created() {
            console.log('resource-form', this.resourceId);
            this.fetchResourceForm();
        },
        methods: {
            async fetchResourceForm() {
                this.fields = [];
                let route;
                if (this.resourceId !== null) {
                    route = Cms.route('cms.api.forms.show', {
                        resource: this.resource,
                        id: this.resourceId
                    });
                } else {
                    route = Cms.route('cms.api.forms.new', {resource: this.resource});
                }

                const response = await api(route);
                this.fields = response.data.data.fields;
            },

            async submitResourceForm() {
                const formData = this.getFormData();

                try {
                    const foo = {
                        ...Cms.route('cms.api.forms.store', _.pickBy({
                            resource: this.resource,
                            id: this.resourceId
                        })),
                        data: formData
                    };
                    const response = await api(foo);

                    this.$emit('success', response.data.data);

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
