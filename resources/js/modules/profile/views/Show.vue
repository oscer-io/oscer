<template>
    <div>
        <div class="md:flex md:items-center md:justify-between">
            <div class="flex-1 min-w-0">
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    Profile
                </h3>
                <p class="mt-1 text-sm leading-5 text-gray-500">
                    {{$t('profile.subtitle')}}
                </p>
            </div>
            <div class="mt-4 flex md:mt-0 md:ml-4">
                <span class="ml-3 shadow-sm rounded-md">
                    <RouterLink :to="{name:'profile.edit'}" class="btn">
                        {{$t('profile.edit')}}
                    </RouterLink>
                </span>
            </div>
        </div>
        <div class="mt-6 grid grid-cols-1 row-gap-6 col-gap-4 sm:grid-cols-6">
            <div class="sm:col-span-3">
                <span class="block text-sm font-medium leading-5 text-gray-700">
                    {{$t('profile.name')}}
                </span>
                <div class="py-3">
                    {{user.name}}
                </div>
            </div>
            <div class="sm:col-span-3">
                <span class="block text-sm font-medium leading-5 text-gray-700">
                    {{$t('profile.email')}}
                </span>
                <div class="py-3">
                    {{user.email}}
                </div>
            </div>

            <div class="sm:col-span-6">
                <span class="block text-sm font-medium leading-5 text-gray-700">
                    {{$t('profile.bio')}}
                </span>
                <div class="py-3">
                    {{user.bio}}
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        created() {
        },
        data() {
            return {
                user: window.Cms.config.user
            }
        },
    }
</script>
