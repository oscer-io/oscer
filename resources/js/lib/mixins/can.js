export default {
    data() {
        return {
            permissions: this
        }
    },
    methods: {
        can(ability) {
            return window.Cms.config.user.roles.some(role => role.name === "super-admin") ||
                window.Cms.config.user.assigned_permissions.includes(ability);
        }
    }
};
