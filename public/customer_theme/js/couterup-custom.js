(function ($) {
    // USE STRICT
    "use strict";

    $(document).ready(function () {

        var counter_select =  $('.counter');

        counter_select.counterUp({
            delay: 10,
            time: 1000,
            offset: 70,
            beginAt: 100,
            formatter: function (n) {
                return n.replace(/,/g, '.')
            }
        });
    });

})(jQuery);