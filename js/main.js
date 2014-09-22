
(function( $ ){
$.fn.exists = function(callback) {
  var args = [].slice.call(arguments, 1);

  if (this.length) {
    callback.call(this, args);
  }

  return this;
};

console.log("hello?");


var popup = {
    gallery : {
                type:'image', 
                removalDelay: 300,
                mainClass: 'mfp-fade'  

            },

}

$('a[href$=".jpg"]').each(function(index, element) {
    console.log($(element));
    $(element).magnificPopup(popup.gallery);
});



})( jQuery );