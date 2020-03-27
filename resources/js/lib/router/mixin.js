import Router from "./router";
export default {
    methods: {
        route(name, params = {}) {
            const router = this.$page.routes;

            return router.make(name, params);
        },
    }
}
