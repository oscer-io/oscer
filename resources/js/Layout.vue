<template>
    <div class="min-h-screen bg-white">
        <nav  class="bg-white border-b border-gray-200">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <div class="flex-shrink-0 flex items-center">
                            <img class="block lg:hidden h-8 w-auto" src="/vendor/cms/workflow-mark-on-white.svg"
                                 alt=""/>
                            <img class="hidden lg:block h-8 w-auto" src="/vendor/cms/workflow-logo-on-white.svg"
                                 alt=""/>
                        </div>
                        <div class="hidden sm:-my-px sm:ml-6 sm:flex">
                            <inertia-link :href="route('cms.backend.posts.index')"
                                          class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm
                            font-medium leading-5 text-gray-500 hover:text-gray-700 hover:border-gray-300
                            focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150
                            ease-in-out">
                                Posts
                            </inertia-link>
                            <inertia-link :href="route('cms.backend.pages.index')"
                                          class="ml-8 inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm
                            font-medium leading-5 text-gray-500 hover:text-gray-700 hover:border-gray-300
                            focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150
                            ease-in-out">
                                Pages
                            </inertia-link>
                            <inertia-link :href="route('cms.backend.menus.index')"
                                          class="ml-8 inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm
                            font-medium leading-5 text-gray-500 hover:text-gray-700 hover:border-gray-300
                            focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150
                            ease-in-out">
                                Menus
                            </inertia-link>
                            <inertia-link :href="route('cms.backend.users.index')"
                                          class="ml-8 inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm
                            font-medium leading-5 text-gray-500 hover:text-gray-700 hover:border-gray-300
                            focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150
                            ease-in-out">
                                Users
                            </inertia-link>
                        </div>
                    </div>
                    <div class="hidden sm:ml-6 sm:flex sm:items-center">
                        <div class="ml-3 relative">
                            <div>
                                <button @click="open = !open"
                                        class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition duration-150 ease-in-out">
                                    <img class="h-8 w-8 rounded-full"
                                         :src="$page.auth.user.avatar"
                                         alt=""/>
                                </button>
                            </div>
                            <div v-if="open === true" v-click-outside="closeMenu"
                                 class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg z-10">
                                <div class="py-1 rounded-md bg-white shadow-xs">
                                    <inertia-link :href="route('cms.backend.profile.show')"
                                                  class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out">
                                        Your
                                        Profile
                                    </inertia-link>
                                    <a :href="route('cms.backend.auth.logout')"
                                       class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out">Sign
                                        out</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div @click. class="-mr-2 flex items-center sm:hidden">
                        <button @click="open = !open"
                                class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                <path :class="{'hidden': open, 'inline-flex': !open }" class="inline-flex"
                                      stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M4 6h16M4 12h16M4 18h16"/>
                                <path :class="{'hidden': !open, 'inline-flex': open }" class="hidden"
                                      stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
            <div :class="{'block': open, 'hidden': !open}" class="hidden sm:hidden">
                <div class="pt-2 pb-3">
                    <a href="#"
                       class="block pl-3 pr-4 py-2 border-l-4 border-indigo-500 text-base font-medium text-indigo-700 bg-indigo-50 focus:outline-none focus:text-indigo-800 focus:bg-indigo-100 focus:border-indigo-700 transition duration-150 ease-in-out">Dashboard</a>
                    <a href="#"
                       class="mt-1 block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300 focus:outline-none focus:text-gray-800 focus:bg-gray-50 focus:border-gray-300 transition duration-150 ease-in-out">Team</a>
                    <a href="#"
                       class="mt-1 block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300 focus:outline-none focus:text-gray-800 focus:bg-gray-50 focus:border-gray-300 transition duration-150 ease-in-out">Projects</a>
                    <a href="#"
                       class="mt-1 block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300 focus:outline-none focus:text-gray-800 focus:bg-gray-50 focus:border-gray-300 transition duration-150 ease-in-out">Calendar</a>
                </div>
                <div class="pt-4 pb-3 border-t border-gray-200">
                    <div class="flex items-center px-4">
                        <div class="flex-shrink-0">
                            <img class="h-10 w-10 rounded-full"
                                 :src="$page.auth.user.avatar"
                                 alt=""/>
                        </div>
                        <div class="ml-3">
                            <div class="text-base font-medium leading-6 text-gray-800">{{$page.auth.user.name}}</div>
                            <div class="text-sm font-medium leading-5 text-gray-500">{{$page.auth.user.email}}</div>
                        </div>
                    </div>
                    <div class="mt-3">
                        <inertia-link :href="route('cms.backend.menus.index')"
                                      class="block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100 focus:outline-none focus:text-gray-800 focus:bg-gray-100 transition duration-150 ease-in-out">
                            Your
                            Profile
                        </inertia-link>
                        <a :href="route('cms.backend.auth.logout')"
                           class="mt-1 block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100 focus:outline-none focus:text-gray-800 focus:bg-gray-100 transition duration-150 ease-in-out">Sign
                            out</a>
                    </div>
                </div>
            </div>
        </nav>

        <div class="py-10">
            <main>
                <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
                    <slot/>
                </div>
            </main>
        </div>
        <flash :message-data="this.$page.flash.message"/>
    </div>
</template>

<script>
    import Flash from './components/Flash';

    export default {
        props: {
            title: String,
        },
        components: {
            Flash,
        },
        data() {
            return {
                open: false
            }
        },
        watch: {
            title: {
                immediate: true,
                handler(title) {
                    document.title = title
                },
            },
        },
        methods: {
            closeMenu() {
                this.open = false;
            }
        }
    }
</script>
