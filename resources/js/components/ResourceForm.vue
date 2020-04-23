<template>
    <loading :loading="isLoading">
        <form @submit.prevent="submitResourceForm">
            <div
                class="mb-8 border-b border-gray-200 pb-5"
                v-if="inSubmitPositions('top')"
            >
                <div class="flex justify-end">
                    <span class="inline-flex rounded-md shadow-sm">
                        <button
                            type="button"
                            class="py-2 px-4 border border-gray-300 rounded-md text-sm leading-5 font-medium text-gray-700 hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-50 active:text-gray-800 transition duration-150 ease-in-out"
                            @click="$emit('cancel')"
                        >
                            {{this.cancelText}}
                        </button>
                    </span>
                    <span class="ml-3 inline-flex rounded-md shadow-sm">
                        <button
                            type="submit"
                            class="btn"
                        >
                            {{this.submitText}}
                        </button>
                    </span>
                </div>
            </div>
            <component
                v-for="(field, index) in fields"
                v-if="field.active"
                :key="field.name + index"
                :ref="`${field.name}-field`"
                :is="field.component"
                :field="field"
                :validation-errors="getValidationErrors(field)"
                @componentChange="activateDependents"
            />
            <div v-if="inSubmitPositions('bottom')" class="mt-8 border-t border-gray-200 pt-5">
                <div class="flex justify-end">
                    <span class="inline-flex rounded-md shadow-sm">
                        <button
                            type="button"
                            class="py-2 px-4 border border-gray-300 rounded-md text-sm leading-5 font-medium text-gray-700 hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-50 active:text-gray-800 transition duration-150 ease-in-out"
                            @click="$emit('cancel')"
                        >
                            {{this.cancelText}}
                        </button>
                    </span>
                    <span class="ml-3 inline-flex rounded-md shadow-sm">
                        <button
                            type="submit"
                            class="btn"
                        >
                            {{this.submitText}}
                        </button>
                    </span>
                </div>
            </div>
        </form>
    </loading>
</template>
<script>
    import api from "../lib/api";
    import _ from "lodash";
    import {objectToFormData} from 'object-to-formdata';

    export default {
        props: {
            resource: {
                type: String,
                required: true
            },
            resourceId: {
                required: false,
                default: null
            },
            preloadedResource: {
                required: false,
                default: false
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
            append: {
                default: false
            },
            submitPositions: {
                type: Array,
                validator: (value) => {
                    const valid = ['top', 'bottom'];

                    return value === undefined || _.difference(value, valid).length === 0;
                },
                default: () => {
                    return ['bottom']
                }
            }
        },
        data() {
            return {
                isLoading: true,
                fields: [],
                removeNullValues: false,
                validationErrors: {}
            }
        },
        watch: {
            resourceId() {
                this.fetchResourceForm();
            }
        },
        mounted() {
            if (this.preloadedResource !== false) {
                this.initializeForm(this.preloadedResource);
                this.isLoading = false;
            } else {
                this.fetchResourceForm();
            }

            Cms.$on('reset-form-' + this.resource, payload => {
                console.log('reset', payload);
                if (typeof payload !== 'undefined') {
                    this.initializeForm(payload);
                } else {
                    this.fetchResourceForm();
                }
            });
        },
        methods: {
            inSubmitPositions(positions) {
                if (!Array.isArray(positions)) {

                    positions = [positions];
                }
                return _.difference(positions, this.submitPositions).length === 0;
            },

            initializeForm(resource) {
                this.fields = resource.fields;
                this.removeNullValues = resource.removeNullValues;
            },

            async fetchResourceForm() {
                this.isLoading = true;
                // fetch the form definition from the backend.
                const route = this.resourceId === null
                    ? Cms.route('cms.backend.resources.create', this.resource)
                    : Cms.route('cms.backend.resources.show', [this.resource, this.resourceId]);
                const response = await api(route);

                this.initializeForm(response.data.data);
                this.isLoading = false;
            },

            async submitResourceForm() {
                // Submit the form. If we get validation errors, they will be passed to the fields.
                try {
                    const data = this.getFormData(); // get current form values

                    const response = await api({
                        ...Cms.route(
                            'cms.backend.resources.store',
                            [this.resource, this.resourceId].filter(el => el !== null)),
                        data: data
                    });

                    // Emit success event with the data from the successful response
                    this.$emit('success', response.data.data);
                    // Reset form by fetching the fields again. Only if resetOnSuccess prop is true
                    this.resetOnSuccess && this.fetchResourceForm();
                } catch (error) {
                    if (error.response.status === 422) {
                        this.validationErrors = error.response.data.errors;
                        this.$store.dispatch('flash', {
                            type: 'error',
                            text: 'There are validation errors in the form.'
                        })
                    }
                }
            },

            getFormData() {
                let data = {};
                // Fill the FormData object with executing the fill method of all fields
                _.each(this.fields, field => {
                    //skip fields that are not active
                    if (field.active === true) {
                        data = field.fill(data);
                    }
                });
                // If a form has removeNullValues set, this block will remove all keys
                // which have null or an empty string as their value.
                if (this.removeNullValues === true) {
                    data = _.pickBy(data);
                }
                // If there are values to append, do it.
                if (this.append !== false) {
                    Object.assign(data, this.append)
                }

                return objectToFormData(data);
            },

            getValidationErrors(field) {
                return this.$data.validationErrors[field.name] || [];
            },

            /**
             * Activate or deactivate all fields when the dependency field matches the value activation value.
             *
             * @param name of the field that changed
             * @param value of the field that changed
             */
            activateDependents(name, value) {
                _.each(this.fields, function (field) {
                    if (!_.isEmpty(field.dependency)) {
                        if (field.dependency.field === name) {
                            field.active = field.dependency.value === value
                        }
                    }
                });
            }
        }
    }
</script>
