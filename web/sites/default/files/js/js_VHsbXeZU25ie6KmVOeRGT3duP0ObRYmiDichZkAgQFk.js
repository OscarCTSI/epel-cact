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
/**
 * @file
 * Defines Javascript behaviors for the cookies module.
 */
(function (Drupal) {
  'use strict';

  /**
   * Define defaults.
   */
  Drupal.behaviors.cookiesFbPixel = {

    consentGiven: function () {
      var scriptIds = [
        'cookies_facebook_tracking_pixel_script',
        'facebook_tracking_pixel_script'
      ];
      for (var i in scriptIds) {
        var script = document.getElementById(scriptIds[i]);
        if (script) {
          var content = script.innerHTML;
          var newScript = document.createElement('script');
          var attributes = Array.from(script.attributes);
          for (var attr in attributes) {
            var name = attributes[attr].nodeName;
            if (name !== 'type' && name !== 'id') {
              newScript.setAttribute(name, attributes[attr].nodeValue);
            }
          }
          newScript.innerHTML = content;
          script.parentNode.replaceChild(newScript, script);

          // We have to call the attach() from facebook_pixel manually,
          // otherwise the script won't be initialized.
          // TODO: This isn't good but we have a timing issue here, the script might not be loaded yet:
          // @see https://www.drupal.org/project/cookies/issues/3274995#comment-14641051
          setTimeout(function(){
            if (typeof Drupal.behaviors.facebook_pixel.attach === 'function') {
              Drupal.behaviors.facebook_pixel.attach(document);
            }
          }, 2000);
        }
      }
    },

    attach: function (context) {
      var self = this;
      document.addEventListener('cookiesjsrUserConsent', function (event) {
        var service = (typeof event.detail.services === 'object') ? event.detail.services : {};
        if (typeof service.facebook_pixel !== 'undefined' && service.facebook_pixel) {
          self.consentGiven(context);
        }
      });
    }
  };
})(Drupal);
;
/**
 * @file
 * Defines Javascript behaviors for the cookies module.
 */
(function (Drupal) {
  'use strict';

  /**
   * Define defaults.
   */
  Drupal.behaviors.cookiesGa = {

    consentGiven: function () {
      var scriptIds = [
        'cookies_ga_ga',
        'cookies_ga_ga_debug',
        'cookies_ga_google_analytics_tracking_script',
        'cookies_ga_google_analytics_tracking_file',
      ];
      for (var scriptId in scriptIds) {
        var script = document.getElementById(scriptIds[scriptId]);
        if (script) {
          var content = script.innerHTML;
          var newScript = document.createElement('script');
          var attributes = Array.from(script.attributes);
          for (var attr in attributes) {
            var name = attributes[attr].nodeName;
            if (name !== 'type' && name !== 'id') {
              newScript.setAttribute(name, attributes[attr].nodeValue);
            }
          }
          newScript.innerHTML = content;
          script.parentNode.replaceChild(newScript, script);
        }
      }
    },

    attach: function (context) {
      var self = this;
      document.addEventListener('cookiesjsrUserConsent', function (event) {
        var service = (typeof event.detail.services === 'object') ? event.detail.services : {};
        if (typeof service.analytics !== 'undefined' && service.analytics) {
          self.consentGiven(context);
        }
      });
    }
  };
})(Drupal);
;
/**
 * @file
 * Defines Javascript behaviors for the cookies module.
 */;

(function (Drupal) {
  'use strict';

  /**
   * Define defaults.
   */
  Drupal.behaviors.cookiesGtag = {

    consentGiven: function () {
      var scriptIds = [
        'cookies_gtag_gtag',
        'cookies_gtag_gtag_ajax',
        'cookies_gtag_gtm'
      ];
      for (var scriptId in scriptIds) {
        var script = document.getElementById(scriptIds[scriptId]);
        if (script) {
          var content = script.innerHTML;
          var newScript = document.createElement('script');
          var attributes = Array.from(script.attributes);
          for (var attr in attributes) {
            var name = attributes[attr].nodeName;
            if (name !== 'type' && name !== 'id') {
              newScript.setAttribute(name, attributes[attr].nodeValue);
            }
          }
          newScript.innerHTML = content;
          script.parentNode.replaceChild(newScript, script);
        }
      }
    },

    attach: function (context) {
      var self = this;
      document.addEventListener('cookiesjsrUserConsent', function (event) {
        var service = (typeof event.detail.services === 'object') ? event.detail.services : {};
        if (typeof service.gtag !== 'undefined' && service.gtag) {
          self.consentGiven(context);
        }
      });
    }
  };
})(Drupal);
;
/**
 * @todo Remove code if IE11 not supported anymore.
 * Polyfill for CustomEvent constructor. Required for IE9-11.
 * https://developer.mozilla.org/en-US/docs/Web/API/CustomEvent/CustomEvent#Polyfill
 */

(function () {
  if (typeof window.CustomEvent === "function") return false;
  function CustomEvent(event, params) {
    params = params || { bubbles: false, cancelable: false, detail: null };
    var evt = document.createEvent('CustomEvent');
    evt.initCustomEvent(event, params.bubbles, params.cancelable, params.detail);
    return evt;
  }
  window.CustomEvent = CustomEvent;
})();

