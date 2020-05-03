<template>
    <div>
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

