(function ($) {
    // USE STRICT
    "use strict";

    $(document).ready(function() {
        var owlSelector = $('.owl-carousel');
        owlSelector.each(function () {
            var owl = $(this);
            var dots = $(this).attr('data-dots');
            var center = false;
            var col_sm =  1;
            var col_md =  1;
            var col_lg =  1;
            var col_xs =  1;
            var items = 1;
            if ($(this).attr('data-center') == 1) {
                center = true;
            }
            if ($(this).attr('data-items') != null) {
                items = $(this).attr('data-items');
            }
            if ($(this).attr('data-col-xs') != null &&
                $(this).attr('data-col-sm') != null &&
                $(this).attr('data-col-lg') != null &&
                $(this).attr('data-col-md') != null) {

                col_sm = $(this).attr('data-col-sm');
                col_md = $(this).attr('data-col-md');
                col_lg = $(this).attr('data-col-lg');
                col_xs = $(this).attr('data-col-xs');
            }
            $(this).owlCarousel({
                autoplay: true,
                dotsContainer: dots,
                loop: true,
                animateOut: 'fadeOut',
                animateIn: 'fadeIn',
                responsive: {
                    // breakpoint from 0 up
                    0: {
                        items: col_xs,
                        center:center
                    },
                    // breakpoint from 480 up
                    320: {
                        items: col_sm,
                        center:center
                    },
                    // breakpoint from 768 up
                    480: {
                        items: col_md,
                        center:center
                    },
                    992: {
                        items: col_lg,
                        center:center
                    },
                    1200: {
                        items : items
                    }
                }
            });

            $('.owl-dots .owl-dot').on('click', function () {
                owl.trigger('to.owl.carousel', [$(this).index(), 300]);
            });

            // Go to the next item
            $('.slider-arrow .next').on('click', function() {
                owl.trigger('next.owl.carousel');
            });
            // Go to the previous item
            $('.slider-arrow .prev').on('click', function() {
                // With optional speed parameter
                // Parameters has to be in square bracket '[]'
                owl.trigger('prev.owl.carousel', [300]);
            });
        });
    });

})(jQuery);




