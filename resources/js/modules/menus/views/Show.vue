<template>
    <loading :loading="isLoading">
        <div v-if="menu" class="flex">
            <div class="w-2/3">
                <div class="flex justify-between mb-3">
                    <h1 class="mb-4 text-lg leading-6 font-medium text-gray-900">
                        {{ $t('menus.show_title', {name: menu.name}) }}
                    </h1>
                </div>
                <div>
                    <draggable
                        class="border rounded"
                        v-model="items"
                        v-bind="{ghostClass: 'ghost'}"
                        @start="drag=true"
                        @end="drag=false"
                    >
                        <transition-group type="transition" name="flip-list">
                            <div
                                class="flex justify-between border-b cursor-move last:border-b-0 py-2 px-3"
                                v-for="(item, index) in items" :key="item.id"
                            >
                                <div class="flex">
                                    <svg
                                        fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor"
                                        class="text-gray-600 mt-1 w-4 h-4 mr-2"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M4 6h16M4 12h16M4 18h16"
                                        />
                                    </svg>
                                    <span>
                                {{item.name}} - {{item.url}}
                            </span>
                                </div>
                                <div>
                                    <button
                                        class="mr-4"
                                        @click="deleteItem(item)"
                                    >
                                        <svg
                                            fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor"
                                            class="text-gray-600 mt-1 w-4 h-4"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                                            />
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
                            <button
                                type="button"
                                class="btn"
                                :disabled="!reordered"
                                :class="{'bg-gray-600 hover:bg-gray-500': !reordered, 'bg-indigo-600 hover:bg-indigo-500': reordered}"
                                @click="saveOrder"
                            >
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
            </div>
            <div v-if="isNewMode" class="w-1/3 p-6">
                <p class="pt-6 text-lg leading-6 font-medium text-gray-900 text-center">New item</p>
                <ResourceForm
                    resource="menu-item"
                    :append="{menu: name, order: menu.items.length + 1}"
                    :clear-on-success="true"
                    @cancel=""
                    @success="handleNewItemSuccess"
                />
            </div>
            <div v-if="isUpdateMode && selectedItem" class="w-1/3 p-6">
                <p class="pt-6 text-lg leading-6 font-medium text-gray-900 text-center">Update item</p>
                <ResourceForm
                    resource="menu-item"
                    :resource-id="selectedItem.id"
                    :append="{menu: name}"
                    @cancel="mode = 'new'"
                    @success="handleUpdateItemSuccess"
                />
            </div>
        </div>
    </loading>
</template>

<script>
    import api from "../../../lib/api";
    import Draggable from 'vuedraggable';
    import ResourceForm from "../../../components/ResourceForm";

    export default {
        props: {
            name: String,
        },
        components: {
            Draggable,
            ResourceForm
        },
        data() {
            return {
                isLoading: true,
                mode: 'new',
                menu: null,
                items: [],
                selectedItem: false,
            }
        },
        mounted() {
            this.fetchMenu();
            this.isLoading = false;
        },
        computed: {
            reordered() {
                return this.menu.items !== this.items;
            },
            isNewMode() {
                return this.mode === 'new'
            },
            isUpdateMode() {
                return this.mode === 'update'
            }
        },
        watch: {
            menu() {
                this.items = this.menu.items;
            }
        },
        methods: {
            async fetchMenu() {
                const response = await api(Cms.route('cms.api.resources.show', ['menu', this.name]));
                this.menu = response.data.data
            },

            updateItem(item) {
                this.selectedItem = item;
                this.mode = 'update';
            },


            handleNewItemSuccess() {
                Cms.flash('success', 'new Item created');
                this.fetchMenu();
            },

            handleUpdateItemSuccess() {
                this.fetchMenu();
                this.mode = 'new';
                Cms.flash('success', 'new Item created');
            },

            async saveOrder() {
                // update order
                await api({
                    ...Cms.route('cms.api.menus.save_order', this.name),
                    data: {
                        order: this.items.map((value, index) => {
                            return {
                                id: value.id,
                                order: index
                            }
                        })
                    }
                });
                // and fetch menu again
                this.fetchMenu();
                Cms.flash('success', 'Items reordered');
            },

            async deleteItem(item) {
                // delete item
                await api(Cms.route('cms.api.resources.delete', ['menu-item', item.id]));
                // and fetch menu again
                this.fetchMenu();
                Cms.flash('success', 'Item deleted');
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
