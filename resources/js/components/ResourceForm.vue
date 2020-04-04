<template>
    <form @submit.prevent="handleSubmit">
        <component
            v-for="(field, index) in fields"
            :key="index"
            :ref="`${field.name}-field`"
            :is="field.component"
            :field="field"
            :validation-errors="getValidationErrors(field)"
        />
        <div class="mt-8 border-t border-gray-200 pt-5">
            <div class="flex justify-end">
                        <span class="inline-flex rounded-md shadow-sm">
                            <button type="button" @click="cancelMethod ? cancelMethod() : $emit('cancel')"
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
            cancelText: {
                type: String,
                default: 'Cancel'
            },
            submitText: {
                type: String,
                default: 'Submit'
            },
            cancelMethod: {
                type: Function
            }
        },
        data() {
            return {
                fields: []
            }
        },
        mounted() {
            this.fetchResourceForm();
        },
        methods: {
            async fetchResourceForm() {
                const response = await api(
                    Cms.route('cms.api.resources.fields', {resource: this.resource})
                );

                this.fields = response.data.fields;
            }
        }
    }
</script>
