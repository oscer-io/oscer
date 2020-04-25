<template>
    <loading :loading="isLoading">
        <div v-if="resourceItem">
            <div class="md:flex md:items-center md:justify-between">
                <div class="flex-1 min-w-0">
                    <h1 class="text-lg leading-6 font-medium text-gray-900" v-text="`Show ${resource}`">
                    </h1>
                </div>
                <div class="mt-4 flex md:mt-0 md:ml-4">
                    <slot name="edit-button">
                        <RouterLink
                            class="btn"
                            :to="{name:`${resource}s.edit`, params: {id: resourceId}}"
                        >
                            edit
                        </RouterLink>
                    </slot>
                </div>
            </div>
            <div>
                <component
                    v-for="(field, index) in filteredFields"
                    :is="`Detail${field.component}`"
                    :key="index"
                    :field="field"
                />
            </div>
        </div>
    </loading>
</template>

<script>
    import api from "../lib/api";

    export default {
        props: {
            resource: {
                type: String,
                required: true
            },
            resourceId: {
                required: true
            }
        },
        data() {
            return {
                isLoading: true,
                resourceItem: false,
            }
        },
        mounted() {
            this.fetchResource();
        },
        computed: {
            filteredFields() {
                return this.resourceItem
                    ? this.resourceItem.fields.filter(field => field.component !== 'PasswordField')
                    : []
            }
        },
        methods: {
            async fetchResource() {
                const response = await api(Cms.route('cms.backend.resources.show', [this.resource, this.resourceId]));
                this.resourceItem = response.data.data;
                this.isLoading = false;
            }
        }
    }
</script>
