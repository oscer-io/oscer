<template>
    <layout :title="$t('menus.show_page_title', {name: menu.name, id: menu.id} )">
        <div class="flex justify-between mb-3">
            <h1 class="mb-4 text-lg leading-6 font-medium text-gray-900">
                {{ $t('menus.show_title', {name: menu.name}) }}
            </h1>
            <div>
                <span class="ml-3 inline-flex rounded-md shadow-sm">
                    <button type="button" @click="openCreateModal"
                            class="inline-flex justify-center py-2 px-4 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500  focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-700 transition duration-150 ease-in-out">
                        {{ $t('menus.button_create_item') }}
                    </button>
                </span>
            </div>
        </div>
        <div>
            <draggable class="border rounded" v-model="items" v-bind="{ghostClass: 'ghost'}" @start="drag=true" @end="drag=false">
                <transition-group type="transition" name="flip-list">
                    <div class="flex justify-between border-b cursor-move last:border-b-0 py-2 px-3"
                         v-for="item in items" :key="item.id">
                        <div class="flex">
                            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                 class="text-gray-600 mt-1 w-4 h-4 mr-2">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                            <span>
                                {{item.name}} - {{item.url}}
                            </span>
                        </div>
                        <div>
                            <button @click="deleteItem(item)" class="mr-4">
                                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                     class="text-gray-600 mt-1 w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </button>
                            <button @click="updateItem(item)">
                                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                     class="text-gray-600 mt-1 w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </transition-group>
            </draggable>
        </div>
        <div class="mt-8 border-t border-gray-200 pt-5">
            <div class="flex justify-end">
                <span class="ml-3 inline-flex rounded-md shadow-sm">
                    <button type="button" @click="saveOrder" :disabled="!reordered"
                            :class="{'bg-gray-600 hover:bg-gray-500': !reordered, 'bg-indigo-600 hover:bg-indigo-500': reordered}"
                            class="inline-flex justify-center py-2 px-4 border border-transparent text-sm leading-5 font-medium rounded-md text-white focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-700 transition duration-150 ease-in-out">
                        <span v-if="reordered">
                            {{ $t('menus.button_order_save') }}
                        </span>
                        <span v-else>
                            {{ $t('menus.button_order_disabled') }}
                        </span>
                    </button>
                </span>
            </div>
        </div>
        <modal :visible="modal" @close="modal = !modal">
            <form @submit.prevent="createOrSave">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:col-span-3">
                        <label for="name" class="block text-sm font-medium leading-5 text-gray-700">
                            {{ $t('menus.name') }}
                        </label>
                        <div class="mt-1 rounded-md shadow-sm">
                            <input id="name" type="test" v-model="newItem.name"
                                   class="form-input block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5" />
                        </div>
                        <p v-if="$page.errors.name" class="mt-2 text-sm text-red-600">{{ $page.errors.name[0] }}</p>
                    </div>
                    <div class="sm:col-span-3">
                        <label for="url" class="block text-sm font-medium leading-5 text-gray-700">
                            {{ $t('menus.url') }}
                        </label>
                        <div class="mt-1 rounded-md shadow-sm">
                            <input id="url" type="text" v-model="newItem.url"
                                   class="form-input block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5" />
                        </div>
                        <p v-if="$page.errors.url" class="mt-2 text-sm text-red-600">{{ $page.errors.url[0] }}</p>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                        <button type="submit"
                                class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-red-600 text-base leading-6 font-medium text-white shadow-sm hover:bg-red-500 focus:outline-none focus:border-red-700 focus:shadow-outline-red transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                            {{ $t('menus.button_create') }}
                        </button>
                    </span>
                    <span class="mt-3 flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto">
                        <button type="button" @click="modal = !modal"
                            class="inline-flex justify-center w-full rounded-md border border-gray-300 px-4 py-2 bg-white text-base leading-6 font-medium text-gray-700 shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                            {{ $t('menus.button_cancel') }}
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
    import Layout from '../Layout';
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
                update: false,
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
                this.modal = !_.isEmpty(errors)
            },
            menu() {
                this.items = this.menu.items;
            }
        },
        methods: {
            saveOrder() {
                this.$inertia.post(this.route('cms.backend.menus.save_order', {name: this.menu.name}), {
                    order: this.items.map((value, index) => {
                        return {
                            id: value.id,
                            order: index
                        }
                    })
                })
            },
            openCreateModal() {
                this.update = false;
                this.modal = true;
            },
            updateItem(item) {
                this.update = true;
                this.newItem = item;
                this.modal = true;
            },
            createOrSave() {
                if (!this.update) {
                    this.createItem();
                } else {
                    this.saveItem();
                }
            },
            saveItem() {
                this.$inertia.put(this.route('cms.backend.menus.update', {item: this.newItem.id}), this.newItem);
            },
            createItem() {
                this.$inertia.post(this.route('cms.backend.menus.store', {name: this.menu.name}), this.newItem);
            },
            deleteItem(item) {
                this.$inertia.delete(this.route('cms.backend.menus.delete', {item: item.id}));
            }
        }
    }
</script>

<style>
    .flip-list-move {
        transition: transform 0.5s;
    }
    .no-move {
        transition: transform 0s;
    }
    .ghost {
        opacity: 0.5;
        background: #c8ebfb;
    }
</style>