(function (Drupal, $, drupalSettings) {
  function ucfirst(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
  }

  $.fn.extend({
    cookiesOverlay: function (serviceId) {
      return this.each(function () {
        // Define default classes.
        var classStr = 'cookies-fallback';
        var baseStr = classStr + '--' + serviceId;
        var classes = [classStr, baseStr];
        // Define basic elements.
        var $element = $(this);
        var $elementWrapper = $element.parent();
        if (!($element.parent().hasClass(baseStr + '--wrap'))) {
          // Create and get the wrapper element. Caution, wrap returns the original set of elements:
          $elementWrapper = $element.wrapAll("<div />").parent().addClass(baseStr + '--wrap');
        }
        if ($element.data('status') !== 'fallback') {
          $element.data('status', 'fallback').addClass(classStr + '--element');
          var $fallback = $('<div />').addClass(classes.join(' '));
          $fallback.addClass(baseStr + '--overlay')
          // Create text box.
          var $textbox = $('<div />').addClass('cookies-fallback--text');
          $textbox.text(drupalSettings.cookies.services[serviceId].placeholderMainText);

          // Create Button to only accept current service (e.g. video only)
          var $button = $('<button />').addClass(baseStr + '--btn ' + classStr + '--btn');
          $button.text(drupalSettings.cookies.services[serviceId].placeholderAcceptText);

          // Add link behaviors: Dispatch Event, Remove class disabled from wrapper, set element status active.
          $button.on('click', function (event) {
            event.preventDefault();
            var services = {};
            services[serviceId] = true;
            document.dispatchEvent(new CustomEvent('cookiesjsrSetService', { detail: { services } }));
          });

          // Create link to accept all cookies for all services
          var $acceptLink = $('<a href="#cookiesjsrAccept"/>').addClass(classStr + '--link');
          $acceptLink.text(drupalSettings.cookies.cookiesTexts.placeholderAcceptAllText);
          // Add link behaviors: Dispatch Event, Remove class disabled from wrapper, set element status active.
          $acceptLink.on('click', function (event) {
            event.preventDefault();
            document.dispatchEvent(new CustomEvent('cookiesjsrSetService', { detail: { all: true } }));
          });

          // Remove fallback overlay when service becomes enabled.
          document.addEventListener('cookiesjsrUserConsent', function (event) {
            var service = (typeof event.detail.services === 'object') ? event.detail.services : {};
            if (typeof service[serviceId] !== 'undefined' && service[serviceId]) {
              var $wrapper = $element.parent('.' + baseStr + '--wrap');
              $element.data('status', 'active');
              // remove wrapper and overlay:
              $wrapper.after($element);
              $wrapper.remove();
            }
          })

          // Build overlay.
          $fallback.append($textbox);
          $fallback.append($button);
          $fallback.append($acceptLink);
          // Put overlay to page.
          $elementWrapper.append($fallback);
        }
        if (!$elementWrapper.is('.disabled')) {
          var wrapperClasses = classes.map(function (c) { return c + '--wrap' });
          wrapperClasses.push('disabled');
          $elementWrapper.addClass(wrapperClasses.join(' '));
        }
      });
    },
    // @todo This is currently only used for "cookies_filter". As a
    // cookies_filter does not have custom "placeholderMainText" nor a
    // custom "placeholderAcceptText", this should be resolved in the future!
    cookiesLegacyOverlay: function (serviceName) {
      return this.each(function () {
        // Define default classes.
        var classStr = 'cookies-fallback';
        var baseStr = classStr + '--' + serviceName;
        var classes = [classStr, baseStr];
        // Define basic elements.
        var $element = $(this);
        var $elementWrapper = $element.parent();
        if (!($element.parent().hasClass(baseStr + '--wrap'))) {
          // Create and get the wrapper element. Caution, wrap returns the original set of elements:
          $elementWrapper = $element.wrapAll("<div />").parent().addClass(baseStr + '--wrap');
        }
        if ($element.data('status') !== 'fallback') {
          $element.data('status', 'fallback').addClass(classStr + '--element');
          var $fallback = $('<div />').addClass(classes.join(' '));
          $fallback.addClass(baseStr + '--overlay')
          // Create text box.
          var $textbox = $('<div />').addClass('cookies-fallback--text');
          $textbox.text(Drupal.t('This content is blocked because @service cookies have not been accepted.',
            { '@service': ucfirst(serviceName) }));
          // Create Button.
          var $button = $('<button />').addClass(baseStr + '--btn ' + classStr + '--btn');
          $button.text(drupalSettings.cookies.cookiesTexts.placeholderAcceptAllText);

          // Add link behaviors: Dispatch Event, Remove class disabled from wrapper, set element status active.
          $button.on('click', function (event) {
            event.preventDefault();
            document.dispatchEvent(new CustomEvent('cookiesjsrSetService', { detail: { all: true } }));
          });

          // Create link.
          var $acceptLink = $('<a href="#cookiesjsrAccept"/>').addClass(classStr + '--link');
          $acceptLink.text(Drupal.t('Only accept @service cookies', { '@service': ucfirst(serviceName) }));
          // Add link behaviors: Dispatch Event, Remove class disabled from wrapper, set element status active.
          $acceptLink.on('click', function (event) {
            event.preventDefault();
            var services = {};
            services[serviceName] = true;
            document.dispatchEvent(new CustomEvent('cookiesjsrSetService', { detail: { services } }));
          });

          // Remove fallback overlay when service becomes enabled.
          document.addEventListener('cookiesjsrUserConsent', function (event) {
            var service = (typeof event.detail.services === 'object') ? event.detail.services : {};
            if (typeof service[serviceName] !== 'undefined' && service[serviceName]) {
              var $wrapper = $element.parent('.' + baseStr + '--wrap');
              $element.data('status', 'active');
              // remove wrapper and overlay:
              $wrapper.after($element);
              $wrapper.remove();
            }
          })

          // Build overlay.
          $fallback.append($textbox);
          $fallback.append($button);
          $fallback.append($acceptLink);
          // Put overlay to page.
          $elementWrapper.append($fallback);
        }
        if (!$elementWrapper.is('.disabled')) {
          var wrapperClasses = classes.map(function (c) { return c + '--wrap' });
          wrapperClasses.push('disabled');
          $elementWrapper.addClass(wrapperClasses.join(' '));
        }
      });
    }
  });
}

)(Drupal, jQuery, drupalSettings);
;
/**
 * @file
 * Defines Javascript behaviors for the cookies module.
 */
(function (Drupal, $) {
  'use strict';

  /**
   * Define defaults.
   */
  Drupal.behaviors.cookiesInstagram = {

    id: 'instagram',

    consentGiven: function () {
      // Activate scripts in correct order to regard dependencies.
      var i = 0;
      var progress = true;
      while (i < 10 && progress) {
        var id = 'cookies_instagram_' + i;
        var script = document.getElementById(id);
        progress = (script !== null);
        if (progress) {
          // Create new script element to alter the old.
          var src = script.getAttribute('src');
          var newScript = document.createElement('script');
          newScript.setAttribute('id', id);
          if (src) {
            newScript.setAttribute('src', src);
          }
          else {
            newScript.innerHTML = script.innerHTML;
          }
          // Replace script.
          script.parentNode.replaceChild(newScript, script);
        }
        i++;
      }
    },

    consentDenied: function (context) {
      $('.instagram-media', context).cookiesOverlay('instagram');
    },


    attach: function (context) {
      var self = this;
      document.addEventListener('cookiesjsrUserConsent', function (event) {
        var service = (typeof event.detail.services === 'object') ? event.detail.services : {};
        if (typeof service[self.id] !== 'undefined' && service[self.id]) {
          self.consentGiven(context);
        } else {
          self.consentDenied(context);
        }
      });
    }
  };
})(Drupal, jQuery);
;
/**
 * @file
 * Defines Javascript behaviors for the cookies module.
 */
(function (Drupal, $) {
  'use strict';

  /**
   * Define defaults.
   */
  Drupal.behaviors.cookiesTwitter = {
    initTwitter: {},

    consentGiven: function (context) {
      var $twttrMedia = $('.media--type-twitter', context);
      $twttrMedia.data('status', 'active').removeClass('disabled');
      if (typeof Drupal.behaviors.cookiesTwitter.initTwitter.attach === 'function') {
        Drupal.behaviors.cookiesTwitter.initTwitter.attach();
      }
      if ($twttrMedia.length) {
        var newScript = document.createElement('script');
        newScript.setAttribute('src', '//platform.twitter.com/widgets.js');
        document.body.appendChild(newScript);
      }
    },

    consentDenied: function (context) {
      $('blockquote.twitter-tweet', context).cookiesOverlay('twitter');
    },

    attach: function (context) {
      var self = this;
      if (Drupal.behaviors.hasOwnProperty('twitterMediaEntity')) {
        // Take over the init function and remove it from the original context.
        if (typeof Drupal.behaviors.twitterMediaEntity.attach === 'function') {
          self.initTwitter['attach'] = Drupal.behaviors.twitterMediaEntity.attach;
          self.initTwitter.attach.bind(self.initTwitter);
          Drupal.behaviors.twitterMediaEntity.attach = null;
        }
      }

      document.addEventListener('cookiesjsrUserConsent', function(event) {
        var service = (typeof event.detail.services === 'object') ? event.detail.services : {};
        if (typeof service.twitter !== 'undefined' && service.twitter) {
          self.consentGiven(context);
        } else {
          self.consentDenied(context);
        }
      });
    }
  };
})(Drupal, jQuery);
;
/**
 * @file
 * Defines Javascript behaviors for the cookies module.
 */
