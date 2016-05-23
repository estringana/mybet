window.$ = window.jQuery = require('jquery')
require('bootstrap-sass');
require('bootstrap-select');

$( document ).ready(function() {
    console.log($.fn.tooltip.Constructor.VERSION);

    $('.selectpicker').selectpicker();

    var progress = ($('.bet').size()-$('.pending-bet').size())*100/$('.bet').size();
    
    $('.betProgress .progress-bar').css('width', progress+'%').attr('aria-valuenow',progress);
});