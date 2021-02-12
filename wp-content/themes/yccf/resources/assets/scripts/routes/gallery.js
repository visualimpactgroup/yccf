// Fancybox
import '@fancyapps/fancybox/dist/jquery.fancybox.min.js';

export default {
  init() {
    // fancybox
    $('[data-fancybox="gallery"]').fancybox({
      loop      : true,
      arrows    : true,
      infobar   : true,
      smallBtn  : true,
      toolbar   : false,
      buttons   : [
        "close",
      ],
      protect   : false,
      modal     : false,
      image     : {
        preload : false,
      },
      animationEffect : "zoom",
      transitionEffect: "fade",
    });
  },
};
