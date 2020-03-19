<template>
    <div>
        <form @submit.prevent="save">
            <label :for="option.key" class="block text-sm font-medium leading-5 text-gray-700">
                {{option.label}}
            </label>
            <div class="flex">
                <div class="mt-1 rounded-md shadow-sm">
                    <input :id="option.key" type="text" v-model="currentValue"
                           class="form-input block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5"/>
                </div>
                <button type="submit"
                        class="inline-flex justify-center py-2 px-4 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-700 transition duration-150 ease-in-out">
                    save
                </button>
            </div>
        </form>
    </div>
</template>

<script>
    export default {
        created() {
            console.log(this.key)
        },
        props: {
            option: Object,
        },
        data() {
            return {
                currentValue: this.option.value
            }
        },
        methods: {
            save() {
                this.$inertia.post(this.route('cms.backend.options.store'), {
                    key: this.option.key,
                    value: this.currentValue,
                })
            }
        }
    }
</script>
