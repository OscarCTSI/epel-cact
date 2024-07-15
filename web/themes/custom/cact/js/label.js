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
