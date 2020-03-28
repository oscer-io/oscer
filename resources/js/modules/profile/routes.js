import Show from "./views/Show";
import Edit from "./views/Edit";

export default [
    {
        path: '/admin/profile',
        name: 'profile.show',
        component: Show
    },
    {
        path: '/admin/profile/edit',
        name: 'profile.edit',
        component: Edit
    },
]
