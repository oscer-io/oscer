<template>
    <layout :title="$t('users.create_page_title')">
        <div>
            <div class="md:flex md:items-center md:justify-between">
                <div class="flex-1 min-w-0">
                    <h1 class="text-lg leading-6 font-medium text-gray-900">
                        {{ $t('users.create_title') }}
                    </h1>
                </div>
            </div>
            <form @submit.prevent="submit">
                <div class="mt-6 grid grid-cols-1 row-gap-6 col-gap-4 sm:grid-cols-6">
                    <div class="sm:col-span-6">
                        <label for="name" class="block text-sm font-medium leading-5 text-gray-700">
                            {{ $t('users.name') }}
                        </label>
                        <div class="mt-1 rounded-md shadow-sm">
                            <input id="name"
                                   type="text"
                                   v-model="form.name"
                                   class="form-input block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5" />
                        </div>
                        <p v-if="$page.errors.name" class="mt-2 text-sm text-red-600">{{ $page.errors.name[0] }}</p>
                    </div>
                    <div class="sm:col-span-6">
                        <label for="email" class="block text-sm font-medium leading-5 text-gray-700">
                            {{ $t('users.email') }}
                        </label>
                        <div class="mt-1 rounded-md shadow-sm">
                            <input id="email"
                                   type="email"
                                   v-model="form.email"
                                   class="form-input block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5" />
                        </div>
                        <p v-if="$page.errors.email" class="mt-2 text-sm text-red-600">{{ $page.errors.email[0]}}</p>
                    </div>
                    <div class="sm:col-span-6">
                        <label for="about" class="block text-sm font-medium leading-5 text-gray-700">
                            {{ $t('users.bio') }}
                        </label>
                        <div class="mt-1 rounded-md shadow-sm">
                            <textarea id="about"
                                      rows="3"
                                      v-model="form.bio"
                                      class="form-textarea block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5"></textarea>
                        </div>
                        <p v-if="$page.errors.bio" class="mt-2 text-sm text-red-600">{{ $page.errors.bio[0] }}</p>
                        <p class="mt-2 text-sm text-gray-500">{{ $t('users.bio_subtext') }}</p>
                    </div>
                </div>
                <div class="mt-8 border-t border-gray-200 pt-5">
                    <div class="flex justify-end">
                        <span class="inline-flex rounded-md shadow-sm">
                            <InertiaLink :href="route('cms.backend.users.index')"
                                         class="py-2 px-4 border border-gray-300 rounded-md text-sm leading-5 font-medium text-gray-700 hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-50 active:text-gray-800 transition duration-150 ease-in-out">
                                {{ $t('users.button_cancel') }}
                            </InertiaLink>
                        </span>
                        <span class="ml-3 inline-flex rounded-md shadow-sm">
                            <button type="submit"
                                class="inline-flex justify-center py-2 px-4 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-700 transition duration-150 ease-in-out">
                                {{ $t('users.button_save') }}
                            </button>
                        </span>
                    </div>
                </div>
            </form>
        </div>
    </layout>
</template>

<script>
    import _ from 'lodash';
    import Layout from '../Layout';

    export default {
        components: {
            Layout
        },
        props: {
            user: Object,
        },
        created() {
        },
        data() {
            return {
                form: {
                    name: this.user.name,
                    email: this.user.email,
                    bio: this.user.bio
                },
            }
        },
        methods: {
            submit() {
                this.$inertia.post(this.route('cms.backend.users.store'), _.pickBy(this.form));
            }
        }
    }
</script>
