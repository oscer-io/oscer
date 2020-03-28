export default {
    methods: {
        route(name, params = {}) {
            let route = Cms.config.routes[name];

            let matches = route.uri.match(/[^{]+(?=\})/g);

            if (Object.entries(params).length >= 1 && matches.length >= 1) {
                matches.forEach(match => {
                    route.uri = route.uri.replace('{' + match + '}', params[match])
                });
            }

            return route;
        }
    }
}