(function (Drupal) {
  'use strict';

  /**
   * Define defaults.
   */
  Drupal.behaviors.consentHandler = {
    consentGiven: function (context, settings, serviceId) {
      var blockedAssetsObj = drupalSettings.cookies.cookies_asset_injector.blocked_assets;
      var consentedBlockedAssets = blockedAssetsObj[serviceId];
      if (consentedBlockedAssets) {
        // This service has been unblocked. Unblock asset_injector scripts:
        for (var i in consentedBlockedAssets) {
          if (Object.prototype.hasOwnProperty.call(consentedBlockedAssets, i) && consentedBlockedAssets[i]) {
            var blockedAsset = consentedBlockedAssets[i];
            var scriptId = blockedAsset.script_dom_id;
            var script = document.getElementById(scriptId);
            if (script) {
              var content = script.innerHTML;
              var newScript = document.createElement('script');
              var attributes = Array.from(script.attributes);
              for (var attr in attributes) {
                if (Object.prototype.hasOwnProperty.call(attributes, attr) && attributes[attr]) {
                  var name = attributes[attr].nodeName;
                  if (name !== 'type' && name !== 'id') {
                    newScript.setAttribute(name, attributes[attr].nodeValue);
                  }
                }
              }
              newScript.innerHTML = content;
              script.parentNode.replaceChild(newScript, script);
            }
          }
        }
      }
    },

    consentDenied: function (context, settings, serviceId) {
      // Nothing to do here.
    },

    attach: function (context, settings) {
      var self = this;
      document.addEventListener('cookiesjsrUserConsent', function (event) {
        var services = (typeof event.detail.services === 'object') ? event.detail.services : {};
        for (var serviceId in services) {
          if (Object.prototype.hasOwnProperty.call(services, serviceId)) {
            var consentGiven = services[serviceId];
            if (consentGiven) {
              self.consentGiven(context, settings, serviceId);
            }
            else {
              self.consentDenied(context, settings, serviceId);
            }
          }
        }
      });
    }
  };
})(Drupal, drupalSettings);
;
/**
 * @file
 * Attaches behaviors for the zipang captcha refresh module.
 */

