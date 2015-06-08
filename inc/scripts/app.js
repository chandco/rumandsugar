/**
 * jQuery Cookie plugin
 *
 * Copyright (c) 2010 Klaus Hartl (stilbuero.de)
 * Dual licensed under the MIT and GPL licenses:
 * http://www.opensource.org/licenses/mit-license.php
 * http://www.gnu.org/licenses/gpl.html
 *
 */
jQuery.cookie=function(e,t,n){if(arguments.length>1&&String(t)!=="[object Object]"){n=jQuery.extend({},n);if(t===null||t===undefined){n.expires=-1}if(typeof n.expires==="number"){var r=n.expires,i=n.expires=new Date;i.setDate(i.getDate()+r)}t=String(t);return document.cookie=[encodeURIComponent(e),"=",n.raw?t:encodeURIComponent(t),n.expires?"; expires="+n.expires.toUTCString():"",n.path?"; path="+n.path:"",n.domain?"; domain="+n.domain:"",n.secure?"; secure":""].join("")}n=t||{};var s,o=n.raw?function(e){return e}:decodeURIComponent;return(s=(new RegExp("(?:^|; )"+encodeURIComponent(e)+"=([^;]*)")).exec(document.cookie))?o(s[1]):null};


(function(e,t,n){"use strict";e.fn.foundationAccordion=function(t){var n=function(e){return e.hasClass("hover")&&!Modernizr.touch};e(document).on("mouseenter",".accordion li",function(){var t=e(this).parent();if(n(t)){var r=e(this).children(".content").first();e(".content",t).not(r).hide().parent("li").removeClass("active");r.show(0,function(){r.parent("li").addClass("active")})}});e(document).on("click.fndtn",".accordion li .title",function(){var t=e(this).closest("li"),r=t.parent();if(!n(r)){var i=t.children(".content").first();if(t.hasClass("active")){r.find("li").removeClass("active").end().find(".content").hide()}else{e(".content",r).not(i).hide().parent("li").removeClass("active");i.show(0,function(){i.parent("li").addClass("active")})}}})}})(jQuery,this);

