<template>
    <loading :loading="isLoading">
        <div class="bg-white px-4 py-5 border-b border-gray-200 sm:px-6">
            <div class="-ml-4 -mt-2 flex items-center justify-between flex-wrap sm:flex-no-wrap">
                <div class="ml-4 mt-2">
                    <h1 class="text-lg leading-6 font-medium text-gray-900">
                        {{ $t('pages.index_title') }}
                    </h1>
                </div>
                <div class="ml-4 mt-2 flex-shrink-0">
                    <span class="inline-flex rounded-md shadow-sm">
                        <router-link :to="{name:'pages.create'}" class="btn">
                            {{ $t('pages.button_create') }}
                        </router-link>
                    </span>
                </div>
            </div>
        </div>
        <div class="bg-white shadow overflow-hidden sm:rounded-md">
            <ul>
                <li v-for="page in pages">
                    <router-link :to="{name: 'pages.show', params:{id: page.id}}"
                                 class="block hover:bg-gray-50 focus:outline-none focus:bg-gray-50 transition duration-150 ease-in-out"
                    >
                        <div class="flex items-center px-4 py-4 sm:px-6">
                            <div class="min-w-0 flex-1 flex items-center">
                                <div class="min-w-0 flex-1 px-4 md:grid md:grid-cols-2 md:gap-4">
                                    <div>
                                        <div class="text-sm leading-5 font-medium text-indigo-600 truncate">
                                            {{page.name}}
                                        </div>
                                        <div class="mt-2 flex items-center text-sm leading-5 text-gray-500">
                                            <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" fill="currentColor"
                                                 viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                      d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884zM18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"
                                                      clip-rule="evenodd"/>
                                            </svg>
                                            <span class="truncate">
                                                {{page.slug}}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="hidden md:block">
                                        <div>
                                            <div class="text-sm leading-5 text-gray-900">
                                                {{ $t('pages.created_at') }}
                                                <time :datetime="page.created_at">{{page.created_at}}</time>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                          d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </div>
                        </div>
                    </router-link>
                </li>
            </ul>
        </div>
    </loading>
</template>

<script>
    import api from "../../../lib/api";

    export default {
        data() {
            return {
                isLoading: true,
                pages: []
            }
        },
        async mounted() {
            const response = await api(Cms.route('cms.api.resources.index', 'page'));
            this.pages = response.data.data;
            this.isLoading = false;
        }
    }
</script>
