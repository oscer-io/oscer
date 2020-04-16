<template>
    <div>
        <div class="md:flex md:items-center md:justify-between">
            <div class="flex-1 min-w-0">
                <h1 class="text-lg leading-6 font-medium text-gray-900">
                    {{ $t('posts.edit_title') }}
                </h1>
            </div>
        </div>
        <ResourceForm
            resource="post"
            :resource-id="id"
            @cancel="$router.push({name: 'posts.index'})"
            @success="handleSuccess"
        />
    </div>
</template>

<script>
    import ResourceForm from "../../../components/ResourceForm";

    export default {
        components: {ResourceForm},

        props: ['id'],

        methods: {
            handleSuccess(post) {
                this.$store.dispatch('flash', {
                    type: 'success',
                    text: 'Nice one!'
                });
                this.$router.push({name: 'posts.show', params: {id: post.id}})
            }
        }
    }
</script>

