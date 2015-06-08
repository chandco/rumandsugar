<?php
/**
 * The sidebar containing the main widget area.
 *
 * 
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
?>
	<?php 
	$sb = 'cro_sidebarmain';
	$sbarname = get_post_meta(get_option('woocommerce_shop_page_id'), 'cro_sidebarsel',true);
	$sb = ($sbarname != '' && $sbarname !== '0') ? 'cro_' . $sbarname : 'cro_sidebarmain' ;
	?>
	<?php if ( is_active_sidebar( $sb ) ) : ?>
		<ul class="mainwidget widgside widginside">
			<?php dynamic_sidebar( $sb ); ?>
		</ul><!-- #secondary -->
	<?php endif; ?>