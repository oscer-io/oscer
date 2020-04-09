<template>
    <div>
        <field-wrapper v-for="(item, index) in field.fields"
                       :name="item.name"
                       :key="index"
                       :label="item.label || item.name"
                       :errors="validationErrors">
            <input
                class="form-checkbox transition duration-150 ease-in-out sm:text-sm sm:leading-5"
                :class="{'border-red-600': !!hasValidationErrors}"
                :id="item.name"
                :name="item.name"
                v-model="item.value"
                type="checkbox"
            />
        </field-wrapper>
    </div>
</template>
<script>
    import FormField from "../../lib/mixins/FormField";

    export default {
        mixins: [FormField],
        methods: {
            fill(data) {
                data[this.field.name] = JSON.stringify(this.field.fields);

                return data;
            }
        }
    }
</script>
