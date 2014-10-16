
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



$('.mfp-gallery-item').magnificPopup(popup.gallery);


$('a.popup-box-link').each(function(index, element) {
  $(element).magnificPopup(popup.inline);
})





})( jQuery );