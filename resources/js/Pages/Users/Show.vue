<template>
    <layout title="Show user">
        <div>
        <div class="md:flex md:items-center md:justify-between">
            <div class="flex-1 min-w-0">
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    {{user.name}}
                </h3>
                <p class="mt-1 text-sm leading-5 text-gray-500">
                    a smart sentence can be written here...
                </p>
            </div>
            <div class="mt-4 flex md:mt-0 md:ml-4">
                    <span class="ml-3 shadow-sm rounded-md">
      <inertia-link :href="route('cms.backend.users.edit', {user: user.id})"
                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:shadow-outline transition duration-150 ease-in-out">
        Edit
      </inertia-link>
    </span>
            </div>
        </div>
        <div class="mt-6 grid grid-cols-1 row-gap-6 col-gap-4 sm:grid-cols-6">
            <div class="sm:col-span-6">
                                <span class="block text-sm font-medium leading-5 text-gray-700">
                                    Name
                                </span>
                <div class="py-3">
                    {{user.name}}
                </div>
            </div>
            <div class="sm:col-span-6">
                                <span class="block text-sm font-medium leading-5 text-gray-700">
                                    Email
                                </span>
                <div class="py-3">
                    {{user.email}}
                </div>
            </div>

            <div class="sm:col-span-6">
                                <span class="block text-sm font-medium leading-5 text-gray-700">
                                    Bio
                                </span>
                <div class="py-3">
                    {{user.bio}}
                </div>
            </div>
        </div>

        </div>
    </layout>
</template>

<script>
    import Layout from '../../Layout';

    export default {
        components: {
            Layout
        },
        props: {
            user: Object,
        }
    }
</script>
