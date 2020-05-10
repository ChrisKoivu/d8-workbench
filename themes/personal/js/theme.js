// Custom javascript for this theme

window.addEventListener('load', function () {
    function runSlideshow () {
        var $ = jQuery;
        $('.slideshow').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            autoplay: true,
            autoplaySpeed: 2000,
        }); 
    }

    (function ($) {
    //    runSlideshow ();
      // change size of navbar when scrolling down page
      $(window).on("scroll touchmove", function () {
          $('#block-personal-main-menu').toggleClass('tiny', $(document).scrollTop() > 0);
          $('.admin-view').toggleClass('shift', $(document).scrollTop() > 0);
      });
       

    })(jQuery);
}, false);