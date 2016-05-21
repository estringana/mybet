window.$ = window.jQuery = require('jquery')
require('bootstrap-sass');
require('bootstrap-select');

$( document ).ready(function() {
    console.log($.fn.tooltip.Constructor.VERSION);

    $('.selectpicker').selectpicker();
});