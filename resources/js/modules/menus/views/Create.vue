<template>
    <div>
        <ResourceForm
            resource="menu"
            @cancel="$router.push({name: 'menus.index'})"
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
