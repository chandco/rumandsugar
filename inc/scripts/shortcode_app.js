// closure to avoid namespace collision
(function(){

    "use strict";
    // creates the plugin
    tinymce.create('tinymce.plugins.croshortcode', {
        // creates control instances based on the control's id.
        // our button's id is &quot;mygallery_button&quot;
        createControl : function(id, controlManager) {
            if (id === 'croshortcode_button') {
                // creates the button
                var button = controlManager.createButton('croshortcode_button', {
                    title : 'Croma Shortcode', 
                    image : cro_shortcodeicon, 
                    onclick : function() {
                       
                        var width = jQuery(window).width(), H = jQuery(window).height(), W = ( 720 < width ) ? 720 : width;
                        W = W - 80;
                        H = H - 84;
                        tb_show( 'Croma Shortcode Manager', '#TB_inline?width=' + W + '&height=' + H + '&inlineId=cro_shortcode_form' );

                    }
                });
                return button;
            }
            return null;
        }
    });
 
    // registers the plugin. DON'T MISS THIS STEP!!!
    tinymce.PluginManager.add('croshortcode', tinymce.plugins.croshortcode);


    jQuery(function(){
        var data = {
                action: 'croma_shortcode_action',
                type: 'short_form'},
                form = jQuery('<div id="cro_shortcode_form"><div class="cro_shcode_strap"></div></div>'),
                menno = 0, 
                teamno = 0, 
                galno = 0, 
                calno = 0,
                vidno = 0,
                ctcno = 0,
                layno = 0;
           

        form.appendTo('body').hide();


        jQuery.post(ajaxurl, data, function(response) {

            form.find('.cro_shcode_strap').html(response);
            form.find('#cro_shortcode_form').appendTo('body').hide();
            form.find('input[type^="button"]').unbind('click').bind('click', click_a_shortcode);
            form.find('select').unbind('click').bind('click', update_a_value);
            form.find('li.tabber').unbind('click').bind('click', update_a_tabski);
        });


        function update_a_value() {
            var node = jQuery(this).attr('rel'),
                vals = jQuery(this).val();

            switch (node) {
                case 'menuno':  menno = vals;  break;
                case 'teamno':  teamno = vals;  break;
                case 'galno':   galno = vals;  break;
                case 'calno':   calno = vals;  break;
                case 'vidno':   vidno = vals;  break;
                case 'laytype': layno = vals;  break;
                case 'ctcname': ctcno = vals;  break;
                
            }
                
         }

         function update_a_tabski() {
            var $this = jQuery(this);
            var $tc = $this.parents('ul').find('.cro_topcurrent');
            var node = jQuery(this).attr('rel');
            var $ttab = jQuery('.cro_tabcurrent');
            $tc.removeClass('cro_topcurrent');
            $this.addClass('cro_topcurrent');
            $ttab.removeClass('cro_tabcurrent');
            $ttab.parents('.cro_shcode_strap').find(node).addClass('cro_tabcurrent');
            return;             
         }

         
         function click_a_shortcode() {
            var el = jQuery(this),
                shortname = el.attr('rel'),
                sol1 = '',
                sol2 = '',
                sol3 = '',
                shortcode = '',
                $i = 0,
                shortclass = '';

            switch (shortname) {
                
                case 'team': 
                    sol1 = el.parents('.cro_tabpage').find('#teamcatselector[rel^="teamno"]').val(); 
                    shortcode  = '[cro_team no="' + sol1 + '"]';
                break;

                case 'menu': 
                     sol1 = el.parents('.cro_tabpage').find('#teamtypeselector').val();
                     sol2 = el.parents('.cro_tabpage').find('#teamcatselector[rel^="menuno"]').val(); 
                    if (sol1 == 4) {
                        shortcode  = '[cro_menuq title="Title here" desc="Description here" price="$0-00"]';
                    } else {
                        shortcode  = '[cro_menu no="' + sol2 + '" type="' +  sol1  +  '"]';
                    }
                break;


                case 'accordion': 
                    sol1 = el.parents('.cro_tabpage').find('#teamcatselector[rel^="accordion"]').val(); 
                    shortcode = '[cro_accordionstart]<br/><br/>';

                    for ($i=0; $i < sol1 ; $i++) { 
                        shortclass = ($i == 0) ? ' item="active" ' : ' item="" ' ;
                        shortcode += '[cro_accordionitem title="add_your_title_here"' +  shortclass  + ']add your content here[/cro_accordionitem]<br/><br/>';
                    }

                    shortcode += '[cro_accordionend]';
                break;

                case 'gallery': 
                    sol1 = el.parents('.cro_tabpage').find('#teamcatselector[rel^="galno"]').val();  
                    shortcode  = '[cro_gallery no="' + sol1 + '"]';
                break;

                 case 'button': 
                    sol1 = el.parents('.cro_tabpage').find('#cro-shortcode-input_text').val(); 
                    sol2 = el.parents('.cro_tabpage').find('#cro-shortcode-input_link').val(); 
                    sol3 = el.parents('.cro_tabpage').find('select[rel^="buttoncol"]').val(); 
 
                    shortcode = '[cro_button text="' +  sol1  +  '" link="' +  sol2  +  '" color="' +  sol3  +  '"]';
                break;


                 case 'special':  
                    shortcode  = '[cro_promo no="0"]';
                break;

                 case 'ctc':  
                    sol1 = el.parents('.cro_tabpage').find('#ctctypeselector[rel^="ctcname"]').val();
                    sol2 =  el.parents('.cro_tabpage').find('#ctctypeselector[rel^="ctctype"]').val();
                    if (sol2 >= 0) { 
                        shortcode  = '[cro_contact no="' + sol1 + '" type="' +  sol2 + '"]';
                    }
                break;

                 case 'lte': 
                    sol1 = el.parents('.cro_tabpage').find('#laytypeselector[rel^="laytype"]').val(); 
                    if (sol1 == 1)  {
                        shortcode  = '[cro_halves_layoutstart] [cro_halves_layoutmid] [cro_layoutend]';
                    } else if (sol1 == 2) {
                        shortcode  = '[cro_thirds_firstthird] [cro_thirds_secondthird] [cro_thirds_third-third] [cro_layoutend]';
                    }  else if (sol1 == 3) {
                        shortcode  = '[cro_thirds_twothirds] [cro_thirds_onethird] [cro_layoutend]';
                    }   else if (sol1 == 4) {
                        shortcode  = '[cro_thirds_onethirds] [cro_thirds_twothird] [cro_layoutend]';
                    }    else if (sol1 == 5) {
                        shortcode  = '[cro_quarters_firstquarter] [cro_quarters_secondquarter]  [cro_quarters_thirdquarter] [cro_quarters_fourthquarter] [cro_layoutend] ';
                    }    else if (sol1 == 6) {
                        shortcode  = '[cro_quarters_firsthalf] [cro_quarters_half-firstquarter]  [cro_quarters_half_secondquarter] [cro_layoutend] ';
                    }    else if (sol1 == 7) {
                        shortcode  = '[cro_quarters_half-firstquarters] [cro_quarters_half_secondquarters] [cro_quarters_lasthalf] [cro_layoutend] ';
                    }        
                break;

                case 'calendar': 
                    sol1 = el.parents('.cro_tabpage').find('#teamcatselector[rel^="calno"]').val();   
                    shortcode  = '[cro_calendar no="' + sol1 + '"]';
                break;


                case 'callout' :
                    sol1 = el.parents('.cro_tabpage').find('textarea[rel^="callouttext"]').val(); 
                    sol2 = el.parents('.cro_tabpage').find('select[rel^="calloutbg"]').val(); 
                    sol3 = el.parents('.cro_tabpage').find('select[rel^="calloutpos"]').val();

                    shortcode  = '[cro_callout text="' + sol1 + '" layout="' + sol3 + '"  color="' + sol2 + '"]';

                break;


                case 'video': 
                    sol1 = el.parents('.cro_tabpage').find('textarea').val(); 
                    if (sol1.indexOf("iframe") >= 0){
                        var vn = jQuery(sol1);
                        sol2 = vn.attr('src');
                    } else {
                       sol2 = sol1;
                    }
                    shortcode  = '[cro_video no="' + sol2 + '"]';
                break;
     
            }

            tinyMCE.activeEditor.execCommand('mceInsertContent', 0, shortcode);
            
            tb_remove();

         }
                    
        
    });
})();