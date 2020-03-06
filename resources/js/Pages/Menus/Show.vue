<template>
    <layout title="menu show">
        <div class="flex justify-between mb-3">

            <h3 class="mb-4 text-lg leading-6 font-medium text-gray-900">
                Menu: {{menu.name}}
            </h3>
            <div>

            <span class="ml-3 inline-flex rounded-md shadow-sm">
        <button type="button" @click="modal = !modal"
                class="inline-flex justify-center py-2 px-4 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500  focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-700 transition duration-150 ease-in-out">
            New Menu item
        </button>
      </span>
            </div>
        </div>
        <div>
            <draggable class="border rounded" v-model="items" @start="drag=true" @end="drag=false">
                <div class="border-b cursor-pointer last:border-b-0 py-2 px-3" v-for="item in items" :key="item.id">
                    {{item.name}} - {{item.url}} <button @click="deleteItem(item)">delete</button>
                </div>
            </draggable>
        </div>
        <div class="mt-8 border-t border-gray-200 pt-5">
            <div class="flex justify-end">
                <span class="ml-3 inline-flex rounded-md shadow-sm">
        <button type="button" @click="saveOrder" :disabled="!reordered"
                :class="{'bg-gray-600 hover:bg-gray-500': !reordered, 'bg-indigo-600 hover:bg-indigo-500': reordered}"
                class="inline-flex justify-center py-2 px-4 border border-transparent text-sm leading-5 font-medium rounded-md text-white   focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-700 transition duration-150 ease-in-out">
          <span v-if="reordered">Save order</span>
          <span v-else>Menu not reordered</span>
        </button>
      </span>
            </div>
        </div>
        <modal :visible="modal" @close="modal = !modal">
            <form @submit.prevent="createNewItem">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:col-span-3">
                        <label for="name" class="block text-sm font-medium leading-5 text-gray-700">
                            Name
                        </label>
                        <div class="mt-1 rounded-md shadow-sm">
                            <input id="name" type="test" v-model="newItem.name"
                                   class="form-input block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5"/>
                        </div>
                        <p v-if="$page.errors.name" class="mt-2 text-sm text-red-600">{{ $page.errors.name[0]
                            }}</p>
                    </div>
                    <div class="sm:col-span-3">
                        <label for="url" class="block text-sm font-medium leading-5 text-gray-700">
                            Url
                        </label>
                        <div class="mt-1 rounded-md shadow-sm">
                            <input id="url" type="text" v-model="newItem.url"
                                   class="form-input block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5"/>
                        </div>
                        <p v-if="$page.errors.url" class="mt-2 text-sm text-red-600">{{ $page.errors.url[0]
                            }}</p>

                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
      <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
        <button type="submit"
                class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-red-600 text-base leading-6 font-medium text-white shadow-sm hover:bg-red-500 focus:outline-none focus:border-red-700 focus:shadow-outline-red transition ease-in-out duration-150 sm:text-sm sm:leading-5">
          Create
        </button>
      </span>
                    <span class="mt-3 flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto">
        <button type="button" @click="modal = !modal"
                class="inline-flex justify-center w-full rounded-md border border-gray-300 px-4 py-2 bg-white text-base leading-6 font-medium text-gray-700 shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline transition ease-in-out duration-150 sm:text-sm sm:leading-5">
          Cancel
        </button>
      </span>
                </div>
            </form>
        </modal>
    </layout>
</template>

<script>
    import _ from 'lodash';
    import Draggable from 'vuedraggable';
    import Layout from '../../Layout';
    import Modal from "../../components/Modal";

    export default {
        props: {
            menu: Object,
            errors: Object
        },
        components: {
            Draggable,
            Layout,
            Modal
        },
        data() {
            return {
                modal: false,
                items: this.menu.items,
                newItem: {
                    name: '',
                    url: '',
                }
            }
        },
        computed: {
            reordered() {
                return this.menu.items !== this.items;
            }
        },
        watch: {
            errors(errors) {
                if (!_.isEmpty(errors)) this.modal = true
            },
            menu() {
                this.items = this.menu.items;
            }
        },
        methods: {
            saveOrder() {
                this.$inertia.post(this.route('cms.menus.save_order', {name: this.menu.name}), {
                    order: this.items.map((value, index) => {
                        return {
                            id: value.id,
                            order: index
                        }
                    })
                })
            },
            createNewItem() {
                this.$inertia.post(this.route('cms.menus.store', {name: this.menu.name}), this.newItem);
                this.modal = false;
            },
            deleteItem(item) {
                this.$inertia.delete(this.route('cms.menus.delete', {item: item.id}));
            }
        }
    }
</script>
