import Index from "./views/Index";
import Show from "./views/Show";

export default [
    {
        path: '/admin/roles',
        name: 'roles.index',
        component: Index
    },
    {
        path: '/admin/roles/:id',
        name: 'roles.show',
        component: Show,
        props: true
    },
];

