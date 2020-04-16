import Index from "./views/Index";
import Show from "./views/Show";
import Edit from "./views/Edit";
import Create from "./views/Create";

export default [
    {
        path: '/admin/users',
        name: 'users.index',
        component: Index
    },
    {
        path: '/admin/users/create',
        name: 'users.create',
        component: Create
    },
    {
        path: '/admin/users/:id',
        name: 'users.show',
        component: Show,
        props: true
    },
    {
        path: '/admin/users/:id/edit',
        name: 'users.edit',
        component: Edit,
        props: true
    },
];
