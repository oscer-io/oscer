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
                Cms.flash('success', 'Role updated.');
            }
        }
    }
</script>
