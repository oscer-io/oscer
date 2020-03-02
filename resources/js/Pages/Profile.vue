<template>
    <layout title="test">
        <h1>Welcome</h1>
        <p>Hello {{ name }}, welcome to your first Inertia app!</p>

    </layout>
</template>

<script>
    import Layout from '../Layout';
    export default {
        components: {
          Layout
        },
        props: {
            user: Object,
        },
        data(){
            return {
                name: this.user.name
            }
        }
    }
</script>
