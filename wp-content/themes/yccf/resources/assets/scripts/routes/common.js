import '@google/maps/lib/index.js';
import List from 'list.js';
import 'jquery.mmenu/dist/jquery.mmenu.all.js';
import 'jquery-mask-plugin/dist/jquery.mask.min.js';

export default {
  init() {
    // JavaScript to be fired on all pages
    if ("ontouchstart" in window || "ontouch" in window) {
      $('body').addClass('touch');
    }

    $('[data-fancybox="search"]').fancybox({
      animationEffect : "zoom",
      transitionEffect: "fade",
      wrapCSS: 'fancybox--search',
      closeBtn: false,
      afterShow: function(){
        //console.log('click');
        $('.search-field').focus();
      },
    });

    $('[data-fancybox="bio-"]').fancybox({
      animationEffect : "zoom",
      transitionEffect: "fade",
      wrapCSS: 'fancybox--bio',
      fullScreen: false,
      thumbs: false,
      iframe: {
        scrolling: 'yes',
      },
      closeBtn: true,
    });

    //us phone - https://igorescobar.github.io/jQuery-Mask-Plugin/docs.html
    $('.phone_us').mask('(000) 000-0000');

    //Mmenu
    var $menu = $("#menu").mmenu({
       // options
       "slidingSubmenus": false,
       "navbar": "",
       "extensions": [
          "fx-menu-zoom",
          "fx-panels-zoom",
          "position-right",
       ],
    });
    var $icon = $("#my-icon");
    var API = $menu.data( "mmenu" );

    $icon.on( "click", function() {
       API.open();
    });

    API.bind( "open:finish", function() {
       setTimeout(function() {
          $icon.addClass( "is-active" );
       }, 100);
    });
    API.bind( "close:finish", function() {
       setTimeout(function() {
          $icon.removeClass( "is-active" );
       }, 100);
    });

    //menu active class
    $(".main-nav li.menu-item-has-children").hover(
      function () {
          var $this = $(this),
              timer = $this.data("timer") || 0;

          clearTimeout(timer);
          $this.addClass("activated");

          timer = setTimeout(function() {
              $this.addClass("activated");
          }, 0);

          $this.data("timer", timer);
      },
      function () {
          var $this = $(this),
              timer = $this.data("timer") || 0;

          clearTimeout(timer);
          timer = setTimeout(function() {
              $this.removeClass("activated");
          }, 100);

          $this.data("timer", timer);
      }
    );


    // faqs - clicked
    if($(".toggle .toggle-title").hasClass('active') ){
      $(".toggle .toggle-title.active").closest('.toggle').find('.toggle-inner').show();
    }

    $(".toggle .toggle-title").click(function(){
      if($(this).hasClass('active')){
        $(this).removeClass("active").closest('.toggle').find('.toggle-inner').slideUp(200);
      } else {
        $(this).addClass("active").closest('.toggle').find('.toggle-inner').slideDown(200);
      }
    });

    //bulma Tabs
    $('#tabs li').on('click', function() {
      var tab = $(this).data('tab');

      $('#tabs li').removeClass('is-active');
      $(this).addClass('is-active');

      $('#tab-content .tab-container').removeClass('is-active');
      $('div.tab-container[data-content="' + tab + '"]').addClass('is-active');
    });

    //smooth
    $('a[href*="#"]')
      // Remove links that don't actually link to anything
      .not('[href="#"]')
      .not('[href="#0"]')
      .click(function(event) {
        // On-page links
        if (
          location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '')
          &&
          location.hostname == this.hostname
        ) {
          // Figure out element to scroll to
          var target = $(this.hash);
          target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
          // Does a scroll target exist?
          if (target.length) {
            // Only prevent default if animation is actually gonna happen
            event.preventDefault();
            $('html, body').animate({
              scrollTop: target.offset().top,
            }, 1000, function() {
              // Callback after animation
              // Must change focus!
              var $target = $(target);
              $target.focus();
              if ($target.is(":focus")) { // Checking if the target was focused
                return false;
              } else {
                $target.attr('tabindex','-1'); // Adding tabindex for elements not focusable
                $target.focus(); // Set focus again
              }
            });
          }
        }
      });

      //compliancy
      $('.add-aria, h1, h2, h3, h4, p, ul li, ol li, img, .mission-title, ul.social-media li a, .impact-title, section.faq-block .toggle-title .title-name, .block-cont .name, .block-cont .title, .recent-articles a').attr('tabindex', '0');
      $('nav ul li, .brand, .brand img, .breadcrumbs a, .breadcrumbs span, .img, .img img, ul.social-media li, .fs-img img').attr('tabindex', '-1');
  },
  finalize() {
    // JavaScript to be fired on all pages, after page specific JS is fired
    //fund search list
    var options = {
      valueNames: [ 'fund-title', 'established' ],
    };

    var fundList = new List('fund-listings', options);

    $('#search-field').on('keyup', function() {
      var searchString = $(this).val();
      fundList.search(searchString);
    });
    //
  },
};
