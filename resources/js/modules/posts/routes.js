import Index from "./views/Index";
import Show from "./views/Show";
import Edit from "./views/Edit";
import Create from "./views/Create";

export default [
    {
        path: '/admin/posts',
        name: 'posts.index',
        component: Index
    },
    {
        path: '/admin/posts/create',
        name: 'posts.create',
        component: Create
    },
    {
        path: '/admin/posts/:id',
        name: 'posts.show',
        component: Show,
        props: true
    },
    {
        path: '/admin/posts/:id/edit',
        name: 'posts.edit',
        component: Edit,
        props: true
    },
];
