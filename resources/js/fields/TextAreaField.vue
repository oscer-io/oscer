<template>
    <field-wrapper :name="field.name" :label="field.label || field.name">
        <textarea
            class="form-textarea block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5"
            :id="field.name" :rows="field.rows || 8"
            v-model="value">

        </textarea>
    </field-wrapper>
</template>
<script>
    export default {
        props: ['field'],
        data() {
            return {
                value: this.field.value || ''
            }
        }
    }
</script>
