<template>
    <div v-if="menu">
        <div class="flex justify-between mb-3">
            <h1 class="mb-4 text-lg leading-6 font-medium text-gray-900">
                {{ $t('menus.show_title', {name: menu.name}) }}
            </h1>
            <div>
                <span class="ml-3 inline-flex rounded-md shadow-sm">
                    <button type="button" @click="$modal.show('new-item')"
                            class="inline-flex justify-center py-2 px-4 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500  focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-700 transition duration-150 ease-in-out">
                        {{ $t('menus.button_create_item') }}
                    </button>
                </span>
            </div>
        </div>
        <div>
            <draggable class="border rounded" v-model="items" v-bind="{ghostClass: 'ghost'}" @start="drag=true"
                       @end="drag=false">
                <transition-group type="transition" name="flip-list">
                    <div class="flex justify-between border-b cursor-move last:border-b-0 py-2 px-3"
                         v-for="(item, index) in items" :key="item.id">
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
        <modal name="new-item" height="auto">
            <p class="pt-6 text-lg leading-6 font-medium text-gray-900 text-center">New item</p>
            <BaseForm
                class="p-6"
                :fields="createFields"
                :api-route="route('cms.api.menus.store',{name:this.name})"
                :append="{menu: name}"
                @cancel="$modal.hide('new-item')"
                @success="handleNewItemSuccess()"
            />
        </modal>
    </div>
</template>

<script>
    import _ from 'lodash';
    import api from "../../../lib/api";
    import Draggable from 'vuedraggable';
    import BaseForm from "../../../components/BaseForm";

    export default {
        props: {
            name: String,
        },
        components: {
            BaseForm,
            Draggable
        },
        data() {
            return {
                createFields: [
                    {
                        type: 'text',
                        name: 'name',
                        label: this.$t('menus.name'),
                    },
                    {
                        type: 'text',
                        name: 'url',
                        label: this.$t('menus.url'),
                    },
                ],
                menu: null,
                items: []
            }
        },
        async mounted() {
            this.fetchItems();
        },
        computed: {
            reordered() {
                return this.menu.items !== this.items;
            }
        },
        watch: {
            menu() {
                this.items = this.menu.items;
            }
        },
        methods: {
            async fetchItems() {
                const response = await api(this.route('cms.api.menus.show', {name: this.name}));
                this.menu = response.data.data
            },
            handleNewItemSuccess() {
                this.$modal.hide('new-item');
                Cms.flash('success', 'new Item created');
                this.fetchItems();
            },
            handleUpdateItemSuccess(item) {
                this.$modal.hide('edit-item-modal-' + item.id);
                Cms.flash('success', 'Item updated');
                this.fetchItems();
            },
            saveOrder() {
                api({
                    ...this.route('cms.backend.menus.save_order', {name: this.name}),
                    data: {
                        order: this.items.map((value, index) => {
                            return {
                                id: value.id,
                                order: index
                            }
                        })
                    }
                })
            },

            updateItem(item) {
                this.$modal.show(
                    BaseForm,
                    {
                        fields: _.map(this.createFields, field => {
                            if (item.hasOwnProperty(field.name)) {
                                field.value = item[field.name]
                            }
                            console.log(field)
                            return field;
                        }),
                        apiRoute: this.route('cms.api.menus.update', {name: this.name, id: item.id}),
                        append: {menu: this.name},
                        cancelMethod: () => {
                            this.$modal.hide('edit-item-modal-' + item.id)
                        },
                        successMethod: this.handleUpdateItemSuccess
                    },
                    {
                        name: 'edit-item-modal-' + item.id,
                        height: 'auto',
                    }
                );
            },

            deleteItem(item) {
                api(this.route('cms.backend.menus.delete', {item: item.id}));
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
