(function ($) {
    // USE STRICT
    "use strict";

    $(document).ready(function () {

        var LocsA = [
            {
                lat: 37.774509,
                lon: -122.411727,
                title: 'San Francisco',
                html: [
                    '<h3>We in  San Francisco</h3>',
                    '<p>24/7 Support</p>'
                ].join(''),
                icon: 'img/icons/location.png',
                animation: google.maps.Animation.DROP,
                zoom:10
            },
            {
                lat: 34.298450,
                lon: -111.714435,
                title: 'Arizona',
                html: '<h3>We in Arizona</h3>',
                icon: 'img/icons/location.png',
                show_infowindow: true,
                animation: google.maps.Animation.DROP,
                zoom:4
            },
            {
                lat: 35.775319,
                lon: -79.708533,
                title: 'North Carolina',
                html: [
                    '<h3>We in North Carolina</h3>',
                    '<p>We Are Architect</p>'
                ].join(''),
                icon: 'img/icons/location.png',
                animation: google.maps.Animation.DROP,
                zoom:4
            },
            {
                lat: 39.952644,
                lon: -75.165247,
                title: 'Philadelphia',
                html: [
                    '<h3>We in Philadelphia</h3>',
                    '<p> 4th floor, 129 Hudson St, Philadelphia</p>'
                ].join(''),
                icon: 'img/icons/location.png',
                animation: google.maps.Animation.DROP,
                zoom:8
            }
        ];



        new Maplace({
            locations: LocsA,
            map_div: '#google_map',
            controls_type: 'list',
            controls_on_map: false,
            map_options: {
                scrollwheel: false
            },
            start:1,
            styles: {
                'Night': [{
                    featureType: 'all',
                    stylers: [
                        { invert_lightness: 'true' }
                    ]
                }],
                'Greyscale': [{
                    featureType: 'all',
                    stylers: [
                        { saturation: -100 },
                        { gamma: 0.50 }
                    ]
                }],

                "Ultra Light": [
                    {
                        "featureType": "landscape",
                        "stylers": [
                            {
                                "saturation": -100
                            },
                            {
                                "lightness": 65
                            },
                            {
                                "visibility": "on"
                            }
                        ]
                    },
                    {
                        "featureType": "poi",
                        "stylers": [
                            {
                                "saturation": -100
                            },
                            {
                                "lightness": 51
                            },
                            {
                                "visibility": "simplified"
                            }
                        ]
                    },
                    {
                        "featureType": "road.highway",
                        "stylers": [
                            {
                                "saturation": -100
                            },
                            {
                                "visibility": "simplified"
                            }
                        ]
                    },
                    {
                        "featureType": "road.arterial",
                        "stylers": [
                            {
                                "saturation": -100
                            },
                            {
                                "lightness": 30
                            },
                            {
                                "visibility": "on"
                            }
                        ]
                    },
                    {
                        "featureType": "road.local",
                        "stylers": [
                            {
                                "saturation": -100
                            },
                            {
                                "lightness": 40
                            },
                            {
                                "visibility": "on"
                            }
                        ]
                    },
                    {
                        "featureType": "transit",
                        "stylers": [
                            {
                                "saturation": -100
                            },
                            {
                                "visibility": "simplified"
                            }
                        ]
                    },
                    {
                        "featureType": "administrative.province",
                        "stylers": [
                            {
                                "visibility": "off"
                            }
                        ]
                    },
                    {
                        "featureType": "water",
                        "elementType": "labels",
                        "stylers": [
                            {
                                "visibility": "on"
                            },
                            {
                                "lightness": -25
                            },
                            {
                                "saturation": -100
                            }
                        ]
                    },
                    {
                        "featureType": "water",
                        "elementType": "geometry",
                        "stylers": [
                            {
                                "hue": "#ffff00"
                            },
                            {
                                "lightness": -25
                            },
                            {
                                "saturation": -97
                            }
                        ]
                    }
                ]
            }
        }).Load();

    });

})(jQuery);