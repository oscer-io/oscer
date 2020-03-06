export default {
    methods: {
        route(name, params = {}) {
            let route = this.$page.routes[name];

            let matches = route.match(/[^{]+(?=\})/g);

            if (Object.entries(params).length >= 1) {
                matches.forEach(match => {
                    route = route.replace('{' + match + '}', params[match])
                });
            }

            return route;
        },
    }
}
