<template>
    <loading :loading="isLoading">
        <div>
            <div class="bg-white px-4 py-5 border-b border-gray-200 sm:px-6">
                <div class="-ml-4 -mt-2 flex items-center justify-between flex-wrap sm:flex-no-wrap">
                    <div class="ml-4 mt-2">
                        <h1 class="text-lg leading-6 font-medium text-gray-900">
                            {{ $t('roles.index_title') }}
                        </h1>
                    </div>
                    <div class="ml-4 mt-2 flex-shrink-0">
                    <span class="inline-flex rounded-md shadow-sm">
                        <router-link :to="{name: 'roles.create'}"
                                     class="relative inline-flex items-center px-4 py-2 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:shadow-outline">
                            {{ $t('roles.button_create') }}
                        </router-link>
                    </span>
                    </div>
                </div>
            </div>
            <div class="bg-white shadow overflow-hidden sm:rounded-md">
                <ul>
                    <li v-for="role in roles">
                        <router-link :to="{name: 'roles.show',params: {id: role.id}}"
                                     class="block hover:bg-gray-50 focus:outline-none focus:bg-gray-50 transition duration-150 ease-in-out">

                            <div class="flex items-center px-4 py-4 sm:px-6">
                                <div class="min-w-0 flex-1 flex items-center">
                                    <div class="min-w-0 flex-1 px-4 md:grid md:grid-cols-2 md:gap-4">
                                        <div>
                                            <div class="text-sm leading-5 font-medium text-indigo-600 truncate">
                                                {{role.name}}
                                            </div>
                                        </div>
                                        <div class="hidden md:block">
                                            <div>
                                                <div class="text-sm leading-5 text-gray-900">
                                                    {{ $t('roles.created_at') }}
                                                    <time datetime="2020-01-07">{{role.created_at}}</time>
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
        </div>
    </loading>
</template>

<script>
    import api from "../../../lib/api";

    export default {
        data() {
            return {
                isLoading: true,
                roles: []
            }
        },
        async mounted() {
            const response = await api(this.route('cms.api.roles.index'));
            this.roles = response.data.data;
            this.isLoading = false;
        }
    }
</script>
