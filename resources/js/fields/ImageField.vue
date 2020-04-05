<template>
    <field-wrapper :name="field.name" :label="field.label || field.name" :errors="validationErrors">
        <input
            class="form-input block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5"
            :class="{'border-red-600': !!hasValidationErrors}"
            :id="field.name"
            :name="field.name"
            @change="imageChanged"
            type="file"
        />
    </field-wrapper>
</template>
<script>
    import FormField from "../lib/mixins/FormField";

    export default {
        mixins: [FormField],
        data() {
            return {
                updated: false,
                reader: new FileReader(),
                image: {
                    name: null,
                    mimeType: null,

                }
            }
        },
        methods: {
            imageChanged(e) {
                if (e.target.files != null && e.target.files[0] != null) {
                    this.reader.onload = event => {
                        this.dataUrl = event.target.result
                    }
                    this.reader.readAsDataURL(e.target.files[0])
                    this.image.name = e.target.files[0].name || 'unknown'
                    this.image.mimeType = e.target.files[0].type
                    this.value = e.target.files[0];
                    this.updated = true;
                    this.$emit('changed', e.target.files[0], this.reader)
                }
            },
            fill(data) {
                if (this.updated) {
                    data[this.field.name] = this.value;
                }
                return data;
            }
        }
    }
</script>
