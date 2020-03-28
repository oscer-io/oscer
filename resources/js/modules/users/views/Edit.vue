<template>
    <div v-if="user">
        <div class="md:flex md:items-center md:justify-between">
            <div class="flex-1 min-w-0">
                <h1 class="text-lg leading-6 font-medium text-gray-900">
                    {{ $t('users.edit_title', {name: user.name} ) }}
                </h1>
            </div>
        </div>
        <BaseForm v-if="user"
            :fields="fields"
            :api-route="route('cms.api.users.update',{user: id})"
            @cancel="handleCancel"
            @success="handleSuccess"
        />
    </div>
</template>

<script>
    import axios from 'axios';
    import BaseForm from "../../../components/BaseForm";

    export default {
        components: {BaseForm},
        props: ['id'],
        data() {
            return {
                user: null,
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
            this.fields = [
                {
                    label: 'Name',
                    name: 'name',
                    type: 'text',
                    value: this.user.name
                },
                {
                    label: 'E-Mail',
                    name: 'email',
                    type: 'text',
                    value: this.user.email
                },
                {
                    label: 'Biography',
                    name: 'bio',
                    type: 'textarea',
                    value: this.user.bio
                }
            ];
        }
    }
</script>

