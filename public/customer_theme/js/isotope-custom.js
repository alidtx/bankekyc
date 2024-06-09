(function ($) {
    // USE STRICT
    "use strict";

    $(document).ready(function () {
        var $isoContainer = $('.isotope-grid');
        var $filter = $('.filter-button-group');

        // filter items on button click
        $filter.each(function () {
            $filter.on( 'click', 'li', function() {
                var filterValue = $(this).attr('data-filter');
                $isoContainer.isotope({ filter: filterValue });
            });
            var $buttonGroup = $('.filter-button-group');
            $buttonGroup.on('click', 'li', function () {
                $buttonGroup.find('.is-checked').removeClass('is-checked');
                $(this).addClass('is-checked');
            });
        });

        // init Isotope
        var $grid = $isoContainer.each(function () {
            $(this).isotope({
                itemSelector: '.isotope-item',
                percentPosition: true,
                masonry: {
                    columnWidth: '.isotope-item'
                }
            });
        });

        // layout Isotope after each image loads
        $grid.imagesLoaded().progress( function() {
            $grid.isotope('layout');
        });
    });

})(jQuery);