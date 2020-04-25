<template>
    <ResourceDetails resource="user" :resource-id="userId">
        <template v-slot:edit-button>
            <RouterLink
                class="btn"
                :to="{name:'profile.edit'}"
            >
                Edit Profile
            </RouterLink>
        </template>
    </ResourceDetails>
</template>

<script>
    export default {
        computed: {
            userId(){
                return Cms.config.user.id
            }
        }
    }
</script>
