export default {
    methods: {
        route(name, params = {}) {
           console.log('start');
           console.log(name,params);
            let route = Cms.config.routes[name];

            let matches = route.url.match(/[^{]+(?=\})/g);

            if (Object.entries(params).length >= 1 && matches.length >= 1) {
                matches.forEach(match => {
                    route.url = route.url.replace('{' + match + '}', params[match])
                });
            }
           console.log(route)
           console.log('end');

            return route;
        }
    }
}
