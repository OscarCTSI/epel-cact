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
})(Drupal, jQuery);