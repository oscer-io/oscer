<template>
    <FieldWrapper
        :name="field.name"
        :label="field.label || field.name"
        :errors="validationErrors"
    >
        <div>
            <Draggable
                class="border rounded"
                v-model="value"
                v-bind="{ghostClass: 'ghost'}"
                @start="drag=true"
                @end="drag=false"
            >
                <transition-group type="transition" name="flip-list">
                    <div
                        class="flex justify-between border-b cursor-move last:border-b-0 py-2 px-3"
                        v-for="(item, index) in value" :key="item.id"
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
            </Draggable>
            <button class="btn" type="button" @click="$modal.show('new-menu-item')">new</button>

            <modal name="new-menu-item" height="auto" >

                <ResourceForm
                    class="p-4"
                    resource="menu-item"
                    :append="{menu: field.model.id, order: field.model.items.length + 1}"
                    :clear-on-success="true"
                    @cancel="$modal.hide('new-menu-item')"
                    @success="handleNewItemSuccess"
                />
            </modal>
            <!--            <p>update</p>-->
            <!--            <ResourceForm-->
            <!--                resource="menu-item"-->
            <!--                :resource-id="selectedItem.id"-->
            <!--                :append="{menu: id}"-->
            <!--                @cancel="mode = 'new'"-->
            <!--                @success="handleUpdateItemSuccess"-->
            <!--            />-->
        </div>
    </FieldWrapper>
</template>
<script>
    import Draggable from 'vuedraggable';
    import FormField from "../../lib/mixins/FormField";
    import ResourceForm from "../ResourceForm";

    export default {
        mixins: [FormField],
        components: {Draggable, ResourceForm},
        data() {
            return {
                value: [],
                drag: false
            }
        },

        methods: {
            updateItem() {
                console.log('update')
            },
            deleteItem() {
                console.log('delete')
            },
            handleNewItemSuccess(payload) {
                console.log('success', payload);
                this.$modal.hide('new-menu-item');
                Cms.flash('success', 'Item updated');
                Cms.$emit('reset-form-menu');
            },
            fill(data) {
                data[this.field.name] = JSON.stringify(this.value.map((item, index) => {
                    item.order = index + 1;
                    return item;
                }));

                return data;
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
        background: #5850ec;
    }
</style>
