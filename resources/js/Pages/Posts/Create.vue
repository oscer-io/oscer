<template>
    <layout title="Create new post">
        <div>
            <div class="md:flex md:items-center md:justify-between">
                <div class="flex-1 min-w-0">
                    <h1 class="text-lg leading-6 font-medium text-gray-900">
                        Create new post
                    </h1>
                    <p class="mt-1 text-sm leading-5 text-gray-500">
                        a smart sentence can be written here...
                    </p>
                </div>
            </div>
            <form @submit.prevent="submit">
                <div class="mt-6 grid grid-cols-1 row-gap-6 col-gap-4 sm:grid-cols-6">
                    <div class="sm:col-span-6">
                        <label for="title" class="block text-sm font-medium leading-5 text-gray-700">
                            Title
                        </label>
                        <div class="mt-1 rounded-md shadow-sm">
                            <input id="title" type="text" v-model="form.title"
                                   class="form-input block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5"/>
                        </div>
                        <p v-if="$page.errors.title" class="mt-2 text-sm text-red-600">{{ $page.errors.title[0] }}</p>
                    </div>
                    <div class="sm:col-span-6">
                        <tag-input v-model="form.tags" :available-tags="tags"></tag-input>
                    </div>

                    <div class="sm:col-span-6">
                        <label for="body" class="block text-sm font-medium leading-5 text-gray-700">
                            Body
                        </label>

                        <markdown-field id="body"
                                        class="form-input block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5"
                                        v-model="form.body"/>
                        <p v-if="$page.errors.body" class="mt-2 text-sm text-red-600">{{ $page.errors.body[0]}}</p>
                        <p class="mt-2 text-sm text-gray-500">Write crazy stuff.</p>
                    </div>
                </div>
                <div class="mt-8 border-t border-gray-200 pt-5">
                    <div class="flex justify-end">
                        <span class="inline-flex rounded-md shadow-sm">
                            <inertia-link :href="route('cms.posts.index')"
                                          class="py-2 px-4 border border-gray-300 rounded-md text-sm leading-5 font-medium text-gray-700 hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-50 active:text-gray-800 transition duration-150 ease-in-out">
                              Cancel
                            </inertia-link>
                        </span>
                        <span class="ml-3 inline-flex rounded-md shadow-sm">
                            <button type="submit"
                                    class="inline-flex justify-center py-2 px-4 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-700 transition duration-150 ease-in-out">
                              Save
                            </button>
                        </span>
                    </div>
                </div>
            </form>
        </div>
    </layout>
</template>

<script>
    import _ from 'lodash';
    import Layout from '../../Layout';
    import TagInput from "../../components/TagInput";
    import MarkdownField from "../../components/Fields/MarkdownField";
    export default {
        components: {
            Layout,
            MarkdownField,
            TagInput,
        },
        props: {
            tags: Array
        },
        data() {
            return {
                form: {
                    name: '',
                    body: '',
                    tags: []
                },
            }
        },
        methods: {
            submit() {
                this.$inertia.post(this.route('cms.posts.store'), _.pickBy(this.form));
            }
        }
    }
</script>
