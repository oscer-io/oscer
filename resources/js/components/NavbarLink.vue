<template>
    <router-link :to="to" class="mt-1 group flex items-center px-2 py-2 text-sm leading-5 font-medium text-gray-300 rounded-md hover:text-white hover:bg-gray-700 focus:outline-none focus:text-white focus:bg-gray-700 transition ease-in-out duration-150">
        <slot/>
    </router-link>
</template>
<script>
    export default {
        props:['to']
    }
</script>
<style>
    .router-link-active{
        background-color: #161e2e;
        color: #fff;
    }
</style>
