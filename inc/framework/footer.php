<?php
/**
 * footer framework functions
 */ 
   
/********** Code Index
 *
 * -01- ADD MENU DESCRIPTIONS
 * 
 */


add_action( 'croma_footstuff', 'croma_fetch_footstuff' );

function croma_fetch_footstuff() { 
$tlset = get_option( "tlset" );  
$mlabel =  $tlset["menulabel"]; 
?>
<div id="modalholder">&nbsp;</div>
<div class="galholder">&nbsp;</div>

	<script type="text/javascript">
	jQuery(document).ready(function($) {
		swvf = '<?php echo get_template_directory_uri(); ?>/inc/scripts/';
		selectnav('cro-menu', {
 			label: '<?php echo $mlabel; ?>',
  			nested: true,
  			indent: '--'
		});	
	});	
    </script>

<?php  
}


if (defined('CROCSH') && CROCSH == '1') {
	add_action( 'croma_sch', 'croma_create_sch' );

	function croma_create_sch() {     
	?>

	<div class="cro_sch" rel="<?php echo get_template_directory_uri(); ?>/public/styles/cs-">
		<div class="cro_sec">
			<div class="secpoint" style="background: #E8AF46;" rel="1">&nbsp;</div>
			<div class="secpoint" style="background: #BD3741;" rel="2">&nbsp;</div>
			<div class="secpoint" style="background: #D15B23" rel="3">&nbsp;</div>
			<div class="secpoint" style="background: #9DAF20;" rel="4">&nbsp;</div>
			<div class="secpoint" style="background: #4784BF" rel="5">&nbsp;</div>
			<div class="secpoint" style="background: #CF6795;" rel="6">&nbsp;</div>
			<div class="secpoint" style="background: #C89FC1;" rel="7">&nbsp;</div>
		</div>

		<div class="cro_prim" rel="<?php echo get_template_directory_uri(); ?>/public/styles/images">
			<div class="secpoint prim" style="background: #fff; top: 185px;" rel="1">&nbsp;</div>
			<div class="secpoint prim" style="background: #000; top: 205px;" rel="2">&nbsp;</div>
		</div>

	</div>

	<?php  
	}

}
 
?>