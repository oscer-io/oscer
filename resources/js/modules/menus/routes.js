import Index from "./views/Index";
import Show from "./views/Show";

export default [
    {
        path: '/admin/menus',
        name: 'menus.index',
        component: Index
    },
    {
        path: '/admin/menus/:id',
        name: 'menus.show',
        component: Show,
        props: true
    },
]
