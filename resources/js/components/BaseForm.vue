<template>
    <form @submit.prevent="handleSubmit">
        <component
            v-for="(field, index) in fields"
            :key="index"
            :ref="`${field.name}-field`"
            :is="`${field.type}-field`"
            :field="field"
            :validation-errors="validationErrors[field.name] || false"
        />
        <div class="mt-8 border-t border-gray-200 pt-5">
            <div class="flex justify-end">
                        <span class="inline-flex rounded-md shadow-sm">
                            <button type="button" @click="cancelMethod ? cancelMethod() : $emit('cancel')"
                                    class="py-2 px-4 border border-gray-300 rounded-md text-sm leading-5 font-medium text-gray-700 hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-50 active:text-gray-800 transition duration-150 ease-in-out">
                                {{ $t('users.button_cancel') }}
                            </button>
                        </span>
                <span class="ml-3 inline-flex rounded-md shadow-sm">
                            <button type="submit"
                                    class="inline-flex justify-center py-2 px-4 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-700 transition duration-150 ease-in-out">
                                {{ $t('users.button_save') }}
                            </button>
                        </span>
            </div>
        </div>
    </form>
</template>
<script>
    import _ from 'lodash';
    import api from "../lib/api";

    export default {
        props: {
            fields: {
                type: Array,
                default: () => []
            },
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
            cancelMethod: {
                type: Function
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
        mounted() {
            console.log('foo')
        },
        methods: {
            async handleSubmit() {
                _.each(this.fields, field => {
                    this.payload[field.name] = field.getValue()
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
                    if (error.response.status === 422) {
                        this.validationErrors = error.response.data.errors;
                        Cms.flash('error', 'There are validation errors in the form.')
                    }
                }
            }
        }
    }
</script>
