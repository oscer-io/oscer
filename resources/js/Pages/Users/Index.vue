<template>
    <layout title="users">
        <h1>Users index</h1>

    </layout>
</template>

<script>
    import Layout from '../../Layout';
    export default {
        created() {
            this.route('cms.users.show', 1)
        },
        components: {
          Layout
        },
    }
</script>
