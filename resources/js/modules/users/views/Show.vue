<template>
    <loading :loading="isLoading">
        <div v-if="user">
            <div class="md:flex md:items-center md:justify-between">
                <div class="flex-1 min-w-0">
                    <h1 class="text-lg leading-6 font-medium text-gray-900">
                        {{ $t('users.show_title', {name: user.name} ) }}
                    </h1>
                </div>
                <div class="mt-4 flex md:mt-0 md:ml-4">
                    <span class="ml-3 shadow-sm rounded-md">
                        <router-link :to="{name: 'users.edit', params: {id: id}}" class="btn">
                            {{ $t('users.button_edit') }}
                        </router-link>
                    </span>
                </div>
            </div>
            <div class="mt-6 grid grid-cols-1 row-gap-6 col-gap-4 sm:grid-cols-6">
                <div class="sm:col-span-6">
                    <span class="block text-sm font-medium leading-5 text-gray-700">
                        {{ $t('users.name') }}
                    </span>
                    <div class="py-3">
                        {{user.name}}
                    </div>
                </div>
                <div class="sm:col-span-6">
                    <span class="block text-sm font-medium leading-5 text-gray-700">
                        {{ $t('users.email') }}
                    </span>
                    <div class="py-3">
                        {{user.email}}
                    </div>
                </div>
                <div class="sm:col-span-6">
                    <span class="block text-sm font-medium leading-5 text-gray-700">
                        {{ $t('users.bio') }}
                    </span>
                    <div class="py-3">
                        {{user.bio}}
                    </div>
                </div>
            </div>
        </div>
    </loading>
</template>

<script>
    import axios from 'axios';

    export default {
        props: ['id'],
        data() {
            return {
                isLoading: true,
                user: null
            }
        },
        computed: {
            title() {
                return this.user
                    ? this.$t('pages.show_user_title', {name: this.user.name, id: this.user.id})
                    : 'Loading'
            },
        },
        async mounted() {
            // posts endpoint not implemented because of the thoughts to only use one model with different types
            const response = await axios.get('/api/cms/users/' + this.id);
            this.user = response.data.data;
            this.isLoading = false;
        }
    }
</script>
