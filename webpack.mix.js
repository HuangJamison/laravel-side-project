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

mix.js('resources/js/app.js', 'public/js');

mix.styles([
    'resources/css/todo/all.css',
    'resources/css/todo/create.css',
], 'public/css/todo.css');

mix.styles([
    'resources/css/assigner/all.css',
    'resources/css/assigner/create.css',
], 'public/css/assigner.css');
