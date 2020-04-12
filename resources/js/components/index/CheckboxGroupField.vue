<template>
    <div>
        <span class="mr-2" v-for="checkedField in checkedFields" v-text="checkedField.label"></span>
    </div>
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
