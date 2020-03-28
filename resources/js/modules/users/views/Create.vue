<template>
    <div>
        <div class="md:flex md:items-center md:justify-between">
            <div class="flex-1 min-w-0">
                <h1 class="text-lg leading-6 font-medium text-gray-900">
                    {{ $t('users.create_title') }}
                </h1>
            </div>
        </div>
        <CreateForm
            :fields="fields"
            @cancel="handleCancel"
            :api-endpoint="route('cms.api.users.store')"
            @success="handleSuccess"
        />
    </div>
</template>

<script>
    import CreateForm from "../../../components/CreateForm";

    export default {
        components: {CreateForm},
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
