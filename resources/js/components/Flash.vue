<template>
    <div class="fixed bottom-0 right-0 m-6">
        <template v-for="message in flashMessages">
            <transition name="slide-fade">
                <div
                    :class="{
        'bg-red-200 text-red-900': message.type === 'error',
        'bg-green-200 text-green-900': message.type === 'success',
      }"
                    class="rounded-lg shadow-md p-6 pr-10 mb-4"
                    style="min-width: 240px"
                >
                    <div class="flex items-center">
                        {{ message.text }}
                    </div>
                </div>
            </transition>
        </template>
    </div>
</template>

<script>
    import {mapState} from 'vuex';

    export default {

        computed: mapState(['flashMessages']),

    };
</script>

<style scoped>
    .slide-fade-enter-active,
    .slide-fade-leave-active {
        transition: all 0.4s;
    }

    .slide-fade-enter,
    .slide-fade-leave-to {
        transform: translateX(400px);
        opacity: 0;
    }
</style>
