<?php
/*
 Template Name: Page with Sidebar
 *
 * Home Page template
 *
 * For more info: http://codex.wordpress.org/Page_Templates
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

	<div class="main singleitem row left-content" style="background: url('http://rumandsugar.dev.chand.co/wp-content/uploads//2015/07/clipboard-bg.jpg');">				
		<div class="row singlepage" style="background: url(/wp-content/uploads//2015/06/background-texture9.jpg); margin:15px;">


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
			
		</div>
	</div>

	<?php endwhile; // end of the loop. ?>

	<div class="right-content">
	<?php dynamic_sidebar( 'sidebar-widget-area' ); ?>
	</div>


<?php get_footer(); ?>