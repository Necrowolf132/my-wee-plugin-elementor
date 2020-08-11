var PostGridSlider = function($scope, $) {
    console.log("estoy aqui");
    var $gallery = $(".eael-post-appender", $scope).isotope({
        itemSelector: ".eael-grid-post",
        masonry: {
            columnWidth: ".eael-post-grid-column",
            percentPosition: true
        }
    });

    // layout gal, while images are loading
    $gallery.imagesLoaded().progress(function() {
        $gallery.isotope("layout");
    });
};

jQuery(window).on("elementor/frontend/init", function() {
    elementorFrontend.hooks.addAction(
        "frontend/element_ready/eael-post-grid.default",
        PostGrid
    );
});
jQuery( window ).on( 'elementor/frontend/init', () => {
    const addHandler = ( $element ) => {
       /* elementorFrontend.elementsHandler.addHandler( WidgetHandlerClass, {
            $element,
        } );*/
        let iniciador = '.swiper-container-' + $element.data("id"); 
        var swiper = new Swiper(iniciador, {
            slidesPerView: 1,
            spaceBetween: 5,
            pagination: {
              el: '.swiper-pagination',
              clickable: true,
            },
            breakpoints: {
                // when window width is >= 360px
                700: {
                  slidesPerView: 2,
                  spaceBetween: 0
                }
            }
          });
    };
 
    elementorFrontend.hooks.addAction( 'frontend/element_ready/wee-post-grid-slider.default', addHandler );
 } );