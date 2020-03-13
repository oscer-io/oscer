<template>
    <layout :title="'Show page - ' + page.name + ' (ID: ' + page.id + ')'">
        <div class="flex flex-col">
            <div class="-mb-2 py-4 flex flex-wrap flex-grow justify-between">
                <div class="flex items-center py-2">
                    <h1 class="text-3xl font-bolder leading-tight text-gray-900">
                        {{ page.name }} - (ID: {{ page.id }})
                    </h1>
                </div>
                <div class="flex items-center py-2">
                    <inertia-link
                        :href="route('cms.pages.edit', {page: page.id})"
                        class="inline-block px-4 py-2 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:shadow-outline">
                        Edit
                    </inertia-link>
                </div>
            </div>
            <div class="bg-gray-50 shadow overflow-hidden sm:rounded-lg">
                <div>
                    <dl>
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dd class="text-sm leading-5 font-medium text-gray-500">
                                Name
                            </dd>
                            <dt class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                                {{ page.name }}
                            </dt>
                        </div>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dd class="text-sm leading-5 font-medium text-gray-500">
                                Slug
                            </dd>
                            <dt class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                                {{ page.slug }}
                            </dt>
                        </div>
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dd class="text-sm leading-5 font-medium text-gray-500">
                                Status
                            </dd>
                            <dt class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                                <span
                                    class="px-2 inline-flex text-sm leading-5 font-bold">
                                    not yet implemented
                                </span>
                                <span
                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    published example
                                </span>
                                <span
                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                    draft example
                                </span>
                                <span
                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                    in review example
                                </span>
                            </dt>
                        </div>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dd class="text-sm leading-5 font-medium text-gray-500">
                                Author
                            </dd>
                            <dt class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <img class="h-10 w-10 rounded-full"
                                             :src="page.author.avatar"
                                             alt=""/>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm leading-5 font-medium text-gray-900">
                                            <div
                                                class="">{{page.author.name}}
                                            </div>
                                            <div class="text-xs text-gray-500">{{page.author.email}}</div>
                                        </div>
                                    </div>
                                </div>
                            </dt>
                        </div>
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dd class="text-sm leading-5 font-medium text-gray-500">
                                Published at
                            </dd>
                            <dt class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                                {{ page.created_at }}
                            </dt>
                        </div>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dd class="text-sm leading-5 font-medium text-gray-500">
                                Updated at
                            </dd>
                            <dt class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                                {{ page.updated_at }}
                            </dt>
                        </div>
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dd class="text-sm leading-5 font-medium text-gray-500">
                                Body
                            </dd>
                            <dt class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                                <div v-html="markdown(page.body)"></div>
                            </dt>
                        </div>
                    </dl>
                </div>
            </div>
        </div>
    </layout>
</template>

<script>
    import Layout from '../../Layout';
    import marked from 'marked';

    export default {
        components: {
            Layout
        },
        props: {
            page: Object
        },
        methods: {
            markdown(value) {
                return marked(value);
            }
        }
    }
</script>
