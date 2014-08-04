<?php
/*
 * Croma admin framework: page controller
 */



/********** Code Index
 *
 * -01- DRAW THE SETTINGS PAGE
 * -02- DRAW THE SAVE
 * 
 */


/**
 * -01- DRAW THE SETTINGS PAGE
 */ 
function cro_page() {
	
	$cro_init = cro_setup_admin_data();
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
			<img src="<?php echo get_template_directory_uri(); ?>/inc/admin/images/marlogo.png" class="logo" title="Link to the Croma website">
		</a>		
			
		<!-- link to faq support -->		
		<ul class="crosup">	
			<li class="sup"><a href="http://cro.ma/?page_id=327" target="_blank" title="Link to the Croma support page"><?php echo  __('SUPPORT', 'localize'); ?></a></li>
		</ul>	

		<!-- get the versioning info sorted -->			
		<?php echo cro_fetch_version(); ?>	

	</div> 

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
				<?php   echo cro_fetch_main($cro_init['dash'], $cro_init['tab'], $cro_init['item'], $cro_init['action'],$cro_init['base_url'], $cro_init['values'], $cro_init['ptype']);	?>
			</div>					
		</div>
	</div>
</div>
						
<?php
	
}





/**
 * -02- DRAW THE SAVE
 */ 
function cro_spage() {
	
	$cro_init = cro_setup_admin_data();
	
	if ( isset($_GET["action"]) && $_GET["action"] == '-2' ) {
		
		wp_delete_post( $cro_init['item'], true );
			
		$ab = $cro_init['base_url'] . '&tab=' . $cro_init['tab']  . '&dash=' . $cro_init['dash']  . '&item=0&action=0&updated=trues';		
		wp_redirect(admin_url($ab));
		
		
	} elseif ( isset($_POST["crosubmit"]) &&  $_POST["crosubmit"] == 'Y' ) {
		
		check_admin_referer( 'cro_admionnonce');
		
		if ( isset($_POST["crotab"])) { $ttab = $_POST["crotab"]; } 
		if ( isset($_POST["crodash"])) { $tdash = $_POST["crodash"]; }
		if ( isset($_POST["croitem"])) { $titem = $_POST["croitem"]; }
		if ( isset($_POST["croaction"])) { $taction = $_POST["croaction"];}
		
		if (isset($_POST["addtype"])){

			$ttype = $_POST["addtype"];
			if ( isset($_POST["addname"])) { $tname = $_POST["addname"]; } 
			
			if ($ttype && $tname){				
				cro_add_a_post($tname, $ttype);				
			}	
			
			$ab = $cro_init['base_url'] . '&tab=' . $ttab . '&dash=' . $tdash . '&item=0&action=0&updated=true';		
			wp_redirect(admin_url($ab));	


		} else {	
			$ab = cro_fetch_updateaction( $ttab, $tdash, $titem,$taction, $cro_init['base_url'],  $cro_init['savetype'],  $cro_init['ptype'], $cro_init['values']);		
			wp_redirect(admin_url($ab));			
		}	
	}
}

?>