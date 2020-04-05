<template>
    <div>
        <div class="md:flex md:items-center md:justify-between">
            <div class="flex-1 min-w-0">
                <h1 class="text-lg leading-6 font-medium text-gray-900">
                    {{ $t('posts.create_title') }}
                </h1>
            </div>
        </div>
        <ResourceForm
            resource="post"
            @cancel="$router.push({name: 'posts.index'})"
            @success="handleSuccess"
        />
    </div>
</template>

<script>
    import ResourceForm from "../../../components/ResourceForm";

    export default {
        components: {
            ResourceForm
        },
        methods: {
            handleCancel() {
                this.$router.push({name: 'posts.index'})
            },
            handleSuccess(post) {
                Cms.flash('success', 'Nice one!');
                this.$router.push({name: 'posts.show', params: {id: post.id}})
            }
        }
    }
</script>
