<?php
/*
 * Croma admin framework: page parts
 */



/********** Code Index
 *
 * -01- VERSION UPDATE
 * -02- CREATE THE NAV MENU SYSTEM
 * -03- CREATE THE MAIN SITE
 * 
 */
 



 /**
 * -01- VERSION UPDATE
 */ 
function cro_fetch_version() {
	
	// DEFAULT SETTINGS
	$settings = get_option("tlset");
	$ver = '1.0.2'; 
	$now = time();
	$op = '';
	
	
	// IF ITS TIME GET THE RESULT AND POPULATE THE SETTINGS
	if (isset($settings['cro_updatetime']) && ($settings['cro_updatetime'] + 172800) <= $now ){		
		$result = wp_remote_get ( 'http://updates.cro.ma/forked.json', array ( 'sslverify' => false ) ); 		
		if ( !is_wp_error ($result) ) {  
       		$jdec = json_decode($result['body']);
			$settings['cro_updatetime'] = $now;
			$settings['cro_newver']	 = 	$jdec->{'latest'};
			update_option("tlset", $settings );
    	}  
			
	// INNITIALIZE IF ITS THE FIRST TIME HERE
	} elseif (!isset($settings['cro_updatetime'])){				
		$settings['cro_updatetime'] = $now;		
		update_option("tlset", $settings );				
	}
	
	if (isset($settings['cro_newver'])) {	
	// COMPOSE STRING IF NEW VERSION IS AVAILABLE
		$op = '<div class="crover">';
	
		if (version_compare($ver, $settings['cro_newver']) <= -1 && $settings['cro_newver']) {		
			$op .= '<div class="croverwrap cronewver">' .  __('Version', 'localize') . ' ' . $settings['cro_newver'] . ' ' . __('available time to upgrade', 'localize');
		
   		// COMPOSE STRING IF NEW VERSION IS NOT AVAILABLE
		} else {	
			$op .= '<div class="croverwrap">' .  __('Theme up to date', 'localize');
			$op .= '<span>' .  __('VER', 'localize') . ' ' .  $ver   .    '</span>';
		
		}
				
		// WRAP UP
		$op .= '</div></div>';	
	}
	return $op;
}



 /**
 * -02- CREATE THE NAV MENU SYSTEM
 */ 

function cro_fetch_menu($dashno, $tabno, $list, $url ,$type) {

	$op = '';
	$cntr = 0;	
				
	foreach($list as $field){		
		if ($type == 'prim') {
			$currmen = $cntr == $dashno? 'crocurrent' : '';	
			$pdir = $url . '&dash=' . $cntr;
		} elseif ($type == 'sec') {
			$currmen = $cntr == $tabno? 'crocurrent' : '';	
			$pdir = $url . '&dash=' . $dashno . '&tab=' . $cntr;
		}	
		
		$op .= '<li class="d-' . $cntr . ' ' . $currmen . '"><a href="' . admin_url($pdir) . '"><span>' . $field . '</span></a></li>';	
		
		$cntr++;
	}
			
	return $op;		
}




 /**
 * -03- CREATE THE MAIN SITE
 */ 
