<template>
    <div v-if="page">
        <div class="md:flex md:items-center md:justify-between">
            <div class="flex-1 min-w-0">
                <h1 class="text-lg leading-6 font-medium text-gray-900">
                    {{ $t('pages.edit_title', {name: page.name} ) }}
                </h1>
            </div>
        </div>

        <form @submit.prevent="submit">
            <div class="mt-6 grid grid-cols-1 row-gap-6 col-gap-4 sm:grid-cols-6">
                <div class="sm:col-span-6">
                    <label for="name" class="block text-sm font-medium leading-5 text-gray-700">
                        {{ $t('pages.name') }}
                    </label>
                    <div class="mt-1 rounded-md shadow-sm">
                        <input id="name" type="text" v-model="form.name"
                               class="form-input block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5"/>
                    </div>
                    <!--                        <p v-if="$page.errors.name" class="mt-2 text-sm text-red-600">{{ $page.errors.name[0]}}</p>-->
                </div>
                <div class="sm:col-span-6">
                    <label for="slug" class="block text-sm font-medium leading-5 text-gray-700">
                        {{ $t('pages.slug') }}
                    </label>
                    <div class="mt-1 rounded-md shadow-sm">
                        <input id="slug" type="text" v-model="form.slug"
                               class="form-input block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5"/>
                    </div>
                    <!--                        <p v-if="$page.errors.slug" class="mt-2 text-sm text-red-600">{{ $page.errors.slug[0]}}</p>-->
                </div>
                <div class="sm:col-span-6">
                    <label for="body" class="block text-sm font-medium leading-5 text-gray-700">
                        {{ $t('pages.body') }}
                    </label>
                    <div class="mt-1 rounded-md shadow-sm">
                        <MarkdownField id="body"
                                       class="form-input block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5"
                                       v-model="form.body"/>
                    </div>
                    <!--                        <p v-if="$page.errors.body" class="mt-2 text-sm text-red-600">{{ $page.errors.body[0]}}</p>-->
                </div>
            </div>
            <div class="mt-8 border-t border-gray-200 pt-5">
                <div class="flex justify-end">
                        <span class="inline-flex rounded-md shadow-sm">
                            <router-link :to="{name: 'pages.show',params: {id: id}}"
                                         class="py-2 px-4 border border-gray-300 rounded-md text-sm leading-5 font-medium text-gray-700 hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-50 active:text-gray-800 transition duration-150 ease-in-out">
                                {{ $t('pages.button_cancel') }}
                            </router-link>
                        </span>
                    <span class="ml-3 inline-flex rounded-md shadow-sm">
                            <button type="submit"
                                    class="inline-flex justify-center py-2 px-4 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-700 transition duration-150 ease-in-out">
                                {{ $t('pages.button_save') }}
                            </button>
                      </span>
                </div>
            </div>
        </form>
    </div>
</template>

<script>
    import MarkdownField from '../../components/fields/MarkdownField';
    import axios from 'axios';

    export default {
        props: ['id'],
        components: {
            MarkdownField,
        },
        data() {
            return {
                page: null,
                form: {
                    name: '',
                    slug: '',
                    body: ''
                },
            }
        },
        async mounted() {
            const response = await axios.get('/api/cms/pages/' + this.id);
            this.page = response.data.data;
            this.form.name = this.page.name;
            this.form.slug = this.page.slug;
            this.form.body = this.page.body;
        },
        computed: {
            title() {
                return this.page
                    ? this.$t('pages.edit_page_title', {name: this.page.name, id: this.page.id})
                    : 'Loading'
            },
        },
        methods: {
            submit() {
                axios.put(this.route('cms.backend.pages.update', {page: this.page.id}), _.pickBy(this.form));
            }
        }
    }
</script>
