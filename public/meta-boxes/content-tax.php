<?php
/*
 * Netlabs Admin Framework
 */
 
 
function cro_define_tax_metas() {
	$cro_taxes = array(
		array(
			'taxname' 			=> 'category',
			'values' 			=> array(
				array(		
					'type' 		=> 'getsidebar',
					'fn' 		=> 'cro_cat_sbar',
					'heading'	=> __('Sidebar', 'localize'),
					'options'	=> '',
					'desc' 		=> __('Sidebar for this category', 'localize')
				)
			)				
		)	
	);
	return apply_filters( 'cro_define_tax_metas',$cro_taxes );
}



?>