(function ($) {
  "use strict";

  /**
   * Attaches jQuery validate behavior to forms.
   *
   * @type {Drupal~behavior}
   *
   * @prop {Drupal~behaviorAttach} attach
   *  Attaches the outline behavior to the right context.
   */
  Drupal.behaviors.CaptchaRefresh = {
    attach: function (context) {
      $('.reload-captcha', context).not('.processed').bind('click', function () {
        $(this).addClass('processed');
        const $form = $(this).parents('form');
        // Send post query for getting new captcha data.
        const date = new Date();
        const baseUrl = document.location.origin;
        const url = baseUrl.replace(/\/$/g, '') + '/' + $(this).attr('href').replace(/^\//g, '') + '?' + date.getTime();
        // Adding loader.
        $('.captcha').addClass('captcha--loading');
        $.get(
          url,
          {},
          function (response) {
            if (response.status === 1) {
              $('.captcha', $form).find('img').attr('src', response.data.url);
              $('input[name=captcha_sid]', $form).val(response.data.sid);
              $('input[name=captcha_token]', $form).val(response.data.token);
              $('.captcha').removeClass('captcha--loading');
            }
            else {
              alert(response.message);
            }
          },
          'json'
        );
        return false;
      });
    }
  };
})(jQuery);
;
/*
 * Superfish v1.4.8 - jQuery menu widget
 * Copyright (c) 2008 Joel Birch
 *
 * Dual licensed under the MIT and GPL licenses:
 *  http://www.opensource.org/licenses/mit-license.php
 *  http://www.gnu.org/licenses/gpl.html
 *
 * CHANGELOG: http://users.tpg.com.au/j_birch/plugins/superfish/changelog.txt
 */
/*
 * This is not the original jQuery Superfish plugin.
 * Please refer to the README for more information.
 */

(function($){
  $.fn.superfish = function(op){
    var sf = $.fn.superfish,
      c = sf.c,
      $arrow = $(['<span class="',c.arrowClass,'"> &#187;</span>'].join('')),
      over = function(){
        var $$ = $(this), menu = getMenu($$);
        clearTimeout(menu.sfTimer);
        $$.showSuperfishUl().siblings().hideSuperfishUl();
      },
      out = function(){
        var $$ = $(this), menu = getMenu($$), o = sf.op;
        clearTimeout(menu.sfTimer);
        menu.sfTimer=setTimeout(function(){
          if ($$.children('.sf-clicked').length == 0){
            o.retainPath=($.inArray($$[0],o.$path)>-1);
            $$.hideSuperfishUl();
            if (o.$path.length && $$.parents(['li.',o.hoverClass].join('')).length<1){over.call(o.$path);}
          }
        },o.delay);
      },
      getMenu = function($menu){
        var menu = $menu.parents(['ul.',c.menuClass,':first'].join(''))[0];
        sf.op = sf.o[menu.serial];
        return menu;
      },
      addArrow = function($a){ $a.addClass(c.anchorClass).append($arrow.clone()); };

    return this.each(function() {
      var s = this.serial = sf.o.length;
      var o = $.extend({},sf.defaults,op);
      o.$path = $('li.'+o.pathClass,this).slice(0,o.pathLevels);
      var p = o.$path;
      for (var l = 0; l < p.length; l++){
        p.eq(l).addClass([o.hoverClass,c.bcClass].join(' ')).filter('li:has(ul)').removeClass(o.pathClass);
      }
      sf.o[s] = sf.op = o;

      $('li:has(ul)',this)[($.fn.hoverIntent && !o.disableHI) ? 'hoverIntent' : 'hover'](over,out).each(function() {
        if (o.autoArrows) addArrow( $(this).children('a:first-child, span.nolink:first-child') );
      })
      .not('.'+c.bcClass)
        .hideSuperfishUl();

      var $a = $('a, span.nolink',this);
      $a.each(function(i){
        var $li = $a.eq(i).parents('li');
        $a.eq(i).focus(function(){over.call($li);}).blur(function(){out.call($li);});
      });
      o.onInit.call(this);

    }).each(function() {
      var menuClasses = [c.menuClass];
      if (sf.op.dropShadows){
        menuClasses.push(c.shadowClass);
      }
      $(this).addClass(menuClasses.join(' '));
    });
  };

  var sf = $.fn.superfish;
  sf.o = [];
  sf.op = {};

  sf.c = {
    bcClass: 'sf-breadcrumb',
    menuClass: 'sf-js-enabled',
    anchorClass: 'sf-with-ul',
    arrowClass: 'sf-sub-indicator',
    shadowClass: 'sf-shadow'
  };
  sf.defaults = {
    hoverClass: 'sfHover',
    pathClass: 'overideThisToUse',
    pathLevels: 1,
    delay: 800,
    animation: {opacity:'show'},
    speed: 'fast',
    autoArrows: true,
    dropShadows: true,
    disableHI: false, // true disables hoverIntent detection
    onInit: function(){}, // callback functions
    onBeforeShow: function(){},
    onShow: function(){},
    onHide: function(){}
  };
  $.fn.extend({
    hideSuperfishUl : function(){
      var o = sf.op,
        not = (o.retainPath===true) ? o.$path : '';
      o.retainPath = false;
      var $ul = $(['li.',o.hoverClass].join(''),this).add(this).not(not).removeClass(o.hoverClass)
          .children('ul').addClass('sf-hidden');
      o.onHide.call($ul);
      return this;
    },
    showSuperfishUl : function(){
      var o = sf.op,
        sh = sf.c.shadowClass+'-off',
        $ul = this.addClass(o.hoverClass)
          .children('ul.sf-hidden').hide().removeClass('sf-hidden');
      o.onBeforeShow.call($ul);
      $ul.animate(o.animation,o.speed,function(){ o.onShow.call($ul); });
      return this;
    }
  });
})(jQuery);;
/*!
 * hoverIntent v1.10.1 // 2019.10.05 // jQuery v1.7.0+
 * http://briancherne.github.io/jquery-hoverIntent/
 *
 * You may use hoverIntent under the terms of the MIT license. Basically that
 * means you are free to use hoverIntent as long as this header is left intact.
 * Copyright 2007-2019 Brian Cherne
 */
!function(factory){"use strict";"function"==typeof define&&define.amd?define(["jquery"],factory):"object"==typeof module&&module.exports?module.exports=factory(require("jquery")):jQuery&&!jQuery.fn.hoverIntent&&factory(jQuery)}(function($){"use strict";function track(ev){cX=ev.pageX,cY=ev.pageY}var cX,cY,_cfg={interval:100,sensitivity:6,timeout:0},INSTANCE_COUNT=0,compare=function(ev,$el,s,cfg){if(Math.sqrt((s.pX-cX)*(s.pX-cX)+(s.pY-cY)*(s.pY-cY))<cfg.sensitivity)return $el.off(s.event,track),delete s.timeoutId,s.isActive=!0,ev.pageX=cX,ev.pageY=cY,delete s.pX,delete s.pY,cfg.over.apply($el[0],[ev]);s.pX=cX,s.pY=cY,s.timeoutId=setTimeout(function(){compare(ev,$el,s,cfg)},cfg.interval)};$.fn.hoverIntent=function(handlerIn,handlerOut,selector){var instanceId=INSTANCE_COUNT++,cfg=$.extend({},_cfg);$.isPlainObject(handlerIn)?(cfg=$.extend(cfg,handlerIn),$.isFunction(cfg.out)||(cfg.out=cfg.over)):cfg=$.isFunction(handlerOut)?$.extend(cfg,{over:handlerIn,out:handlerOut,selector:selector}):$.extend(cfg,{over:handlerIn,out:handlerIn,selector:handlerOut});function handleHover(e){var ev=$.extend({},e),$el=$(this),hoverIntentData=$el.data("hoverIntent");hoverIntentData||$el.data("hoverIntent",hoverIntentData={});var state=hoverIntentData[instanceId];state||(hoverIntentData[instanceId]=state={id:instanceId}),state.timeoutId&&(state.timeoutId=clearTimeout(state.timeoutId));var mousemove=state.event="mousemove.hoverIntent.hoverIntent"+instanceId;if("mouseenter"===e.type){if(state.isActive)return;state.pX=ev.pageX,state.pY=ev.pageY,$el.off(mousemove,track).on(mousemove,track),state.timeoutId=setTimeout(function(){compare(ev,$el,state,cfg)},cfg.interval)}else{if(!state.isActive)return;$el.off(mousemove,track),state.timeoutId=setTimeout(function(){!function(ev,$el,s,out){var data=$el.data("hoverIntent");data&&delete data[s.id],out.apply($el[0],[ev])}(ev,$el,state,cfg.out)},cfg.timeout)}}return this.on({"mouseenter.hoverIntent":handleHover,"mouseleave.hoverIntent":handleHover},cfg.selector)}});;
/*
 * sf-Smallscreen v1.3b - Provides small-screen compatibility for the jQuery Superfish plugin.
 *
 * Developer's note:
 * Built as a part of the Superfish project for Drupal (http://drupal.org/project/superfish)
 * Found any bug? have any cool ideas? contact me right away! http://drupal.org/user/619294/contact
 *
 * jQuery version: 1.3.x or higher.
 *
 * Dual licensed under the MIT and GPL licenses:
 *  http://www.opensource.org/licenses/mit-license.php
 *  http://www.gnu.org/licenses/gpl.html
  */

(function($){
  $.fn.sfsmallscreen = function(options){
    options = $.extend({
      mode: 'inactive',
      type: 'accordion',
      breakpoint: 768,
      breakpointUnit: 'px',
      useragent: '',
      title: '',
      addSelected: false,
      menuClasses: false,
      hyperlinkClasses: false,
      excludeClass_menu: '',
      excludeClass_hyperlink: '',
      includeClass_menu: '',
      includeClass_hyperlink: '',
      accordionButton: 1,
      expandText: 'Expand',
      collapseText: 'Collapse'
    }, options);

    // We need to clean up the menu from anything unnecessary.
    function refine(menu){
      var
      refined = menu.clone(),
      // Things that should not be in the small-screen menus.
      rm = refined.find('span.sf-sub-indicator'),
      // This is a helper class for those who need to add extra markup that shouldn't exist
      // in the small-screen versions.
      rh = refined.find('.sf-smallscreen-remove'),
      // Mega-menus has to be removed too.
      mm = refined.find('ul.sf-multicolumn');
      for (var a = 0; a < rh.length; a++){
        rh.eq(a).replaceWith(rh.eq(a).html());
      }
      if (options.accordionButton == 2 || options.type == 'select'){
        for (var b = 0; b < rm.length; b++){
          rm.eq(b).remove();
        }
      }
      if (mm.length > 0){
        mm.removeClass('sf-multicolumn');
        var ol = refined.find('div.sf-multicolumn-column > ol');
        for (var o = 0; o < ol.length; o++){
          ol.eq(o).replaceWith('<ul>' + ol.eq(o).html() + '</ul>');
        }
        var elements = ['div.sf-multicolumn-column','.sf-multicolumn-wrapper > ol','li.sf-multicolumn-wrapper'];
        for (var i = 0; i < elements.length; i++){
          obj = refined.find(elements[i]);
          for (var t = 0; t < obj.length; t++){
            obj.eq(t).replaceWith(obj.eq(t).html());
          }
        }
        refined.find('.sf-multicolumn-column').removeClass('sf-multicolumn-column');
      }
      refined.add(refined.find('*')).css({width:''});
      return refined;
    }

    // Creating <option> elements out of the menu.
    function toSelect(menu, level){
      var
      items = '',
      childLI = $(menu).children('li');
      for (var a = 0; a < childLI.length; a++){
        var list = childLI.eq(a), parent = list.children('a, span');
        for (var b = 0; b < parent.length; b++){
          var
          item = parent.eq(b),
          path = (item.is('a') && !!item.attr('href')) ? item.attr('href') : '',
          // Class names modification.
          itemClone = item.clone(),
          classes = (options.hyperlinkClasses) ? ((options.excludeClass_hyperlink && itemClone.hasClass(options.excludeClass_hyperlink)) ? itemClone.removeClass(options.excludeClass_hyperlink).attr('class') : itemClone.attr('class')) : '',
          classes = (options.includeClass_hyperlink && !itemClone.hasClass(options.includeClass_hyperlink)) ? ((options.hyperlinkClasses) ? itemClone.addClass(options.includeClass_hyperlink).attr('class') : options.includeClass_hyperlink) : classes;
          // Retaining the active class if requested.
          if (options.addSelected && item.hasClass('active')){
            classes += ' active';
          }
          classes = (classes) ? ' class="' + classes + '"' : '';
          // <option> has to be disabled if the item is not a link.
          disable = (path == '') || (path == '#') ? ' disabled="disabled"' : '',
          // Crystal clear.
          subIndicator = 1 < level ? Array(level).join('-') + ' ' : '';
          // Preparing the <option> element.
          items += '<option value="' + path + '"' + classes + disable + '>' + subIndicator + $.trim(item.text()) +'</option>',
          childUL = list.find('> ul');
          // Using the function for the sub-menu of this item.
          for (var u = 0; u < childUL.length; u++){
            items += toSelect(childUL.eq(u), level + 1);
          }
        }
      }
      return items;
    }

    // Create the new version, hide the original.
    function convert(menu){
      var menuID = menu.attr('id'),
      // Creating a refined version of the menu.
      refinedMenu = refine(menu);
      // Currently the plugin provides two reactions to small screens.
      // Converting the menu to a <select> element, and converting to an accordion version of the menu.
      if (options.type == 'accordion'){
        var
        toggleID = menuID + '-toggle',
        accordionID = menuID + '-accordion';
        // Making sure the accordion does not exist.
        if ($('#' + accordionID).length == 0){
          var
          // Getting the style class.
          styleClass = menu.attr('class').split(' ').filter(function(item){
            return item.indexOf('sf-style-') > -1 ? item : '';
          }),
          // Creating the accordion.
          accordion = $(refinedMenu).attr('id', accordionID);
          // Removing unnecessary classes.
          accordion.removeClass('sf-horizontal sf-vertical sf-navbar sf-shadow sf-js-enabled');
          // Adding necessary classes.
          accordion.addClass('sf-accordion sf-hidden');
          // Removing style attributes and any unnecessary class.
          accordion.find('li').each(function(){
            $(this).removeAttr('style').removeClass('sfHover').attr('id', $(this).attr('id') + '-accordion');
          });
          // Doing the same and making sure all the sub-menus are off-screen (hidden).
          accordion.children('ul').removeAttr('style').not('.sf-hidden').addClass('sf-hidden');
          // Creating the accordion toggle switch.
          var toggle = '<div class="sf-accordion-toggle ' + styleClass + '"><a href="#" id="' + toggleID + '"><span>' + options.title + '</span></a></div>';

          // Adding Expand\Collapse buttons if requested.
          if (options.accordionButton == 2){
            accordion.addClass('sf-accordion-with-buttons');
            var parent = accordion.find('li.menuparent');
            for (var i = 0; i < parent.length; i++){
              parent.eq(i).prepend('<a href="#" class="sf-accordion-button">' + options.expandText + '</a>');
            }
          }
          // Inserting the according and hiding the original menu.
          menu.before(toggle).before(accordion).hide();

          var
          accordionElement = $('#' + accordionID),
          // Deciding what should be used as accordion buttons.
          buttonElement = (options.accordionButton < 2) ? 'a.menuparent,span.nolink.menuparent' : 'a.sf-accordion-button',
          button = accordionElement.find(buttonElement);

          // Attaching a click event to the toggle switch.
          $('#' + toggleID).on('click', function(e){
            // Preventing the click.
            e.preventDefault();
            // Adding the sf-expanded class.
            $(this).toggleClass('sf-expanded');

            if (accordionElement.hasClass('sf-expanded')){
              // If the accordion is already expanded:
              // Hiding its expanded sub-menus and then the accordion itself as well.
              accordionElement.add(accordionElement.find('li.sf-expanded')).removeClass('sf-expanded')
              .end().children('ul').hide()
              // This is a bit tricky, it's the same trick that has been in use in the main plugin for some time.
              // Basically we'll add a class that keeps the sub-menu off-screen and still visible,
              // and make it invisible and removing the class one moment before showing or hiding it.
              // This helps screen reader software access all the menu items.
              .end().hide().addClass('sf-hidden').show();
              // Changing the caption of any existing accordion buttons to 'Expand'.
              if (options.accordionButton == 2){
                accordionElement.find('a.sf-accordion-button').text(options.expandText);
              }
            }
            else {
              // But if it's collapsed,
              accordionElement.addClass('sf-expanded').hide().removeClass('sf-hidden').show();
            }
          });

          // Attaching a click event to the buttons.
          button.on('click', function(e){
            // Making sure the buttons does not exist already.
            if ($(this).closest('li').children('ul').length > 0){
              e.preventDefault();
              // Selecting the parent menu items.
              var parent = $(this).closest('li');
              // Creating and inserting Expand\Collapse buttons to the parent menu items,
              // of course only if not already happened.
              if (options.accordionButton == 1 && parent.children('a.menuparent,span.nolink.menuparent').length > 0 && parent.children('ul').children('li.sf-clone-parent').length == 0){
                var
                // Cloning the hyperlink of the parent menu item.
                cloneLink = parent.children('a.menuparent').clone();
                // Removing unnecessary classes and element(s).
                cloneLink.removeClass('menuparent sf-with-ul').children('.sf-sub-indicator').remove();
                // Wrapping the hyerplinks in <li>.
                cloneLink = $('<li class="sf-clone-parent" />').html(cloneLink);
                // Adding a helper class and attaching them to the sub-menus.
                parent.children('ul').addClass('sf-has-clone-parent').prepend(cloneLink);
              }
              // Once the button is clicked, collapse the sub-menu if it's expanded.
              if (parent.hasClass('sf-expanded')){
                parent.children('ul').slideUp('fast', function(){
                  // Doing the accessibility trick after hiding the sub-menu.
                  $(this).closest('li').removeClass('sf-expanded').end().addClass('sf-hidden').show();
                });
                // Changing the caption of the inserted Collapse link to 'Expand', if any is inserted.
                if (options.accordionButton == 2 && parent.children('.sf-accordion-button').length > 0){
                  parent.children('.sf-accordion-button').text(options.expandText);
                }
              }
              // Otherwise, expand the sub-menu.
              else {
                // Doing the accessibility trick and then showing the sub-menu.
                parent.children('ul').hide().removeClass('sf-hidden').slideDown('fast')
                // Changing the caption of the inserted Expand link to 'Collape', if any is inserted.
                .end().addClass('sf-expanded').children('a.sf-accordion-button').text(options.collapseText)
                // Hiding any expanded sub-menu of the same level.
                .end().siblings('li.sf-expanded').children('ul')
                .slideUp('fast', function(){
                  // Doing the accessibility trick after hiding it.
                  $(this).closest('li').removeClass('sf-expanded').end().addClass('sf-hidden').show();
                })
                // Assuming Expand\Collapse buttons do exist, resetting captions, in those hidden sub-menus.
                .parent().children('a.sf-accordion-button').text(options.expandText);
              }
            }
          });
        }
      }
      else {
        var
        // Class names modification.
        menuClone = menu.clone(), classes = (options.menuClasses) ? ((options.excludeClass_menu && menuClone.hasClass(options.excludeClass_menu)) ? menuClone.removeClass(options.excludeClass_menu).attr('class') : menuClone.attr('class')) : '',
        classes = (options.includeClass_menu && !menuClone.hasClass(options.includeClass_menu)) ? ((options.menuClasses) ? menuClone.addClass(options.includeClass_menu).attr('class') : options.includeClass_menu) : classes,
        classes = (classes) ? ' class="' + classes + '"' : '';

        // Making sure the <select> element does not exist already.
        if ($('#' + menuID + '-select').length == 0){
          // Creating the <option> elements.
          var newMenu = toSelect(refinedMenu, 1),
          // Creating the <select> element and assigning an ID and class name.
          selectList = $('<select' + classes + ' id="' + menuID + '-select"/>')
          // Attaching the title and the items to the <select> element.
          .html('<option>' + options.title + '</option>' + newMenu)
          // Attaching an event then.
          .change(function(){
            // Except for the first option that is the menu title and not a real menu item.
            if ($('option:selected', this).index()){
              window.location = selectList.val();
            }
          });
          // Applying the addSelected option to it.
          if (options.addSelected){
            selectList.find('.active').attr('selected', !0);
          }
          // Finally inserting the <select> element into the document then hiding the original menu.
          menu.before(selectList).hide();
        }
      }
    }

    // Turn everything back to normal.
    function turnBack(menu){
      var
      id = '#' + menu.attr('id');
      // Removing the small screen version.
      $(id + '-' + options.type).remove();
      // Removing the accordion toggle switch as well.
      if (options.type == 'accordion'){
        $(id + '-toggle').parent('div').remove();
      }
      // Remove inline CSS display property; less clear than simply using .show(), but respects stylesheet
      $(id).css('display', '');
    }

    // Return original object to support chaining.
    // Although this is unnecessary because of the way the module uses these plugins.
    for (var s = 0; s < this.length; s++){
      var
      menu = $(this).eq(s),
      mode = options.mode;
      // The rest is crystal clear, isn't it? :)
      if (menu.children('li').length == 0){
        // Skip empty menu which will not be visible and don't want to suddenly make it visible.
      }
      else if (mode == 'always_active'){
        convert(menu);
      }
      else if (mode == 'window_width'){
        var breakpoint = (options.breakpointUnit == 'em') ? (options.breakpoint * parseFloat($('body').css('font-size'))) : options.breakpoint,
        windowWidth = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth,
        timer;
        if ((typeof Modernizr === 'undefined' || typeof Modernizr.mq !== 'function') && windowWidth < breakpoint){
          convert(menu);
        }
        else if (typeof Modernizr !== 'undefined' && typeof Modernizr.mq === 'function' && Modernizr.mq('(max-width:' + (breakpoint - 1) + 'px)')) {
          convert(menu);
        }
        $(window).resize(function(){
          clearTimeout(timer);
          timer = setTimeout(function(){
            var windowWidth = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;
            if ((typeof Modernizr === 'undefined' || typeof Modernizr.mq !== 'function') && windowWidth < breakpoint){
              convert(menu);
            }
            else if (typeof Modernizr !== 'undefined' && typeof Modernizr.mq === 'function' && Modernizr.mq('(max-width:' + (breakpoint - 1) + 'px)')) {
              convert(menu);
            }
            else {
              turnBack(menu);
            }
          }, 50);
        });
      }
      else if (mode == 'useragent_custom'){
        if (options.useragent != ''){
          var ua = RegExp(options.useragent, 'i');
          if (navigator.userAgent.match(ua)){
            convert(menu);
          }
        }
      }
      else if (mode == 'useragent_predefined' && navigator.userAgent.match(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od|ad)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i)){
        convert(menu);
      }
    }
    return this;
  }
})(jQuery);
;
/*
 * Supposition v0.2 - an optional enhancer for Superfish jQuery menu widget.
 *
 * Copyright (c) 2008 Joel Birch - based mostly on work by Jesse Klaasse and credit goes largely to him.
 * Special thanks to Karl Swedberg for valuable input.
 *
 * Dual licensed under the MIT and GPL licenses:
 *  http://www.opensource.org/licenses/mit-license.php
 *  http://www.gnu.org/licenses/gpl.html
 */
