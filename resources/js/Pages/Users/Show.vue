<template>
    <layout title="Show user">

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
