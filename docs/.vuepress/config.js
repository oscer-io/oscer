module.exports = {
    title: 'Laravel CMS',
    description: 'A simple CMS and blogging platform made for developers.',

    themeConfig: {
        nav: [
            { text: 'Discord', link: 'https://discord.gg/EwpuT3z', target:'_blank' }
        ],
        repo: 'bambamboole/laravel-cms',
        editLinks: true,
        docsDir: 'docs',
        displayAllHeaders: true,
        sidebarDepth: 0,
        sidebar: [
            ['introduction', 'Introduction'],
            {
                title: 'Getting Started',
                collapsable: false,
                children: [
                    ['getting-started/installation', 'Installation'],
                    ['getting-started/configuration', 'Configuration'],
                    ['getting-started/dummy-data', 'Seed dummy data'],
                ],

            },
            {
                title: 'Usage',
                collapsable: false,
                children: [
                    ['usage/user-management', 'Users'],
                    ['usage/pages', 'Pages'],
                    ['usage/posts-tags', 'Posts & Tags'],
                ],

            },
            {
                title: 'Theming',
                collapsable: false,
                children: [
                    ['theming/introduction', 'Introduction'],
                    ['theming/default-theme', 'DefaultTheme'],
                    ['theming/menus', 'Menus'],
                    ['theming/posts', 'Posts'],
                    ['theming/pages', 'Pages'],
                ],

            },
            {
                title: 'Architecture',
                collapsable: false,
                children: [
                    ['architecture/database-schema', 'Database schema'],
                ],

            },
            {
                title: 'Contribution',
                collapsable: false,
                children: [
                    ['contribution/guidelines', 'Guidelines'],
                    ['contribution/coding-style-guide', 'Coding Style Guide'],
                ],

            }
        ],
    }
};
