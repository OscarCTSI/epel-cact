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
})(jQuery);