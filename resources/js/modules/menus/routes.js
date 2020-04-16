import Index from "./views/Index";
import Show from "./views/Show";
import Create from "./views/Create";

export default [
    {
        path: '/admin/menus',
        name: 'menus.index',
        component: Index
    },
    {
        path: '/admin/menus/create',
        name: 'menus.create',
        component: Create
    },
    {
        path: '/admin/menus/:id',
        name: 'menus.show',
        component: Show,
        props: true
    },
]
