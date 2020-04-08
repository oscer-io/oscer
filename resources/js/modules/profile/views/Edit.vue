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

        <ResourceForm
            resource="user"
            :resource-id="currentUser.id"
            @cancel="$router.push({name: 'profile.show'})"
            @success="handleSuccess"
        />
    </div>
</template>

<script>
    import ResourceForm from "../../../components/ResourceForm";

    export default {
        components: {
            ResourceForm
        },
        computed:{
          currentUser(){
              return Cms.config.user;
          }
        },
        methods: {
            handleSuccess(user) {
                Cms.config.user = user;
                Cms.flash('success', 'Nice one!');
                this.$router.push({name: 'profile.show'})
            }
        }
    }
</script>