(function ($) {
	"use strict";
	$.cromabook = function(el) {
		var croma = $(el),
			now = new Date(), 
			dateToday = Math.floor(now / 1000),
			formSub = croma.find('.cro_bookingformsub'),
			valMess	= croma.find('.valmess'),
			insertTval = croma.find('.timevalues'),
			dateInput = croma.find('.cro_calendarvalue'),
			timeInput = croma.find('.cro_timevalue'),
			timeInner = croma.find('.timeselectinner'),
			loader1 = croma.find('.cro_bookingsoverlay1'),
			loader2 = croma.find('.cro_bookingsoverlay2'),
			turnRed	= {'border' : '1px solid #EF8688'},
			valiDated = 0,
			ajaxUrl = cro_query.ajaxurl,
			data = '',
			turnGrey = {'border' : '1px solid #CCCCCC'},
			bigGrey	= {'border' : '3px solid #CCCCCC'},

		methods = {
			init: function() {
				methods.valClear();
				methods.valInit();
				methods.deleGater();
				methods.dirToShow();

			},
			valInit: function() {
				croma.find('input').not(formSub).css(turnGrey);
				if (croma.find('select').length >= 1) {
					croma.find('select').css(turnGrey);
				}
				formSub.removeAttr("disabled");
				valMess.find('div').hide();
				valiDated = 0;
			},
			valClear: function() {
				croma.find('input').not(formSub).val('');
				if (croma.find('select').length >= 1) {
					croma.find('select').val('');
				}
				croma.find('textarea').val('');
				formSub.removeAttr("disabled");
				croma.find('.cro_isselected').removeClass('cro_isselected');
				croma.find('.timeselectinner').html('');
				croma.find('.cro_showtimes').removeClass('cro_showtimes');
				valiDated = 0;
			},
			deleGater: function() {
				croma.delegate('span.daynumber:not(.cro_isblocked):not(.cro_blockedday):not(.cro_dayhaspassed),.caldir, .cro_bookingformsub, .timeselect','click', function(event) {
					event.preventDefault();
					var $this = $(this);
					if ($this.hasClass('daynumber')){
						methods.bookAdate($this);
					} else if ($this.hasClass('caldir')){
						methods.calendarDir($this);
					} else if ($this.hasClass('cro_bookingformsub')){
						methods.formSubmitter();
					} else if ($this.hasClass('timeselect')){
						methods.selectAtime($this);
					}				
				});			
			},
			dirToShow: function() {
				var dateFirst	= croma.find('span.daynumber:first').attr('rel'),
					dateLast	= croma.find('span.daynumber:last').attr('rel');
				if ((dateToday > dateFirst) && (dateToday < dateLast)) {
					croma.find('.prevm').hide();
				} else {
					croma.find('.prevm').show();
				}
			},
			bookAdate: function(el) {
				var $this = $(el),
					calcDater = $this.attr('rel');
					data = { action: 'cro_get_ajaxdatas', type: 'bookingcal_fetch_timeslots', option1: calcDater, crnonce: cro_query.cro_nonces};
				loader1.fadeIn('slow');
				croma.find('.cro_isselected').removeClass('cro_isselected');
				$this.addClass('cro_isselected');
				timeInput.val('');
				dateInput.val(calcDater);
				$.post(ajaxUrl, data, function(response) {
					insertTval.addClass('cro_showtimes').find('.timeselectinner').html(response);
					loader1.fadeOut('slow');
				});
				
			},
			calendarDir: function(el) {
				var $this = $(el),
					calcMonth = $this.attr('rel');
				data = { action: 'cro_get_ajaxdatas', type: 'bookingcal_fetch_nextmonth', option1: calcMonth};
				$.post(ajaxUrl, data, function(response) {
					croma.find('.cro_calendarholder').html(response);
					methods.dirToShow();
				});
			},
			formSubmitter: function() {
				methods.valInit();
				loader2.fadeIn('slow');
				croma.find('.cro_validatethis').each(function() {
					var $this = $(this),
						inpVal = $this.val(),
						inpType = $this.attr('contents');

					switch (inpType) {
						case 'cro_ct':
							$this.css(turnGrey);
							if (inpVal.length === 0){ 
								valiDated++; $this.css(turnRed);
							}
						break;
						case 'cro_sel':
							$this.css(turnGrey);
							if (isNaN(inpVal)){ 
								valiDated++; $this.css(turnRed); 
							}
						break;
						case 'cro_cal':
							croma.find('.cro_calendarholder').css(turnGrey);
							if (inpVal.length === 0){ 
								valiDated++;croma.find('.cro_calendarholder').css(turnRed);
							}
						break;
						case 'cro_tim':
							croma.find('.cro_showtimes').css(bigGrey);
							if (inpVal.length === 0 && croma.find('.cro_showtimes').length !== 0){
								valiDated++;croma.find('.cro_showtimes').css(turnRed);
							}
						break;
					}
				});

				if (valiDated >= 1) {
					valMess.find('.bookerror').fadeIn('slow');
					loader2.fadeOut('slow');
				} else {
					var namedata = croma.find('input.nets_bookingformname').val(),
						maildata = croma.find('input.nets_bookingformmail').val(),
						caldata = croma.find('input.cro_calendarvalue').val(),
						timedata = croma.find('input.cro_timevalue').val(),
						commtdata = croma.find('textarea#bookingform-info').val(),
						teldata = croma.find('input.nets_bookingformtel').val(),
						guestdata = (croma.find('select').length >= 1)? croma.find('select.cro_guestcount').val() : '',
						data = { action: 'cro_get_ajaxdatas', type: 'bookingcal_make_booking', option1: namedata, option2: maildata, option3: caldata, option4: timedata, option5: guestdata, option6: commtdata, option7: teldata, crnonce: cro_query.cro_nonces};
						formSub.attr('disabled','disabled');
					$.post(ajaxUrl, data, function() {
						valMess.find('.booksuccess').fadeIn('slow');
						loader2.fadeOut('slow');
						window.setTimeout(
							function (){
								valMess.find('.booksuccess').fadeOut('slow');
								methods.valClear();
							},10000
						);
					});
				}
			},
			selectAtime: function(el) {
				var $this = $(el),
				timesValues = $this.attr('rel');
				timeInner.find('.timeselectselected').removeClass('timeselectselected');
				$this.addClass('timeselectselected');
				$('.bookingcommt').show();
				timeInput.val(timesValues);
			}
		};

		methods.init();
	};

	$.fn.cromabook = function() {
		var $this = $(this);
		new $.cromabook($this);
	};

})( jQuery );





