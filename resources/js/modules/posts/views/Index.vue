<template>
    <div>
        <div class="bg-white px-4 py-5 border-b border-gray-200 sm:px-6">
            <div class="-ml-4 -mt-2 flex items-center justify-between flex-wrap sm:flex-no-wrap">
                <div class="ml-4 mt-2">
                    <h1 class="text-lg leading-6 font-medium text-gray-900">
                        {{ $t('posts.index_title') }}
                    </h1>
                </div>
                <div class="ml-4 mt-2 flex-shrink-0">
                    <span class="inline-flex rounded-md shadow-sm">
                        <RouterLink
                            class="btn"
                            :to="{name:'posts.create'}"
                        >
                            {{ $t('posts.button_create') }}
                        </RouterLink>
                    </span>
                </div>
            </div>
        </div>
        <ResourceIndex resource="post"/>
    </div>
</template>

<script>
    import ResourceIndex from "../../../components/ResourceIndex";

    export default {
        components: {ResourceIndex},
    }
</script>
