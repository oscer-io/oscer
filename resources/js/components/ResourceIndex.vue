<template>
    <div>
        <div class="bg-white px-4 py-5 border-b border-gray-200 sm:px-6">
            <div class="-ml-4 -mt-2 flex items-center justify-between flex-wrap sm:flex-no-wrap">
                <div class="ml-4 mt-2">
                    <h1
                        class="text-lg leading-6 font-medium text-gray-900"
                        v-text="this.labels ? this.labels.titles.index : ''"
                    >
                    </h1>
                </div>
                <div class="ml-4 mt-2 flex-shrink-0">
                    <span class="inline-flex rounded-md shadow-sm">
                        <router-link
                            :to="{name:`${resource}s.create`}"
                            class="btn"
                            v-text="this.labels ? this.labels.buttons.create : ''"
                        >
                    </router-link>
                    </span>
                </div>
            </div>
        </div>
        <loading :loading="isLoading" class="bg-white">
            <table v-if="items.length > 0" class="table w-full overflow-x-scroll">
                <thead>
                <tr>
                    <th
                        v-for="column in tableHeaderColumns"
                        v-text="column"
                        class="p-3 border-b border-gray-200 bg-gray-50 text-xs leading-4 text-xs font-medium text-gray-500 uppercase tracking-wider text-left"
                    ></th>
                    <th class="p-3 border-b border-gray-200 bg-gray-50 th-fit">
                    </th>
                </tr>
                </thead>
                <tbody class="bg-white">
                <tr v-for="(item, itemIndex) in items">
                    <td v-for="(field, fieldIndex) in filteredFields(item)"
                        :key="`${field.name}-${itemIndex}`"
                        class="p-3 whitespace-no-wrap border-b border-gray-200 text-sm"
                    >
                        <component
                            :is="`Index${field.component}`"
                            :field="field"
                        />
                    </td>
                    <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 td-fit">
                        <div class="inline-flex items-center">
                            <router-link v-if="showDetailButton" :to="{name:`${resource}s.show`, params: {id: item.resourceId}}"
                                         class="inline-flex">
                                <svg class="w-8 h-8 text-gray-500" viewBox="0 0 64 64" stroke="currentColor">
                                    <path fill="none" stroke-miterlimit="10" stroke-width="3"
                                          d="M54.09 32S44.2 45.82 32 45.82 9.91 32 9.91 32 19.8 18.18 32 18.18 54.09 32 54.09 32z"/>
                                    <circle cx="32" cy="32" r="13.82" fill="none" stroke-miterlimit="10"
                                            stroke-width="3"/>
                                    <circle cx="32" cy="32" r="3.21" fill="currentColor"/>
                                </svg>
                            </router-link>
                            <router-link :to="{name:`${resource}s.edit`, params: {id: item.resourceId}}"
                                         class="inline-flex">
                                <svg class="w-8 h-8 text-gray-500" viewBox="0 0 64 64" stroke="currentColor">
                                    <path
                                        fill="none"
                                        stroke-miterlimit="10"
                                        stroke-width="3"
                                        d="M27.92 46.23L17.77 36.08M45.603 14.2l4.186 4.187a4.22 4.22 0 010 5.968l-4.95 4.95h0L34.685 19.15h0l4.95-4.95a4.22 4.22 0 015.968 0zM27.93 46.23l-14.96 4.8 4.8-14.95h0l16.89-16.9 10.16 10.16-16.89 16.89h0zM15.61 42.81l5.58 5.58"/>
                                </svg>
                            </router-link>
                        </div>

                    </td>
                </tr>
                </tbody>
            </table>
        </loading>
        <div class="bg-white px-4 py-5 border-b border-gray-200 sm:px-6">
            <div v-if="meta" class="flex justify-between py-6">
                <button v-if="page > 1" @click="prevPage" class="btn">prev page</button>
                <p>Show Items {{meta.from}} to {{meta.to}} from {{meta.total}}</p>
                <button v-if="page < meta.last_page" @click="nextPage" class="btn">next page</button>
            </div>
        </div>
    </div>

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
                page: 1,
                items: [],
                labels: false,
                meta: false,
            }
        },
        computed: {
            tableHeaderColumns() {
                return this.items.length > 0
                    ? this.filteredFields(this.items[0])
                        .map(field => field.name)
                    : []
            },
            showDetailButton(){
              return !!this.items[0].hasDetailView;
            },
        },
        watch: {
            page() {
                this.fetchResourceList();
            }
        },
        mounted() {
            this.fetchResourceList();
        },
        methods: {
            async fetchResourceList() {
                const response = await api(Cms.route('cms.backend.resources.index', {
                    resource: this.resource,
                    page: this.page
                }));
                this.items = response.data.data;
                this.labels = this.items[0].labels;
                this.meta = response.data.meta;
                this.isLoading = false;
            },
            filteredFields(resource) {
                return resource.fields.filter(field => !!field.showOnIndex)
            },
            nextPage() {
                this.page = Math.max(this.meta.last_page, this.page + 1)
            },
            prevPage() {
                this.page = Math.max(1, this.page - 1)
            }
        }
    }
</script>
<style>
    .table {
        border-collapse: collapse;
        border-spacing: 0;
    }

    .td-fit, .th-fit {
        width: 1%;
        white-space: nowrap;
    }
</style>
