(function ($) {
  Drupal.behaviors.myTable = {
    attach: function (context) {
    $('table').once('add Wrapper').each(function( index, element ) {
      $(this).wrapAll("<div class='wrapper-table'/>");
    });

    }
  };
})(jQuery);
