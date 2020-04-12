<template>
    <RouterLink
        :to="to"
        :active-class="this.exact === true ? '' : activeClasses"
        :exact-active-class="activeClasses"
        :exact="exact === true"
        active-class="text-white bg-gray-900"
        class="mt-1 group flex items-center px-2 py-2 text-sm leading-5 font-medium text-gray-300 rounded-md hover:text-white hover:bg-gray-700 focus:outline-none focus:text-white focus:bg-gray-700 transition ease-in-out duration-150"
    >
        <slot/>
    </RouterLink>
</template>
<script>
    export default {
        props: ['to', 'exact'],
        data() {
            return {
                activeClasses: 'text-white bg-gray-900'
            }
        },
    }
</script>
