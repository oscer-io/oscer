<template>
    <div v-if="page" class="flex flex-col">
        <div class="-mb-2 py-4 flex flex-wrap flex-grow justify-between">
            <div class="flex items-center py-2">
                <h1 class="text-3xl font-bolder leading-tight text-gray-900">
                    {{ $t('pages.show_title', {name: page.name} ) }}
                </h1>
            </div>
            <div class="flex items-center py-2">
                <router-link :to="{name: 'pages.edit',params: {id: this.id}}"
                             class="inline-block px-4 py-2 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:shadow-outline">
                    {{ $t('pages.button_edit') }}
                </router-link>
            </div>
        </div>
        <div class="bg-gray-50 shadow overflow-hidden sm:rounded-lg">
            <div>
                <dl>

                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dd class="text-sm leading-5 font-medium text-gray-500">
                            {{ $t('pages.name') }}
                        </dd>
                        <dt class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ page.name }}
                        </dt>
                    </div>
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dd class="text-sm leading-5 font-medium text-gray-500">
                            {{ $t('pages.slug') }}
                        </dd>
                        <dt class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ page.slug }}
                        </dt>
                    </div>
                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dd class="text-sm leading-5 font-medium text-gray-500">
                            {{ $t('pages.status') }}
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
                            {{ $t('pages.author') }}
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
                            {{ $t('pages.published_at') }}
                        </dd>
                        <dt class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ page.created_at }}
                        </dt>
                    </div>
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dd class="text-sm leading-5 font-medium text-gray-500">
                            {{ $t('pages.updated_at') }}
                        </dd>
                        <dt class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ page.updated_at }}
                        </dt>
                    </div>
                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dd class="text-sm leading-5 font-medium text-gray-500">
                            {{ $t('pages.body') }}
                        </dd>
                        <dt class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                            <div v-html="markdown(page.body)"></div>
                        </dt>
                    </div>
                </dl>
            </div>
        </div>
    </div>
</template>

<script>
    import marked from 'marked';
    import axios from 'axios';

    export default {

        props: ['id'],
        data() {
            return {
                page: null
            }
        },
        computed: {
            title() {
                return this.page
                    ? this.$t('pages.show_page_title', {name: this.page.name, id: this.page.id})
                    : 'Loading'
            },
        },
        async mounted() {
            // posts endpoint not implemented because of the thoughts to only use one model with different types
            const response = await axios.get('/api/cms/pages/' + this.id);
            this.page = response.data.data
        },
        methods: {
            markdown(value) {
                return marked(value);
            }
        }
    }
</script>
