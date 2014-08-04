<?php
/**
 * The template for displaying 404 pages.
 *
 *
 */


/********** Code Index
 *
 * -01- GET HEADER
 * -02- GET HEADERIMAGE
 * -03- MAIN PART
 * -04- GET FOOTER
 * 
 */
 
$tlset = get_option( 'tlset' );
  

get_header(); ?>

<?php 
	if (isset($tlset['cro_showbanindex']) && $tlset['cro_showbanindex'] == 1 ){
		$ps =  cro_fetch_banner('inner'); 
	} else {
		$ps =  ''; 
	}
				
	$sbar = get_post_meta($post->ID, 'cro_sidebar', true);
	echo cro_headerimg(0, '404',$ps);
?>

<!--
 * 03- MAIN PART
-->	
	<div class="main singleitem">				
		<div class="row singlepage">

				<div class="eight column">
					<div class="post">	<p><?php _e( 'It seems we can&rsquo;t find what you&rsquo;re looking for.', 'localize' ); ?></p></div>
				</div>

				<div class="four column">
					<?php get_sidebar(); ?>
				</div>

		</div>
	</div>



<!--
 * 03- FOOTER
-->	
<?php get_footer(); ?>