const mix = require('laravel-mix');
let tailwindcss = require('tailwindcss');
const path = require('path');

mix.webpackConfig({
    resolve: {
        alias: {
            '@': path.resolve(__dirname, 'resources/js/'),
            ziggy: path.resolve('vendor/tightenco/ziggy/dist/js/route.js'),
        },
    },
});

mix.options({processCssUrls: false})
    .setPublicPath('dist')
    .js('resources/js/app.js', 'dist')
    .sass('resources/sass/app.scss', 'dist', {}, [tailwindcss('./tailwind.config.js')])
    .browserSync('web.oscer.test')
    .version();

