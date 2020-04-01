<template>
    <loading :loading="isLoading">
        <div class="md:flex md:items-center md:justify-between">
            <div class="flex-1 min-w-0">
                <h1 class="text-lg leading-6 font-medium text-gray-900">
                    {{ $t('posts.edit_title', {name: post.name} ) }}
                </h1>
            </div>
        </div>
        <BaseForm v-if="post"
                  :fields="fields"
                  :api-route="{name:'cms.api.posts.update',params:{id: id}}"
                  @cancel="handleCancel"
                  @success="handleSuccess"
        />
    </loading>
</template>

<script>
    import api from "../../../lib/api";
    import BaseForm from "../../../components/BaseForm";

    export default {
        components: {BaseForm},
        props: ['id'],
        data() {
            return {
                isLoading: true,
                post: false,
                fields: []
            }
        },

        methods: {
            handleCancel() {
                this.$router.push({name: 'posts.index'})
            },
            handleSuccess(post) {
                Cms.flash('success', 'Nice one!');
                this.$router.push({name: 'posts.show', params: {id: post.id}})
            }
        },
        async mounted() {
            // posts endpoint not implemented because of the thoughts to only use one model with different types
            const response = await api(this.route('cms.api.posts.show', {id: this.id}));
            this.post = response.data.data;
            this.fields = response.data.fields;
            this.isLoading = false;
        }
    }
</script>

