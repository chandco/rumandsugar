<?php
/**
 * The file handling all the functions for the structure and customization of the site.
 *
 */
 
 
 function get_colorstyles() {
 	$op = '';
	$clr = 'a, 
	        a:hover, 
	        a:focus';
 }
 
 function tli_sortfonts() { 	
	$ab = lets_define_fontlist();
	$isbold = 0;
	$tlset = get_option( 'tlset' );
	
	foreach ($ab as $val) {
		
		if ($tlset['font'] == $val['family']){
			foreach ($val['variants'] as $v) {
				if ($v == 'bold' || $v == 700){
					$isbold = 1;
				}
			}
		}
	}
	
	return $isbold;
 }
 
 
?>