/*
 * This is not the original jQuery Supposition plugin.
 * Please refer to the README for more information.
 */

(function($){
  $.fn.supposition = function(){
    var $w = $(window), /*do this once instead of every onBeforeShow call*/
    _offset = function(dir) {
      return window[dir == 'y' ? 'pageYOffset' : 'pageXOffset']
      || document.documentElement && document.documentElement[dir=='y' ? 'scrollTop' : 'scrollLeft']
      || document.body[dir=='y' ? 'scrollTop' : 'scrollLeft'];
    },
    onHide = function(){
      this.css({bottom:''});
    },
    onBeforeShow = function(){
      this.each(function(){
        var $u = $(this);
        $u.css('display','block');
        var $mul = $u.closest('.sf-menu'),
        level = $u.parents('ul').length,
        menuWidth = $u.width(),
        menuParentWidth = $u.closest('li').outerWidth(true),
        menuParentLeft = $u.closest('li').offset().left,
        totalRight = $w.width() + _offset('x'),
        menuRight = $u.offset().left + menuWidth,
        exactMenuWidth = (menuRight > (menuParentWidth + menuParentLeft)) ? menuWidth - (menuRight - (menuParentWidth + menuParentLeft)) : menuWidth;
        if ($u.parents('.sf-js-enabled').hasClass('rtl')) {
          if (menuParentLeft < exactMenuWidth) {
            if (($mul.hasClass('sf-horizontal') && level == 1) || ($mul.hasClass('sf-navbar') && level == 2)){
              $u.css({left:0,right:'auto'});
            }
            else {
              $u.css({left:menuParentWidth + 'px',right:'auto'});
            }
            $u.parent().addClass('sf-supposition-active');
          }
        }
        else {
          if (menuRight > totalRight && menuParentLeft > menuWidth) {
            if (($mul.hasClass('sf-horizontal') && level == 1) || ($mul.hasClass('sf-navbar') && level == 2)){
              $u.css({right:0,left:'auto'});
            }
            else {
              $u.css({right:menuParentWidth + 'px',left:'auto'});
            }
            $u.parent().addClass('sf-supposition-active');
          }
        }
        var windowHeight = $w.height(),
        offsetTop = $u.offset().top,
        menuParentShadow = ($mul.hasClass('sf-shadow') && $u.css('padding-bottom').length > 0) ? parseInt($u.css('padding-bottom').slice(0,-2)) : 0,
        menuParentHeight = ($mul.hasClass('sf-vertical')) ? '-' + menuParentShadow : $u.parent().outerHeight(true) - menuParentShadow,
        menuHeight = $u.height(),
        baseline = windowHeight + _offset('y');
        var expandUp = ((offsetTop + menuHeight > baseline) && (offsetTop > menuHeight));
        if (expandUp) {
          $u.css({bottom:menuParentHeight + 'px',top:'auto'});
        }
        $u.css('display','none');
      });
    };

    return this.each(function() {
      var o = $.fn.superfish.o[this.serial]; /* get this menu's options */

      /* if callbacks already set, store them */
      var _onBeforeShow = o.onBeforeShow,
      _onHide = o.onHide;

      $.extend($.fn.superfish.o[this.serial],{
        onBeforeShow: function() {
          onBeforeShow.call(this); /* fire our Supposition callback */
          _onBeforeShow.call(this); /* fire stored callbacks */
        },
        onHide: function() {
          onHide.call(this); /* fire our Supposition callback */
          _onHide.call(this); /* fire stored callbacks */
        }
      });
    });
  };
})(jQuery);;
/*
 * Supersubs v0.4b - jQuery plugin
 * Copyright (c) 2013 Joel Birch
 *
 * Dual licensed under the MIT and GPL licenses:
 *  http://www.opensource.org/licenses/mit-license.php
 *  http://www.gnu.org/licenses/gpl.html
 *
 * This plugin automatically adjusts submenu widths of suckerfish-style menus to that of
 * their longest list item children. If you use this, please expect bugs and report them
 * to the jQuery Google Group with the word 'Superfish' in the subject line.
 *
 */
