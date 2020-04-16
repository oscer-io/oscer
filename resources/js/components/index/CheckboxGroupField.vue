<template>
    <ul class="flex flex-wrap max-w-2xl">
        <li v-for="checkedField in checkedFields">
            <span class="items-center py-1 pl-2 pr-3 rounded-full font-bold text-sm" v-text="checkedField.label"></span>
        </li>
    </ul>
</template>
<script>
    export default {
        props: {
            field: {
                type: Object,
                required: true
            }
        },
        computed: {
            checkedFields() {
                return this.field.fields.filter(field => field.value === true)
            }
        }
    }
</script>
