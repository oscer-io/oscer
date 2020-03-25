const mix = require('laravel-mix');
let tailwindcss = require('tailwindcss');
/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

// mix.options({processCssUrls: false})
//     .setPublicPath('dist')
//     .js('resources/js/app.js', 'dist')
//     .version();

// mix.options({processCssUrls: false})
//     .setPublicPath('dist')
//     .js('resources/js/swagger-ui.js', 'dist')
//     .sass('resources/sass/swagger-ui.scss', 'dist')
//     .version();

mix.options({processCssUrls: false})
    .setPublicPath('dist')
    .js('resources/js/cms.js', 'dist')
    .sass('resources/sass/app.scss', 'dist', {}, [tailwindcss('./tailwind.config.js')])
    .version();
