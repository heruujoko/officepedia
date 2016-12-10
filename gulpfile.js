const elixir = require('laravel-elixir');

require('laravel-elixir-vue');

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

elixir(mix => {
    mix.webpack('salesinvoice.js');
    // mix.webpack('purchaseinvoice.js');
    // mix.webpack('stockcardreport.js');
    // mix.webpack('salesreport.js');
    // mix.webpack('invoicereport.js');
    // mix.webpack('arcustreport.js');
    // mix.webpack('arreport.js');
    // mix.webpack('stockvaluereport.js');
    // mix.webpack('purchasereport.js');
    // mix.webpack('apreport.js');
});
