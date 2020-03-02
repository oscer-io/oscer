<template>
    <layout title="My Profile">

        <div>

            <div class="md:flex md:items-center md:justify-between">
                <div class="flex-1 min-w-0">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                        Profile
                    </h3>
                    <p class="mt-1 text-sm leading-5 text-gray-500">
                        This information will be displayed publicly so be careful what you share.
                    </p>
                </div>
                <div class="mt-4 flex md:mt-0 md:ml-4">
                    <span class="ml-3 shadow-sm rounded-md">
      <button @click="edit = true" v-if="edit === false" type="button"
              class="inline-flex items-center px-4 py-2 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:shadow-outline transition duration-150 ease-in-out">
        Edit
      </button>
    </span>
                </div>
            </div>
            <div v-if="edit === false" class="mt-6 grid grid-cols-1 row-gap-6 col-gap-4 sm:grid-cols-6">
                <div class="sm:col-span-3">
                                <span class="block text-sm font-medium leading-5 text-gray-700">
                                    Name
                                </span>
                    <div class="py-3">
                        {{user.name}}
                    </div>
                </div>
                <div class="sm:col-span-3">
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

            <form v-if="edit === true" @submit.prevent="save">
                <div>
                    <div>

                        <div class="mt-6 grid grid-cols-1 row-gap-6 col-gap-4 sm:grid-cols-6">
                            <div class="sm:col-span-3">
                                <label for="name" class="block text-sm font-medium leading-5 text-gray-700">
                                    Name
                                </label>
                                <div class="mt-1 rounded-md shadow-sm">
                                    <input id="name" type="test" v-model="form.name"
                                           class="form-input block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5"/>
                                </div>
                            </div>
                            <div class="sm:col-span-3">
                                <label for="email" class="block text-sm font-medium leading-5 text-gray-700">
                                    Email
                                </label>
                                <div class="mt-1 rounded-md shadow-sm">
                                    <input id="email" type="email" v-model="form.email"
                                           class="form-input block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5"/>
                                </div>
                            </div>

                            <div class="sm:col-span-6">
                                <label for="about" class="block text-sm font-medium leading-5 text-gray-700">
                                    Bio
                                </label>
                                <div class="mt-1 rounded-md shadow-sm">
                                <textarea id="about" rows="3" v-model="form.bio"
                                          class="form-textarea block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5"></textarea>
                                </div>
                                <p class="mt-2 text-sm text-gray-500">Write a few sentences about yourself.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-8 border-t border-gray-200 pt-5">
                    <div class="flex justify-end">
      <span class="inline-flex rounded-md shadow-sm">
        <button type="button" @click="cancel"
                class="py-2 px-4 border border-gray-300 rounded-md text-sm leading-5 font-medium text-gray-700 hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-50 active:text-gray-800 transition duration-150 ease-in-out">
          Cancel
        </button>
      </span>
                        <span class="ml-3 inline-flex rounded-md shadow-sm">
        <button type="submit"
                class="inline-flex justify-center py-2 px-4 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-700 transition duration-150 ease-in-out">
          Save
        </button>
      </span>
                    </div>
                </div>
            </form>

        </div>
    </layout>
</template>

<script>
    import Layout from '../Layout';

    export default {
        components: {
            Layout
        },
        props: {
            user: Object,
        },
        data() {
            return {
                edit: false,
                form: {
                    name: this.user.name,
                    email: this.user.email,
                    bio: this.user.bio
                },
            }
        },
        methods: {
            cancel() {
                this.form = {
                    name: this.user.name,
                    email: this.user.email,
                    bio: this.user.bio
                };
                this.edit = false;
            },
            save() {
                this.edit = false;
            }
        }
    }
</script>
