<template>
    <ResourceDetails resource="page" :resource-id="id"/>
</template>

<script>
    import ResourceDetails from "../../../components/ResourceDetails";

    export default {
        components: {ResourceDetails},
        props: ['id'],
    }
</script>
