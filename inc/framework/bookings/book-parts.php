<?php
/*
 * Croma Bookings functions to draw and save the admin page
 */

 

 /*===========  PAGE INDEX ================
 *
 * -01- DRAW MAIN FORM
 * -02- SAVE ACTION
 * -03- SAVE BOOKSCHEDULER
 * -04- SAVE BOOKING SCHEDULE 
 * -05- GENERATE MAINCONTENT
 * 
 * */


/*
 *
 * -01- DRAW MAIN FORM
 * 
 * */
function cro_b_page() {	
	$cro_init = book_setup_admin_data();
	$u_mess = '';
		
	// DECIDE WHICH UPDATE MESSAGE TO SHOW.
	if (  isset ( $_GET['updated'] ) &&  'true' == esc_attr( $_GET['updated'] ) ) {		
		$u_mess = '<p class="updatemess">' . $cro_init['update_mess'] . '</p>';		
	} elseif (  isset ( $_GET['updated'] ) &&  'true' != esc_attr( $_GET['updated'] )) {		
		$u_mess = '<p class="updatemess">' . esc_attr( $_GET['updated']) . '</p>';		
	}	
?>
	
<!-- Start to render the body -->
<div class="cro_wrap">
	
	<!-- add all the support and faq links -->
	<div class="cro_support">	
		<a href="http://www.cro.ma" target="_blank" title="Link to the Croma website">
			<img src="<?php echo get_template_directory_uri(); ?>/inc/framework/bookings/images/marlogo.png" class="logo" title="Link to the Croma website">
		</a>		
	</div> <!-- /.tlsupport -->	

			<!-- add the main menu-->	
	<div class="cro_mainmen">
		<ul class="cro_men">
			<?php echo cro_fetch_menu($cro_init['dash'],$cro_init['tab'], $cro_init['mainmen'], $cro_init['base_url'], 'prim'); ?>
		</ul>
	</div>
			
	<!-- add the main page part-->		
	<div class="crostrap">			
	
		<!-- start the subheader-->	
		<div class="cro_slab">										
			<!-- print dashboard name-->	
			<h1 class="slabtop"><?php echo  $cro_init['dashname']; ?></h1>
			<!-- add the secondary menu-->	
			<div class="croscondary">
				<ul>								
					<?php echo cro_fetch_menu($cro_init['dash'],$cro_init['tab'], $cro_init['secmen'], $cro_init['base_url'], 'sec'); ?>																
				</ul>
			</div>
		</div>

					
		<div class="cro_table">												
			<!-- show the update message if needed-->	
			<?php echo  $u_mess; ?>						
			<!-- add the page body-->	
			<div class="crodash">
				<?php  echo crob_fetch_main($cro_init['dash'], $cro_init['tab'], $cro_init['item'], $cro_init['action'],$cro_init['base_url'], $cro_init['values'], $cro_init['ptype']);	?>	
			</div>					
		</div>
	</div>
</div>
						
<?php
	
}




/*
 *
 * -02- SAVE ACTION
 * 
 * */
function cro_bpage() {
	
	$cro_init = book_setup_admin_data();
	
	if ( isset($_POST["crosubmit"]) &&  $_POST["crosubmit"] == 'Y' ) {
		
		check_admin_referer( 'cro_admionnonce');
		
		if ( isset($_POST["crotab"])) { $ttab = $_POST["crotab"]; } 
		if ( isset($_POST["crodash"])) { $tdash = $_POST["crodash"]; }
		if ( isset($_POST["croitem"])) { $titem = $_POST["croitem"]; }
		if ( isset($_POST["croaction"])) { $taction = $_POST["croaction"];}
		
		if (isset($_POST["addtype"]) && 'schedule' == $_POST["addtype"]){			
			cro_add_booking_schedule();											
		} elseif (isset($_POST["guestadd"]) && 'add_a_guest' == $_POST["guestadd"]){
			cro_add_guest_schedule();		
		} else {
			cro_save_the_bookingoptions($cro_init['values']);
		}

		$ab = $cro_init['base_url'] . '&tab=' . $ttab . '&dash=' . $tdash . '&item=0&action=0&updated=true';		
		wp_redirect(admin_url($ab));
	}
}




/*
 *
 * -03- SAVE BOOKSCHEDULER
 * 
 * */
