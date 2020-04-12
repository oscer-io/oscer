<template>
    <div id="cms">
        <div v-cloak class="h-screen flex overflow-hidden bg-gray-100">
            <!-- Static sidebar for desktop -->
            <div class="hidden md:flex md:flex-shrink-0">
                <div class="flex flex-col w-64">
                    <div class="flex items-center h-16 flex-shrink-0 px-4 bg-gray-900">
                        <h1 class="text-xl text-white font-bold w-full text-center">Laravel CMS</h1>
                    </div>
                    <div class="h-0 flex-1 flex flex-col overflow-y-auto">
                        <!-- Sidebar component, swap this element with another sidebar if you like -->
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
                            <NavbarLink v-if="can('pages.view')" :to="{name: 'pages.index'}">
                                <svg
                                    class="mr-3 h-6 w-6 text-gray-400 group-hover:text-gray-300 group-focus:text-gray-300 transition ease-in-out duration-150"
                                    stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/>
                                </svg>
                                Pages
                            </NavbarLink>
                            <NavbarLink v-if="can('posts.view')" :to="{name: 'posts.index'}">
                                <svg
                                    class="mr-3 h-6 w-6 text-gray-400 group-hover:text-gray-300 group-focus:text-gray-300 transition ease-in-out duration-150"
                                    stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/>
                                </svg>
                                Posts
                            </NavbarLink>
                            <NavbarLink v-if="can('menus.view')" :to="{name: 'menus.index'}">
                                <svg
                                    class="mr-3 h-6 w-6 text-gray-400 group-hover:text-gray-300 group-focus:text-gray-300 transition ease-in-out duration-150"
                                    stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/>
                                </svg>
                                Menus
                            </NavbarLink>
                            <NavbarLink v-if="can('options.view')" :to="{name: 'options.index'}">
                                <svg
                                    class="mr-3 h-6 w-6 text-gray-400 group-hover:text-gray-300 group-focus:text-gray-300 transition ease-in-out duration-150"
                                    stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                Options
                            </NavbarLink>
                            <NavbarLink v-if="can('users.view')" :to="{name: 'users.index'}">
                                <svg
                                    class="mr-3 h-6 w-6 text-gray-400 group-hover:text-gray-300 group-focus:text-gray-300 transition ease-in-out duration-150"
                                    stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                Users
                            </NavbarLink>
                            <NavbarLink v-if="can('roles.view')" :to="{name: 'roles.index'}">
                                <svg
                                    class="mr-3 h-6 w-6 text-gray-400 group-hover:text-gray-300 group-focus:text-gray-300 transition ease-in-out duration-150"
                                    stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                Roles
                            </NavbarLink>
                        </nav>
                    </div>
                </div>
            </div>
            <div class="flex flex-col w-0 flex-1 overflow-hidden">
                <div class="relative z-10 flex-shrink-0 flex h-16 bg-white shadow">
                    <div class="flex-1 px-4 flex justify-between">
                        <div class="flex-1 flex">
                            <div class="w-full flex md:ml-0">
                                <label for="search_field" class="sr-only">Search</label>
                                <div class="relative w-full text-gray-400 focus-within:text-gray-600">
                                    <div class="absolute inset-y-0 left-0 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                  d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"/>
                                        </svg>
                                    </div>
                                    <input id="search_field"
                                           class="block w-full h-full pl-8 pr-3 py-2 rounded-md text-gray-900 placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 sm:text-sm"
                                           placeholder="Search"/>
                                </div>
                            </div>
                        </div>
                        <div class="ml-4 flex items-center md:ml-6">
                            <a class="mr-4" target="_blank" href="/">Show Website</a>
                            <button
                                class="p-1 text-gray-400 rounded-full hover:bg-gray-100 hover:text-gray-500 focus:outline-none focus:shadow-outline focus:text-gray-500">
                                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                                </svg>
                            </button>
                            <Dropdown>
                                <template v-slot:trigger>
                                    <img class="h-8 w-8 rounded-full"
                                         src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                                         alt=""/>
                                </template>
                                <template v-slot:content>
                                    <div class="py-1 rounded-md bg-white shadow-xs">
                                        <RouterLink :to="{name: 'profile.show'}"
                                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition ease-in-out duration-150">
                                            Your
                                            Profile
                                        </RouterLink>
                                        <a href="/admin/logout"
                                           class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition ease-in-out duration-150">Sign
                                            out</a>
                                    </div>
                                </template>
                            </Dropdown>
                        </div>
                    </div>
                </div>
                <main class="flex-1 relative z-0 overflow-y-auto py-6 focus:outline-none" tabindex="0">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
                        <transition :name="transitionName" mode="out-in">
                            <router-view :key="$route.fullPath"></router-view>
                        </transition>
                        <modals-container></modals-container>
                    </div>
                </main>
            </div>
        </div>
        <Flash/>
    </div>
</template>
<script>
    export default {
        props: ['transitionName']
    }
</script>
