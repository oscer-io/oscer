<template>
    <div>
        index users bla
        <hr>
    <button @click="test">test</button>
    </div>
</template>

<script>
    import axios from 'axios';

    export default {
        methods: {
            async test() {
                const response = await axios.get('/api/cms/menus');
                console.log(response.data);
            }
        }
    }
</script>
