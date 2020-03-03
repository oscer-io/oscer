<template>
    <div class="fixed bottom-0 right-0 m-6">
        <transition name="slide-fade">
            <div
                v-if="show"
                :class="{
        'bg-red-200 text-red-900': message.type === 'error',
        'bg-green-200 text-green-900': message.type === 'success',
      }"
                class="rounded-lg shadow-md p-6 pr-10"
                style="min-width: 240px"
            >
                <button
                    class="opacity-75 cursor-pointer absolute top-0 right-0 py-2 px-3 hover:opacity-100"
                    @click.prevent="hide(50)"
                >
                    ×
                </button>
                <div class="flex items-center">
                    {{ message.text }}
                </div>
            </div>
        </transition>
    </div>
</template>

<script>
    import _ from 'lodash';

    export default {

        data() {
            return {
                message: {
                    type: '',
                    text: ''
                },
                show: false
            }
        },

        created() {
            if (!_.isEmpty(this.$page.flash.message)) {
                this.flash({
                    type: this.$page.flash.message.type,
                    text: this.$page.flash.message.text,
                });
            }

            window.events.$on(
                'flash', data => this.flash(data)
            );

        },

        methods: {
            flash(data) {

                if (data) {
                    this.message = data
                }

                this.show = true;
                this.hide();
            },

            hide(timeout = 3000) {
                setTimeout(() => {
                    this.show = false;
                }, timeout);
            }
        }
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
