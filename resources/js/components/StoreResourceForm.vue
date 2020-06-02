<template>
    <loading :loading="!resource">
        <div v-if="resource">
            <div class="md:flex md:items-center md:justify-between">
                <div class="flex-1 min-w-0">
                    <h1 class="text-lg leading-6 font-medium text-gray-900" v-text="title"></h1>
                </div>
            </div>
            <form>
                <div class="flex">
                    <component
                        v-for="(field, index) in resource.fields"
                        :key="field.name + index"
                        :ref="`${field.name}-field`"
                        :is="`Form${field.component}`"
                        :field="field"
                        :validation-errors="[]"
                    />
                </div>
                <div class="mt-8 border-t border-gray-200 pt-5">
                    <div class="flex justify-end">
                    <span class="inline-flex rounded-md shadow-sm">
                        <button
                            type="button"
                            class="btn-transparent"
                            @click="$emit('cancel')"
                            v-text="resource.labels.buttons.cancel"
                        >
                        </button>
                    </span>
                        <span class="ml-3 inline-flex rounded-md shadow-sm">
                        <button
                            type="submit"
                            class="btn"
                            v-text="resource.labels.buttons.save"
                        >
                        </button>
                    </span>
                    </div>
                </div>
            </form>
        </div>
    </loading>
</template>
<script>
    export default {
        props: {
            resourceName: {
                type: String,
                required: true
            },
            resourceId: {
                required: false,
                default: null
            }
        },
        computed: {
            title() {
                return this.resource
                    ? this.resourceId ? this.resource.labels.titles.update : this.resource.labels.titles.create
                    : ''
            },
            resource() {
                return this.$store.getters['resources/getForm']({name: this.resourceName, id: this.resourceId})
            }
        },
        mounted() {
            this.$store.dispatch('resources/fetchForm', {name: this.resourceName, id: this.resourceId})
        }
    }
</script>
