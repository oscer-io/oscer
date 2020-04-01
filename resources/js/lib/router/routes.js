const NotFound = {template: '<div>not found</div>'};
const Admin = {template: '<div>Admin index</div>'};

import menusRoutes from '../../modules/menus/routes';
import optionsRoutes from '../../modules/options/routes';
import profileRoutes from '../../modules/profile/routes';
import usersRoutes from '../../modules/users/routes';
import rolesRoutes from '../../modules/roles/routes';

export default [
    {
        path: '/admin',
        name: 'dashboard',
        component: Admin
    },

    ...menusRoutes,
    ...optionsRoutes,
    ...profileRoutes,
    ...usersRoutes,
    ...rolesRoutes,

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
