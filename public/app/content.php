<?php
/*
 * Netlabs Admin Framework
 */
 
 
function lets_define_booking_layouts() {
	$crob_layouts = array(
		array(
			'dash' 				=> '0',
			'tab' 				=> '0',
			'action' 			=> '0',
			'dashname' 			=> __('Bookings', 'localize'),
			'tabname' 			=> __('Month View', 'localize'),
			'savetype' 			=> 'querysave',
			'updatemess' 		=> __('Updated', 'localize'),
			'posttype' 			=> '',
			'values' 			=> array(	


				array(
					'type'		=> 'bookingcal',
					'name' 		=> __('Booking calendar', 'localize'),
					'fn' 		=> 'ntl_bookingcal',
					'def' 		=> '',
					'desc' 		=> __('Booking calendar', 'localize'),
					'before' 	=> 'startbroad',
					'after' 	=> ''
				)


			)				
		),
		array(
			'dash' 				=> '0',
			'tab' 				=> '1',
			'action' 			=> '0',
			'dashname' 			=> __('Bookings', 'localize'),
			'tabname' 			=> __('Day View', 'localize'),
			'savetype' 			=> 'querysave',
			'updatemess' 		=> __('Updated', 'localize'),
			'posttype' 			=> '',
			'values' 			=> array(	


				array(
					'type'		=> 'bookdayview',
					'name' 		=> __('Booking calendar', 'localize'),
					'fn' 		=> 'ntl_bookingcal',
					'def' 		=> '',
					'desc' 		=> __('Booking calendar', 'localize'),
					'before' 	=> 'startbroad',
					'after' 	=> 'endone'
				)
			)				
		),
		
		array(
			'dash' 				=> '1',
			'tab' 				=> '0',
			'action' 			=> '0',
			'dashname' 			=> __('Settings', 'localize'),
			'tabname' 			=> __('Schedules', 'localize'),
			'savetype' 			=> 'optionsave',
			'updatemess' 		=> __('Schedules updated', 'localize'),
			'posttype' 			=> 'schedule',
			'values' 			=> array(

				array(
					'type'		=> 'schedone',
					'name' 		=> __('Booking slots', 'localize'),
					'fn' 		=> 'ntl_bookslote',
					'def' 		=> '',
					'desc' 		=> __('Booking slots', 'localize'),
					'before' 	=> 'startbroad',
					'after' 	=> ''
				)
						
			)				
		),

		array(
			'dash' 				=> '1',
			'tab' 				=> '1',
			'action' 			=> '0',
			'dashname' 			=> __('Settings', 'localize'),
			'tabname' 			=> __('Guests', 'localize'),
			'savetype' 			=> 'optionsave',
			'updatemess' 		=> __('Guests updated', 'localize'),
			'posttype' 			=> 'schedule',
			'values' 			=> array(

				array(
					'type'		=> 'guestman',
					'name' 		=> __('Booking slots', 'localize'),
					'fn' 		=> 'ntl_bookslote',
					'def' 		=> '',
					'desc' 		=> __('Booking slots', 'localize'),
					'before' 	=> 'startbroad',
					'after' 	=> ''
				)
						
			)				
		),

		array(
			'dash' 				=> '1',
			'tab' 				=> '2',
			'action' 			=> '0',
			'dashname' 			=> __('Settings', 'localize'),
			'tabname' 			=> __('Settings', 'localize'),
			'savetype' 			=> 'optionsave',
			'updatemess' 		=> __('Settings updated', 'localize'),
			'posttype' 			=> '',
			'values' 			=> array(

				array(
					'type'		=> 'selectone',
					'name' 		=> __('Days Before', 'localize'),
					'fn' 		=> 'daysbefore',
					'def' 		=> 1,
					'options'	=> array(__('Same','localize'), 1, 2, 3, 4, 5, 6, 7),
					'desc' 		=> __('How many days in advance (minimum) must be booked?', 'localize'),
					'before' 	=> 'startone',
					'after' 	=> ''
				),
				array(
					'type'		=> 'selectone',
					'name' 		=> __('Booking Status', 'localize'),
					'fn' 		=> 'bookstatus',
					'def' 		=> 2,
					'options'	=> array(__('Confirmed','localize'), __('Unconfirmed','localize')),
					'desc' 		=> __('Select if a booking needs to be confirmed after being booked', 'localize'),
					'before' 	=> '',
					'after' 	=> ''
				),
				array(
					'type'		=> 'selectone',
					'name' 		=> __('Send Reminders', 'localize'),
					'fn' 		=> 'sendreminders',
					'def' 		=> 1,
					'options'	=> array(__('Yes','localize'), __('No','localize')),
					'desc' 		=> __('Select wether reminders needs to be sent.', 'localize'),
					'before' 	=> '',
					'after' 	=> ''
				),
				array(
					'type'		=> 'textarea',
					'name' 		=> __('Success Message', 'localize'),
					'fn' 		=> 'booksuccessmessage',
					'def' 		=> __('Thank you for booking. Check your inbox for further instructions.','localize'),
					'desc' 		=> __('Success message when a booking is made.', 'localize'),
					'before' 	=> '',
					'after' 	=> ''
				),
				array(
					'type'		=> 'textarea',
					'name' 		=> __('Failed Message', 'localize'),
					'fn' 		=> 'bookfailmessage',
					'def' 		=> __('Your form have some errors that prevents it from being submitted. Please review the red borders and submit again.','localize'),
					'desc' 		=> __('Message when a booking is made and there is an error in the form.', 'localize'),
					'before' 	=> '',
					'after' 	=> 'endone'
				),
				array(
					'type'		=> 'input',
					'name' 		=> __('Maximum bookings per period', 'localize'),
					'fn' 		=> 'maxbookings',
					'def' 		=> 1,
					'desc' 		=> __('Maximum bookings that can be made per booking peroid.', 'localize'),
					'before' 	=> 'startone',
					'after' 	=> ''
				),
				array(
					'type'		=> 'selectone',
					'name' 		=> __('Guest type', 'localize'),
					'fn' 		=> 'guesttype',
					'def' 		=> 1,
					'options'	=> array(__('Numbers','localize'), __('None','localize'), __('Custom','localize')),
					'desc' 		=> __('Select wether reminders needs to be sent.', 'localize'),
					'before' 	=> '',
					'after' 	=> ''
				),
				array(
					'type'		=> 'input',
					'name' 		=> __('Guest Label', 'localize'),
					'fn' 		=> 'guestlabel',
					'def' 		=> 'Guests',
					'desc' 		=> __('Label for guest options', 'localize'),
					'before' 	=> '',
					'after' 	=> ''
				),
				array(
					'type'		=> 'input',
					'name' 		=> __('Guest description', 'localize'),
					'fn' 		=> 'guestdesc',
					'def' 		=> 'Number of guests',
					'desc' 		=> __('Label for dropdown description', 'localize'),
					'before' 	=> '',
					'after' 	=> ''
				),				
				array(
					'type'		=> 'input',
					'name' 		=> __('Email address', 'localize'),
					'fn' 		=> 'bookingmail',
					'def' 		=> '',
					'desc' 		=> __('Email address that should receive bookings.', 'localize'),
					'before' 	=> '',
					'after' 	=> ''
				),
				array(
					'type'		=> 'textarea',
					'name' 		=> __('Booking form header', 'localize'),
					'fn' 		=> 'bookformheader',
					'def' 		=> __('Select a date to start booking','localize'),
					'desc' 		=> __('Header for the booking form', 'localize'),
					'before' 	=> '',
					'after' 	=> 'endone'
				),							
			)				
		),
		
		array(
			'dash' 				=> '2',
			'tab' 				=> '0',
			'action' 			=> '0',
			'dashname' 			=> __('E-mails', 'localize'),
			'tabname' 			=> __('Booked', 'localize'),
			'savetype' 			=> 'optionsave',
			'updatemess' 		=> __('Message settings updated', 'localize'),
			'posttype' 			=> '',
			'values' 			=> array(

				array(
					'type'		=> 'textarea',
					'name' 		=> __('Email to Admin (subject)', 'localize'),
					'fn' 		=> 'ntl_bookadmin_s',
					'def' 		=> 'New table booking',
					'desc' 		=> __('Subject line of the email sent to admin when a booking is made.', 'localize'),
					'before' 	=> 'startone',
					'after' 	=> ''
				),	

				array(
					'type'		=> 'textarea',
					'name' 		=> __('Email to Admin (body)', 'localize'),
					'fn' 		=> 'ntl_bookadmin',
					'def' 		=> 'You have a new booking from your website',
					'desc' 		=> __('Message of the email sent to admin when a booking is made.', 'localize'),
					'before' 	=> '',
					'after' 	=> 'endone'
				),
				array(
					'type'		=> 'textarea',
					'name' 		=> __('Email to client (subject)', 'localize'),
					'fn' 		=> 'ntl_bookclient_s',
					'def' 		=> 'Thank you for your booking',
					'desc' 		=> __('Subject line of the email sent to client when a booking is made.', 'localize'),
					'before' 	=> 'startone',
					'after' 	=> ''
				),	

				array(
					'type'		=> 'textarea',
					'name' 		=> __('Email to client (body)', 'localize'),
					'fn' 		=> 'ntl_bookclient',
					'def' 		=> 'Thank you for booking your table with us.',
					'desc' 		=> __('Message of the email sent to client when a booking is made.', 'localize'),
					'before' 	=> '',
					'after' 	=> 'endone'
				)
										
			)				
		),

		array(
			'dash' 				=> '2',
			'tab' 				=> '1',
			'action' 			=> '0',
			'dashname' 			=> __('E-mails', 'localize'),
			'tabname' 			=> __('Confirmed', 'localize'),
			'savetype' 			=> 'optionsave',
			'updatemess' 		=> __('Message settings updated', 'localize'),
			'posttype' 			=> '',
			'values' 			=> array(

				array(
					'type'		=> 'textarea',
					'name' 		=> __('Confirmation - client (subject)', 'localize'),
					'fn' 		=> 'ntl_bookconf_s',
					'def' 		=> 'Booking Confirmed',
					'desc' 		=> __('Subject line of the email sent to client when a booking is confirmed.', 'localize'),
					'before' 	=> 'startone',
					'after' 	=> 'endone'
				),	

				array(
					'type'		=> 'textarea',
					'name' 		=> __('Confirmation -  client (body)', 'localize'),
					'fn' 		=> 'ntl_bookconf',
					'def' 		=> 'We would like to confirm your booking. Thanks for booking with us. Details of your booking is below.',
					'desc' 		=> __('Message of the email sent to client when a booking is confirmed.', 'localize'),
					'before' 	=> 'startone',
					'after' 	=> 'endone'
				)										
			)				
		),


		array(
			'dash' 				=> '2',
			'tab' 				=> '2',
			'action' 			=> '0',
			'dashname' 			=> __('E-mails', 'localize'),
			'tabname' 			=> __('Declined', 'localize'),
			'savetype' 			=> 'optionsave',
			'updatemess' 		=> __('Message settings updated', 'localize'),
			'posttype' 			=> '',
			'values' 			=> array(

				array(
					'type'		=> 'textarea',
					'name' 		=> __('Declined - client (subject)', 'localize'),
					'fn' 		=> 'ntl_bookdec_s',
					'def' 		=> 'Booking Declined',
					'desc' 		=> __('Subject line of the email sent to client when a booking is declined.', 'localize'),
					'before' 	=> 'startone',
					'after' 	=> 'endone'
				),	

				array(
					'type'		=> 'textarea',
					'name' 		=> __('Declined -  client (body)', 'localize'),
					'fn' 		=> 'ntl_bookdec',
					'def' 		=> 'We unfortunately had to decline your booking due to our restaurant being full at this time. Please try again later.',
					'desc' 		=> __('Message of the email sent to client when a booking is confirmed.', 'localize'),
					'before' 	=> 'startone',
					'after' 	=> 'endone'
				)	
										
			)				
		),

		array(
			'dash' 				=> '2',
			'tab' 				=> '3',
			'action' 			=> '0',
			'dashname' 			=> __('E-mails', 'localize'),
			'tabname' 			=> __('Cancelled', 'localize'),
			'savetype' 			=> 'optionsave',
			'updatemess' 		=> __('Message settings updated', 'localize'),
			'posttype' 			=> '',
			'values' 			=> array(

				array(
					'type'		=> 'textarea',
					'name' 		=> __('Cancelled - client (subject)', 'localize'),
					'fn' 		=> 'ntl_bookcan_s',
					'def' 		=> 'Booking cancelled',
					'desc' 		=> __('Subject line of the email sent to client when a booking is cancelled.', 'localize'),
					'before' 	=> 'startone',
					'after' 	=> 'endone'
				),	

				array(
					'type'		=> 'textarea',
					'name' 		=> __('Cancelled -  client (body)', 'localize'),
					'fn' 		=> 'ntl_bookcan',
					'def' 		=> 'We unfortunately had to cancel your booking. Please feel free to book at a later stage.',
					'desc' 		=> __('Message of the email sent to client when a booking is cancelled.', 'localize'),
					'before' 	=> 'startone',
					'after' 	=> 'endone'
				)	
										
			)				
		),

		array(
			'dash' 				=> '2',
			'tab' 				=> '4',
			'action' 			=> '0',
			'dashname' 			=> __('E-mails', 'localize'),
			'tabname' 			=> __('Reminded', 'localize'),
			'savetype' 			=> 'optionsave',
			'updatemess' 		=> __('Message settings updated', 'localize'),
			'posttype' 			=> '',
			'values' 			=> array(

				array(
					'type'		=> 'textarea',
					'name' 		=> __('Reminded - client (subject)', 'localize'),
					'fn' 		=> 'ntl_bookrem_s',
					'def' 		=> '',
					'desc' 		=> __('Subject line of the email sent to client when a booking is reminded.', 'localize'),
					'before' 	=> 'startone',
					'after' 	=> 'endone'
				),	

				array(
					'type'		=> 'textarea',
					'name' 		=> __('Reminded -  client (body)', 'localize'),
					'fn' 		=> 'ntl_bookrem',
					'def' 		=> '',
					'desc' 		=> __('Message of the email sent to client when a booking is reminded.', 'localize'),
					'before' 	=> 'startone',
					'after' 	=> 'endone'
				)	
										
			)				
		)
		
	);

	return apply_filters( 'lets_define_booking_layouts', $crob_layouts );
}



?>