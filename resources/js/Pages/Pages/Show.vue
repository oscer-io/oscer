<template>
    <layout title="posts">


        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 border-b border-gray-200 sm:px-6">
                <h1>Page ID {{ page.id }}</h1>
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    {{ page.title }}
                </h3>
                <p class="mt-1 max-w-2xl text-sm leading-5 text-gray-500">
                    {{ page.excerpt }}
                </p>
            </div>
            <div>
                <dl>
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dd class="text-sm leading-5 font-medium text-gray-500">
                            Title
                        </dd>
                        <dt class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ page.title }}
                        </dt>
                    </div>
                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dd class="text-sm leading-5 font-medium text-gray-500">
                            Status
                        </dd>
                        <dt class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                            <span
                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                {{ page.status }}
                            </span>
                        </dt>
                    </div>
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dd class="text-sm leading-5 font-medium text-gray-500">
                            Excerpt
                        </dd>
                        <dt class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ page.excerpt }}
                        </dt>
                    </div>
                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dd class="text-sm leading-5 font-medium text-gray-500">
                            Content
                        </dd>
                        <dt class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ page.content }}
                        </dt>
                    </div>
                </dl>
            </div>
        </div>
    </layout>
</template>

<script>
    import Layout from '../../Layout';
    export default {
        mounted() {
            console.log(this.route('cms.pages.index'));
        },
        components: {
          Layout
        },
        props: {
            page: Object,
        },
    }
</script>
