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
 })(Drupal, jQuery);