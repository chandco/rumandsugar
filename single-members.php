<?php
/**
 * The template for displaying member pages.
 *
 *
 * 
 */
 
$tlset = get_option( 'tlset' );
  

get_header(); 

	if (isset($tlset['cro_showbanindex']) && $tlset['cro_showbanindex'] == 1 ){
		$ps =  cro_fetch_banner('inner'); 
	} else {
		$ps =  ''; 
	}

?>

				
	<?php while ( have_posts() ) : the_post();
		$sbar = get_post_meta($post->ID, 'cro_sidebar', true);
		echo cro_headerimg($post->ID, 'page', $ps);			
	?>

	<div class="main singleitem">				
		<div class="row singlepage">

			<?php
			$prq = get_post_meta($post->ID, 'cro_showpromo', true);
			$prw = get_post_meta($post->ID, 'cro_showpromowhat', true);
			if ($prq == 2 ) {
			 echo '<div class="cro_banner-pagetop">' . $ps . '</div>'; 
			}
			 ?>

			<?php if ($sbar == 1) { ?>


				<div class="eight column">
					<?php get_template_part( 'public/tparts/content', 'page' ); ?>
				</div>

				<div class="four column">
					<?php get_sidebar(); ?>
				</div>



			<?php } else { ?>

				<div class="twelve column">
					<?php get_template_part( 'public/tparts/content', 'page' ); ?>
				</div>

			<?php } ?>
			
			<?php
			if ($prq == 3 ) {
			 echo '<div class="cro_banner-pagebottom">' . $ps . '</div>'; 
			}
			?>
		</div>
	</div>

	<?php endwhile; // end of the loop. ?>


<?php get_footer(); ?>