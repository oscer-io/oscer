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
            <PermissionTable
                :role="role"
                :permissions="permissions"/>
        </div>
    </loading>
</template>

<script>
    import api from "../../../lib/api";
    import PermissionTable from '../components/PermissionTable';

    export default {
        components: {PermissionTable},
        props: ['id'],
        data() {
            return {
                isLoading: true,
                role: null,
                permissions: null
            }
        },
        computed: {
            title() {
                return this.role
                    ? this.$t('pages.show_role_title', {name: this.role.name, id: this.role.id})
                    : 'Loading'
            },
        },
        async mounted() {
            const responseRole = await api(this.route('cms.api.roles.index'));
            const responsePermissions = await api(this.route('cms.api.permissions.index'));
            this.role = responseRole.data.data;
            this.permissions = responsePermissions.data.data;

            this.isLoading = false;
        },
    }
</script>
