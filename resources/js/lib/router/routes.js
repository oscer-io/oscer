const NotFound = {template: '<div>not found</div>'};
const Admin = {template: '<div>Admin index</div>'};

import menuRoutes from '../../modules/menus/routes';
import optionRoutes from '../../modules/options/routes';
import profileRoutes from '../../modules/profile/routes';
import userRoutes from '../../modules/users/routes';
import postRoutes from '../../modules/posts/routes';
import pageRoutes from '../../modules/pages/routes';

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
    ...pageRoutes,

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
