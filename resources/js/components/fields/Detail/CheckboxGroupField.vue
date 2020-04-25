<template>
        <FieldWrapper :name="field.name" :label="field.label">
            <p v-for="checkedField in checkedFields" v-text="checkedField.label"></p>
        </FieldWrapper>
</template>
<script>
    export default{
        props:{
            field:{
                type:Object,
                required: true
            }
        },
        computed:{
            checkedFields(){
                return this.field.fields.filter(field => field.value === true)
            }
        }
    }
</script>
