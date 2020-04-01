import Index from "./views/Index";
import Show from "./views/Show";
import Edit from "./views/Edit";
import Create from "./views/Create";

export default [
    {
        path: '/admin/roles',
        name: 'roles.index',
        component: Index
    },
    {
        path: '/admin/roles/create',
        name: 'roles.create',
        component: Create
    },
    {
        path: '/admin/roles/:id',
        name: 'roles.show',
        component: Show,
        props: true
    },
    {
        path: '/admin/roles/:id/edit',
        name: 'roles.edit',
        component: Edit,
        props: true
    },
];
