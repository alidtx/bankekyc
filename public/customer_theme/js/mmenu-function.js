(function ($) {
    // USE STRICT
    "use strict";

    $(document).ready(function() {
        var mmenu = $("#mmenu");
        mmenu.mmenu({
            "extensions": [
                "pagedim-black",
                "theme-blue",
                "shadow-page"
            ],
            "offCanvas": {
                zposition   : "front"
            },
            navbar: {
                title: "INSURANCE"
            },
            "navbars": [
                {
                    "position": "top"
                },
                {
                    "position": "bottom",
                    "content": [
                        "<a class='fa fa-envelope' href='#/'></a>",
                        "<a class='fa fa-twitter' href='#/'></a>",
                        "<a class='fa fa-facebook' href='#/'></a>"
                    ]
                }
            ]
        });
        var API = mmenu.data( "mmenu" );

        $(".navbar-toggle").click(function() {
            API.open();
        });
    });

})(jQuery);




