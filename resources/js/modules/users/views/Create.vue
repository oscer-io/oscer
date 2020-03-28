<template>
    <div>
        <div class="md:flex md:items-center md:justify-between">
            <div class="flex-1 min-w-0">
                <h1 class="text-lg leading-6 font-medium text-gray-900">
                    {{ $t('users.create_title') }}
                </h1>
            </div>
        </div>
        <BaseForm
            :fields="fields"
            :api-route="route('cms.api.users.store')"
            @cancel="handleCancel"
            @success="handleSuccess"
        />
    </div>
</template>

<script>
    import BaseForm from "../../../components/BaseForm";

    export default {
        components: {BaseForm},
        data() {
            return {
                fields: [
                    {
                        label: 'Name',
                        name: 'name',
                        type: 'text'
                    },
                    {
                        label: 'E-Mail',
                        name: 'email',
                        type: 'text'
                    },
                    {
                        label: 'Biography',
                        name: 'bio',
                        type: 'textarea'
                    }
                ]
            }
        },
        methods: {
            handleCancel() {
                this.$router.push({name: 'users.index'})
            },
            handleSuccess(user) {
                Cms.flash('success', 'Nice one!');
                this.$router.push({name: 'users.show', params: {id: user.id}})
            }
        }
    }
</script>
