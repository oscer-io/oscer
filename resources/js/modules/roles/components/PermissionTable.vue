<template>
    <table class="table-fixed w-full">
        <thead>
        <tr>
            <th class="w-1/5 px-4 py-2">Permission</th>
            <th class="w-1/5 px-4 py-2">Create</th>
            <th class="w-1/5 px-4 py-2">Delete</th>
            <th class="w-1/5 px-4 py-2">Update</th>
            <th class="w-1/5 px-4 py-2">View</th>
        </tr>
        </thead>
        <tbody>
        <PermissionTableRow v-for="(permissionGroup, permissionGroupName) in permissionGroups"
                            :key="permissionGroupName"
                            :role="role"
                            :name="permissionGroupName"
                            :permissions="permissionGroup"/>
        </tbody>
    </table>
</template>

<script>
    import PermissionTableRow from './PermissionTableRow';
    import {groupBy} from 'lodash';

    export default {
        components: {
            PermissionTableRow
        },
        computed: {
            permissionGroups() {
                return groupBy(this.permissions, 'group');
            },
        },
        props: {
            role: Object,
            permissions: Array,
            name: String,
        },
        data() {
            return {
                rolePermissions: this.role.permissions,
            }
        },
    }
</script>
