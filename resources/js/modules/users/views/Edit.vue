<template>
    <loading :loading="isLoading">
        <div class="md:flex md:items-center md:justify-between">
            <div class="flex-1 min-w-0">
                <h1 class="text-lg leading-6 font-medium text-gray-900">
                    {{ $t('users.edit_title', {name: user.name} ) }}
                </h1>
            </div>
        </div>
        <BaseForm v-if="user"
                  :fields="fields"
                  :api-route="{name:'cms.api.users.update',params:{user: id}}"
                  @cancel="handleCancel"
                  @success="handleSuccess"
        />
    </loading>
</template>

<script>
    import axios from 'axios';
    import BaseForm from "../../../components/BaseForm";

    export default {
        components: {BaseForm},
        props: ['id'],
        data() {
            return {
                isLoading: true,
                user: false,
                fields: []
            }
        },
        computed: {
            title() {
                return this.user
                    ? this.$t('users.edit_title', {name: this.user.name, id: this.user.id})
                    : 'Loading'
            },
        },

        methods: {
            handleCancel() {
                this.$router.push({name: 'users.index'})
            },
            handleSuccess(user) {
                Cms.flash('success', 'Nice one!');
                this.$router.push({name: 'users.show', params: {id: user.id}})
            }
        },
        async mounted() {
            // posts endpoint not implemented because of the thoughts to only use one model with different types
            const response = await axios.get('/api/cms/users/' + this.id);
            this.user = response.data.data;
            this.fields = response.data.fields;
            this.isLoading = false;
        }
    }
</script>

