module.exports = {
    title: 'Laravel CMS',
    description: 'A simple CMS and blogging platform made for developers.',


    themeConfig: {
        repo: 'bambamboole/laravel-cms',
        editLinks: true,
        docsDir: 'docs',
        displayAllHeaders: true,
        sidebarDepth: 0,
        sidebar: [
            {
                title: 'Getting Started',
                collapsable: false,
                children: [
                    ['getting-started/installation', 'Installation'],
                    ['getting-started/dummy-data', 'Seed dummy data'],
                ],

            },
            {
                title: 'Usage',
                collapsable: false,
                children: [
                    ['usage/users', 'Users'],
                    ['usage/pages', 'Pages'],
                    ['usage/posts-tags', 'Posts & Tags'],
                ],

            },
            {
                title: 'Architecture',
                collapsable: false,
                children: [
                    ['architecture/database-schema', 'Database schema'],
                ],

            }
        ],
    }
}