function cro_fetch_main($dashno, $tabno, $itemno, $action, $url, $val, $ptype) {
	
		
	// DRAW THE BASICS AND START TO FILL THE FORM		
	$op = '<form method="post" action="'   .   admin_url( $url . '&tab='  . $tabno . '&dash='  . $dashno . '&item=' . $itemno . '&action='  . $action ) . '">';
	$op .= wp_nonce_field('cro_admionnonce');
	$op .= '<input type="hidden" name="crosubmit" value="Y" />';	
	$op .= '<input type="hidden" name="crotab" value="'  . $tabno . '" />';	
	$op .= '<input type="hidden" name="crodash" value="'  . $dashno . '" />';	
	$op .= '<input type="hidden" name="croitem" value="'  . $itemno . '" />';	
	$op .= '<input type="hidden" name="croaction" value="'  . $action . '" />';	
	
	switch ($ptype) {
		case 'none':
		
			foreach($val as $fieldarr){
				$op .= cro_bodycreate($fieldarr, '',0);
			}
			
		break;
			
		case 'slideshows':
		
			$postarray = cro_get_postarray($ptype);					
			$countthem = count($postarray);
			
			// IF NO POSTS GET START FORM
			if ($countthem == 0 || $action == -1) {
				
				// CREATE A FIELD TO REMIND THE FORM HANDLER TO CREATE A NEW FIELD				
				$op .= '<input type="hidden" name="addtype" value="'  . $ptype . '" />';
				
				// DRAW THE FIELDS					
				$op .=  '<div class="slideinner"><p class="slideaddinfo">';
					
					
				// DIFFERENT MESSAGE IF NO SLIDES WAS DETECTED THAN NORMAL ADD A SLIDE
				if ($countthem == 0) {						
					$op .= __('No items detected at present. Add your first.', 'localize');
						
				} else {
					$op .= __('Name your item and click to create.', 'localize');
					}
				
				// DRAW REST OF FORM
				$op .= '</p><p class="slideaddinfo"><input type="text" size="49"  name="addname" value="" class="addslidebut" /></p>';				
				$op .= '<p class="slideaddinfo"><input class="addaslidesubmit" type="submit"  name="slidebut" value="' .  __('Add the item', 'localize')   . '" /></p></div>';
									
			} else {
				
				//DRAW THE FIELDS
				$op .= '<div class="slideinner"><div class="slidewrap"><div class="slideaction">';
					
					
				// BUTTON TO ADD A POST		
				$create_addurl = admin_url( $url . '&tab='  . $tabno . '&dash='  . $dashno . '&item=' . $itemno . '&action=-1');					
					
				$op .= '<a class="addnewslide" style="text-decoration: none;" href="' . $create_addurl . '">' .  __('Add slide', 'localize')   . '</a>';
				 
				
				// CURRENT POST LIST START
				$op .= '<ul class="slidename" rel="' .  $ptype . '">';
				 
				if ($itemno == 0) {
				 	$aid = $postarray[0];
				} else {
				 	$aid = $itemno;
				}
				 
				// COMPOSE THE LIST
				$listcount = 1;
				foreach ($postarray as $postnumber){
					if ($postnumber == $aid) {$curr = 'currit';} else {$curr = '';}
					$admin1 = admin_url( $url . '&tab='  . $tabno . '&dash='  . $dashno . '&item=' . $postnumber . '&action='  . $action );
					$admin2 = admin_url( $url . '&tab='  . $tabno . '&dash='  . $dashno . '&item=' . $postnumber . '&action=-2');
					$op .= '<li class="list_items  ' . $curr . '" id="list_item_' . $listcount . '" rel="' . $postnumber  . '">
								<span class="nameslide">
									<a href="' . $admin1 . '">' . get_the_title($postnumber) . '</a>
								</span>
								<span class="deleteslide">
									<a href="' . $admin2 . '">X</a>
								</span>
								<div class="clear"></div>
							</li>';
					$listcount++;
				}	


				 // CLOSE LIST & START WITH LAYOUT
				 $op .= '</ul>';

				 $op .= '<div class="cro_slide_explain">' .  __('Image size:','localize')  . '<br/><strong>1680px x 550px</strong></div>';


				 $op .= '</div><div class="slidecontent">';
				 
				 
				 	// ADD THE LAYOUTS
				 foreach($val as $fieldarr){
					$op .= cro_bodycreate($fieldarr, $ptype, $aid);
				}
								
				// CLOSE ALL
				 $op .= '</div><br class="clear" /></div></div>';
				
			}
			
		break;

		case 'frontcontents':
		
			$postarray = cro_get_postarray($ptype);					
			$countthem = count($postarray);
			
			// IF NO POSTS GET START FORM
			if ($countthem == 0 || $action == -1) {
				
				// CREATE A FIELD TO REMIND THE FORM HANDLER TO CREATE A NEW FIELD				
				$op .= '<input type="hidden" name="addtype" value="'  . $ptype . '" />';
				
				// DRAW THE FIELDS					
				$op .=  '<div class="slideinner"><p class="slideaddinfo">';
					
					
				// DIFFERENT MESSAGE IF NO SLIDES WAS DETECTED THAN NORMAL ADD A SLIDE
				if ($countthem == 0) {						
					$op .= __('No items detected at present. Add your first.', 'localize');
						
				} else {
					$op .= __('Name your item and click to create.', 'localize');
					}
				
				// DRAW REST OF FORM
				$op .= '</p><p class="slideaddinfo"><input type="text" size="49"  name="addname" value="" class="addslidebut" /></p>';				
				$op .= '<p class="slideaddinfo"><input class="addaslidesubmit" type="submit"  name="slidebut" value="' .  __('Add the item', 'localize')   . '" /></p></div>';
									
			} else {
				
				//DRAW THE FIELDS
				$op .= '<div class="slideinner"><div class="slidewrap"><div class="slideaction">';
					
					
				// BUTTON TO ADD A POST		
				$create_addurl = admin_url( $url . '&tab='  . $tabno . '&dash='  . $dashno . '&item=' . $itemno . '&action=-1');					
					
				$op .= '<a class="addnewslide" style="text-decoration: none;" href="' . $create_addurl . '">' .  __('Add content banner', 'localize')   . '</a>';
				 
				
				// CURRENT POST LIST START
				$op .= '<ul class="slidename" rel="' .  $ptype . '">';
				 
				if ($itemno == 0) {
				 	$aid = $postarray[0];
				} else {
				 	$aid = $itemno;
				}
				 
				// COMPOSE THE LIST
				$listcount = 1;
				foreach ($postarray as $postnumber){
					if ($postnumber == $aid) {$curr = 'currit';} else {$curr = '';}
					$admin1 = admin_url( $url . '&tab='  . $tabno . '&dash='  . $dashno . '&item=' . $postnumber . '&action='  . $action );
					$admin2 = admin_url( $url . '&tab='  . $tabno . '&dash='  . $dashno . '&item=' . $postnumber . '&action=-2');
					$op .= '<li class="list_items  ' . $curr . '" id="list_item_' . $listcount . '" rel="' . $postnumber  . '">
								<span class="nameslide">
									<a href="' . $admin1 . '">' . get_the_title($postnumber) . '</a>
								</span>
								<span class="deleteslide">
									<a href="' . $admin2 . '">X</a>
								</span>
								<div class="clear"></div>
							</li>';
					$listcount++;
				}	


				 // CLOSE LIST & START WITH LAYOUT
				 $op .= '</ul>';


				  $op .= '<div class="cro_slide_explain">' .  __('Image size:','localize')  . '<br/><br/>'  .  __('Top left & bottom right:','localize')  . '<br/><strong>465px x 340px</strong><br/>' .  __('Bottom left & top right:','localize')  . '<br/><strong>465px x 170px</strong><br/><br/>';

				  $op .= __('Images will be auto resized','localize')  . '<br/><br/>'  .  __('Images can be dragged and dropped to reorder','localize')  . '<br/><br/>'  .  __('Image 1 and 4 will always be the larger one and 2 and 4 the smaller one','localize');


				  $op .= '</div>';


				 $op .= '</div><div class="slidecontent">';
				 
				 
				 	// ADD THE LAYOUTS
				 foreach($val as $fieldarr){
					$op .= cro_bodycreate($fieldarr, $ptype, $aid);
				}
								
				// CLOSE ALL
				 $op .= '</div><br class="clear" /></div></div>';
				
			}
			
		break;
		

	}
					
	
	$op .= '<br class="clear">';	
	
	$op .= '<input type="submit" name="Submit"  class="cro_formsave" value="'   .  __('Save', 'localize') . '" />';
	
	return $op . '</form>';
	
}


?>