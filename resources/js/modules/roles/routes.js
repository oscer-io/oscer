import Index from "./views/Index";
import Edit from "./views/Edit";

export default [
    {
        path: '/admin/roles',
        name: 'roles.index',
        component: Index
    },
    {
        path: '/admin/roles/:id/edit',
        name: 'roles.edit',
        component: Edit,
        props: true
    },
];

