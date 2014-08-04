<?php
/*
 * CROMA Admin Framework: formbuilder
 */


/********** Code Index
 *
 * -01- DETERMINE THE DEFAULTS
 * -02- DETERMINE THE LAYOUT
 * -03- SET THE HEADER MESSAGE
 * -04- CUSTOM SIDEBAR CREATOR
 * -05- IMAGE UPLOADER
 * -06- HELPLIST
 * -07- SELECT ONE FROM A SET OF OPTIONS
 * -08- ON AND OFF SWITCH
 * -09- FONT LIST
 * -10- SELECT A COLOR
 * -11- STANDARD TEXT INPUT
 * -12- STANDARD TEXTAREA INPUT
 * -13- SELECT TO A POST TYPE
 * -14- STANDARD SELECTLIST
 * 
 */
 



function cro_bodycreate($args, $tipe, $opst){		
	$settings = get_option("tlset");
	$op = $hdl = $field = $val = $tpost = $forcefield = '';
	$field = $args['fn'];



	/**
 	* -01- DETERMINE THE DEFAULTS
 	*/ 
	if (isset($settings[$field])) {$forcefield = $settings[$field];}
	$val 			= ($tipe) ? get_post_meta($opst, $field, true) : $forcefield  ;
	$targsbefore 	= (isset($args['before']) && $args['before']) ? $args['before'] : '' ;



	/**
 	* -02- DETERMINE THE LAYOUT
 	*/ 	
	switch ($targsbefore) {
		case 'startone':			
			$op .= '<div class="oneside">';			
		break;		
		case 'startbroad':			
			$op .= '<div class="broadside">';			
		break;		
	}
	
	
	
	
	/**
 	* -03- SET THE HEADER MESSAGE
 	*/ 	
	if ($args['name'] ) { $hdl = '<div class="sideinner"><h2>' .  $args['name']  . '</h2><p class="helper">' . $args['desc']  . '</p>'; }	
	$hdl = $args['desc'] ? $hdl . '<div class="helphelp">?</div>': $hdl;
	



	switch ($args['type']) {
		




		/**
 		* -04- CUSTOM SIDEBAR CREATOR
 		*/ 	
		case 'itemlist':				
			$listhdl = get_option('cro_sbar');				
			$op .= $hdl . '<div class="cro_itemlistinside"><div class="cro_itemlistitems">';

			if ($listhdl) {				
				foreach ($listhdl as $v){				
					$op .= '<div class="cro_listcloneractive" style="display: block;"><input type="text" name="' . $v['code']  . '" value="'  .  $v['name']  . '"><span class="cro_listdeleteone">-</span></div>';
				}				
			} else {
				$op .= '<p class="cro_theresnolist">' .  __('You have no custom sidebars at present. Click to add a sidebar', 'localize')  . '</p>';
			}

			$op .= '</div><div class="cro_listcloner"><input type="text"><span class="cro_listdeleteone">-</span></div><div class="cro_itemplusitems"><span>+</span></div></div>';						
		break;




		
		/**
 		* -05- IMAGE UPLOADER
 		*/ 
		case 'getlogo':			
			$imgnow = $resetimg = '';
			$hideclass="upload_image_active";	
			if ($tipe) {
				$tpost = $opst;
				$val = wp_get_attachment_url( get_post_thumbnail_id($opst) );
			}
			if ($val) {
				$imgnow = '<img alt="" src="' .  $val  .   '" id="image_' .  $field  .  '" class="uploaderimage">';
				$resetimg = '<div class="resetimg bkg1">' .  __('Remove Image', 'localize')  . '</div>';	
				$hideclass= '';
			}
			
			$op .= $hdl . '
				<div class="image_upload_div">
				<input id="upload_image_button" class="uploader image_upload_button bkg2 rad1" type="button" value="' .  __('Upload', 'localize')  . '" rel="' . $tpost . '" />
				<input id="upload_image" type="text" name="' . $field  . '" value="' . esc_html( stripslashes($val ))  . '" />
				</div><div id="upload_image_preview" class="' . $hideclass  . '" rel="' . $field  . '">' . $imgnow . ' ' . $resetimg . '</div>';					
		break;





		/**
 		* -06- HELPLIST
 		*/ 
		case 'helplist':					
			$op .= $hdl;
			$op .= '<div class="explanationhelp"><h1>' .__('Getting to the helpfiles','localize') . '</h1>';

			$op .= '<br/><p><strong>' . __('Below the steps for getting access to the helpfiles','localize') . ':</strong></p>';

			$op .= '<p><strong>1. </strong>' . __('Unzip the files that you downloaded from Themeforest','localize') . ':</strong></p>';
			$op .= '<p><strong>2. </strong>' . __('Search for a folder called "helpfiles"','localize') . ':</strong></p>';

			$op .= '<p><strong>3. </strong>' . __('Click on the index.html file in the helpfiles folder to open the help files in your browser','localize') . ':</strong></p>';


			$op .= '<br/><h1>' .__('Getting help','localize') . '</h1>';

			$op .= '<br/><p>' . __('Click the icons at the top right of this page to go to the faq and help section of the Croma website.','localize') . ':</p>';

			$op .= '</div>';
		break;





		/**
 		* -07- SELECT ONE FROM A SET OF OPTIONS
 		*/ 
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


		/**
 		* -08- ON AND OFF SWITCH
 		*/
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
		


		/**
 		* -09- FONT LIST
 		*/
		case 'fontlist':			
			$op .= $hdl . '<div class="opti">';
			$now = time();
			$month = date('F', $now);
			$selecttoset =  $defaultfontset = '';
			$fontoptions = get_option('cro_fontset');
			if (isset($fontoptions['fontselected'])){
					$defaultfontset = $fontoptions['fontselected'];
			}
			if (!$fontoptions || (isset($fontoptions['dates']) && $fontoptions['dates'] != $month )){

       			$jdec = json_decode(fontslists());
				$sdec = cro_admin_objtoA($jdec);

				foreach ($sdec['items'] as $v){
					$holdarr[] =  wp_kses($v['family'], '');
				}

				$fontnames = array(
					'names' => $holdarr,
					'dates' => $month,
					'defaults' => $defaultfontset
				);

				update_option('cro_fontset', $fontnames);
			}

			if (isset($fontnames['names'])) {

				$selecttoset = $fontnames['names'];

			} elseif (isset($fontoptions['names'])) {

				$selecttoset = $fontoptions['names'];

			}

			$op .= '<select class="selectlist cro_fselect" name="' .   $field  . '" style="margin-bottom: 20px;">';

			foreach ($selecttoset as $vv) {
				if ( $vv == $val ) { $sel = 'selected="selected"';} else {$sel = ' ';}	
				$op .= '<option value="'   . $vv  .  '" ' . $sel  . '>'   . $vv  .  '</option>';
			}
	
			$op .= '</select><div class="fontpreview">';

			if ($val){
				$op .= '<link href="http://fonts.googleapis.com/css?family=' .  str_replace('+' , ' ' , $val)  . '" rel="stylesheet" type="text/css">';
				$op .= '<p style="font-family: ' . $val . ', sans-serif; font-size: 20px;margin: 0 0 30px 0; line-height: 30px;">Grumpy wizards make toxic brew for the evil Queen and Jack.</p>';
			} else {

				$op .= '<link href="http://fonts.googleapis.com/css?family=Finger+Paint" rel="stylesheet" type="text/css">';
				$op .= '<p style="font-family: Finger Paint, sans-serif;">Grumpy wizards make toxic brew for the evil Queen and Jack.</p>';

			}	

			$op .= '</div></div>'; 
			
		break;	




				
		/**
 		* -10- SELECT A COLOR
 		*/
		case 'selectcolor':
			$op .= $hdl . '<div class="col-pic" style="margin-left: 20px; margin-bottom: 20px;">
				<input type="text" class="cro_pickme ' . $field   .   '" name="' . $field   .   '" value="' . $val   .   '" size="29" style="background: ' . $val   . ';" rel=".' . $field   .   '" />
				</div>';			
		break;	






		/**
 		* -11- STANDARD TEXT INPUT
 		*/		
		case 'input':		
			$op .= $hdl . '<div class="opti" style="margin-bottom: 20px;"><input type="text" size="47"  name="' . $field  . '" value="' . esc_html( stripslashes($val ))  . '" /></div>';		
		break;


		/**
 		* -12- STANDARD TEXTAREA INPUT
 		*/	
		case 'textarea':			
			$op .= $hdl . '<div class="opti" style="margin-bottom: 20px;"><textarea cols="28" rows="7" name="' . $field  . '">' . esc_html( stripslashes($val ))  . '</textarea></div>';				
		break;


		/**
 		* -13- SELECT TO A POST TYPE
 		*/	
		case 'linkto':
			$op .=  $hdl . '<div class="opti" style="margin-bottom: 20px;"><select class="selectlist" name="' .   $field  . '">';
			$op .= '<option value="0">' . __('Nothing','localize') . '</option>';
			foreach ($args['options'] as $sellist) {
				 $op .= '<optgroup label="' . $sellist  .  '">';
				 

				$selargs = array('post_type'=>$sellist,'showposts'=> 10000);
				$sel_newquery = new WP_Query($selargs);
				if ($sel_newquery->have_posts()) : while ($sel_newquery->have_posts()) : $sel_newquery->the_post();

					$selid = get_the_ID();

					if ( $selid == $val ) { $sel = 'selected="selected"';} else {$sel = ' ';}	
					$op .= '<option value="'   . $selid  .  '" ' . $sel  . '>'   . get_the_title($selid)  .  '</option>';

				endwhile;
				else : endif;
				wp_reset_query();

				$op .= '</optgroup>';		
			} 
			$op .= '</select></div>';			
		break;		
		
		
		/**
 		* -14- STANDARD SELECTLIST
 		*/	
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
	$op .= $args['after'] == 'endone'? '</div>': '';	
	return $op;
}

?>