(function($) { 
	"use strict";
	function randomAlphaNum() {
        var rnd = Math.floor(Math.random() * 62);
        if (rnd >= 52) {return String.fromCharCode(rnd - 4);} else if (rnd >= 26) {return String.fromCharCode(rnd + 71);} else {return String.fromCharCode(rnd + 65);}
    }

    function shuffle(a) {
        var i = a.length, j;
        while (i) {
            j = Math.floor((i--) * Math.random());
            var t = a[i];
            a[i] = a[j];
            a[j] = t;
        }
    }


    $.fn.unscramble = function(bits,pieces) {
        this.each(function() {
            var $ele = $(this), str = $ele.text(), replace = /[^\s]/,
                state = [], choose = [], reveal = bits, random = randomAlphaNum;
            
            for (var i = 0; i < str.length; i++) {
                if (str[i].match(replace)) {
                    state.push(random());
                    choose.push(i);
                } else {
                    state.push(str[i]);
                }
            }
            
            shuffle(choose);
            $ele.text(state.join(''));
            
            var timer = setInterval(function() {
                var i, r = reveal;
                while (r-- && choose.length) {
                    i = choose.pop();
                    state[i] = str[i];
                }
                for (i = 0; i < choose.length; i++) {state[choose[i]] = random();}
                $ele.text(state.join(''));
                if (choose.length === 0) {clearInterval(timer);}
            }, pieces);
        });
        return this;
    };
    
})(jQuery);



(function ($) {
	"use strict";
	$.cromaform = function(el) {
		var croma = $(el),
			formSub = croma.find('#cro_form_sub'),
			turnRed	= {'border' : '1px solid #EF8688'},
			loader1 = croma.find('.cro_bookingsoverlay1'),
			valiDated= 0,
			turnGrey= (croma.hasClass('blackform')) ? {'border' : '1px solid #2a2a2a'} : {'border' : '1px solid #CCCCCC'},

		methods = {
			init: function() {
				methods.formClear();
				methods.valReset();
				methods.deleGated();
			},
			formClear: function() {
				croma.find('input').not(formSub).val('');
				croma.find('textarea').val('');
				formSub.removeAttr("disabled");
				valiDated = 0;
			},
			valReset: function() {
				croma.find('input').not(formSub).css(turnGrey);
				croma.find('textarea').css(turnGrey);
				formSub.removeAttr("disabled");
				croma.find('.valmess').find('div').hide();
				valiDated = 0;
			},
			deleGated: function() {
				croma.delegate('#cro_form_sub','click', function(event) {
					event.preventDefault();
					methods.formSubm();			
				});			
			},
			formSubm: function() {
				methods.valReset();
				loader1.fadeIn('slow');
				croma.find('.cro_validateform').each(function() {
					var $this = $(this),
						inpVal = $this.val(),
						inpType = $this.attr('contents');

					switch (inpType) {
						case 'cro_ct':
							$this.css(turnGrey);
							if (inpVal.length === 0){ valiDated++; $this.css(turnRed);}
						break;
						case 'cro_loc':
							$this.css(turnGrey);
							if (inpVal.length !== 0){ valiDated++; $this.css(turnRed);}
						break;
					}
				});

				if (valiDated >= 1) {
					croma.find('.bookerror').fadeIn('slow');
					loader1.fadeOut('slow');
				} else {
					var namedata = croma.find('input#cro_form_name').val(),
						maildata = croma.find('input#cro_form_mail').val(),
						commtdata = croma.find('textarea#cro_form_cmmt').val(),
						teldata = croma.find('input#cro_form_tel').val(),
						locdata = croma.find('#cro_form_loc').val(),
						data = { action: 'cro_get_ajaxdatas', type: 'bookingcal_form_submit', option1: namedata, option2: maildata, option3: commtdata, option4: teldata, option5: locdata};
						formSub.attr('disabled','disabled');
					$.post(cro_query.ajaxurl, data, function() {
						croma.find('.booksuccess').fadeIn('slow');
						loader1.fadeOut('slow');
						window.setTimeout(
							function (){
								croma.find('.booksuccess').fadeOut('slow');
								methods.formClear();
							},10000
						);
					});
				}
			},		
		};
		methods.init();
	};
	$.fn.cromaform = function(){new $.cromaform($(this));};
 })( jQuery );




