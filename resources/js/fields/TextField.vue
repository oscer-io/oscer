<template>
    <field-wrapper :name="field.name" :label="field.label || field.name">
        <input
            class="form-input block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5"
            :id="field.name"
            v-model="value"
        />
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
