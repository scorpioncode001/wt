$(function () {
    $('#home').click(function (event) {
        event.preventDefault();
        $('#top-bar')[0].scrollIntoView({
            behavior: "smooth",
            block: "start"
        })
    });
    $('.service').click(function (event) {
        event.preventDefault();
        $('#offer')[0].scrollIntoView({
            behavior: "smooth",
            block: "start"
        })
    });
    $('.faq').click(function (event) {
        event.preventDefault();
        $('#history')[0].scrollIntoView({
            behavior: "smooth",
            block: "start"
        })
    });
    $('.news').click(function (event) {
        event.preventDefault();
        $('.recent-news')[0].scrollIntoView({
            behavior: "smooth",
            block: "start"
        })
    });
    $('.contact').click(function (event) {
        event.preventDefault();
        $('#inquiry')[0].scrollIntoView({
            behavior: "smooth",
            block: "start"
        })
    });

    // $('#h-carousel').owlCarousel({
    //     loop: true,
    //     margin: 10,
    //     responsiveClass: true,
    //     responsive: {
    //         0: {
    //             items: 1,
    //             nav: true,
    //         },
    //         300: {
    //             items: 1,
    //             nav: false,
    //             autoplay: true,
    //             mouseDrag:true,
    //             autoplayTimeout: 3000,
    //             autoplaySpeed: 2000,
    //         },
    //         1000: {
    //             items: 3,
    //             nav: false,
    //             mouseDrag:true,
    //             loop: true,
    //             autoplay: true,
    //             autoplayTimeout: 3000,
    //             autoplaySpeed: 2000,
    //         }
    //     }
    // });
    $("#h-carousel").owlCarousel({
        items: 3,
        singleItem: false,
        // margin:10,
        itemsScaleUp : true,
        slideSpeed: 500,
        autoPlay: 5000,
        stopOnHover: true
      });
})


// Control home navigation fixed scrolling mechanism
window.onscroll = function () { navfixedScroll() };
// Get the navbar
var navbar = document.getElementById("nav-bar");
// Get the offset position of the navbar
var sticky = navbar.offsetTop;
// Add the sticky class to the navbar when you reach its scroll position. Remove "sticky" when you leave the scroll position
function navfixedScroll() {
    if (window.pageYOffset >= sticky) {
        navbar.classList.add("sticky")
    } else {
        navbar.classList.remove("sticky");
    }
}
