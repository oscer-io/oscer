<template>
    <div>

        <div class="md:flex md:items-center md:justify-between">
            <div class="flex-1 min-w-0">
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    {{$t('profile.label')}}
                </h3>
                <p class="mt-1 text-sm leading-5 text-gray-500">
                    {{$t('profile.subtitle')}}
                </p>
            </div>
        </div>

        <CreateForm
            resource="profile"
            :api-route="{name: 'cms.api.profile.update'}"
            @cancel="handleCancel"
            @success="handleSuccess"
        />
    </div>
</template>

<script>
    import CreateForm from "../../../components/CreateForm";

    export default {
        components: {
            CreateForm
        },
        data() {
            return {
                fields: [
                    {
                        type: 'text',
                        name: 'name',
                        label: this.$t('profile.name'),
                        value: Cms.config.user.name
                    },
                    {
                        type: 'text',
                        attributes:{
                            type: 'email'
                        },
                        name: 'email',
                        label: this.$t('profile.email'),
                        value: Cms.config.user.email
                    },
                    {
                        type: 'textarea',
                        name: 'bio',
                        label: this.$t('profile.bio'),
                        value: Cms.config.user.bio
                    },
                    {
                        type: 'text',
                        attributes:{
                            type: 'password'
                        },
                        name: 'password',
                        label: this.$t('profile.password')
                    },
                    {
                        type: 'text',
                        attributes:{
                            type: 'password'
                        },
                        name: 'password_confirmation',
                        label: this.$t('profile.password_confirmation')
                    }
                ]
            }
        },
        methods: {
            handleCancel() {
                this.$router.push({name: 'profile.show'})
            },
            handleSuccess(user) {
                Cms.config.user = user
                Cms.flash('success', 'Nice one!');
                this.$router.push({name: 'profile.show'})
            }
        }
    }
</script>
