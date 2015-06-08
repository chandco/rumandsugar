<?php
/**
 * The template for displaying posts in the Gallery Post Format on index and archive pages
 *
 */
?>



<div id="post-<?php the_ID(); ?>" <?php post_class(); ?> >
	
	<?php the_content(); ?>

</div>
