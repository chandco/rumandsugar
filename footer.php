<?php
/**
 * The template for displaying the footer.
 *
 */

/********** Code Index
 *
 * -01- CLOSE MAINPART
 * -02- START FOOTER
 * -03- FOOTER WIDGETS
 * -04- CREDITS
 * -05- FOOTER FRAMEWORK STUFF
 * 
 */

?>



<!--
 * -01- CLOSE MAINPART
-->	
		</div>
	</div> 
</div> 


<!--
 * -02- START FOOTER
-->	
<div class="footer" id='footer'>
	<div class="footinner">
		<div class="row">

<!--
 * -03- FOOTER WIDGETS
-->	
			<div class="four columns">
				&nbsp;
				<?php if ( is_active_sidebar( 'cro_footleft' ) ) { 
					echo '<ul class="footwidget">';
					dynamic_sidebar( 'cro_footleft' );
					echo '</ul>';
				} ?>					
			</div>

			<div class="four columns">
				&nbsp;
				<?php if ( is_active_sidebar( 'cro_footcent' ) ) { 
					echo '<ul class="footwidget">';
					dynamic_sidebar( 'cro_footcent' );
					echo '</ul>';
				} ?>					
			</div>

			<div class="four columns">
				&nbsp;
				<?php if ( is_active_sidebar( 'cro_footright' ) ) { 
					echo '<ul class="footwidget">';
					dynamic_sidebar( 'cro_footright' );
					echo '</ul>';
				} ?>					
			</div>

		</div>
	</div>

<!--
 * -04- CREDITS
-->	
	<div class="footscribe">
		<div class="row">
			<div class="six columns">
				<div id="site-info">
					<a href="<?php echo home_url( '/' ) ?>" class="whites" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
						&copy; <a href='http://www.ampersandcatering.co.uk'>Ampersand</a> <?php echo date('Y'); ?>
					</a>
					<Br /><br />
					No.1 Warehouse, West India Quay, Canary Wharf, E14 4AL ( <a href='<?php echo get_site_url(); ?>/about-us/'> Find Us </a> )
				</div>					
			</div>

			<div class="six columns">
				<div id="site-generator">
					<img src='<?php echo get_stylesheet_directory_uri(); ?>/lib/images/museumlogo-mod.png' id='mold-logo' />
					<?php include(get_stylesheet_directory() . "/lib/images/ampersand.svg"); ?>
				</div><!-- #site-generator -->				
			</div>
		</div>
	</div>
</div>

<?php do_action('croma_sch'); ?>
<?php do_action('croma_footstuff'); ?>
<?php wp_footer(); ?>

<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-21561026-4']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' :
'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0];
s.parentNode.insertBefore(ga, s);
  })();

</script>
</body>
</html>
