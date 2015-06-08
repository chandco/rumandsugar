<?php
/**
 * meta box taxonomy functions
 *
 */


// ADDS THE TAXONOMY TERMS IN THE TAXONOMY PAGE
function cro_taxonomy_fieldadd() {

	$op = '';


	// CHECK VALUES AND PERMISSIONS
	if ( is_admin() && isset( $_GET['taxonomy'] )) {
		$cro_taxname = $_GET['taxonomy'];
	}
	

	// WALKS THROUGH ARRAYS
	foreach (cro_define_tax_metas() as $crov){


		if (isset($crov['taxname']) && $crov['taxname'] == $cro_taxname){
			if (isset($crov['values'])){$crovarr = $crov['values'];}
			foreach ($crovarr as $crovv) {


				// START THE FIELD
				$op .= '<div class="form-field">';
				$op .= '<label for="term_meta[' . $crovv['fn']  . ']">' .  $crovv['heading'] . '</label>';



				// FORMFIELD TYPE SWITCHER
				switch ($crovv['type']) {
					case 'getinput':
						$op .= '<input type="text" name="term_meta[' . $crovv['fn']  . ']" id="term_meta[' . $crovv['fn']  . ']" value="">';
					break;	

					case 'getsidebar':
						$optlist = get_option('cro_sbar');
						$op .= '<select  name="term_meta[' . $crovv['fn']  . ']" id="term_meta[' . $crovv['fn']  . ']">';
						$op .= '<option value="0">' . __('Standard Sidebar', 'localize') . '</option>';

						if (isset($optlist) && $optlist != '') {
							foreach ($optlist as $crov) {
								$s = $crov['name'];
								$op .= '<option value="' .  sanitize_title($s)  . '">' . $crov['name']  .   '</option>';
							}

						}
						$op .= '</select>';
					break;				
				}


				// CLOSE THE FIELD
				$op .= '<p class="description">' .  $crovv['desc']  . '</p>';
				$op .= '</div>';

			}
		}
	}

	echo $op;
}



// Edit term page
function cro_taxonomy_fieldedit($term) {


	$trm_id = $term->term_id;
	$term_meta = get_option( 'taxonomy_' . $trm_id);
	$op = '';

	// CHECK VALUES AND PERMISSIONS
	if ( is_admin() && isset( $_GET['taxonomy'] )) {
		$cro_taxname = $_GET['taxonomy'];
	}
	

	// WALKS THROUGH ARRAYS
	foreach (cro_define_tax_metas() as $crov){

		if (isset($crov['taxname']) && $crov['taxname'] == $cro_taxname){
			if (isset($crov['values'])){$crovarr = $crov['values'];}
			foreach ($crovarr as $crovv) {

				// START THE FIELD
				$op .= '<tr class="form-field"><th scope="row" valign="top">';
				$op .= '<label for="term_meta[' . $crovv['fn']  . ']">' .  $crovv['heading'] . '</label><td>';

				$sdef = 'taxonomy_' . $_GET['tag_ID'];

				$def = get_option($sdef);



				// FORMFIELD TYPE SWITCHER
				switch ($crovv['type']) {
					case 'getinput':
						$croval =  $term_meta[$crovv['fn']]  ? $term_meta[$crovv['fn']]  : ''; 
						$op .= '<input type="text" name="term_meta[' . $crovv['fn']  . ']" id="term_meta[' . $crovv['fn']  . ']" value="' .  esc_attr($croval) . '">';
					break;	

					case 'getsidebar':
						$optlist = get_option('cro_sbar');
						$op .= '<select  name="term_meta[' . $crovv['fn']  . ']" id="term_meta[' . $crovv['fn']  . ']">';
						$op .= '<option value="0">' . __('Standard Sidebar', 'localize') . '</option>';

						if (isset($optlist) && $optlist != '') {
							foreach ($optlist as $crov) {
								$s = $crov['name'];
								$ddeeff = '';
								$default = $def[$crovv['fn']];
								if ($default == sanitize_title($s)) {
									$ddeeff = 'selected="selected"';
								} else {
									$ddeeff = '';
								}
								$op .= '<option value="' .  sanitize_title($s)  . '" ' .  $ddeeff . '>' . $crov['name']  .   '</option>';
							}

						}
						$op .= '</select>';
					break;				
				}


				// CLOSE THE FIELD
				$op .= '<p class="description">' .  $crovv['desc']  . '</p></td>';
				$op .= '</th></tr';
			}
		}
	}

	echo $op;
}




// Save extra taxonomy fields callback function.
function cro_save_taxmeta( $term_id ) {
	$pr = cro_define_tax_metas();
	$pname = '';
	$tmeta = '';
	foreach ($pr as $value) {
		if ($value['taxname'] == $_POST['taxonomy']){
			$pname = $value['taxname'];
		}
	}
	if ($pname && isset($_POST['taxonomy'])) { 
		$term_meta = get_option( 'taxonomy_' . $term_id );
		$cat_keys = array_keys( $_POST['term_meta'] );
		foreach ( $cat_keys as $key ) {
			if ( isset ( $_POST['term_meta'][$key] ) ) {
				$term_meta[$key] = $_POST['term_meta'][$key];
				update_option( 'taxonomy_' . $term_id, $term_meta);
			}
		}
	}
}  





if ( isset( $_GET['taxonomy'] )) {

	add_action( $_GET['taxonomy'] . '_add_form_fields', 'cro_taxonomy_fieldadd', 10, 2 );
	add_action( $_GET['taxonomy'] . '_edit_form_fields', 'cro_taxonomy_fieldedit', 10, 2 );

}

if ( isset( $_POST['taxonomy'] )) {
add_action( 'edited_' . $_POST['taxonomy'] , 'cro_save_taxmeta', 10, 2 );  
add_action( 'create_' . $_POST['taxonomy'] , 'cro_save_taxmeta', 10, 2 );
}



 ?>