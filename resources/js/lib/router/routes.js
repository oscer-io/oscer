const NotFound = {template: '<div>not found</div>'};
const Admin = {template: '<div>Admin index</div>'};

import menuRoutes from '../../modules/menus/routes';
import optionRoutes from '../../modules/options/routes';
import profileRoutes from '../../modules/profile/routes';
import userRoutes from '../../modules/users/routes';
import postRoutes from '../../modules/posts/routes';

export default [
    {
        path: '/admin',
        name: 'dashboard',
        component: Admin
    },

    ...menuRoutes,
    ...optionRoutes,
    ...profileRoutes,
    ...userRoutes,
    ...postRoutes,

    {
        path: '/admin/404',
        name: 'not-found',
        component: NotFound
    },
    {
        path: '*',
        name: 'catch-all',
        component: NotFound
    },
];
