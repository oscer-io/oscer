<template>
    <form @submit.prevent="handleSubmit">
        <component
            v-for="(field, index) in fields"
            :key="index"
            :is="`${field.type}-field`"
            :field="field"
        />
        <div class="mt-8 border-t border-gray-200 pt-5">
            <div class="flex justify-end">
                        <span class="inline-flex rounded-md shadow-sm">
                            <router-link :to="{name: cancelRoute}"
                                         class="py-2 px-4 border border-gray-300 rounded-md text-sm leading-5 font-medium text-gray-700 hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-50 active:text-gray-800 transition duration-150 ease-in-out">
                                {{ $t('users.button_cancel') }}
                            </router-link>
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
    export default {
        props: ['fields', 'cancelRoute'],
        methods: {
            handleSubmit() {
                console.log('submit');
            }
        }
    }
</script>
