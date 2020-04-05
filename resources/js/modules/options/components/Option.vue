<template>
    <div>
        <form @submit.prevent="save">
            <component
                :ref="`${option.name}-field`"
                :is="`${option.type}-field`"
                :field="option"
                v-model="currentValue"
                :validation-errors="[]"
            />
            <button type="submit" class="btn">save</button>
        </form>
    </div>
</template>

<script>
    import api from "../../../lib/api";

    export default {
        props: {
            option: Object,
        },
        data() {
            return {
                currentValue: this.option.value
            }
        },
        methods: {
            async save() {
                try {
                    await api({
                        ...Cms.route('cms.api.resources.store', 'option'),
                        data: {
                            key: this.option.key,
                            value: this.currentValue,
                        }
                    });
                    Cms.flash('success', 'Option successfully saved')
                } catch (e) {
                    Cms.flash('error', 'Something went wrong')
                }
            }
        }
    }
</script>