function cro_save_the_bookingoptions($values) {	
	$settings = get_option( "bookset" );	
	foreach ( $values as $field ) {		
		if ($field['fn'] && isset($_POST[$field['fn']])) {
			if ($field['type'] == 'textarea') {
				$settings[$field['fn']] = esc_textarea($_POST[$field['fn']]);
			} else {
				$settings[$field['fn']] = esc_attr($_POST[$field['fn']]);
			}
		}					
	}	
	$updated = update_option( "bookset", $settings );		
	return;	
}


/* 
 * -04- SAVE BOOKING SCHEDULE 
 * */
function cro_add_booking_schedule() {
	
	$notaskey = array('crosubmit', 'crotab', 'crodash', 'croitem', 'croaction', 'addtype', 'Submit', '_wp_http_referer', '_wpnonce');
	
	$setsidearr = array();
	$setsidesave = array();
			
	foreach ($_POST as $key => $value) {
		$pos = strpos($key, 'cro_schedcontrol');		
		if ($pos !== false) {			
			$setsidearr[] = esc_attr($value);					
		}
  	}

  	if ($setsidearr) {
  		foreach ($setsidearr as $cro_v) {
  			$setsidesave[] = array(
  				'day' 	=> $_POST['cro_dayname-' . $cro_v],
  				'shour'	=> $_POST['cro_schedfromhour-' . $cro_v],
  				'smin'	=> $_POST['cro_schedfrommin-' . $cro_v],
  				'ehour' => $_POST['cro_schedtohour-' . $cro_v],
  				'emin'	=> $_POST['cro_schedtomin-' . $cro_v],
  				'ival' 	=> $_POST['cro_intervalminutes-' . $cro_v]
  			);
  		}
  	}
	
	$updated = update_option( "cro_booksched", $setsidesave );			
	return;	
}


/* 
 * -04- SAVE GUEST SCHEDULE 
 * */
function cro_add_guest_schedule() {

	$settings = get_option( "bookset" );	
	if (isset($_POST["guesttype"]) && '1' == $_POST["guesttype"]){
		$settings['minguests'] = $_POST["minguests"];
		$settings['maxguests'] = $_POST["maxguests"];
		$updated = update_option( "bookset", $settings);	
	} elseif (isset($_POST["guesttype"]) && '2' == $_POST["guesttype"]) {

		$notaskey = array('crosubmit', 'crotab', 'crodash', 'croitem', 'croaction', 'guestadd',  'guesttype' , 'Submit', '_wp_http_referer', '_wpnonce');	
		$setsidearr = array();
			
		foreach ($_POST as $key => $value) {		
			if (!in_array($key, $notaskey)){			
				$setsidearr[] = array(
					'code' => $key,
					'name' => esc_attr($value)			
				);			
			}
  		}
  		$settings['custworks'] = $setsidearr;	
		$updated = update_option( "bookset", $settings);			
	}

	return;	
}

/*
 *
 * -05- GENERATE MAINCONTENT
 * 
 * */
function crob_fetch_main($dashno, $tabno, $itemno, $action, $url, $val, $ptype) {
		
	// DRAW THE BASICS AND START TO FILL THE FORM		
	$op = '<form method="post" action="'   .   admin_url( $url . '&tab='  . $tabno . '&dash='  . $dashno . '&item=' . $itemno . '&action='  . $action ) . '">';
	$op .= wp_nonce_field('cro_admionnonce');
	$op .= '<input type="hidden" name="crosubmit" value="Y" />';	
	$op .= '<input type="hidden" name="crotab" value="'  . $tabno . '" />';	
	$op .= '<input type="hidden" name="crodash" value="'  . $dashno . '" />';	
	$op .= '<input type="hidden" name="croitem" value="'  . $itemno . '" />';	
	$op .= '<input type="hidden" name="croaction" value="'  . $action . '" />';	
	
		
	foreach($val as $fieldarr){
		$op .= crob_bodycreate($fieldarr, '',0);
	}
						
	$op .= '<br class="clear">';
	
	if (!$dashno == 0 )	{
		$op .= '<input type="submit" name="Submit"  class="cro_formsave" value="'   .  __('Save', 'localize') . '" />';	
	}
	return $op . '</form>';
	
}


?>