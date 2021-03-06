const elixir = require('laravel-elixir');

require('laravel-elixir-vue');
require('laravel-elixir-webpack-official');

Elixir.webpack.mergeConfig({
    babel: {
       presets: ['babel-preset-stage-3'],
       plugins: ['babel-plugin-transform-runtime'],
   }
})

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
    mix.webpack('purchaseinvoice.js');
    mix.webpack('stockcardreport.js');
    mix.webpack('salesreport.js');
    mix.webpack('invoicereport.js');
    mix.webpack('arcustreport.js');
    mix.webpack('arreport.js');
    mix.webpack('stockvaluereport.js');
    mix.webpack('purchasereport.js');
    mix.webpack('apreport.js');
    mix.webpack('cogshistory.js');
    mix.webpack('purchasequotation.js');
    mix.webpack('payap.js');
    mix.webpack('payar.js');
    mix.webpack('salesquotation.js');
    mix.webpack('purchasequotation.js');
    mix.webpack('journalreport.js');
    mix.webpack('ledgerreport.js');
    mix.webpack('cashincome.js');
    mix.webpack('generaljournal.js');
    mix.webpack('roles.js');
    mix.webpack('changebranch.js');
    mix.webpack('arbook.js');
    mix.webpack('salespurchasejournal.js');
    mix.webpack('cashbalance.js');
    mix.webpack('purchasefixedasset.js');
    // mix.scripts([
    //     '/public/app.min.js','/public/app.config.js','/public/select2.min.js'
    // ],'public/js/app.mixed.js');

});
