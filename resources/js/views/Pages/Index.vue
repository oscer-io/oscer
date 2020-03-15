<template>
    <layout :title="$t('pages.index_page_title')">
        <div class="flex flex-col">
            <div class="mb-4">
                <h1 class="text-3xl font-bolder leading-tight text-gray-900">
                    {{ $t('pages.index_title') }}
                </h1>
            </div>
            <div class="-mb-2 py-4 flex flex-wrap flex-grow justify-between">
                <div class="flex items-center py-2">
                    <input class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500"
                           id="inline-search"
                           type="text"
                           :placeholder="$t('pages.placeholder_search')"
                    />
                </div>
                <div class="flex items-center py-2">
                    <InertiaLink :href="route('cms.backend.pages.create')"
                                 class="inline-block px-4 py-2 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:shadow-outline">
                        {{ $t('pages.button_create') }}
                    </InertiaLink>
                </div>
            </div>
            <div class="-my-2 py-2 sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8">
                <div class="align-middle inline-block w-full shadow overflow-x-auto sm:rounded-lg border-b border-gray-200">
                    <table class="min-w-full">
                        <thead>
                        <tr class="border-b border-gray-200 bg-white leading-4 tracking-wider text-base text-gray-900">
                            <th class="px-6 py-5 text-left" colspan="5">
                                <input class="form-checkbox h-4 w-4 text-indigo-600 transition duration-150 ease-in-out"
                                       type="checkbox"/>
                            </th>
                            <th class="px-6 py-5 text-left">
                                <input class="form-checkbox h-4 w-4 text-indigo-600 transition duration-150 ease-in-out"
                                       type="checkbox"/>
                            </th>
                        </tr>
                        <tr class="bg-gray-50 border-b border-gray-200 text-xs leading-4 text-gray-500 uppercase tracking-wider">
                            <th class="px-6 py-3 text-left font-medium">
                                <input class="form-checkbox h-4 w-4 text-indigo-600 transition duration-150 ease-in-out"
                                       type="checkbox"/>
                            </th>
                            <th class="px-6 py-3 text-left font-medium">
                                {{ $t('pages.name') }}
                            </th>
                            <th class="px-6 py-3 text-left font-medium">
                                {{ $t('pages.author') }}
                            </th>
                            <th class="px-6 py-3 text-left font-medium">
                                {{ $t('pages.status') }}
                            </th>
                            <th class="px-6 py-3 text-left font-medium">
                                {{ $t('pages.date') }}
                            </th>
                            <th class="px-6 py-3 text-left font-medium">
                            </th>
                        </tr>
                        </thead>
                        <tbody class="bg-white">
                        <tr v-if="pages === null || pages.length === 0">
                            <td colspan="7" class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 text-center">
                                {{ $t('pages.message_no_items') }}
                            </td>
                        </tr>
                        <tr v-for="page in pages" v-if="pages !== null"
                            class="border-b border-gray-200 hover:bg-gray-50 focus:outline-none focus:bg-gray-50 transition duration-150 ease-in-out">
                            <td class="px-6 py-4 whitespace-no-wrap">
                                <input class="form-checkbox h-4 w-4 text-indigo-600 transition duration-150 ease-in-out"
                                       type="checkbox"/>
                            </td>
                            <td class="px-6 py-4 whitespace-no-wrap">
                                <div class="flex items-center">
                                    <div class="text-sm leading-5">
                                        <div>
                                            <InertiaLink :href="route('cms.backend.pages.show', {page: page.id})"
                                                          class="text-indigo-600 hover:text-indigo-900 focus:outline-none hover:underline">
                                                {{ page.name }}
                                            </InertiaLink>
                                        </div>
                                        <div class="text-xs leading-5 text-gray-500">
                                            {{ page.slug }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-no-wrap">
                                <div class="flex items-center">
                                    <div class="text-sm leading-5">
                                        <div>
                                            <InertiaLink :href="route('cms.backend.users.show', {user: page.author_id})"
                                                          class="text-indigo-600 hover:text-indigo-900 focus:outline-none hover:underline">
                                                {{ page.author.name }}
                                            </InertiaLink>
                                        </div>
                                        <div class="text-xs leading-5 text-gray-500">
                                            {{ page.author.email }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-no-wrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    not yet implemented
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-500">
                                <div class="text-sm leading-5" v-if="page.published_at === page.updated_at">
                                    <div class="text-sm leading-5">
                                        {{ $t('pages.published_at') }}
                                    </div>
                                    <div class="text-xs leading-5">
                                        {{ page.created_at }}
                                    </div>
                                </div>
                                <div class="text-sm leading-5" v-else>
                                    <div class="text-sm leading-5">
                                        {{ $t('pages.updated_at') }}
                                    </div>
                                    <div class="text-xs leading-5">
                                        {{ page.updated_at }}
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-no-wrap text-right text-sm leading-5 font-medium">
                                <InertiaLink
                                    :href="route('cms.backend.pages.show', { page: page.id })"
                                    class="text-indigo-600 hover:text-indigo-900 focus:outline-none focus:underline">
                                    {{ $t('pages.button_show') }}
                                </InertiaLink>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </layout>
</template>

<script>
    import Layout from '../Layout';

    export default {
        props: {
            pages: Array
        },
        components: {
            Layout
        }
    }
</script>
