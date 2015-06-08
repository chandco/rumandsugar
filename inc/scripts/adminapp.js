jQuery(document).ready(function(){

	"use strict";
	
	// IMAGE UPLOAD BUTTON
	jQuery('.image_upload_button').click(function() {
		var formid = jQuery(this).attr('rel');
		if(formid){tb_show('Upload a logo', 'media-upload.php?referer=wp-settings&type=image&&post_id=' + formid + 'TB_iframe=true', false);} else {tb_show('Upload a logo', 'media-upload.php?referer=wp-settings&type=image&post_id=0&TB_iframe=true', false);}
		return false;
	});

	// IMAGE SEND PREVIEW				
	window.send_to_editor = function(html) {
		var imgurl = jQuery('img',html).attr('src');
		jQuery('#upload_image').val(imgurl);
		jQuery('#upload_image_preview').html('').prepend('<img src="' + imgurl + '">').addClass('upload_image_active');
		tb_remove();
	};

	// SHOW FONTPREVIEW
	jQuery('.cro_fselect').change(function() {
		var crofontval	= jQuery(this).val();
		var cropdiv		= jQuery(this).parents('.opti').find('.fontpreview');
		var fontname	= crofontval.replace(' ','+');
		var fontstring	= '<link href="http://fonts.googleapis.com/css?family=' + fontname +  '" rel="stylesheet" type="text/css">';
		fontstring		=  fontstring + '<p style="font-family: ' +   crofontval + ', serif;">Grumpy wizards make toxic brew for the evil Queen and Jack.</p>';
		cropdiv.html(fontstring);
	});
	
	

	// FADE UPDATEMESSAGE OUT
	if (jQuery('p.updatemess').length){
		jQuery('p.updatemess').delay(3000).fadeOut('slow');
	}
	
	
	// SHOW HELP CONTENT
	jQuery('.helphelp').mouseenter(function() {
		jQuery(this).parents('.sideinner').find('p.helper').fadeIn('fast');
	}).mouseleave(function() {
		jQuery(this).parents('.sideinner').find('p.helper').fadeOut('fast');
	});

	jQuery('.switchbtn').click(function() {
		var target = jQuery(this).parents('.switchouter').find('.switchbut');
		var targetinp = jQuery(this).parents('.switchouter').find('#switchput');
		if (target.hasClass('switchon')){
			target.removeClass('switchon').animate({left: '-=43'}, 300);
			targetinp.val('0');
		} else {
			target.addClass('switchon').animate({left: '+=43'}, 300);
			targetinp.val('1');
		}
	});

	// SIDEBAR MANAGER
	jQuery(document).on("click", ".cro_itemplusitems span", function(){ 
		var rstr = new Date().getTime();
		if (jQuery('.cro_theresnolist').length !== 0) {
			jQuery('.cro_theresnolist').remove();
		}
		jQuery('.cro_listcloner').clone().appendTo('.cro_itemlistitems').show().removeClass('cro_listcloner').addClass('cro_listcloneractive').find('input').attr('name', 'inp-' + rstr).find('.cro_listdeleteone').unbind('click').bind('click', untrest);
	});

	function untrest(){
		jQuery(this).parents('.cro_listcloneractive').remove();
	}

	jQuery('.cro_listcloneractive span').click(function() {
		jQuery(this).parents('.cro_listcloneractive').remove();
	});

	// IMAGE RESET FUNCTION
	jQuery('.resetimg').click(function() {
		var activdiv = jQuery(this).closest('.sideinner');
		activdiv.find('#upload_image_preview').addClass('upload_image_active').html('');
		activdiv.find('#upload_image').val('');
		jQuery(this).fadeOut('slow');
	});

	jQuery('.cro_pickme').each(function() {
		var identifier = jQuery(this).attr('rel');
		jQuery(identifier).wpColorPicker();
	});
	
	// SORT BOXES
	jQuery('ul.slidename').sortable({
		items: '.list_items',
		opacity: 0.6,
		axis: 'y',
		update: function() {
			var order = jQuery(this).sortable('serialize');
			var type = jQuery(this).attr('rel');
			var sdep = '';
			var adep = new Array();
			var data = '';
			jQuery('li.list_items').each(function(i) {
				adep[i] = jQuery(this).attr('rel');
			});
			sdep = adep.join('/');
			data = 'action=cro_post_action&type=update_order&' + order + '&types=' + type + '&idees=' + sdep;
			jQuery.post(ajaxurl, data, function(response) { });
		}
	});
	
	
	// function to select one from a list.
	jQuery('.butoff').live('click', function() {		
		var clickedid = jQuery(this),
			clickedparent = clickedid.parents('.opti'),
			elem = clickedparent.children('.optionbut'),
			value = clickedid.attr('rel');			
		elem.addClass('butoff');		
		clickedid.toggleClass('butoff');		
		clickedparent.find('#setinputvalue').val(value);		
	});
			
});			
	