<?php
/**
 * The template for displaying  the woo-commerce shop
 *
 *
 * Template Name: Woo Commerce
 */
 
$tlset = get_option( 'tlset' );
  

get_header(); 

	if (isset($tlset['cro_showbanindex']) && $tlset['cro_showbanindex'] == 1 ){
		$ps =  cro_fetch_banner('inner'); 
	} else {
		$ps =  ''; 
	}



?>

				
	<?php 
	$sbar = get_post_meta(get_option('woocommerce_shop_page_id'), 'cro_sidebar', true);
	echo cro_headerimg(get_option('woocommerce_shop_page_id'), 'page', $ps);			
	 ?>

	<div class="main singleitem">				
		<div class="row singlepage">

			<?php if ($sbar == 1) { ?>


				<div class="eight column">
					<?php woocommerce_content(); ?>
				</div>

				<div class="four column">
					<?php get_sidebar('shop'); ?>
				</div>



			<?php } else { ?>

				<div class="twelve column">
					<?php woocommerce_content(); ?>
				</div>

			<?php } ?>
			
		</div>
	</div>


<?php get_footer(); ?>