jQuery(document).ready(function ($) {
    $('#twitter-feed').owlCarousel({
        loop: true,
        autoHeight: true,
        autoplay:true,
        nav: true,
        dots: false,
        navText: ['', ''],
        items: 1
    })

    $('.site-footer #twitter-feed').owlCarousel({
        loop: true,
        nav: true,
        autoplay:true,
        dots: false,
        navText: ['', ''],
        items: 1
    })
});
