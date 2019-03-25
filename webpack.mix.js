const mix = require('laravel-mix');

mix.js('resources/js/app.js', 'public/js').version();

mix.styles([
    'resources/css/all.css',
], 'public/css/all.css');
