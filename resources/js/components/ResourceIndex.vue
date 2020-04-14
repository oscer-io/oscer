<template>
    <loading :loading="isLoading">
        <table v-if="items.length > 0" class="table-auto">
            <thead>
            <tr>
                <th
                    v-for="column in tableHeaderColumns"
                    v-text="column"
                    class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider text-left"
                ></th>
                <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider text-center">
                    Actions
                </th>
            </tr>
            </thead>
            <tbody class="bg-white">
            <tr v-for="(item, itemIndex) in items">
                <td v-for="(field, fieldIndex) in filteredFields(item)"
                    :key="`${field.name}-${itemIndex}`"
                    class="px-6 py-4 whitespace-no-wrap border-b border-gray-200"
                >
                    <component
                        :is="`Index${field.component}`"
                        :field="field"
                    />
                </td>
                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                    <router-link v-if="item.displayShowButtonOnIndex" :to="{name:`${resource}s.show`, params: {id: item.resourceId}}" class="btn">
                        show
                    </router-link>
                    <router-link v-if="item.displayEditButtonOnIndex && meta.is_editable" :to="{name:`${resource}s.edit`, params: {id: item.resourceId}}"
                                 class="btn">
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
                meta: {},
            }
        },
        computed: {
            tableHeaderColumns() {
                return this.items.length > 0
                    ? this.filteredFields(this.items[0])
                        .map(field => field.name)
                    : []
            },
        },
        mounted() {
            this.fetchResourceList();
        },
        methods: {
            async fetchResourceList() {
                const response = await api(Cms.route('cms.backend.resources.index', this.resource));
                this.items = response.data.data;
                this.meta = response.data.meta;
                this.isLoading = false;
            },
            filteredFields(resource) {
                return resource.fields.filter(field => !!field.showOnIndex)
            }
        }
    }
</script>