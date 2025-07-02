const mix = require('laravel-mix');

mix.js('resources/js/app.js', 'public/js')
   .postCss('resources/css/app.css', 'public/css', [
        require('tailwindcss'),
   ])
   .version()
   .sourceMaps();

// Minify CSS dan JS
if (mix.inProduction()) {
    mix.minify('public/css/app.css')
       .minify('public/js/app.js');
}