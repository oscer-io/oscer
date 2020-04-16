<template>
    <div>
        <div class="md:flex md:items-center md:justify-between">
            <div class="flex-1 min-w-0">
                <h1 class="text-lg leading-6 font-medium text-gray-900">
                    {{ $t('users.create_title') }}
                </h1>
            </div>
        </div>
        <ResourceForm
            resource="user"
            @cancel="$router.push({name: 'users.index'})"
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
        methods: {
            handleSuccess(user) {
                Cms.flash('success', 'Nice one!');
                this.$router.push({name: 'users.show', params: {id: user.id}})
            }
        }
    }
</script>