/*
 * This is not the original jQuery Supersubs plugin.
 * Please refer to the README for more information.
 */

(function($){ // $ will refer to jQuery within this closure
  $.fn.supersubs = function(options){
    var opts = $.extend({}, $.fn.supersubs.defaults, options);
    // return original object to support chaining
    // Although this is unnecessary due to the way the module uses these plugins.
    for (var a = 0; a < this.length; a++) {
      // cache selections
      var $$ = $(this).eq(a),
      // support metadata
      o = $.meta ? $.extend({}, opts, $$.data()) : opts;
      // Jump one level if it's a "NavBar"
      if ($$.hasClass('sf-navbar')) {
        $$ = $$.children('li').children('ul');
      }
      // cache all ul elements
      var $ULs = $$.find('ul');
      if ($ULs.length) {
        // get the font size of menu.
        // .css('fontSize') returns various results cross-browser, so measure an em dash instead
        var fontsize = $('<li id="menu-fontsize">&#8212;</li>'),
        size = fontsize.attr('style','padding:0;position:absolute;top:-99999em;width:auto;')
        .appendTo($$)[0].clientWidth; //clientWidth is faster than width()
        // remove em dash
        fontsize.remove();

        // loop through each ul in menu
        for (var b = 0; b < $ULs.length; b++) {
          var
          // cache this ul
          $ul = $ULs.eq(b);
          // If a multi-column sub-menu, and only if correctly configured.
          if (o.multicolumn && $ul.hasClass('sf-multicolumn') && $ul.find('.sf-multicolumn-column').length > 0){
            // Look through each column.
            var $column = $ul.find('div.sf-multicolumn-column > ol'),
            // Overall width.
            mwWidth = 0;
            for (var d = 0; d < $column.length; d++){
              resize($column.eq(d));
              // New column width, in pixels.
              var colWidth = Math.ceil($column.width());
              // Just a trick to convert em unit to px.
              $column.css({width:colWidth})
              // Making column parents the same size.
              .parents('.sf-multicolumn-column').css({width:colWidth});
              // Overall width.
              mwWidth += colWidth;
            }
            // Resizing the columns container too.
            $ul.add($ul.find('li.sf-multicolumn-wrapper, li.sf-multicolumn-wrapper > ol')).css({width:mwWidth});
          }
          else {
            resize($ul);
          }
        }
      }
    }
    function resize($ul){
      var
      // get all (li) children of this ul
      $LIs = $ul.children(),
      // get all anchor grand-children
      $As = $LIs.children('a');
      // force content to one line and save current float property
      $LIs.css('white-space','nowrap');
      // remove width restrictions and floats so elements remain vertically stacked
      $ul.add($LIs).add($As).css({float:'none',width:'auto'});
      // this ul will now be shrink-wrapped to longest li due to position:absolute
      // so save its width as ems.
      var emWidth = $ul.get(0).clientWidth / size;
      // add more width to ensure lines don't turn over at certain sizes in various browsers
      emWidth += o.extraWidth;
      // restrict to at least minWidth and at most maxWidth
      if (emWidth > o.maxWidth) {emWidth = o.maxWidth;}
      else if (emWidth < o.minWidth) {emWidth = o.minWidth;}
      emWidth += 'em';
      // set ul to width in ems
      $ul.css({width:emWidth});
      // restore li floats to avoid IE bugs
      // set li width to full width of this ul
      // revert white-space to normal
      $LIs.add($As).css({float:'',width:'',whiteSpace:''});
      // update offset position of descendant ul to reflect new width of parent.
      // set it to 100% in case it isn't already set to this in the CSS
      for (var c = 0; c < $LIs.length; c++) {
        var $childUl = $LIs.eq(c).children('ul');
        var offsetDirection = $childUl.css('left') !== undefined ? 'left' : 'right';
        $childUl.css(offsetDirection,'100%');
      }
    }
    return this;
  };
  // expose defaults
  $.fn.supersubs.defaults = {
    multicolumn: true, // define width for multi-column sub-menus and their columns.
    minWidth: 12, // requires em unit.
    maxWidth: 27, // requires em unit.
    extraWidth: 1 // extra width can ensure lines don't sometimes turn over due to slight browser differences in how they round-off values
  };
})(jQuery); // plugin code ends
;
/**
 * @file
 * The Superfish Drupal Behavior to apply the Superfish jQuery plugin to lists.
 */

