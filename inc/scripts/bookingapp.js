
;(function ($) {
	"use strict";
	$.cromares = function(el) {
		var croma = $(el),
			adder = '',
			themess = '',
			isBlockOn = 0,
			alertLength = 0,
			now = new Date(),
			dateB = Math.floor(now / 1000),
			clickAddr = croma.find('.bookingcalholder').attr('rel'),
			lodder = croma.find('.cro_backloader'),

		methods = {
			init: function() {
				methods.fadeMng(lodder, 1000);
				methods.deleGater();
			},
			fadeMng: function(el,time) {
				var $this 		= $(el),
					initski 	=  (($this).is(':visible')) ? $this.delay(time).fadeOut('slow') : $this.delay(time).fadeIn('slow');
			},
			deleGater: function() {
				croma.delegate('.helphelp','mouseenter mouseleave', function() {
					var target	= $(this).parents('.sideinner').find('p.helper');
					methods.fadeMng(target,0);
				});
				croma.delegate('.butoff, .activateblocks, .beblocked, .cro_dayisbooked, .cro_processbooking','click', function() {
					var $this = $(this);
					if ($this.hasClass('butoff')){methods.buttonHandler($this);
					} else if ($this.hasClass('activateblocks')) {methods.actiVate($this);
					} else if ($this.hasClass('beblocked')) {methods.blockAdate($this);
					} else if ($this.hasClass('cro_dayisbooked')) {methods.gotoDay($this);
					} else if ($this.hasClass('cro_processbooking')) {methods.bookingHandler($this);} 
				});
				croma.on("click", ".caldir", function(){ 
					var $this = $(this);
					methods.moveCal($this);
				});

				croma.on("click", ".cro_itemplusitems span", function(){ 
					methods.skedler();					
				});

				croma.on("click", ".cro_listdeleteone", function(){ 
					var $this = $(this),
						counts = ('.schedblox').length;
					$this.parents('.schedblox').remove();
					if (counts <= 1) {
						croma.find('p.cro_thereisnone').show();
					}
				});
			},
			buttonHandler: function(el) {
				var $this = $(el),
				clickedparent = $this.parents('.opti'),
				elem = clickedparent.children('.optionbut'),
				value = $this.attr('rel');			
				elem.addClass('butoff');		
				$this.toggleClass('butoff');		
				clickedparent.find('input').val(value);
			},
			moveCal: function(el) {
				var $this = $(el),
					timings = $this.attr('rel'),
					target = croma.find('.bookingcalholder'),
					data = { action : 'crob_post_action', type : 'crob_movecal', option1 : timings, crnonce : cro_book.cro_booknonce};
				$.post(ajaxurl, data, function(response) {
					target.html(response);
					isBlockOn = 0;
				});
			},
			actiVate: function(el) {
				var $this = $(el),
					elemMess = '';

				switch (isBlockOn) {
					case 0:
						themess = cro_bquery.activateBlocks.split(". ");
						adder = '.isblock0';
						isBlockOn++;
					break;
					case 1:
						themess = cro_bquery.deactivateBlocks.split(". ");
						adder = '.isblock1';
						isBlockOn--;						
					break;
				}
				
				alertLength = themess.length;
				for (var i = 0; i < alertLength; i++) {
					elemMess = elemMess + themess[i] + '.\n\n';
				}

				$this.hide();
				croma.find(adder).show();
				alert(elemMess);
				croma.find('.daynumber').each(function() {
					var $this = $(this);
					var dateval = $this.attr('rel');				
					if (dateval > dateB) {
						$this.not('.cro_blockedday').toggleClass('beblocked');
					}
				});
			},
			blockAdate: function(el) {
				var $this = $(el),
					date_val = $this.attr('rel'),
					rmess = '',
					data = '';

				if (!$this.hasClass('cro_dayisbooked')){

					if ($this.hasClass('cro_isblocked')){
						rmess = confirm(cro_bquery.unblockDate);
						data = { action: 'crob_post_action', type: 'crob_removeblock', option1: date_val, crnonce: cro_book.cro_booknonce};
					} else {
						rmess = confirm(cro_bquery.blockDate);
						data = { action: 'crob_post_action', type: 'crob_addblock', option1: date_val, crnonce: cro_book.cro_booknonce};
					}
					if (rmess === true) {
						$this.toggleClass('cro_isblocked');
						jQuery.post(ajaxurl, data, function() {});	
					}
				}			
			},
			gotoDay: function(el) {
				var $this = $(el),
					secondpart = $this.attr('rel');		
				if (isBlockOn === 0) {
					window.location = clickAddr  + secondpart;
				}
			},
			bookingHandler: function(el) {
				var $this = $(el),
					bookid = $this.parents('.dailytimeslot').attr('rel'),
					rname= '',
					raction = 'confirmed',
					rstrip = cro_bquery.cancelled,
					dupd = $this.parents('.dailyupdaters'),
					actarr = {};

				if ($this.hasClass('cro_bookingconfirm')) {
					rname = 'crob_confirmbooking';
					rstrip = cro_bquery.confirmed;
					actarr= ['.cro_bookingdecline', 'a.cro_bookingconfirm'];
				} else if ($this.hasClass('cro_bookingdecline')) {
					rname = 'crob_declinebooking';
					raction = 'cancelled';
					actarr= ['a.cro_bookingconfirm', 'a.cro_bookingcancel', '.cro_bookingdecline'];
				} else if ($this.hasClass('cro_bookingcancel')) {
					rname = 'crob_cancelbooking';
					raction = 'cancelled';
					actarr = ['a.cro_bookingconfirm', '.cro_bookingdecline', 'a.cro_bookingcancel'];
				} 
				if (actarr){
					lodder.fadeIn('slow');
					var data = { action: 'crob_post_action', type: rname, option1: bookid, crnonce: cro_book.cro_booknonce};
					jQuery.post(ajaxurl, data, function() {
						$this.parents('.dailytimeslot').find('.bookingstatus').removeClass('unconfirmed').addClass(raction).html(rstrip);
						lodder.fadeOut('slow');	
						for (var index = 0; index < actarr.length; ++index) {
							dupd.find(actarr[index]).remove();
						}
						return false;
					});
				}
			},
			skedler: function() {
				var rndstr = methods.rndString(),
					cro_start = $('<div></div>'),
					cro_form = cro_start.addClass('schedblox'),
					cro_date = '<div class="dateblocker datepadright"><select class="dayname" name="cro_dayname-' + rndstr + '"><option value="0">' + cro_bquery.sday + '</option><option value="1">' + cro_bquery.mday + '</option><option value="2">' + cro_bquery.tday + '</option><option value="3">' + cro_bquery.wday + '</option><option value="4">' + cro_bquery.thday + '</option><option value="5">' + cro_bquery.fday + '</option><option value="6">' + cro_bquery.saday + '</option></select></div>',
					cro_to = '<div class="dateblocker"><span class="dateto"> - </span></div>',
					cro_closer = '<div class="dateblocker"><span class="dateto">' + cro_bquery.every + '</span></div><div class="dateblocker"><input type="text" class="intervalminutes" name="cro_intervalminutes-' + rndstr + '"></div><div class="dateblocker"><span class="dateto">' + cro_bquery.minutes + '</span></div><br class="clear"></div>';
	
				cro_form.html(
					'<input type="hidden" name="cro_schedcontrol-' + rndstr + '" value="' + rndstr + '">' + 
					cro_date + '<span class="cro_listdeleteone">-</span>' + 
					'<div class="dateblocker"><select class="starthour" name="cro_schedfromhour-' + rndstr + '">' + methods.dateBlocka(24) + '</select></div>' + 
					'<div class="dateblocker"><select class="startminute" name="cro_schedfrommin-' + rndstr + '">' + methods.dateBlocka(59) + '</select></div>' + 
					cro_to + 
					'<div class="dateblocker"><select class="endhour" name="cro_schedtohour-' + rndstr + '">' + methods.dateBlocka(24) + '</select></div>' + 
					'<div class="dateblocker"><select class="endminute" name="cro_schedtomin-' + rndstr + '">' + methods.dateBlocka(59) + '</select></div>' +
					cro_closer
				);

				croma.find('.schedouter').append(cro_form);
				croma.find('p.cro_thereisnone').hide();
			},
			rndString: function() {
				var text = '',
				possible = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
				for(var i=0; i < 10; i++){text += possible.charAt(Math.floor(Math.random() * possible.length));}
					return text;
			},
			dateBlocka: function(numbers) {
				var	optionstring = '',
					$i = 0,
					$j = 0;
				for ($i=0; $i < numbers ; $i++) { 
					$j = ($i <= 9) ? '0' + $i : $i ;						
					optionstring += '<option value="' + $i + '">' + $j + '</option>';
				}
				return optionstring;
			}

		};
		methods.init();
	};

	$.fn.cromares =function(){new $.cromares($(this));};

})( jQuery );



jQuery(document).ready(function(){

	"use strict";

	jQuery('.cro_table').cromares();

	jQuery(document).on("click", ".cro_listdeleteone", function(){ 
		jQuery(this).parents('.cro_listcloneractive').remove();		
	});

	// SIDEBAR MANAGER
	jQuery(document).on("click", ".cro_itemplusitems span", function(){ 
		var rstr = new Date().getTime();
		if (jQuery('.cro_theresnolist').length !== 0) {
			jQuery('.cro_theresnolist').remove();
		}
		jQuery('.cro_listcloner').clone().appendTo('.cro_itemlistitems').show().removeClass('cro_listcloner').addClass('cro_listcloneractive').find('input').attr('name', 'inp-' + rstr);
	});
});			
	