<template>
    <layout title="posts">
        <h1>posts index</h1>

    </layout>
</template>

<script>
    import Layout from '../../Layout';
    export default {
        mounted() {
            console.log(this.route('cms.users.index'))
        },
        components: {
          Layout
        },
    }
</script>
