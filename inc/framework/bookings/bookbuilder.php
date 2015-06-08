<?php
/*
 * Croma Framework: Bookings Form Builder
 */




function crob_bodycreate($args, $tipe, $opst){
		
	$settings = get_option("bookset");
	$op = $hdl = $field = $val = $tpost = $forcefield = '';
	$field = $args['fn'];


	// GET THE DEFAULTS AND DETERMINE THE VALUES
	if (isset($settings[$field])) {$forcefield = $settings[$field];}
	$val 			= ($tipe) ? get_post_meta($opst, $field, true) : $forcefield  ;
	$targsbefore 	= (isset($args['before']) && $args['before']) ? $args['before'] : '' ;



	// MANAGE THE BEFORE SWITHCH	
	switch ($targsbefore) {
		case 'startone':$op .= '<div class="oneside">';	break;		
		case 'startbroad':	$op .= '<div class="broadside">'; break;		
	}
	
	
	
	// SET THE HEADER FOR EACH BOX	
	if ($args['name'] ) { $hdl = '<div class="sideinner"><h2>' .  $args['name']  . '</h2><p class="helper">' . $args['desc']  . '</p>'; }	
	$hdl = $args['desc'] ? $hdl . '<div class="helphelp">?</div>': $hdl;
	


	// SWITCH THE TYPES	
	switch ($args['type']) {
		
	
		// SELECT ONE FROM A SET OF OPTIONS
		case 'selectone':			
			$op .= $hdl . '<div class="opti">';
			$optcounter = 1;
			foreach ($args['options'] as $optvalue) {
				$valclass = 'butoff';	
				if 	($val == $optcounter ){$valclass = '';}
				$op .= '<span class="optionbut ' . $valclass  . '" rel="' . $optcounter  . '"><span class="ofonbtn">&nbsp;</span>' . $optvalue  . '</span>';		
            $optcounter++;
			}	
			$op .= '<input type="hidden" id="setinputvalue" name="' . $field  . '" value="'. $val .'"></div>'; 		
		break;	


		case 'bookdayview':	
		$op .= cro_make_bookday();
		break;



		case 'schedone':
			$op .= cro_make_scheduler();
		break;


		case 'guestman':
			$op .= cro_make_guests();
		break;



		case 'bookingcal':
			$linkline = 'admin.php?page=cromares&dash=0&tab=1&action=';			
			$op .= '<div class="bookingcalholder" rel="' .  admin_url($linkline)     . '">';
			$op .= booking_calendar('','', 'back');
			$op .= '<div class="cro_backloader"><div class="cro_bl">&nbsp;</div><div class="cro_bmesss">' .  __('Loading Calendar Components','localize')  . '</div></div></div>';
		break;


		// ON AND OFF SWITCH
		case 'switchit':			
			$op .= $hdl . '<div class="opti">';
			if ($val == 1){
				$valclass = 'switchon';	
			} else {
				$valclass = '';	
			}
			$op .= '<span class="switchouter ' . $valclass  . '"><span class="switchbut ' . $valclass  . '" rel="">&nbsp;</span><span class="switchbtn">&nbsp;</span>';
			$op .= '<input type="hidden" id="switchput" name="' . $field  . '" value="'. $val .'"></span></div>'; 
			
		break;	
		
				
		// STANDARD TEXT INPUT
		case 'input':		
			$op .= $hdl . '<div class="opti" style="margin-bottom: 20px;"><input type="text" size="47"  name="' . $field  . '" value="' . esc_html( stripslashes($val ))  . '" /></div>';		
		break;


		// STANDARD TEXTAREA INPUT
		case 'textarea':			
			$op .= $hdl . '<div class="opti" style="margin-bottom: 20px;"><textarea cols="28" rows="7" name="' . $field  . '">' . esc_html( stripslashes($val ))  . '</textarea></div>';				
		break;

			
		// STANDARD SELECTLIST
		case 'selectlist':
			$op .=  $hdl . '<div class="opti" style="margin-bottom: 20px;"><select class="selectlist" name="' .   $field  . '">';
			foreach ($args['options'] as $sellist) {
				if ( $sellist == $val ) { $sel = 'selected="selected"';} else {$sel = ' ';}	
				$op .= '<option value="'   . $sellist  .  '" ' . $sel  . '>'   . $sellist  .  '</option>';				
			} 
			$op .= '</select></div>';			
		break;		
		
	}

	$op .= '</div>';

	if (isset($args['after'])){
		$op .= $args['after'] == 'endone'? '</div>': '';
	}
	
	return $op;
}

?>