jQuery(document).ready(function($) {

	"use strict";

	var ajaxNonces = cro_query.cro_nonces,
		ajaxUrls = cro_query.ajaxurl,
		croInit = '',
		croInits = '';

	$(document).foundationAccordion();

	$('.quickiemenu:odd').addClass('cro_bitty');


	$('#slides').orbit({
		animation: 'fade',
		captions: false,
		bullets: false,
		advanceSpeed: cro_query.cro_slspeed,
		animationSpeed: 800,
		afterSlideChange: function(){
			$('#slides').find('.flex-active-slide').removeClass('flex-active-slide');
			$('#slides').find('.orbit-slide').each(function() {
				var currentZindex = parseInt($(this).css('z-index'), 10);
				if (currentZindex === 3){
					$(this).addClass('flex-active-slide');
				}
			});
		}
	});


	$('#slides').find('.orbit-slide:first').addClass('flex-active-slide');

	$('.cro_slideinit').click(function() {
		window.open('https://vimeo.com/57837715','_blank');
		window.focus();
	});

	/* ========================= COUNTDOWN TIMER ======================== */

	function croAnim(){	

		if ($('ul.timervalue').length !== 0) {
			$('ul.timervalue').each(function() {
				var $this = $(this),
					timesets = $this.attr('rel'),				
					now = new Date(),
					tset = Math.floor(now / 1000),
					counter1 = timesets - tset,
					seconds1 = Math.floor(counter1 % 60);
			
				seconds1 = (seconds1 < 10 && seconds1 >= 0) ? '0'+ seconds1 : seconds1;

				counter1=counter1/60;
				var minutes1=Math.floor(counter1 % 60);
				minutes1 = (minutes1 < 10 && minutes1 >= 0) ? '0'+ minutes1 : minutes1;

				counter1=counter1/60;
				var hours1=Math.floor(counter1 % 24);
				hours1 = (hours1 < 10 && hours1 >= 0) ? '0'+ hours1 : hours1;
			
				counter1=counter1/24;
				var days1=Math.floor(counter1);
				days1 = (days1 < 10 && days1 >= 0) ? '0'+ days1 : days1;

				$this.find('span.secondnumber').html(seconds1);
				$this.find('span.minutenumber').html(minutes1);
				$this.find('span.hournumber').html(hours1);
				$this.find('span.daynumber').html(days1);			
			});
		}
	}

	croInit = setInterval(croAnim, 100);


	if ($('.welcomemsg').length >= 1) {

		var atop = $('.welcomemsg').offset(),
			aHeight = $('.welcomemsg').height(),
			wHeight = $(window).height(),
			doneyet = 0,
			topCalc = atop.top - (wHeight - aHeight);


		$(window).scroll(function() {
			var apart = $(window).scrollTop();


			if (apart >= topCalc  && doneyet === 0) {
				$(".welcomemsg p").unscramble(25,100);
				$(".welcomemsg h3").unscramble(3,100);
				doneyet++;
			}
		});

	}


	/* ========================= BANNER ======================== */

	var countthis = 1;

	function croBanner(){	
		$('.bannerprocess').each(function() {
			var $this = $(this),
				countno	= $this.children('.cro_bannerouter').length;
			$this.find('.bannercurrent').removeClass('bannercurrent');
			$this.children('.cro_bannerouter').eq(countthis - 1).addClass('bannercurrent');
			countthis++;
			countthis = (countthis > countno) ? 1 : countthis;
		});
	}

	if ($('.bannerprocess').find('.cro_bannerouter').length >= 2) {
		croInits = setInterval(croBanner, cro_query.cro_slspeed);
		croBanner();

		$('.bannernext').click(function() {
			clearInterval(croInits);
			croInits = setInterval(croBanner, cro_query.cro_slspeed);
			croBanner();
		});
	} else if ($('.bannerprocess').find('.cro_bannerouter').length === 1) {
		$('.bannerprocess').find('.cro_bannerouter').addClass('bannercurrent');
		$('.bannerprevious').hide();
	}


	/* ========================= FOUNDATION ======================== */
	$('.myModal').each(function() {$(this).detach().prependTo('#modalholder');});
	$(".videodiv").click(function() {var mystr = $(this).attr('rel');var mylighboxstring = '.myModal[rel="' +  mystr  + '"]';$(mylighboxstring).reveal();});
	$('.secondnav ul li:odd a').addClass('cro_oddline');



	// UPDATE TWEETS
	var data = { action: 'cro_get_ajaxdatas', type: 'updte_tweet', nonce: ajaxNonces};
	$.post(ajaxUrls, data);

	// NEWSLETTER
	$('.newssubmit').click(function() {
		var $this = $(this),
			p = $this.parents('form'),
			submitted = 0,
			label = $this.attr('value'),
			labelcopy = $this.attr('value'),
			mlength = label.length,
			initanim = setInterval(intanm,300),
			valemail = p.find('.netlabs_newsmail').val(),	
			valcontent = p.find('.netlabs_newsname').val(),
			valcontrol = cro_valinput(p.find('.newsloc').val(), 'control'),
			succ = p.find('.valsuccess'),
			errr = p.find('.valerror');

		$this.css('cursor','wait').attr('disabled', 'disabled');
		succ.fadeOut('slow');
		errr.fadeOut('slow');

		if (cro_valinput(valcontent,'input') && cro_valemail(valemail)  && valcontrol && submitted === 0) {
			var data = { action: 'cro_get_ajaxdatas', type: 'submit_newsl', nonce: ajaxNonces, option1: valemail, option2: valcontent};
			$.post(ajaxUrls, data, function() {
				succ.fadeIn('fast');
				window.clearInterval(initanim);
				$this.attr('value',labelcopy);
				$this.css('cursor','pointer');
				submitted++;	
			});
		} else {
			errr.fadeIn('fast');
			$this.css('cursor','pointer').removeAttr("disabled");
			window.clearInterval(initanim);
			$this.attr('value',labelcopy);
		}


		function intanm() {
			label = (label.length <= mlength + 5) ?  label + '.' : labelcopy ;
			$this.attr('value',label);
		}

		return false;
	});



	/* ========================= EVENTS CALENDAR ======================== */
	$(document).on("click", ".agendir", function(){ 
		var timings = $(this).attr('rel'),
			data = { action: 'cro_get_ajaxdatas', type: 'cro_moveagenda', nonce: ajaxNonces, option1: timings};
		$.post(ajaxUrls, data, function(response) {
			var mydiv = $('.cro_agendadiv');
			mydiv.html(response);
		});
	});


	/* ========================= EVENTS CALENDAR ======================== */
	$(document).on("click", ".caldir", function(){ 
		var $this = $(this),
			timings = $this.attr('rel'),
			data = { action: 'cro_get_ajaxdatas', type: 'cro_movecal', nonce: ajaxNonces, option1: timings};
		$.post(ajaxUrls, data, function(response) {
			var mydiv = $('.caldiv'),
				wdt   = mydiv.width();
			mydiv.html(response);
			cro_hgtr(mydiv);
			if (wdt < 560) {
				$('ul.calday').hide();
				$('li.empty').hide();
			} else {
				$('ul.calday').show();
				$('li.empty').show();
			}
		});
	});

	if ($('.caldiv').length >= 1) {
		var $this = $('.caldiv');
		cro_hgtr($this);


		$(window).resize(function() {
			var wdt = $('.caldiv').width();

			if (wdt < 560) {
				$('ul.calday').hide();
				$('li.empty').hide();
			} else {
				$('ul.calday').show();
				$('li.empty').show();
			}

		});
	}


	var wdt = $('.caldiv').width();

	if (wdt < 560) {
		$('ul.calday').hide();
		$('li.empty').hide();
	} 


	function cro_hgtr(el){
		var $this = el;
		$this.each(function() {
			var hgt = 0;
			$('ul.maincal li').each(function() {
				var thgt = $(this).height();
				if (thgt > hgt) {
					hgt = thgt;
				}
			});

			if (hgt > 120){
				$(this).find('.maincal li').find('.daybox').css('height', hgt + 'px');
			}

		});
	}


	/* ========================= LIGHTBOX ======================== */
	$('.galholderski').click(function() {
		var clicklist = $(this).parents('.widget-container').find('ul.cro_gallerycontentwidget'),
			clicklistli = clicklist.find('li'),
			da_list  = clicklist.html(),
			da_count = clicklistli.length,
			da_thispage	= 1,
			da_markup = '<div class="cro_galelement"><div class="cro_thumbholder"><div class="cro_listholder"><ul class="cro_listoflists"></ul></div><div class="cro_thumbnext cro_thumbdir"></div><div class="cro_thumbprev cro_thumbdir"></div></div><div class="cro_showholder"><div class="cro_closegallery"></div><div class="cro_loadergal"></div><div class="cro_titlegal"><p>This is the title</p></div></div><div class="cro_biggalleft cro_bigdir"></div><div class="cro_biggalright cro_bigdir"></div></div>',
			da_window = 0,
			da_window_w = 0,
			da_thumbwidth = 0,
			da_stage = 0,
			da_stage_w = 0,
			da_perpage = 0,
			da_pagenums = 0,
			da_galtest = 0,
			da_onlastpage = 0,
			da_elementset = '',
			da_holderset = '',
			da_dirset = '',
			da_listset = '';


			// mask
		$('<div>').addClass('reveal-modal-bg').css('background','rgba(0,0,0,0.8)').show().prependTo('.galholder');

		da_set_things_up();


		// set up the close buttons
		$('.cro_closegallery').click(function() {
			$('.galholder').html('').hide();
		});

		$(window).resize(function() {
			da_set_things_up();
			if (('.cro_showholder img').length !== 0) {
				var ofset = { top: 0, left: 0 };
				ofset = $('.cro_showholder').find('img').offset();
				var wdt = $('.cro_showholder img').width();
				var dim = (typeof(ofset) === 'object')? da_window_w - wdt - ofset.left - 90 : dim = da_window_w - wdt -  90;
				dim = dim + 'px';

				$('.cro_closegallery').css('right', dim);

				var owidth = $('.cro_showholder img').width(),
					oheight = $('.cro_showholder img').height(),
					maxheight = Math.floor(da_stage * 0.9),
					proportion = owidth / oheight;


				if (da_stage < (oheight + 50)) {

					$('.cro_showholder img').css('height', maxheight + 'px');
					oheight = maxheight;
					owidth = maxheight * proportion;
				}

				var topband = Math.floor(da_stage - oheight) / 2;
				var rightband = Math.floor(da_stage_w - owidth) / 2;
				$('.cro_showholder img').css('margin-top', topband + 'px');
				$('.cro_closegallery').css('top', topband + 'px');
				$('.cro_closegallery').css('right', rightband + 'px');
			}
		});

		$('.cro_thumbdir').click(function() {

			if ($(this).hasClass('cro_thumbprev')){
				if ((da_thispage - 1) === 1 ) {
					$('ul.cro_listoflists').animate({left: '0px'}, 1000);
					da_thispage--;
				} else if((da_thispage - 1) > 1 ) {
					$('ul.cro_listoflists').animate({left: '+=' + da_perpage * 105}, 1000);
					da_thispage--;
				}


			} else {
				if ((da_thispage + 1) === da_pagenums ) {
					var da_tomove = 105 * da_onlastpage;
					$('ul.cro_listoflists').animate({left: '-=' + da_tomove}, 1000);
					da_thispage++;
				} else if ((da_thispage + 1) < da_pagenums ) {
					$('ul.cro_listoflists').animate({left: '-=' + da_perpage * 105}, 1000);
					da_thispage++;
				}
			}

			manage_da_thumbs();
		});



		// set up the directional buttons
		$('.cro_bigdir').click(function() {
			var current = $('ul.cro_listoflists li.crocurrgal'),
				target = '';

			if ($(this).hasClass('cro_biggalright')){
				target = current.next('li').length ? current.next('li'): $('ul.cro_listoflists li:first');
			} else {
				target = current.prev('ul.cro_listoflists li').length ? current.prev('li'): $('ul.cro_listoflists li:last');
			}

			current.removeClass('crocurrgal');
			target.addClass('crocurrgal');
			push_da_image(target.attr('contents'), target.attr('title'));

		});

		// show the image thumbs
		$('.cro_listholder li').each(function() {
				var $this = $(this);
				var thumbsrc = $this.attr('rel');
				$this.html('<img src="' + thumbsrc + '"/>');
				$this.unbind('click').bind('click',load_da_stage);
		});

		
		push_da_image('','');


		function da_set_things_up() {

			da_window = $(window).height(); 
			da_window_w = $(window).width();
			da_thumbwidth = da_count * 115;
			da_stage = da_window - 195;
			da_stage_w = da_window_w - 180;
			da_elementset = {'height' : da_window + 'px'};
			da_holderset = {'width' : da_stage_w + 'px','height'	: da_stage + 'px'};
			da_dirset = {'height' : da_stage + 'px'};
			da_listset = {'width' : (da_window_w - 100) + 'px'};
			da_perpage = Math.floor((da_window_w - 100)/105);
			da_pagenums = Math.ceil(da_count/da_perpage);
			
			// setup the show
			if (da_galtest === 0) {
				$(da_markup).prependTo('.galholder');
				$('.cro_listoflists').html(da_list);
				da_galtest++;
			}
			$('.cro_galelement').show().css(da_elementset);
			$('.cro_showholder').css(da_holderset);
			$('.cro_biggalleft').css(da_dirset);
			$('.cro_biggalright').css(da_dirset);
			$('.cro_listholder').css(da_listset);
			$('.cro_listoflists').css('width', da_thumbwidth + 'px');


			if (da_pagenums === 1) {
				var elemwdt = da_count * 105;
				var da_margin = (da_window_w - 100 - elemwdt)/2;
				$('.cro_listholder').css('margin-left', da_margin +'px');
			}


			// set up pages
			if (da_pagenums >= 2) {
				da_onlastpage = da_count - (da_perpage * (da_pagenums - 1));
			}

			manage_da_thumbs();
		}

		function manage_da_thumbs() {
			if (da_thispage >= 2 ) {
				$('.cro_thumbprev').show();
			} else {
				$('.cro_thumbprev').hide();
			}

			if (da_thispage <= (da_pagenums - 1) ) {
				$('.cro_thumbnext').show();
			} else {
				$('.cro_thumbnext').hide();
			}
		}

		function load_da_stage() {
			var $this = $(this);
			var thumb_src = $this.attr('contents');
			var thumb_title = $this.attr('title');
			$('.crocurrgal').removeClass('crocurrgal');
			$this.addClass('crocurrgal');
			push_da_image(thumb_src, thumb_title);
		}

		function push_da_image(img_string, title_string) {			
			var img = new Image();
			$('.cro_loadergal').show();

			if (!img_string) {
				img_string = $('ul.cro_listoflists li:first').attr('contents');
				title_string  = $('ul.cro_listoflists li:first').attr('title');
				$('ul.cro_listoflists li:first').addClass('crocurrgal');
				$('.cro_biggalright').show();
				$('.cro_biggalleft').show();
			}


			$('.cro_showholder img').remove();
			$('.cro_titlegal p').html('').css('display','none');

			$(img).bind('load', function() {			
				$('.cro_showholder').prepend(this);
				$('.cro_loadergal').hide();
				if (title_string) {
					$('.cro_titlegal p').html(title_string).css('display','inline-block');
				} else {
					$('.cro_titlegal p').css('display','none');
				}

				var owidth = $(this).width(),
					oheight = $(this).height(),
					maxheight = Math.floor(da_stage * 0.9),
					proportion = owidth / oheight;


				if (da_stage < (oheight + 50)) {
					oheight = maxheight;
					owidth = maxheight * proportion;
					var  da_newhw = {'width' : owidth + 'px','height'	: oheight + 'px'};
					$(this).css(da_newhw);
				}

				var topband = Math.floor(da_stage - oheight) / 2;
				var rightband = Math.floor(da_stage_w - owidth) / 2;
				$('.cro_closegallery').css('top', topband + 'px');
				$('.cro_closegallery').css('right', rightband + 'px');
				$('.cro_closegallery').show();
				$(img).css('margin-top', topband + 'px');
			}).attr('src', img_string);		
		}

		$('.galholder').show();
	});
	

	/* ========================= HELPERS ======================== */
	function cro_valemail($email){var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;if(!emailReg.test($email)||!$email){return false;}else{return true;}}
	function cro_valinput($input, $type){if(!$input && $type ==='input'){return false;} else if ($input && $type === 'input'){return true;} else if (!$input && $type === 'control'){return true;} else if ($input && $type === 'control'){return false;}}


	/* ========================= BOOKINGS ======================== */
	$('.cro_bookingsform').cromabook();
	$('form#ctcform').cromaform();


	if ($('.cro_sch').length !== 0) {
		
		$('.secpoint').click(function() {
			var cookiesets = $.cookie('cro_css'),
				cookiesetr = $.cookie('cro_cssb'),
				cookieset = '',
				logostring = '',
				styler = $(this).attr('rel'),
				cookiepath = $('.cro_sch').attr('rel'),
				logopath = $('.cro_prim').attr('rel'),
				styleh = '';
			
			if (!cookiesets) {
				cookiesets = 1;
				cookiesetr = 1;
			}
			
			if ($(this).hasClass('prim')){
				cookiesetr = styler;
			} else {
				cookiesets = styler;
			}

			cookieset = cookiesetr + cookiesets;
			styleh = cookiepath + cookieset + '.css';

			$('#croma_color-css').attr('href', styleh);
			$.cookie("cro_css", cookiesets, {expires: 365, path: '/'});
			$.cookie("cro_cssb", cookiesetr, {expires: 365, path: '/'});

			if (cookiesetr === 1) {
				logostring = logopath + '/lightlogo.png';
			} else {
				logostring = logopath + '/darklogo.png';
			}

			$('img.tllogo').attr('src', logostring);

		}); 
	}
	
});


