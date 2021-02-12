import 'slick-carousel/slick/slick.min.js';

export default {
  init() {
    // JavaScript to be fired on the home page

  },
  finalize() {
    // JavaScript to be fired on the home page, after the init JS
    $(document).ready(function(){
      $('.sshow').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        fade: true,
        autoplay: true,
        autoplaySpeed: 7000,
        prevArrow:"<button type='button' class='slick-prev slick-arrow'><icon class='icon-arr-l'></icon></button>",
        nextArrow:"<button type='button' class='slick-next slick-right'><icon class='icon-arr-r'></icon></button>",
      });
      $('.sshow').on('beforeChange', function(event, slick, currentSlide){
        if ($('.slide'+currentSlide+ ' video').length != ''){
          $('.slide'+currentSlide+ ' .video')[0].currentTime = 0;
        }
      });

      $('.sshow').on('afterChange', function(event, slick, currentSlide){
        if ($('.slide'+currentSlide+ ' video').length != ''){
          $('.sshow').slick('slickPause');
          $('.slide'+currentSlide+ ' .video')[0].play();

          $('.slide'+currentSlide+ ' .video').on('ended',function(){
            $('.sshow').slick('slickNext');
          });
        } else {
          $('.sshow').slick('slickPlay');
        }
      });

      $(".slide .video-slide").on("ended", function() {
        alert("Video Finished");
      });
    });

    $(window).on("load resize scroll",function(){
      if($(document).width()<1023) {
        var slick = $('.sshow').slick('getSlick');
        var slides = slick.$slides;
        var slidx = '';
        slides.each(function(i, slide) {
          //debugger;
          if ($(slide).hasClass('charitable-slide')) {
            slidx = i;
          }
        })
        if (slidx || slidx === 0) {
          $('.sshow').slick('slickRemove', slidx);
        }
      }
    });
  },
};
