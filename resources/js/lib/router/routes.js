import PagesIndex from '../../views/Pages/Index';
import ShowPage from '../../views/Pages/Show';
import EditPage from '../../views/Pages/Edit';
import PostsIndex from '../../views/Posts/Index';


const NotFound = {template: '<div>not found</div>'};
const Admin = {template: '<div>Admin index</div>'};

import menuRoutes from '../../modules/menus/routes';
import optionRoutes from '../../modules/options/routes';
import profileRoutes from '../../modules/profile/routes';
import userRoutes from '../../modules/users/routes';

export default [
    {
        path: '/admin',
        name: 'dashboard',
        component: Admin
    },
    {
        path: '/admin/pages',
        name: 'pages.index',
        component: PagesIndex
    },
    {
        path: '/admin/pages/:id',
        name: 'pages.show',
        component: ShowPage,
        props: true
    },
    {
        path: '/admin/pages/:id/edit',
        name: 'pages.edit',
        component: EditPage,
        props: true
    },
    {
        path: '/admin/posts',
        name: 'posts.index',
        component: PostsIndex
    },

    ...menuRoutes,
    ...optionRoutes,
    ...profileRoutes,
    ...userRoutes,
    {
        path: '*',
        name: 'catch-all',
        component: NotFound
    },
];
