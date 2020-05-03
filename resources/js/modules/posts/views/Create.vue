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
    export default {
        methods: {
            handleSuccess(payload) {
                this.$store.dispatch('flash', {
                    type: 'success',
                    text: 'Nice one!'
                });
                this.$router.push({name: 'posts.show', params: {id: payload.model.id}})
            }
        }
    }
</script>
