<template>
    <div>
        <vue-tags-input
            v-model="tag"
            :tags="tags"
            :autocomplete-items="filteredTags"
            @tags-changed="tagsChanged"
        />
    </div>
</template>

<script>
    import VueTagsInput from '@johmun/vue-tags-input';

    export default {
        components: {
            VueTagsInput,
        },
        props: {
            value: Array,
            availableTags: Array
        },
        data() {
            return {
                tag: '',
                tags: this.value.map(name => {return {text:name}}),
            };
        },
        computed: {
            filteredTags() {
                return this.availableTags.filter(tag => {
                    return tag.toLowerCase().indexOf(this.tag.toLowerCase()) !== -1
                }).map(tag => {return {text: tag}})
            }
        },
        methods: {
            tagsChanged(newTags) {
                this.tags = newTags;
                this.$emit("input", this.tags.map(tag => tag.text));
            }
        }
    };
</script>

<style>
    .ti-input{
        border-radius: 0.25rem;
    }
</style>
