<template>
    <div
        class="ml-3 relative"
        v-on-clickaway="away"
    >
        <div @click="isDropdownActive=!isDropdownActive">
            <slot name="trigger">
            </slot>
        </div>
        <div v-if="isDropdownActive">
            <div class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg">
                <slot name="content">
                </slot>
            </div>
        </div>
    </div>
</template>
<script>
    import {mixin as clickaway} from 'vue-clickaway';

    export default {
        props: ['id'],
        mixins: [clickaway],
        data() {
            return {
                isDropdownActive: false,
            }
        },
        methods: {
            away() {
                this.isDropdownActive = false;
            }
        }
    };
</script>
