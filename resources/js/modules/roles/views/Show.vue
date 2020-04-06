<template>
    <loading :loading="isLoading">
        <div v-if="role">
            <div class="md:flex md:items-center md:justify-between">
                <div class="flex-1 min-w-0">
                    <h1 class="text-lg leading-6 font-medium text-gray-900">
                        {{ $t('roles.show_title', {name: role.name} ) }}
                    </h1>
                </div>
                <div class="mt-4 flex md:mt-0 md:ml-4">
                    <span class="ml-3 shadow-sm rounded-md">
                        <router-link :to="{name: 'roles.edit', params: {id: id}}"
                                     class="inline-flex items-center px-4 py-2 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:shadow-outline transition duration-150 ease-in-out">
                            {{ $t('roles.button_edit') }}
                        </router-link>
                    </span>
                </div>
            </div>
            <div class="mt-6 grid grid-cols-1 row-gap-6 col-gap-4 sm:grid-cols-6">
                <div class="sm:col-span-6">
                    <span class="block text-sm font-medium leading-5 text-gray-700">
                        {{ $t('roles.name') }}
                    </span>
                    <div class="py-3">
                        {{role.name}}
                    </div>
                </div>
            </div>
            <ResourceForm
                resource="role"
                :resource-id="role.id"
                :submitPositions="['bottom', 'top']"
                @cancel=""
                @success="handleSuccess"
            />
        </div>
    </loading>
</template>

<script>
    import api from "../../../lib/api";
    import ResourceForm from "../../../components/ResourceForm";

    export default {
        components: {ResourceForm},
        props: ['id'],
        data() {
            return {
                isLoading: true,
                role: null,
                permissions: null
            }
        },
        methods: {
            handleSuccess(role) {
                Cms.flash('success', 'Nice one!');
                // this.$router.push({name: 'role.show', params: {id: post.id}})
            }
        },
        computed: {
        },
        async mounted() {
            const response = await api(Cms.route('cms.api.resources.show', ['role', this.id]));
            this.role = response.data.data;

            this.isLoading = false;
        },
    }
</script>
