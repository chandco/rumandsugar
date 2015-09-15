( function( $ )
{
  $.style={
          insertRule:function(selector,rules,contxt)
          {
            var context=contxt||document,stylesheet;

            if(typeof context.styleSheets=='object')
            {
              if(context.styleSheets.length)
              {
                stylesheet=context.styleSheets[context.styleSheets.length-1];
              }
              if(context.styleSheets.length)
              {
                if(context.createStyleSheet)
                {
                  stylesheet=context.createStyleSheet();
                }
                else
                {
                  context.getElementsByTagName('head')[0].appendChild(context.createElement('style'));
                  stylesheet=context.styleSheets[context.styleSheets.length-1];
                }
              }
              if(stylesheet.addRule)
              {
                for(var i=0;i<selector.length;++i)
                {
                  stylesheet.addRule(selector[i],rules);
                }
              }
              else
              {
                stylesheet.insertRule(selector.join(',') + '{' + rules + '}', stylesheet.cssRules.length);  
              }
            }
          }
        };
  }
)( jQuery );


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



$('.main img:not(.attachment-gallery-thumb)').wrap('<div class="menu-image-wrapper"><div class="inner"></div></div>');



$( "<style>.open .nav-menus  { height: " + $(window).height() + "px; }</style>" ).appendTo( "head" );

$(".menu-toggle").click(function(){

 


  $('.topper').toggleClass('open');


});






})( jQuery );