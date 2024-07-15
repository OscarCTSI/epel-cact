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
})(Drupal, jQuery);