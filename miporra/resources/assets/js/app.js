window.$ = window.jQuery = require('jquery')
require('bootstrap-sass');
require('bootstrap-select');

$( document ).ready(function() {
    console.log($.fn.tooltip.Constructor.VERSION);

    $('.selectpicker').selectpicker();

    var progress = ($('.bet').size()-$('.pending-bet').size())*100/$('.bet').size();
    
    $('.betProgress .progress-bar').css('width', progress+'%').attr('aria-valuenow',progress);

    $('#bets .panel').each(function (index){
        var destination = $(this).find('.panel-heading .panel-title');
        if ($(this).find('.pending-bet').size() > 0){
            destination.append('<span class="pending-bet label label-danger">Pending</span>');
        }
        else
        {
            destination.append('<span class="label label-success">Completed</span>');
        }
    });
});