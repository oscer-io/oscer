<template>
    <ResourceForm
        resource="role"
        :resource-id="id"
        :submitPositions="['bottom', 'top']"
        @cancel="$router.push({name: 'roles.index'})"
        @success="handleSuccess"
    />
</template>

<script>
    export default {
        props: ['id'],
        methods: {
            handleSuccess() {
                this.$store.dispatch('flash', {
                    type: 'success',
                    text: 'Role updated'
                });
            }
        }
    }
</script>
