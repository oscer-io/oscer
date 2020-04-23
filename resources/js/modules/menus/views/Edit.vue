<template>
        <ResourceForm
            resource="menu"
            :resource-id="id"
            @cancel="$router.push({name: 'pages.index'})"
            @success="handleSuccess"
        />
</template>

<script>
    import ResourceForm from "../../../components/ResourceForm";

    export default {
        components: {ResourceForm},

        props: ['id'],

        methods: {
            handleSuccess(menu) {
                Cms.flash('success', 'Nice one!');
                this.$router.push({name: 'menus.show', params: {id: menu.id}})
            }
        }
    }
</script>

