<template>
    <loading :loading="isLoading">
        <table v-if="items.length > 0">
            <thead>
            <tr>
                <th v-for="column in tableHeaderColumns" v-text="column"></th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="item in items">
                <td v-for="field in item.fields" v-text="field.value"></td>
                <td>
                    <router-link :to="{name:`${resource}s.show`, params: {id: item.resourceId}}" class="btn">
                        show
                    </router-link>
                    <router-link :to="{name:`${resource}s.edit`, params: {id: item.resourceId}}" class="btn">
                        edit
                    </router-link>
                </td>
            </tr>
            </tbody>
        </table>

    </loading>
</template>

<script>
    import api from "../lib/api";

    export default {
        props: {
            resource: {
                type: String,
                required: true
            }
        },
        data() {
            return {
                isLoading: true,
                items: [],
            }
        },
        computed: {
            tableHeaderColumns() {
                return this.items.length > 0 ? this.items[0].fields.map(field => field.name) : []
            }
        },
        mounted() {
            this.fetchResourceList();
        },
        methods: {
            async fetchResourceList() {
                const response = await api(Cms.route('cms.backend.resources.index', this.resource));
                console.log(response.data)
                this.items = response.data.data;
                this.isLoading = false;
            }
        }
    }
</script>
