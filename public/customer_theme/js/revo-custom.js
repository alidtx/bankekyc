(function ($) {
    // USE STRICT
    "use strict";

    $(document).ready(function () {
        /*SLIDER*/
        jQuery(document).ready(function() {

            /* initialize the slider based on the Slider's ID attribute from the wrapper above */
            jQuery('#rev_slider_1').show().revolution({
                responsiveLevels: [1201, 1200, 992, 768],
                /* options are 'auto', 'fullwidth' or 'fullscreen' */
                sliderLayout: 'auto',
                gridheight: 500,
                gridwidth: [1170, 970, 740, 740],
                delay: 2500,
                /* basic navigation arrows and bullets */
                navigation: {

                    arrows: {
                        enable: true,
                        style: 'gyges',
                        hide_onleave: false,
                        left: {
                            h_offset: 0
                        },
                        right: {
                            h_offset: 0
                        }
                    },

                    bullets: {
                        enable: true,
                        style: 'hermes',
                        hide_onleave: false,
                        h_align: "center",
                        v_align: "bottom",
                        h_offset: 0,
                        v_offset: 20,
                        space: 5
                    }
                }
            });
        });
    });

})(jQuery);

