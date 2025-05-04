const mix = require('laravel-mix');

mix.js('resources/js/login.js', 'public/js')
   .postCss('resources/css/app.css', 'public/css', [
       require('tailwindcss'),
   ])
   .postCss('resources/css/login.css', 'public/css', [
       require('tailwindcss'),
   ]);

