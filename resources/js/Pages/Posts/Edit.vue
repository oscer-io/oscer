<template>
    <layout :title="'Edit post - ' + post.name + ' (ID: ' +  post.id + ')'">
        <div>
            <div class="md:flex md:items-center md:justify-between">
                <div class="flex-1 min-w-0">
                    <h1 class="text-lg leading-6 font-medium text-gray-900">
                        Edit: {{post.name}}
                    </h1>
                    <p class="mt-1 text-sm leading-5 text-gray-500">
                        a smart sentence can be written here...
                    </p>
                </div>
            </div>
            <form @submit.prevent="submit">
                <div class="mt-6 grid grid-cols-1 row-gap-6 col-gap-4 sm:grid-cols-6">
                    <div class="sm:col-span-6">
                        <label for="name" class="block text-sm font-medium leading-5 text-gray-700">
                            Name
                        </label>
                        <div class="mt-1 rounded-md shadow-sm">
                            <input id="name" type="text" v-model="form.name"
                                   class="form-input block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5"/>
                        </div>
                        <p v-if="$page.errors.name" class="mt-2 text-sm text-red-600">{{ $page.errors.name[0] }}</p>
                    </div>
                    <div class="sm:col-span-6">
                        <label for="slug" class="block text-sm font-medium leading-5 text-gray-700">
                            Slug
                        </label>
                        <div class="mt-1 rounded-md shadow-sm">
                            <input id="slug" type="text" v-model="form.slug"
                                   class="form-input block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5"/>
                        </div>
                        <p v-if="$page.errors.slug" class="mt-2 text-sm text-red-600">{{ $page.errors.slug[0]}}</p>
                    </div>
                    <div class="sm:col-span-6">
                        <tag-input v-model="form.tags" :available-tags="this.tags" />
                    </div>

                    <div class="sm:col-span-6">
                        <label for="body" class="block text-sm font-medium leading-5 text-gray-700">
                            Body
                        </label>
                        <markdown-field id="body"
                                        class="form-input block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5"
                                        v-model="form.body"/>
                        <p v-if="$page.errors.body" class="mt-2 text-sm text-red-600">{{ $page.errors.body[0] }}</p>
                        <p class="mt-2 text-sm text-gray-500">Write crazy stuff.</p>
                    </div>
                </div>
                <div class="mt-8 border-t border-gray-200 pt-5">
                    <div class="flex justify-end">
                        <span class="inline-flex rounded-md shadow-sm">
                            <inertia-link :href="route('cms.posts.show',{post: post.id})"
                                          class="py-2 px-4 border border-gray-300 rounded-md text-sm leading-5 font-medium text-gray-700 hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-50 active:text-gray-800 transition duration-150 ease-in-out">
                              Cancel
                            </inertia-link>
                        </span>
                        <span class="ml-3 inline-flex rounded-md shadow-sm">
                            <button type="submit"
                                    class="inline-flex justify-center py-2 px-4 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-700 transition duration-150 ease-in-out">
                              Save Post
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
    import MarkdownEditor from "../../components/MarkdownEditor";
    import MarkdownField from "../../components/Fields/MarkdownField";
    import TagInput from "../../components/TagInput";

    export default {
        components: {
            Layout,
            MarkdownEditor,
            MarkdownField,
            TagInput
        },
        props: {
            post: Object,
            tags: Array,
        },
        data() {
            return {
                form: {
                    name: this.post.name,
                    slug: this.post.slug,
                    tags: this.post.tags.map(tag => tag.name),
                    body: this.post.body,
                },
            }
        },
        methods: {
            submit() {
                this.$inertia.put(this.route('cms.posts.update',{post: this.post.id}), _.pickBy(this.form));
            }
        }
    }
</script>
