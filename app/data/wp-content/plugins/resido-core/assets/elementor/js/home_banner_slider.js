(function ($) {
    "use strict";
    var home_banner_slider = function ($scope, $) {
        //Sponsors Carousel
        if ($('.home-slider').length) {
          // Home Slider
            $('.home-slider').not('.slick-initialized').slick({
            centerMode:false,
            slidesToShow:1,
            responsive: [
                {
                breakpoint: 768,
                settings: {
                    arrows:true,
                    slidesToShow:1
                }
                },
                {
                breakpoint: 480,
                settings: {
                    arrows: false,
                    slidesToShow:1
                }
                }
            ]
            });
        }

    }
    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction('frontend/element_ready/home_banner.default', home_banner_slider);
    });
})(window.jQuery);