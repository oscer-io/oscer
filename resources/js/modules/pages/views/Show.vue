<template>
    <loading :loading="isLoading">
        <div v-if="page">
            <div class="md:flex md:items-center md:justify-between">
                <div class="flex-1 min-w-0">
                    <h1 class="text-lg leading-6 font-medium text-gray-900">
                        {{ $t('pages.show_title', {name: page.name} ) }}
                    </h1>
                </div>
                <div class="mt-4 flex md:mt-0 md:ml-4">
                    <span class="ml-3 shadow-sm rounded-md">
                        <RouterLink
                            class="btn"
                            :to="{name: 'pages.edit', params: {id: id}}"
                        >
                            {{ $t('pages.button_edit') }}
                        </RouterLink>
                    </span>
                </div>
            </div>
            <div class="mt-6 grid grid-cols-1 row-gap-6 col-gap-4 sm:grid-cols-6">
                <div
                    v-if="page.featured_image"
                    class="sm:col-span-6"
                >
                    <img
                        class="h-80"
                        alt
                        :src="page.featured_image"
                    />
                </div>
                <div class="sm:col-span-6">
                    <span class="block text-sm font-medium leading-5 text-gray-700">
                        {{ $t('pages.name') }}
                    </span>
                    <div class="py-3">
                        {{page.name}}
                    </div>
                </div>
                <div class="sm:col-span-6">
                    <span class="block text-sm font-medium leading-5 text-gray-700">
                        {{ $t('pages.slug') }}
                    </span>
                    <div class="py-3">
                        {{page.slug}}
                    </div>
                </div>
                <div class="sm:col-span-6">
                    <span class="block text-sm font-medium leading-5 text-gray-700">
                        {{ $t('pages.body') }}
                    </span>
                    <div class="py-3">
                        {{page.body}}
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
                page: null
            }
        },
        async mounted() {
            const response = await api(Cms.route('cms.api.resources.show', ['page', this.id]));
            this.page = response.data.data;
            this.isLoading = false;
        }
    }
</script>