(function ($, Drupal, drupalSettings) {

  'use strict';

  /**
   * jQuery Superfish plugin.
   *
   * @type {Drupal~behavior}
   *
   * @prop {Drupal~behaviorAttach} attach
   *   Attaches the behavior to an applicable <ul> element.
   */
  Drupal.behaviors.superfish = {
    attach: function (context, drupalSettings) {
      // Take a look at each menu to apply Superfish to.
      $.each(drupalSettings.superfish || {}, function (index, options) {
        var $menu = $('ul#' + options.id, context);

        // Check if we are to apply the Supersubs plug-in to it.
        if (options.plugins || false) {
          if (options.plugins.supersubs || false) {
            $menu.supersubs(options.plugins.supersubs);
          }
        }

        // Apply Superfish to the menu.
        $menu.superfish(options.sf);

        // Check if we are to apply any other plug-in to it.
        if (options.plugins || false) {
          if (options.plugins.touchscreen || false) {
            $menu.sftouchscreen(options.plugins.touchscreen);
          }
          if (options.plugins.smallscreen || false) {
            $menu.sfsmallscreen(options.plugins.smallscreen);
          }
          if (options.plugins.supposition || false) {
            $menu.supposition();
          }
        }
      });
    }
  };
})(jQuery, Drupal, drupalSettings);
;
/**
* DO NOT EDIT THIS FILE.
* See the following change record for more information,
* https://www.drupal.org/node/2815083
* @preserve
**/
Drupal.debounce = function (func, wait, immediate) {
  var timeout;
  var result;
  return function () {
    for (var _len = arguments.length, args = new Array(_len), _key = 0; _key < _len; _key++) {
      args[_key] = arguments[_key];
    }
    var context = this;
    var later = function later() {
      timeout = null;
      if (!immediate) {
        result = func.apply(context, args);
      }
    };
    var callNow = immediate && !timeout;
    clearTimeout(timeout);
    timeout = setTimeout(later, wait);
    if (callNow) {
      result = func.apply(context, args);
    }
    return result;
  };
};;
/**
* DO NOT EDIT THIS FILE.
* See the following change record for more information,
* https://www.drupal.org/node/2815083
* @preserve
**/
(function ($, Drupal, debounce) {
  $.fn.drupalGetSummary = function () {
    var callback = this.data('summaryCallback');
    return this[0] && callback ? callback(this[0]).trim() : '';
  };
  $.fn.drupalSetSummary = function (callback) {
    var self = this;
    if (typeof callback !== 'function') {
      var val = callback;
      callback = function callback() {
        return val;
      };
    }
    return this.data('summaryCallback', callback).off('formUpdated.summary').on('formUpdated.summary', function () {
      self.trigger('summaryUpdated');
    }).trigger('summaryUpdated');
  };
  Drupal.behaviors.formSingleSubmit = {
    attach: function attach() {
      function onFormSubmit(e) {
        var $form = $(e.currentTarget);
        var formValues = $form.serialize();
        var previousValues = $form.attr('data-drupal-form-submit-last');
        if (previousValues === formValues) {
          e.preventDefault();
        } else {
          $form.attr('data-drupal-form-submit-last', formValues);
        }
      }
      $(once('form-single-submit', 'body')).on('submit.singleSubmit', 'form:not([method~="GET"])', onFormSubmit);
    }
  };
  function triggerFormUpdated(element) {
    $(element).trigger('formUpdated');
  }
  function fieldsList(form) {
    return [].map.call(form.querySelectorAll('[name][id]'), function (el) {
      return el.id;
    });
  }
  Drupal.behaviors.formUpdated = {
    attach: function attach(context) {
      var $context = $(context);
      var contextIsForm = $context.is('form');
      var $forms = $(once('form-updated', contextIsForm ? $context : $context.find('form')));
      var formFields;
      if ($forms.length) {
        $.makeArray($forms).forEach(function (form) {
          var events = 'change.formUpdated input.formUpdated ';
          var eventHandler = debounce(function (event) {
            triggerFormUpdated(event.target);
          }, 300);
          formFields = fieldsList(form).join(',');
          form.setAttribute('data-drupal-form-fields', formFields);
          $(form).on(events, eventHandler);
        });
      }
      if (contextIsForm) {
        formFields = fieldsList(context).join(',');
        var currentFields = $(context).attr('data-drupal-form-fields');
        if (formFields !== currentFields) {
          triggerFormUpdated(context);
        }
      }
    },
    detach: function detach(context, settings, trigger) {
      var $context = $(context);
      var contextIsForm = $context.is('form');
      if (trigger === 'unload') {
        once.remove('form-updated', contextIsForm ? $context : $context.find('form')).forEach(function (form) {
          form.removeAttribute('data-drupal-form-fields');
          $(form).off('.formUpdated');
        });
      }
    }
  };
  Drupal.behaviors.fillUserInfoFromBrowser = {
    attach: function attach(context, settings) {
      var userInfo = ['name', 'mail', 'homepage'];
      var $forms = $(once('user-info-from-browser', '[data-user-info-from-browser]'));
      if ($forms.length) {
        userInfo.forEach(function (info) {
          var $element = $forms.find("[name=".concat(info, "]"));
          var browserData = localStorage.getItem("Drupal.visitor.".concat(info));
          if (!$element.length) {
            return;
          }
          var emptyValue = $element[0].value === '';
          var defaultValue = $element.attr('data-drupal-default-value') === $element[0].value;
          if (browserData && (emptyValue || defaultValue)) {
            $element.each(function (index, item) {
              item.value = browserData;
            });
          }
        });
      }
      $forms.on('submit', function () {
        userInfo.forEach(function (info) {
          var $element = $forms.find("[name=".concat(info, "]"));
          if ($element.length) {
            localStorage.setItem("Drupal.visitor.".concat(info), $element[0].value);
          }
        });
      });
    }
  };
  var handleFragmentLinkClickOrHashChange = function handleFragmentLinkClickOrHashChange(e) {
    var url;
    if (e.type === 'click') {
      url = e.currentTarget.location ? e.currentTarget.location : e.currentTarget;
    } else {
      url = window.location;
    }
    var hash = url.hash.substr(1);
    if (hash) {
      var $target = $("#".concat(hash));
      $('body').trigger('formFragmentLinkClickOrHashChange', [$target]);
      setTimeout(function () {
        return $target.trigger('focus');
      }, 300);
    }
  };
  var debouncedHandleFragmentLinkClickOrHashChange = debounce(handleFragmentLinkClickOrHashChange, 300, true);
  $(window).on('hashchange.form-fragment', debouncedHandleFragmentLinkClickOrHashChange);
  $(document).on('click.form-fragment', 'a[href*="#"]', debouncedHandleFragmentLinkClickOrHashChange);
})(jQuery, Drupal, Drupal.debounce);;
/**
 * @file
 * Defines Javascript behaviors for the commerce cart module.
 */

(($, Drupal) => {
  Drupal.behaviors.commerceCartBlock = {
    attach: (context) => {
      const $context = $(context);
      const $cart = $context
        .find('.cart--cart-block')
        .addBack('.cart--cart-block');
      const $cartContents = $cart.find('.cart-block--contents');

      if ($cartContents.length > 0) {
        // Expand the block when the link is clicked.
        $(
          once('cart-button-processed', '.cart-block--link__expand', context),
        ).on('click', (e) => {
          // Prevent it from going to the cart.
          e.preventDefault();
          // Get the shopping cart width + the offset to the left.
          const windowWidth = $(window).width();
          const cartWidth = $cartContents.width() + $cart.offset().left;
          // If the cart goes out of the viewport we should align it right.
          if (cartWidth > windowWidth) {
            $cartContents.addClass('is-outside-horizontal');
          }
          // Toggle the expanded class.
          $cartContents
            .toggleClass('cart-block--contents__expanded')
            .slideToggle();
        });
      }
    },
  };
})(jQuery, Drupal);
;
