/**
 * @file
 * Defines Javascript behaviors for the cact_module_analytics module.
 */

(function ($) {
  'use strict';

  $(function() {
    function postProductClick(productId, callback) {
      jQuery.ajax({
        type: "POST",
        data: {"product": productId},
        url: '/commerce_analytics/click',
        complete: function() {
          callback();
        }
      });
    }

    $('.products-view a').bind('click', function(e){
      e.preventDefault();
      let $this = $(this);
      let productId = $($this.closest('.views-row').find('.div-product-id')[0]).data('product-id');

      postProductClick(productId, ()=>{window.location.href = $this.attr('href');});

    });

  });
})(jQuery);
