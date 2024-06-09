(function ($) {
    // USE STRICT
    "use strict";

    $(document).ready(function () {

        /*Search form*/
        var search_select = $('.search');
        $( ".search-input" ).on('click', function () {
            search_select.addClass( "search-open");
            event.stopPropagation();
        });
        $(".search-submit").on('click', function (event) {
            search_select.toggleClass( "search-open");
            event.stopPropagation();
        });
        $(window).on('click', function () {
            search_select.removeClass( "search-open");
        });

        /*Fixed Navbar*/

        // Cache Header
        var $header = $('header .navbar-main');
        var navpos = $header.offset();
        // Get height of global-header to use later as starting point
        var $hHeight = $header.height();
        // Set initial position to current position on page
        var prevTop = $(window).scrollTop();

        $(window).on('scroll', function(e) {
            var st = $(this).scrollTop(); // Set scroll location
            if ($(window).scrollTop() > navpos.top) {
                $header.addClass('navbar-fixed');
            }
            else {
                $header.removeClass('navbar-fixed');
            }
            if (st > prevTop && st > $hHeight) {
                $header.addClass('js-global-header-scrolling');
            } else {
                $header.removeClass('js-global-header-scrolling');
            }
            prevTop = st;
        });

        /*Video Block*/
        $('.vimeo a, .youtube a').on('click', function (e) {
            e.preventDefault();
            var videoLink = $(this).attr('href');
            var PlaceV = $(this).parent();
            if ($(this).parent().hasClass('youtube')) {
                $(this).parent().wrapAll('<div class="video-wrapper">');
                $(PlaceV).html('<iframe frameborder="0" height="333" src="' + videoLink + '?autoplay=1&showinfo=0" title="YouTube video player" width="100%"></iframe>');
            } else {
                $(this).parent().wrapAll('<div class="video-wrapper">');
                $(PlaceV).html('<iframe src="' + videoLink + '?title=0&amp;byline=0&amp;portrait=0&amp;autoplay=1&amp;color=cfa144" width="100%" height="300" frameborder="0"></iframe>');
            }
        });

    });

    $(window).on('load', function () {
        $('#loading').fadeOut(500);
    });

})(jQuery);