const $ = jQuery;

$(document).ready(function() {
    if ($('svg.icon-light-theme')[0]) {
        $('header.header').css({
            'backdrop-filter': 'blur(5px) saturate(0.5)',
            'background-color': 'rgb(22 27 40 / 90%)'
        })
    }
    else {
        $('header.header').css({
            'backdrop-filter': 'blur(5px) saturate(0.5)',
            'background-color': 'rgb(248 248 251 / 90%)'
        })
    }
});