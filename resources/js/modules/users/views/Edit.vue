<template>
    <div>
        <div class="md:flex md:items-center md:justify-between">
            <div class="flex-1 min-w-0">
                <h1 class="text-lg leading-6 font-medium text-gray-900">
                    {{ $t('users.edit_title') }}
                </h1>
            </div>
        </div>
        <ResourceForm
            resource="user"
            :resource-id="id"
            @cancel="$router.push({name: 'users.index'})"
            @success="handleSuccess"
        />
    </div>
</template>

<script>
    export default {
        props: ['id'],

        methods: {
            handleSuccess(payload) {
                this.$store.dispatch('flash', {
                    type: 'success',
                    text: 'Nice one!'
                });
                this.$router.push({name: 'users.show', params: {id: payload.model.id}})
            }
        }
    }
</script>

