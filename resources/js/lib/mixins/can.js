export default {
    data() {
        return {
            permissions: this
        }
    },
    methods: {
        can(ability) {
            const user = window.Cms.config.user;
            const roles = user.roles;
            const permissions = user.assigned_permissions;

            return roles.some(role => role.name === "super-admin") || permissions.includes(ability);
        }
    }
};
