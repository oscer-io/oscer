import Index from "./views/Index";
import Show from "./views/Show";
import Edit from "./views/Edit";
import Create from "./views/Create";

export default [
    {
        path: '/admin/pages',
        name: 'pages.index',
        component: Index
    },
    {
        path: '/admin/pages/create',
        name: 'pages.create',
        component: Create
    },
    {
        path: '/admin/pages/:id',
        name: 'pages.show',
        component: Show,
        props: true
    },
    {
        path: '/admin/pages/:id/edit',
        name: 'pages.edit',
        component: Edit,
        props: true
    },
];
