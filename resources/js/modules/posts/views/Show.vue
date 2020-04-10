<template>
    <loading :loading="isLoading">
        <div v-if="post">
            <div class="md:flex md:items-center md:justify-between">
                <div class="flex-1 min-w-0">
                    <h1 class="text-lg leading-6 font-medium text-gray-900">
                        {{ $t('posts.show_title', {name: post.name} ) }}
                    </h1>
                </div>
                <div class="mt-4 flex md:mt-0 md:ml-4">
                    <span class="ml-3 shadow-sm rounded-md">
                        <router-link :to="{name: 'posts.edit', params: {id: id}}" class="btn">
                            {{ $t('posts.button_edit') }}
                        </router-link>
                    </span>
                </div>
            </div>
            <div class="mt-6 grid grid-cols-1 row-gap-6 col-gap-4 sm:grid-cols-6">
                <div v-if="post.featured_image" class="sm:col-span-6">
                    <img class="h-80" alt :src="post.featured_image"/>
                </div>
                <div class="sm:col-span-6">
                    <span class="block text-sm font-medium leading-5 text-gray-700">
                        {{ $t('posts.name') }}
                    </span>
                    <div class="py-3">
                        {{post.name}}
                    </div>
                </div>
                <div class="sm:col-span-6">
                    <span class="block text-sm font-medium leading-5 text-gray-700">
                        {{ $t('posts.slug') }}
                    </span>
                    <div class="py-3">
                        {{post.slug}}
                    </div>
                </div>
                <div class="sm:col-span-6">
                    <span class="block text-sm font-medium leading-5 text-gray-700">
                        {{ $t('posts.body') }}
                    </span>
                    <div class="py-3">
                        {{post.body}}
                    </div>
                </div>
                <div class="sm:col-span-6">
                    <span class="block text-sm font-medium leading-5 text-gray-700">
                        {{ $t('posts.tags') }}
                    </span>
                    <div class="mt-2">
                        <span class="bg-indigo-600 py-1 px-2 ml-1 text-white rounded"
                              v-for="tag in post.tags"
                              v-text="tag">
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </loading>
</template>

<script>
    import api from "../../../lib/api";

    export default {
        props: ['id'],
        data() {
            return {
                isLoading: true,
                post: null
            }
        },
        async mounted() {
            const response = await api(Cms.route('cms.api.resources.show', ['post', this.id]));
            this.post = response.data.data;
            this.isLoading = false;
        }
    }
</script>
