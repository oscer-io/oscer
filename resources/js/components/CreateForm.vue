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
                            <button type="button" @click="$emit('cancel')"
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
    import axios from "axios";

    export default {
        props: ['fields', 'cancelRoute', 'apiEndpoint'],
        data(){
            return {
                payload:{},
                validationErrors: {}
            }
        },
        methods: {
            async handleSubmit() {
                _.each(this.fields, field => {
                    this.payload[field.name] = field.getValue()
                });

                try {
                    const response = await axios.post(this.apiEndpoint, this.payload);
                    console.log(response.data.data)
                    this.$emit('success',response.data.data);
                } catch (error) {
                    if (error.response.status === 422) {
                        this.validationErrors = error.response.data.errors;
                        Cms.flash('error', 'There was a problem submitting the form.')
                    }
                }
            }
        }
    }
</script>
