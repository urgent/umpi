(function ($) {
    "use strict";

    // smart-textimonials
    var resido_testimonial_js = function ($) {
        jQuery('#smart-textimonials').slick({
            slidesToShow:3,
            infinite: true,
            arrows: false,
            autoplay:true,
            responsive: [
            {
                breakpoint: 768,
                settings: {
                arrows: false,
                slidesToShow:2
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
    };

    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction('frontend/element_ready/smart_testimonials.default', resido_testimonial_js);
    });
})(window.jQuery);
  