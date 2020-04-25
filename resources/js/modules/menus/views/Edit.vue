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
                this.$store.dispatch('flash', {
                    type: 'success',
                    text: 'Nice one!'
                });
                this.$router.push({name: 'menus.show', params: {id: menu.id}})
            }
        }
    }
</script>

