<template>
    <tr>
        <td class="w-1/5 px-4 py-2">{{name}}</td>
        <td v-for="permission in permissions" class="w-1/5 px-4 py-2 text-center">
            <input type="checkbox" :id="permission.name" :checked="hasPermission(permission.name)">
        </td>
    </tr>
</template>

<script>
    import {some} from 'lodash';

    export default {
        methods: {
            hasPermission(name) {
                return some(this.role.permissions, {'name': name});
            }
        },
        props: {
            role: Array,
            permissions: Array,
            name: String,
        }
    }
</script>
