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
    import ResourceForm from "../../../components/ResourceForm";

    export default {
        components: {ResourceForm},
        props: ['id'],
        methods: {
            handleSuccess(role) {
                this.$store.dispatch('flash', {
                    type: 'success',
                    text: 'Role updated'
                });
            }
        }
    }
</script>
