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
