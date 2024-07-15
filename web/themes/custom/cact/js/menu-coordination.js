(function ($) {
  $( document ).ready(function() {

    var $topHeaderExists = false;
    //Check if we have a secondary menu
    if ($('.header').length ) {
      $topHeaderExists = true;
    }

    // Hide Header on scroll down
    var didScroll,
        lastScrollTop = 0,
        delta = 5,
        navbarHeight;

    if ($topHeaderExists) {
      navbarHeight = 112;
      $('body').addClass('has-top-header');
    }
    else {
      navbarHeight = 65;
    }

    function hasScrolled() {
      var st = $(window).scrollTop();

      // Make sure they scroll more than delta
      if(Math.abs(lastScrollTop - st) <= delta) {
        return;
      }

      // If they scrolled down and are past the navbar, add class .nav-up.
      // This is necessary so you never see what is "behind" the navbar.
      if (st > lastScrollTop && st > navbarHeight) {

        // Scroll Down
        $('.layout-container').removeClass('menu-hide-scroll').addClass('header-hide-scroll');
        
        // Hidden menu language if it's visible
        if($('#block-alternadordeidioma').hasClass('open')){
          $('#block-alternadordeidioma').removeClass('open');
        }
        if($('.menu-idioma .arrow').hasClass('rotate')){
          $('.menu-idioma .arrow').removeClass('rotate');
        }

        // Hide cart block if it's visible
        if($('.block-commerce-cart .cart-block--contents').css("display") == 'block'){
          $('.block-commerce-cart .cart-block--contents').css('display','none');
        }

      } else if (st < lastScrollTop && st > navbarHeight) {
        // Scroll Up
        $('.layout-container').addClass('menu-hide-scroll').removeClass('header-hide-scroll');

         // Hide menu language if it's visible
        if($('#block-alternadordeidioma').hasClass('open')){
          $('#block-alternadordeidioma').removeClass('open');
        }
        if($('.menu-idioma .arrow').hasClass('rotate')){
          $('.menu-idioma .arrow').removeClass('rotate');
        }

        // Hide cart block if it's visible
        if($('.block-commerce-cart .cart-block--contents').css("display") == 'block'){
          $('.block-commerce-cart .cart-block--contents').css('display','none');
        }


      } else {
        // Scroll Up Top
        if(st + $(window).height() < $(document).height()) {
          $('.layout-container').removeClass('header-hide-scroll menu-hide-scroll menu--open ');
        }
        
      }

      lastScrollTop = st;
    }

    $(window).scroll(function(event){
      didScroll = true;
    });

    setInterval(function() {
      if (didScroll) {
        hasScrolled();
        didScroll = false;
      }
    }, 250);

  });
})(jQuery);
