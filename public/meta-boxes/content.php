<?php
/*
 * Netlabs Admin Framework
 */
 
 
function lets_define_meta_layouts() {
	$ntl_metas = array(
		array(
			'tab' 				=> '0',
			'tabname' 			=> __('General', 'localize'),
			'type'				=> 'page',
			'title'				=> __('Page additional content', 'localize'),
			'context'			=> 'normal',
			'priority'			=> 'high',
			'values' 			=> array(
				array(		
					'type' 		=> 'getselectbox',
					'fn' 		=> 'cro_sidebar',
					'heading'	=> __('Layout', 'localize'),
					'options'	=> array(__('With Sidebar','localize'),__('Fullwidth','localize')),
					'desc'		=> __('Should the page have a sidebar or not?','localize'),
					'before' 	=> 'half',
					'after' 	=> 'endone'
				),
				array(		
					'type' 		=> 'getsidebarbox',
					'fn' 		=> 'cro_sidebarsel',
					'heading'	=> __('Sidebar', 'localize'),
					'options'	=> '',
					'desc'		=> __('If the page is not fullwidth, what widget area should be used?','localize'),
					'before' 	=> 'half',
					'after' 	=> 'endone'
				)							
			)				
		),
		array(
			'tab' 				=> '0',
			'tabname' 			=> __('General', 'localize'),
			'type'				=> 'slideshows',
			'title'				=> __('Slideshow additional content', 'localize'),
			'context'			=> 'normal',
			'priority'			=> 'high',
			'values' 			=> array(

				array(		
					'type' 		=> 'getinput',
					'fn' 		=> 'cro_imgtitle',
					'heading'	=> __('Image Title', 'localize'),
					'desc'		=> __('Name of the image title?','localize'),
					'before' 	=> 'half',
					'after' 	=> ''
				),
				array(		
					'type' 		=> 'getinput',
					'fn' 		=> 'cro_linklabel',
					'heading'	=> __('Link label', 'localize'),
					'desc'		=> __('Name link label','localize'),
					'before' 	=> '',
					'after' 	=> 'endone'
				),
				array(		
					'type' 		=> 'gettextarea',
					'fn' 		=> 'cro_imgcontent',
					'heading'	=> __('Slider Content', 'localize'),
					'options'	=> '',
					'desc'		=> __('Content of the slider area','localize'),
					'before' 	=> 'half',
					'after' 	=> 'endone'
				),
											
			)				
		),
		array(
			'tab' 				=> '0',
			'tabname' 			=> __('General', 'localize'),
			'type'				=> 'locations',
			'title'				=> __('Locations additional content', 'localize'),
			'context'			=> 'normal',
			'priority'			=> 'high',
			'values' 			=> array(
				
				array(		
					'type' 		=> 'gettextarea',
					'fn' 		=> 'cro_streetaddr',
					'heading'	=> __('Street address', 'localize'),
					'options'	=> '',
					'desc'		=> __('Physical Street address','localize'),
					'before' 	=> 'half',
					'after' 	=> ''
				),
				array(		
					'type' 		=> 'getselectbox',
					'fn' 		=> 'cro_mapzoom',
					'heading'	=> __('Map zoom', 'localize'),
					'options'	=> array(4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23),
					'desc'		=> __('how far should the map be zoomed','localize'),
					'before' 	=> '',
					'after' 	=> ''
				),
				array(		
					'type' 		=> 'getinput',
					'fn' 		=> 'cro_mapheight',
					'heading'	=> __('Map height', 'localize'),
					'desc'		=> __('what is the height in of the map?','localize'),
					'before' 	=> '',
					'after' 	=> ''
				),	
				array(		
					'type' 		=> 'getinput',
					'fn' 		=> 'cro_sworient',
					'heading'	=> __('Streetview orientation.', 'localize'),
					'desc'		=> __(' from 0degrees to 360degrees how should the streetview be changed?','localize'),
					'before' 	=> '',
					'after' 	=> ''
				),
				array(		
					'type' 		=> 'getinput',
					'fn' 		=> 'cro_latlong',
					'heading'	=> __('Lattitude and longitude.', 'localize'),
					'desc'		=> __('What is the lattitude and longitude of the map as specified in the map tool?','localize'),
					'before' 	=> '',
					'after' 	=> 'endone'
				),
				array(		
					'type' 		=> 'getinput',
					'fn' 		=> 'cro_telephone',
					'heading'	=> __('Telephone number', 'localize'),
					'desc'		=> __('What is the telephone number','localize'),
					'before' 	=> 'half',
					'after' 	=> ''
				),
				array(		
					'type' 		=> 'getinput',
					'fn' 		=> 'cro_contactmail',
					'heading'	=> __('Email address', 'localize'),
					'desc'		=> __('What is the email address?','localize'),
					'before' 	=> '',
					'after' 	=> ''
				),
				array(		
					'type' 		=> 'getinput',
					'fn' 		=> 'cro_fax',
					'heading'	=> __('Fax number', 'localize'),
					'desc'		=> __('What is the fax number?','localize'),
					'before' 	=> '',
					'after' 	=> ''
				),
				array(		
					'type' 		=> 'getinput',
					'fn' 		=> 'cro_dirhttp',
					'heading'	=> __('Directions link', 'localize'),
					'desc'		=> __('What is the web address that we should link to for the get directions map?','localize'),
					'before' 	=> '',
					'after' 	=> ''
				),
				array(		
					'type' 		=> 'gettextarea',
					'fn' 		=> 'cro_operatinghrs',
					'heading'	=> __('Hours of operation', 'localize'),
					'desc'		=> __('Description of the hours of operation','localize'),
					'options'	=> '',
					'before' 	=> '',
					'after' 	=> 'endone'
				)									
			)				
		),
		array(
			'tab' 				=> '0',
			'tabname' 			=> __('General', 'localize'),
			'type'				=> 'post',
			'title'				=> __('Page additional content', 'localize'),
			'context'			=> 'normal',
			'priority'			=> 'high',
			'values' 			=> array(
				array(		
					'type' 		=> 'getselectbox',
					'fn' 		=> 'cro_sidebar',
					'heading'	=> __('Layout', 'localize'),
					'options'	=> array(__('With Sidebar','localize'),__('Fullwidth','localize')),
					'desc'		=> __('Should the page have a sidebar or not?','localize'),
					'before' 	=> 'half',
					'after' 	=> ''
				),
				array(		
					'type' 		=> 'getsidebarbox',
					'fn' 		=> 'cro_sidebarsel',
					'heading'	=> __('Sidebar', 'localize'),
					'desc'		=> __('If the page is not fullwidth, what widget area should be used?','localize'),
					'options'	=> '',
					'before' 	=> '',
					'after' 	=> 'endone'
				),
				array(		
					'type' 		=> 'getselectbox',
					'fn' 		=> 'cro_readmore',
					'heading'	=> __('Read more button', 'localize'),
					'options'	=> array(__('Yes','localize'),__('No','localize')),
					'desc'		=> __('Should we add a read more button in category view?','localize'),
					'before' 	=> 'half',
					'after' 	=> ''
				),
				array(		
					'type' 		=> 'gettextarea',
					'fn' 		=> 'cro_videogal',
					'heading'	=> __('Video for video post', 'localize'),
					'desc'		=> __('If this is a video type post, add a link to the Youtube or Vimeo video here.','localize'),
					'options'	=> '',
					'before' 	=> '',
					'after' 	=> 'endone'
				)										
			)				
		),
		array(
			'tab' 				=> '0',
			'tabname' 			=> __('General', 'localize'),
			'type'				=> 'events',
			'title'				=> __('Events additional content', 'localize'),
			'context'			=> 'normal',
			'priority'			=> 'high',
			'values' 			=> array(	
				array(		
					'type' 		=> 'getslider',
					'fn' 		=> 'cro_thisslider',
					'heading'	=> __('Time settings', 'localize'),
					'options'	=> '',
					'desc'		=> __('Select the time of the event','localize'),
					'before' 	=> 'half',
					'after' 	=> ''
				),
				array(		
					'type' 		=> 'selectrecurring',
					'fn' 		=> 'cro_selrec',
					'heading'	=> __('Type of event', 'localize'),
					'options'	=> '',
					'desc'		=> __('select the recurring type of this event','localize'),
					'before' 	=> '',
					'after' 	=> ''
				),
				array(		
					'type' 		=> 'getselectbox',
					'fn' 		=> 'cro_sidebar',
					'heading'	=> __('Layout', 'localize'),
					'options'	=> array(__('With Sidebar','localize'),__('Fullwidth','localize')),
					'desc'		=> __('Should the page have a sidebar or not?','localize'),
					'before' 	=> '',
					'after' 	=> ''
				),
				array(		
					'type' 		=> 'getsidebarbox',
					'fn' 		=> 'cro_sidebarsel',
					'heading'	=> __('Sidebar', 'localize'),
					'options'	=> '',
					'desc'		=> __('If the page is not fullwidth, what widget area should be used?','localize'),
					'before' 	=> '',
					'after' 	=> 'endone'
				),

				array(		
					'type' 		=> 'getcal',
					'fn' 		=> 'cro_thiscalbox',
					'heading'	=> __('Calendar', 'localize'),
					'options'	=> array(__('one','localize'),__('two','localize'),__('three','localize')),
					'desc'		=> __('Select a date','localize'),
					'before' 	=> 'half',
					'after' 	=> ''
				),
				array(		
					'type' 		=> 'gettextarea',
					'fn' 		=> 'cro_bannerline',
					'heading'	=> __('Banner description', 'localize'),
					'options'	=> '',
					'desc'		=> __('Short description if the banners are used.','localize'),
					'before' 	=> '',
					'after' 	=> 'endone'
				)															
			)				
		),
		array(
			'tab' 				=> '0',
			'tabname' 			=> __('General', 'localize'),
			'type'				=> 'promotions',
			'title'				=> __('Promotions additional content', 'localize'),
			'context'			=> 'normal',
			'priority'			=> 'high',
			'values' 			=> array(	
				array(		
					'type' 		=> 'getinput',
					'fn' 		=> 'cro_timedesc',
					'heading'	=> __('Time description', 'localize'),
					'options'	=> '',
					'desc'		=> __('What is the time description (in words) of this promotion (ex: 10h00 till 22h00)','localize'),
					'before' 	=> 'half',
					'after' 	=> ''
				),
				array(		
					'type' 		=> 'selectrecurring',
					'fn' 		=> 'cro_selrec',
					'heading'	=> __('Type of event', 'localize'),
					'options'	=> '',
					'desc'		=> __('Select the recurring type for this event','localize'),
					'before' 	=> '',
					'after' 	=> ''
				),
				array(		
					'type' 		=> 'getselectbox',
					'fn' 		=> 'cro_sidebar',
					'heading'	=> __('Layout', 'localize'),
					'options'	=> array(__('With Sidebar','localize'),__('Fullwidth','localize')),
					'desc'		=> __('Should the page have a sidebar or not?','localize'),
					'before' 	=> '',
					'after' 	=> ''
				),
				array(		
					'type' 		=> 'getsidebarbox',
					'fn' 		=> 'cro_sidebarsel',
					'heading'	=> __('Sidebar', 'localize'),
					'options'	=> '',
					'desc'		=> __('If the page is not fullwidth, what widget area should be used?','localize'),
					'before' 	=> '',
					'after' 	=> 'endone'
				),	
				array(		
					'type' 		=> 'getcal',
					'fn' 		=> 'cro_thiscalbox',
					'heading'	=> __('Calendar', 'localize'),
					'options'	=> array(__('one','localize'),__('two','localize'),__('three','localize')),
					'desc'		=> __('Select a date','localize'),
					'before' 	=> 'half',
					'after' 	=> ''
				),
				array(		
					'type' 		=> 'gettextarea',
					'fn' 		=> 'cro_bannerline',
					'heading'	=> __('Description', 'localize'),
					'options'	=> '',
					'desc'		=> __('Short description of the event','localize'),
					'before' 	=> '',
					'after' 	=> ''
				),
				array(		
					'type' 		=> 'getinput',
					'fn' 		=> 'cro_value',
					'heading'	=> __('Special price', 'localize'),
					'options'	=> '',
					'desc'		=> __('Price or value description for the promotion','localize'),
					'before' 	=> '',
					'after' 	=> 'endone'
				),										
			)				
		),
		array(
			'tab' 				=> '0',
			'tabname' 			=> __('General', 'localize'),
			'type'				=> 'members',
			'title'				=> __('Teams additional content', 'localize'),
			'context'			=> 'normal',
			'priority'			=> 'high',
			'values' 			=> array(	
				array(		
					'type' 		=> 'gettextarea',
					'fn' 		=> 'cro_teamdesc',
					'heading'	=> __('Description', 'localize'),
					'options'	=> '',
					'desc'		=> __('Short description of the team member','localize'),
					'before' 	=> 'half',
					'after' 	=> 'endone'
				),
				array(		
					'type' 		=> 'getselectbox',
					'fn' 		=> 'cro_sidebar',
					'heading'	=> __('Layout', 'localize'),
					'options'	=> array(__('With Sidebar','localize'),__('Fullwidth','localize')),
					'desc'		=> __('Should the page have a sidebar or not?','localize'),
					'before' 	=> 'half',
					'after' 	=> ''
				),
				array(		
					'type' 		=> 'getsidebarbox',
					'fn' 		=> 'cro_sidebarsel',
					'heading'	=> __('Sidebar', 'localize'),
					'desc'		=> __('If the page is not fullwidth, what widget area should be used?','localize'),
					'options'	=> '',
					'before' 	=> '',
					'after' 	=> 'endone'
				),									
			)				
		),
		array(
			'tab' 				=> '0',
			'tabname' 			=> __('General', 'localize'),
			'type'				=> 'reservations',
			'title'				=> __('Reservations additional content', 'localize'),
			'context'			=> 'normal',
			'priority'			=> 'high',
			'values' 			=> array(	
				array(		
					'type' 		=> 'getslider2',
					'fn' 		=> 'cro_time',
					'heading'	=> __('Time settings', 'localize'),
					'options'	=> '',
					'desc'		=> __('Select the time of the event','localize'),
					'before' 	=> 'half',
					'after' 	=> ''
				),
				array(		
					'type' 		=> 'getselectbox',
					'fn' 		=> 'cro_status',
					'heading'	=> __('Status', 'localize'),
					'options'	=> array(__('Unconfirmed','localize'),__('Confirmed','localize'), __('Cancelled','localize')),
					'desc'		=> __('Reservation status','localize'),
					'before' 	=> '',
					'after' 	=> ''
				),
				array(		
					'type' 		=> 'getinput',
					'fn' 		=> 'cro_mail',
					'heading'	=> __('Email', 'localize'),
					'options'	=> '',
					'desc'		=> __('Customer email','localize'),
					'before' 	=> '',
					'after' 	=> ''
				),
				array(		
					'type' 		=> 'getinput',
					'fn' 		=> 'cro_tel',
					'heading'	=> __('Telephone', 'localize'),
					'options'	=> '',
					'desc'		=> __('Customer Telephone number','localize'),
					'before' 	=> '',
					'after' 	=> 'endone'
				),
				array(		
					'type' 		=> 'getcal',
					'fn' 		=> 'cro_date',
					'heading'	=> __('Booking Date', 'localize'),
					'options'	=> array(__('one','localize'),__('two','localize'),__('three','localize')),
					'desc'		=> __('Select a date','localize'),
					'before' 	=> 'half',
					'after' 	=> ''
				),
				array(		
					'type' 		=> 'gettextarea',
					'fn' 		=> 'cro_comments',
					'heading'	=> __('Notes', 'localize'),
					'options'	=> '',
					'desc'		=> __('Booking notes','localize'),
					'before' 	=> '',
					'after' 	=> 'endone'
				)										
			)				
		),
		array(
			'tab' 				=> '0',
			'tabname' 			=> __('General', 'localize'),
			'type'				=> 'menus',
			'title'				=> __('Menus additional content', 'localize'),
			'context'			=> 'normal',
			'priority'			=> 'high',
			'values' 			=> array(	
				array(		
					'type' 		=> 'getinput',
					'fn' 		=> 'cro_foodprice',
					'heading'	=> __('Price', 'localize'),
					'before' 	=> 'half',
					'desc'		=> __('Price for the item','localize'),
					'after' 	=> 'endone'
				)										
			)				
		)		
	);

	return apply_filters( 'lets_define_meta_layouts',$ntl_metas );
}



?>