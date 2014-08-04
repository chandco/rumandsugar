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
	$curquer = $wp_query->get_queried_object();
	$sbarname = '';
	$pt = get_post_type();
	if (is_category()){
		$sb = 'cro_sidebarmain';
		$opt = get_option('taxonomy_'. $curquer->term_id);
		$sbarname = $opt['cro_cat_sbar'];
		$sb = ($sbarname != '' && $sbarname !== '0') ? 'cro_' . $sbarname : 'cro_sidebarmain' ;
	} elseif (is_single()) {
		$sb = 'cro_sidebarmain';
		$sbarname = get_post_meta($curquer->ID, 'cro_sidebarsel',true);
		$sb = ($sbarname != '' && $sbarname !== '0') ? 'cro_' . $sbarname : 'cro_sidebarmain' ;
	} elseif (is_page()) {
		$sb = 'cro_sidebarmain';
		$sbarname = get_post_meta($curquer->ID, 'cro_sidebarsel',true);
		$sb = ($sbarname != '' && $sbarname !== '0') ? 'cro_' . $sbarname : 'cro_sidebarmain' ;
	} else{
		$sb = 'cro_sidebarmain';
	}
	?>
	<?php if ( is_active_sidebar( $sb ) ) : ?>
		<ul class="mainwidget">
			<?php dynamic_sidebar( $sb ); ?>
		</ul><!-- #secondary -->
	<?php endif; ?>