
(function( $ ){
$.fn.exists = function(callback) {
  var args = [].slice.call(arguments, 1);

  if (this.length) {
    callback.call(this, args);
  }

  return this;
};



var popup = {
    gallery : {
                type:'image', 
                gallery: {
                  enabled: true
                },
                removalDelay: 300,
                mainClass: 'mfp-fade'  

            },

    inline : {
      type:'inline',
      midClick: true
    }

}



$('.gallery-item a[href$=".jpg"]').magnificPopup(popup.gallery);


$('a.popup-box-link').each(function(index, element) {
  $(element).magnificPopup(popup.inline);
})



$('img').wrap('<div class="menu-image-wrapper"><div class="inner"></div></div>');


$(".menu-toggle").click(function(){
  $(this).toggleClass('header-menu');
});




})( jQuery );