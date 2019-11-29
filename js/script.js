jQuery(function($) {
    "use strict";
    
    //============================================
    //Header
    //=============================================

    // Bootstrap Hover Dropdown Menu

    jQuery('ul.nav li.dropdown').hover(function() {
        jQuery(this).find('.dropdown-menu').stop(true, true).fadeIn(500);
    }, function() {
        jQuery(this).find('.dropdown-menu').stop(true, true).fadeOut(500);
    });

    // Initializing Bootstrap Carousel

    $('.carousel').carousel();

    //============================================
    // Animated Carousel
    //============================================

    //Function to Animate Slider Captions
    function doAnimations( elems ) {
        //Cache the animationend event in a variable
        var animEndEv = 'webkitAnimationEnd animationend';
        
        elems.each(function () {
            var $this = $(this),
                $animationType = $this.data('animation');
            $this.addClass($animationType).one(animEndEv, function () {
                $this.removeClass($animationType);
            });
        });
    }

    //Variables on Page Load

    var $mainCarousel = $('#main-carousel'),
        $firstAnimatingElems = $mainCarousel.find('.item:first').find("[data-animation ^= 'animated']");
        
    //Initialize Carousel

    $mainCarousel.carousel();

    //Animate Captions in First Slide on Page Load

    doAnimations($firstAnimatingElems);


    //Other Slides to be Animated on Carousel Slide Event

    $mainCarousel.on('slide.bs.carousel', function (e) {
        var $animatingElems = $(e.relatedTarget).find("[data-animation ^= 'animated']");
        doAnimations($animatingElems);
    });

    //========================================
    // Count Function
    //======================================

    $('.counter-block').each(function() {
        $(this).appear(function() {
            var focus = $(this),
                i = focus.find(".odometer");
            window.setTimeout(function () {
                i.html(focus.attr("data-count"))
            }, 500)
        });
    });

    //================================================
    //Progress Bar
    //=================================================

    $('.skill').each(function() {
        $(this).appear(function() {
            $(this).find('.skill-box').animate({
                width: jQuery(this).attr('data-percent')
            }, 1000);
        });
    });

    //================================================
    //Testimonials
    //=================================================

    if ($('.two-column-carousel').length) {
        $('.two-column-carousel').owlCarousel({
            loop:true,
            margin:30,
            nav:true,
            smartSpeed: 500,
            autoplay: 4000,
            navText: [ '<span class="fa fa-angle-left"></span>', '<span class="fa fa-angle-right"></span>' ],
            items: 2
        });         
    }
    //=================================*/
    //  Client
    //=================================*/

    var logo = $("#clients-logo");
    try{
        logo.owlCarousel({
            navigation : false, // Show next and prev buttons
            slideSpeed : 100,
            paginationSpeed : 300,
            items :5,
            responsive: true,
            autoPlay : true,
            itemsTablet: [768,3],
            itemsTabletSmall: false,
            itemsMobile : [479,2],
            singleItem : false,
            responsiveRefreshRate : 200,
            responsiveBaseWidth: window,
            pagination:false
        });
    } catch(err) {
    }

    //============================================
    //Tooltip
    //=============================================

    $('[data-toggle="tooltip"]').tooltip();

});
