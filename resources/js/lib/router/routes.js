import PagesIndex from '../../views/Pages/Index';
import ShowPage from '../../views/Pages/Show';
import EditPage from '../../views/Pages/Edit';
import PostsIndex from '../../views/Posts/Index';

import UsersIndex from '../../views/Users/Index';
import ShowUser from '../../views/Users/Show';
import EditUser from '../../views/Users/Edit';

const NotFound = {template: '<div>not found</div>'};
const Admin = {template: '<div>Admin index</div>'};

import menuRoutes from '../../modules/menus/routes';
import optionRoutes from '../../modules/options/routes';
import profileRoutes from '../../modules/profile/routes';

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
    {
        path: '/admin/users',
        name: 'users.index',
        component: UsersIndex
    },
    {
        path: '/admin/users/:id',
        name: 'users.show',
        component: ShowUser,
        props: true
    },
    {
        path: '/admin/users/:id/edit',
        name: 'users.edit',
        component: EditUser,
        props: true
    },
    {
        path: '*',
        name: 'catch-all',
        component: NotFound
    },
    ...menuRoutes,
    ...optionRoutes,
    ...profileRoutes,
];
