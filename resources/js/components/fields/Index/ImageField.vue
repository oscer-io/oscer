<template>
    <div>

        <img
            v-if="field.value !== null"
            class="rounded w-10 h-10"
            :class="{'rounded-full': field.rounded}"
            :src="field.value"
            alt=""
        />
        <span v-else>No Image set</span>
    </div>
</template>
<script>
    export default {
        props: {
            field: {
                type: Object,
                required: true
            }
        }
    }
</script>
