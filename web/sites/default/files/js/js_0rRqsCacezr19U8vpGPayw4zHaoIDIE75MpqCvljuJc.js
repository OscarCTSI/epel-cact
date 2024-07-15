/**
 * @file
 * cact Custom Code of the javascript behaviour.
 */

'use strict';

(function ($) {
  Drupal.behaviors.cactTheme = {
    attach: function (context) {

      if($(".view-filters").children().length == 0){
        $(".view-filters").css('display','none');
      }

      initLanguagePicker();
      /**
       * Language picker initialization
       */
      function initLanguagePicker(){
        var picker = $('[id^=block-alternadordeidioma]').find('.links');

        picker.on('click', 'a', function(e){
          var link = $(this);
          e.stopPropagation();
          if(link.parents('li').hasClass('is-active')){
            e.preventDefault();
            picker.toggleClass('open');
          }
        });

        $(document).on('click.languagePicker', function(){
          picker.removeClass('open');
        });
      }

      $('.view-commerce-cart-form .views-row').each(function( index ) {
        var date = $(this).find('.wrapper-info .field-ticket-date');
        var age = $(this).find('.field--name-attribute-age');
        $(this).find('.wrapper-image-title .field--name-title').append(date);
        $(this).find('.field--name-title').once().wrapAll("<div class='wrapper-title-age'></div>");
        $(this).find('.wrapper-title-age').prepend(age);
      });

    }
  };
})(jQuery);
;
/**
 * @file
 * cact Custom Code of the javascript behaviour.
 */

 'use strict';

(function (Drupal, $) {
  $(document).ready(function () {

    // Variables.
    var footer_menu_link = $('.site-footer .main-menu-footer >.menu > li.menu-item--expanded');

    // Funtions.
    if ($(window).width() < 1170) {  

      footer_menu_link.each(function( index ) {
        $(this).find('> a').after('<span class="icon-arrow"></span>');
      });
  
      $( ".main-menu-footer .icon-arrow" ).click(function() {
        $(this).toggleClass('deploy');
        $(this).siblings('.menu').toggleClass('deploy');
      });

    }

  });
})(Drupal, jQuery);;
(function (Drupal, $) {
  $(document).ready(function(){
    $("#click-menu").click(function () {
      $('html,body').toggleClass('block-scroll');
      $('.menunav--burguer').toggleClass("open");
      $('.menu-links-mobile').toggleClass("open");

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

    });
    $(".menu-idioma .arrow").click(function () {
      $('.block-language-blocklanguage-interface').toggleClass('open');
      $('.arrow').toggleClass('rotate');

      // Hide cart block if it's visible
      if($('.block-commerce-cart .cart-block--contents').css("display") == 'block'){
        $('.block-commerce-cart .cart-block--contents').css('display','none');
      }
    });

  });
})(Drupal, jQuery);;
/**
 * @file
 * Custom Javascript for the resize menu behavior.
 */

 'use strict';

 (function (Drupal, $) {
 
    Drupal.behaviors.resizeElements = {
     attach: function (context, settings) {
         $(window).on('resize.resizeElements orientationchange', function () {
          if (window.matchMedia('(max-width: 1170px').matches) {
            $(".block-language-blocklanguage-interface").removeClass('open');
           } else {
            $("html,body").removeClass('block-scroll');
            $(".menunav--burguer").removeClass('open');
            $(".menu-links-mobile").removeClass('open');
            $(".block-language-blocklanguage-interface").removeClass('open');
           }
         });
         // Trigger the check for the windows width.
         $(window).trigger('resize.resizeElements');
 
     }
   };
 })(Drupal, jQuery);;
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
;
(function ($) {
  Drupal.behaviors.label = {
    attach: function (context, settings) {

      $('input, textarea').each(function() {

        $(this).on('focus', function() {
          if($(this).is("textarea")){
            $(this).parent().siblings('label').addClass('freeze');
          }else{
            $(this).siblings('label').addClass('freeze');
          }
        });

        $(this).on('blur', function() {
          if ($(this).val().length == 0) {
            if($(this).is("textarea")){
              $(this).parent().siblings('label').removeClass('freeze');
            }else {
              $(this).siblings('label').removeClass('freeze');
            }
          }
        });

        if ($(this).val() != ''){
          if($(this).is("textarea")){
            $(this).parent().siblings('label').addClass('freeze');
          }else {
            $(this).siblings('label').addClass('freeze');
          }
        }

      });
    }
  };
})(jQuery);
;
(function ($) {
  $( document ).ready(function() {

    // Variables.
    var $title_form = $('.commerce-checkout-flow-multistep-default .checkout-complete h4');

    // Hidden contact data in complete buy form
    $title_form.click(function() {
      $(this).toggleClass('arrow-up');
      $(this).siblings('.address').toggleClass('hidden-contact-data');
    });

  });
})(jQuery);;
(function ($) {
  Drupal.behaviors.myTable = {
    attach: function (context) {
    $('table').once('add Wrapper').each(function( index, element ) {
      $(this).wrapAll("<div class='wrapper-table'/>");
    });

    }
  };
})(jQuery);
;
