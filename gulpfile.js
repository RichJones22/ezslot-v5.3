const elixir = require('laravel-elixir');
const path = require('path');

require('laravel-elixir-vue-2');
// require('laravel-elixir-vue-loader');

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
    mix.less('app.less')
        .sass('splash.css')
        .webpack('app.js', null, null, {
            resolve: {
                modules: [
                    path.resolve(__dirname, 'vendor/laravel/spark/resources/assets/js'),
                    // path.resolve(__dirname, 'spark/resources/assets/js'),
                    'node_modules'
                ]
            }
        })
        .copy('node_modules/sweetalert/dist/sweetalert.min.js', 'public/js/sweetalert.min.js')
        .copy('node_modules/sweetalert/dist/sweetalert.css', 'public/css/sweetalert.css')
        .copy('resources/startbootstrap-freelancer/vendor/bootstrap/css/bootstrap.min.css', 'public/css/bootstrap.min.css')
        .copy('resources/startbootstrap-freelancer/vendor/bootstrap/js/bootstrap.min.js', 'public/js/bootstrap.min.js')
        .copy('resources/startbootstrap-freelancer/vendor/font-awesome/css/font-awesome.min.css', 'public/css/font-awesome.min.css')
        .copy('resources/startbootstrap-freelancer/vendor/jquery/jquery.min.js', 'public/js/jquery.min.js')
        // .copy('resources/startbootstrap-freelancer/js/contact_me.js', 'public/js/contact_me.js')
        .copy('resources/startbootstrap-freelancer/js/freelancer.min.js', 'public/js/freelancer.min.js')
        // .copy('resources/startbootstrap-freelancer/js/jqBootstrapValidation.js', 'public/js/jqBootstrapValidation.js');
        .webpack('ezSlot.js')
});
