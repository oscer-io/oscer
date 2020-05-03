<template>
    <nav class="flex-1 px-2 py-4 bg-gray-800">
        <NavbarLink :to="{name: 'dashboard'}" :exact="true">
            <svg
                class="mr-3 h-6 w-6 text-gray-300 group-hover:text-gray-300 group-focus:text-gray-300 transition ease-in-out duration-150"
                stroke="currentColor" fill="none" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M3 12l9-9 9 9M5 10v10a1 1 0 001 1h3a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1h3a1 1 0 001-1V10M9 21h6"/>
            </svg>
            Dashboard
        </NavbarLink>
        <NavbarLink
            v-for="(item, index) in sidebar.items"
            :key="index"
            :to="{name: item.target}">
            <span v-html="item.icon"></span>
            {{item.label}}
        </NavbarLink>
    </nav>
</template>

<script>
    export default {
        computed:{
            sidebar(){
                return Cms.config.sidebar
            }
        }
    }
</script>
