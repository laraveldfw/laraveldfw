var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {
    
    
    // copy angular to public directory
    mix.copy('./node_modules/angular/angular.min.js', 'public/js/angular.min.js')
        
        //copy angular material css
        .copy('./node_modules/angular-material/angular-material.min.css', 'public/css/angular-material.min.css')
    
        // create material.js
        .scripts([
            './node_modules/angular-animate/angular-animate.js',
            './node_modules/angular-aria/angular-aria.js',
            './node_modules/angular-messages/angular-messages.js',
            './node_modules/angular-material/angular-material.js'
        ], 'public/js/material.js')
            
        // create login.js
        .scripts([
            'angular/services/auth.service.js',
            'angular/services/exception.service.js',
            'angular/pages/login.controller.js',
            'angular/pages/login.app.js'
        ], 'public/js/login.js')
    
    
        // version files
        .version([
            'public/js/material.js',
            'public/js/login.js'
        ]);
});
