<?php
/*
 * CROMA Admin Framework: BOOKINGS FORM BUILDER
 */



/* 
 * -01- CREATE THE BOOKINGS FORM
 * */
function create_bookingform() {

	// GET THE DEFAULTS
	$settings= get_option('bookset');
	$tlset= get_option('tlset');
	$guests = '';

	if (isset($tlset['primcolor']) && $tlset['primcolor'] == 1){
		$calcol = 'cro_calendarlight';
	} else {
		$calcol = 'cro_calendardark';
	}

	if (!isset($settings['bookformheader']) || $settings['bookformheader'] == '') {
		$bh = __('Select a date to start booking','localize');
	} else {
		$bh = $settings['bookformheader'];
	}


	if (isset($settings['guesttype']) && $settings['guesttype'] == '1') {

		if (isset($settings['minguests']) && isset($settings['maxguests']) && $settings['minguests'] <= $settings['maxguests']){
			$j = $settings['minguests'];$k = $settings['maxguests'];
		} else {
			$j = 1;$k = 10;
		}
	
		for ($i=$j; $i < $k + 1; $i++) { 
			$guests .= '<option value="' . $i  . '">' . $i . '</option>';
		}
	
	} elseif (isset($settings['guesttype']) && $settings['guesttype'] == '3') {
		$c_v_ctr = 1;
		if (isset($settings['custworks']) && $settings['custworks'] != '') {
			foreach ($settings['custworks'] as $c_v) { 
				$guests .= '<option value="' . $c_v_ctr  . '">' . stripslashes($c_v['name']) . '</option>';
				$c_v_ctr++;
			}
		}
	}

	if ($guests) {
		$guests = '<p class="bookingp">
						<label>' . stripslashes($settings['guestlabel']) . '</label>
						<select name="bookingform-num" id="bookingform-num" class="cro_guestcount cro_validatethis" contents="cro_sel">
						<option value="' . stripslashes($settings['guestdesc']) . '">' . stripslashes($settings['guestdesc']) . '</option>'
						.  $guests  .  '
						</select>
					</p>';
	} else {
		$guests = '';
	}

	?>

	<div class="cro_bookingsform eight column <?php echo $calcol; ?>">
		<div class="cro_bookingsforminner">
			<form id="croma_bookingform" action="" method="post">

				<input type="hidden" name="calendarvalue"  class="cro_calendarvalue  cro_validatethis" contents="cro_cal" value="">
				<input type="hidden" name="timevalue" contents="cro_tim" class="cro_timevalue  cro_validatethis" value="">
				
				<div class="six column" style="padding-left: 0;">
					
					<h5 class="cro_accent"><?php echo $bh; ?></h5>
					
					<div class="cro_calendarholder">
						<?php echo  booking_calendar('','', 'front'); ?>
					</div>

					<div class="timevalues">
						<div class="timeselectheader cro_accent"><?php _e( 'Select a timeslot', 'localize' ); ?></div>
						<div class="timeselectinner"></div>
						<div class="clearfix"></div>
					</div>
				</div>
				

				<div class="six column" style="padding: 0;">

					<p class="bookingp">
						<label><?php _e( 'Name', 'localize' ); ?></label>
						<input type="text" name="bookingform-name" id="bookingform-name" contents="cro_ct" class="nets_bookingformname reset cro_validatethis">
					</p>

					<p class="bookingp clear">
						<label><?php _e( 'Email', 'localize' ); ?></label>
						<input type="text" name="bookingform-mail" id="bookingform-mail" contents="cro_ct" class="nets_bookingformmail reset  cro_validatethis">
					</p>
			
					<p class="bookingp clear">
						<label><?php _e( 'Telephone', 'localize' ); ?></label>
						<input type="text" name="bookingform-tel" id="bookingform-tel" contents="cro_ct" class="nets_bookingformtel reset  cro_validatethis">
					</p>
			
					
					<?php echo $guests; ?>

					<p class="bookingp clear bookingcommt">
						<label><?php _e( 'Special requests', 'localize' ); ?></label>
						<textarea name="bookingform-info" id="bookingform-info" ></textarea>
					</p>

					<div class="valmess">
						<div class="booksuccess"><?php echo stripslashes(esc_attr($settings['booksuccessmessage'])); ?></div>
						<div class="bookerror"><?php echo stripslashes(esc_attr($settings['bookfailmessage'])); ?></div>
					</div>

					<p class="bookingsubmit">
						<input type="submit" class="cro_bookingformsub cro_accent" name="cro_bookingformsub" value="<?php _e( 'Make Booking', 'localize' ); ?>">
					</p>
				</div>
				<div class="clearfix"></div>
			</form>

			<div class="cro_bookingsoverlay1">
				<div class="bookingsldr"></div>
				<div class="cro_ldrmess">
					<?php _e( 'Fetching available Timeslots', 'localize' ); ?>
				</div>
			</div>

			<div class="cro_bookingsoverlay2">
				<div class="bookingsldr"></div>
				<div class="cro_ldrmess">
					<?php _e( 'Submitting form', 'localize' ); ?>
				</div>
			</div>
		</div>
	</div>

<?php

}

?>