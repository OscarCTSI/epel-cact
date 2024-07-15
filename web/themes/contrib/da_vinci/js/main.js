/**
 * @file
 * Da Vinci Custom Code of the javascript behaviour.
 */

(function ($, Drupal, once) {
  Drupal.behaviors.dvBehavior = {
    attach: function (context, settings) {


      $('.node__content').imagesLoaded()
        .always( function( instance ) {
          console.log('all images loaded');
        })
        .done( function( instance ) {
          console.log('all images successfully loaded');
        })
        .fail( function() {
          console.log('all images loaded, at least one is broken');
        })
        .progress( function( instance, image ) {
          var result = image.isLoaded ? 'loaded' : 'broken';
          console.log( 'image is ' + result + ' for ' + image.img.src );
      });


      once('dvBehavior', 'html', context).forEach(function (element) {
        // Apply the myCustomBehaviour effect to the elements only once.
      });


      $(window).on('resize.rwdElements orientationchange', function () {

        if (window.matchMedia('(max-width: 48.5rem)').matches) {

          // First add ID to the main menu.
          $('.region-header nav.navigation>ul.menu').attr('id', 'block-mainMenu');
          $('.region-header nav.navigation').attr('id', 'nav-desktop-main-menu');
          // Move the main menu together with its children.
          $('#block-mainMenu').appendTo('#sliding-panel .region-sliding-panel');
        } else {
          // Move back the lists into the desktop positions.
          $('#block-mainMenu').appendTo('#nav-desktop-main-menu');
        }
      });

      // Trigger the check for the windows width.
      $(window).trigger('resize.rwdElements');



    }
  };
})(jQuery, Drupal, once);
