<?php
/**
 * meta box form builder functions
 *
 */
 
 
 
function cro_getformbox($v, $ID){
	
	$op =  $field =  $val = $hdl = '';

	// SET THE FIELDS ANS VALUES
	if (isset($v['fn'])){
		$field = $v['fn'];
		$val = get_post_meta($ID, $field, true);
	}
	

	// DRAW THE OUTLINES
	if ($v['before'] == 'half'){		
		$op .= '<div class="cro_oneside">';		
	} elseif ($v['before'] == 'wide'){
		$op .= '<div class="cro_fullside">';
	}


	// DRAW THE HEADINGS
	if (isset($v['heading'])) {
		$hdl = '<h2>' .  $v['heading']   . '</h2>';
	}


	// DRAW THE INSIDE BOXES
	$op .= '<div class="sideinner">' . $hdl . '<div class="cro_sidebox">';
	

	// TYPE SWITCHES
	switch ($v['type']) {


		// SET UP THE INPUT FIELD		
		case 'getinput':
			$op .= '<input type="text" name="' . $field  . '" value="' . stripslashes($val)  . '" />';									
		break;	

		// SET UP THE INPUT FIELD		
		case 'gettextarea':
			$op .= '<textarea cols="28" rows="7" class="cro_mboxtextarea" name="' . $field  . '">' . esc_html( stripslashes($val ))  . '</textarea>';									
		break;	



		// SET UP THE SELECTBOX
		case 'getselectbox':
			$ctr = 1;
			$op .= '<select class="cro_selbox" name="' . $field  . '"  />';	

			foreach ($v['options'] as $s) {
				if ( $ctr == $val ) { $sel = 'selected="selected"';} else {$sel = ' ';}	
				$op .= '<option value="'   . $ctr  .  '" ' . $sel  . '>'   . $s  .  '</option>';
				$ctr++;
			} 

			$op .= '</select>';								
		break;



		// SET UP THE SELECTBOX
		case 'getsidebarbox':
			$optlist = get_option('cro_sbar');
			$ctr = 1;
			$op .= '<select class="cro_selbox" name="' . $field  . '"  />';	
			$op .= '<option value="0">' . __('Standard Sidebar', 'localize') . '</option>';

			if (isset($optlist) && $optlist != '') {
				foreach ($optlist as $crov) {
					$s = $crov['name'];
					$ddeeff = '';
					if ($val == sanitize_title($s)) {
						$ddeeff = 'selected="selected"';
					} else {
						$ddeeff = '';
					}
					$op .= '<option value="' .  sanitize_title($s)  . '" ' .  $ddeeff . '>' . $crov['name']  .   '</option>';
				}

			}

			$op .= '</select>';								
		break;



		// SET UP THE TIME SLIDER
		case 'getslider':

			if ($val) {
				$valholder = explode(':', $val);
				$mnts = $valholder[1];
				$hhrs = $valholder[0];
			} else {
				$mnts = 30;
				$hhrs = 12;
				$val = '12:30';
			}

			
			$op .= '<div class="cro_timeholder">
						<span class="cro_timerlabel hourlabel" rel="' .  $hhrs . '">' .  __('Hour','localize') . '</span>
						<div id="noUiSlider" class="noUiSlider"></div>
					</div>';
			$op .= '<div class="cro_timeholder timeholderbottom">
						<span class="cro_timerlabel minutelabel" rel="' .  $mnts . '">' .  __('Minute','localize') . '</span>
						<div id="noUiSlider2" class="noUiSlider"></div>
					</div>';
			$op .= '<input type="hidden" class="timelabel" name="' . $field  . '" value="' . $val  . '" />';	

		break;


		// SET UP THE TIME SLIDER
		case 'getslider2':

			if ($val) {
				$vl = date('H:i',$val);
				$valholder = explode(':', $vl);
				$mnts = $valholder[1];
				$hhrs = $valholder[0];
			}

			
			$op .= '<div class="cro_timeholder">
						<span class="cro_timerlabel hourlabel" rel="' .  $hhrs . '">' .  __('Hour','localize') . '</span>
						<div id="noUiSlider" class="noUiSlider"></div>
					</div>';
			$op .= '<div class="cro_timeholder timeholderbottom">
						<span class="cro_timerlabel minutelabel" rel="' .  $mnts . '">' .  __('Minute','localize') . '</span>
						<div id="noUiSlider2" class="noUiSlider"></div>
					</div>';
			$op .= '<input type="hidden" class="timelabel cro_timeres" name="' . $field  . '" value="' . $val  . '" />';	

		break;


		case 'selectrecurring':

			$op .= '<div class="calopti">';
			$namearray = array(
				__('Single day event','localize'), 
				__('Multiple day event','localize'), 
				__('Every week same day','localize'), 
				__('Every month same date.','localize'), 
				__('Advanced configuration.','localize') 
			);
			$advarray1 = array(
				__('first','localize'), 
				__('second','localize'), 
				__('third','localize'), 
				__('fourth','localize'), 
				__('last','localize'), 
			);
			$ctr = 1;

			$val_a = get_post_meta($ID, $field . '_a', true);
			$val_b = get_post_meta($ID, $field . '_b', true);
			$val_c = get_post_meta($ID, $field . '_c', true);
			$val_d = get_post_meta($ID, $field . '_d', true);
			$val_e = get_post_meta($ID, $field . '_e', true);



			foreach ($namearray as $crov) {
				$op .= '<div class="seltype">';
				$optspanselected = ((!$val && $ctr == 1) || $val == $ctr) ? 'optspanselected' : '';
				$op .= '<span class="optspan ' .  $optspanselected . '" rel="' . $ctr . '"></span>';
				$op .= '<span class="optdesc">' .  $crov . '</span></div><br class="clear" />';
				$ctr++;
			}



			$showdaynone = ($val == 5) ? '' : 'showdaynone' ;
			$op .= '<div class="showadvconf ' . $showdaynone  . '">';
			$op .= __('Select Configuration','localize') . '<br/>';



			$op .= '<select class="cro_addayofconf adadvselect" name="' . $field  . '_a">';
			foreach ($advarray1 as $crovv) { 
				$val_a_sel = ($val_a == $crovv) ? 'selected="selected"' : '' ;
				$op .= '<option value="' .  $crovv . '"  ' . $val_a_sel . '>' .  ucfirst($crovv) . '</option>';
			}
			$op .= '</select>';



			$op .= '<select class="cro_adweekofconf adadvselect" name="' . $field  . '_b">';
			$d_mon = strtotime('December 2010 first Monday');
			for ($i=0; $i <= 6 ; $i++) { 
				$d_mas = $i * 86400;
				$val_b_sel = ($val_b == date('l', $d_mon + $d_mas )) ? 'selected="selected"' : '' ;
				$op .= '<option value="' . date('l', $d_mon + $d_mas ) .  '"   ' . $val_b_sel . '>' . date_i18n( 'l' , $d_mon + $d_mas , false )  . '</option>';
			}
			$op .= '</select></div><br class="clear" />';



			$showdaynone = ($val && $val != 1) ? '' : 'showdaynone' ;
			$op .= '<div class="showlastday ' . $showdaynone  . '">';
			$op .= __('Last day of event','localize') . '<br/>';



			$op .= '<select class="cro_addayselect  adcalselect" name="' . $field  . '_c">';
			for ($i=0; $i < 32; $i++) { 
				$val_c_sel = ($val_c == $i) ? 'selected="selected"' : '' ;
				$ii = ($i == 0) ? '--' : $i ;				
				$op .= '<option value="' . $i . '"   ' . $val_c_sel . '>' . $ii  . '</option>';
			}
			$op .= '</select>';



			$op .= '<select class="cro_admonthselect adcalselect" name="' . $field  . '_d">';
			$d_mon = strtotime('January 15th 2010');
			for ($i=0; $i <= 12 ; $i++) { 
				$d_mas = ($i - 1) * 2592000;
				if ($i == 0) {
					$val_d_sel = ($val_d == 0) ? 'selected="selected"' : '' ;
					$op .= '<option value="0"    ' . $val_d_sel . '>--</option>';
				} else {
					$val_d_sel = ($val_d == date('n', $d_mon + $d_mas )) ? 'selected="selected"' : '' ;
					$op .= '<option value="' . date('n', $d_mon + $d_mas ) .  '"    ' . $val_d_sel . '>' . date_i18n( 'M' , $d_mon + $d_mas , false )  . '</option>';
				}
			}
			$op .= '</select>';


			$op .= '<select class="cro_adyearselect adcalselect" name="' . $field  . '_e">';
			$d_mon = time();
			$d_mch = (date('Y', $d_mon)) - 2 ;
			for ($i=0; $i <= 7 ; $i++) { 
				if ($i == 0) {
					$val_e_sel = ($val_e == 0) ? 'selected="selected"' : '' ;
					$op .= '<option value="0" ' . $val_e_sel . '>--</option>';
				} else {
					$val_e_sel = ($val_e == ($d_mch + $i)) ? 'selected="selected"' : '' ;
					$op .= '<option value="' . ($d_mch + $i)  .  '" ' . $val_e_sel . '>' . ($d_mch + $i)  .  '</option>';
				}
			}
			$op .= '</select>';

			$op .= '</div>';

			if ($val) {

				$op .= '<input type="hidden" class="crocalboxx" name="' . $field  . '" value="' . $val . '" />';

			} else {
				$op .= '<input type="hidden" class="crocalboxx" name="' . $field  . '" value="1" />';
			}	

			$op .= '</div>';


		break;


		case 'getcal':

			$now = ($val) ? $val : time();
			$day = date('d', $now);
			$month = date('m', $now);
			$year = date('Y', $now);

			$dval = ($val) ? $val : mktime(0,0,0,$month,$day,$year);

			
			$op .= '<div class="croinner cro_calholder">';
			$op .= fetch_calendar('picker', $day, $month, $year, $val);
			$op .= '</div>';
			$op .= '<input type="hidden" class="crocalbox" name="' . $field  . '" value="' . esc_attr($dval)  . '" />';	
						
		break;	


	}


	if (isset($v['desc']) && $v['desc']) {
		$op .= '<p class="cro_metaboxpdesc">' .    $v['desc']   . '</p>';
	}


	// CLOSE
	$op .= '</div></div>';
	
	
	// CLOSE SETUP BOXES
	if ($v['after']){		
		$op .= '</div>';		
	}
	
	return $op;
}
 


?>