<template>
        <ResourceForm
            resource="menu"
            :resource-id="id"
            @cancel="$router.push({name: 'pages.index'})"
            @success="handleSuccess"
        />
</template>

<script>
    export default {
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

