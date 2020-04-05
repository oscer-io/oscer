<template>
    <table class="table-fixed w-full">
        <thead>
        <tr>
            <th class="w-1/5 py-2 text-left">Permission</th>
            <th class="w-1/5 py-2"></th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="permission in permissions"
            :key="permission.id">
            <td class="w-1/5 pr-4 py-2">{{$t(permission.name)}}</td>
            <td class="w-1/5 py-2 text-center">
                <input type="checkbox" :id="permission.name" :checked="hasPermission(permission.name)"/>
            </td>
        </tr>
        </tbody>
    </table>
</template>

<script>
    // import PermissionTableRow from './PermissionTableRow';
    import {some} from 'lodash';

    export default {
        components: {
        },
        methods: {
            hasPermission(name) {
                return some(this.role.permissions, {'name': name});
            }
        },
        mounted() {
            console.log(this.role.permissions);
            console.log(this.permissions);
            console.log(this.permissions[0].group);
        },
        computed: {},
        props: {
            role: {
                type: Object,
                required: true
            },
            permissions: {
                type: Array,
                required: true
            },
        },
    }
</script>
