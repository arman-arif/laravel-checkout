const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */
const tailwindcss = require('tailwindcss');

mix.js('resources/js/app.js', 'public/js')
    .js('resources/js/bootstrap.js', 'public/js')
    .js('resources/js/jquery.js', 'public/js')
    .js('resources/js/datatables.js', 'public/js')
    .sass('resources/scss/bootstrap.scss', 'public/css')
    .sass('resources/scss/app.scss', 'public/css')
    .options({
        postCss: [
            require('postcss-import'),
            tailwindcss('./tailwind.config.js'),
            require('autoprefixer'),
        ]
    })
    .postCss('resources/css/datatables.css', 'public/css')
