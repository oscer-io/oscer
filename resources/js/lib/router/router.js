export default class Router {

    constructor(routes) {
        this.routes = routes;
    }

    make (name, params = {}) {
        let route = this.routes[name];

        let matches = route.match(/[^{]+(?=\})/g);

        if (Object.entries(params).length >= 1) {
            matches.forEach(match => {
                route = route.replace('{' + match + '}', params[match])
            });
        }

        return route;
    }
}
