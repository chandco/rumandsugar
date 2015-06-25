<?php
/**
 * The Header for our theme.
 */ 
   
/********** Code Index
 *
 * -01- HEADER STUFF
 * -02- START BODY
 * -03- GET TOPBAR
 * -04- LOGO & SOCIAL
 * -05- START THE MAINBODY
 * -06- MENU
 * 
 */
 
// ARRAYS CONSISTING OF COLOR SETTINGS OF THE THEME AND THEME OPTIONS
$tlset = get_option( "tlset" );


/**
 * -01- HEADER STUFF
 */ 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes( 'xhtml' ); ?>>
<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="<?php bloginfo( 'html_type' ); ?>; charset=<?php bloginfo( 'charset' ); ?>" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
<meta name="viewport" content="width=device-width" />
<?php
echo '<title>' .  wp_title('-' , 0, 'right' ) . '</title>';

$ap = get_mapstack();
if ($ap != '') {echo $ap;}

wp_head();
?>


<!--
 * -02- START BODY
 * 
-->
</head>
<?php 
	if ($ap != '') { ?>
		<body <?php body_class(); ?> onload="initialize()">
	<?php } else { ?>
		<body <?php body_class(); ?>>
	<?php } 
?>



<!--
 * -05- START THE MAINBODY
-->
<div class="mbod">
	<div class="topper">
		<div class="row">
			<?php 

				if (defined('CROCSH') && CROCSH == '1') {
					if (isset($_COOKIE['cro_cssb']) && $_COOKIE['cro_cssb'] == '2'){
						echo '<a href="'. esc_url( home_url( '/' ) ) .' class="logolink" title="' . esc_attr( get_bloginfo( 'name', 'display' ) ) . '" rel="home"><img class="tllogo" title="' .  esc_attr( get_bloginfo( 'name', 'display' )) . '" src="' . get_template_directory_uri() . '/public/styles/images/darklogo.png" /></a>';
					} else {
						echo '<a href="'. esc_url( home_url( '/' ) ) .'" class="logolink" title="' . esc_attr( get_bloginfo( 'name', 'display' ) ) . '" rel="home"><img class="tllogo" title="' .  esc_attr( get_bloginfo( 'name', 'display' )) . '" src="' .  $tlset['logo'] . '" /></a>';
					}
				} else {
					if(isset($tlset['logo']) && $tlset['logo'])  {
						echo '<a href="'. esc_url( home_url( '/' ) ) .'" class="logolink" title="' . esc_attr( get_bloginfo( 'name', 'display' ) ) . '" rel="home"><img class="tllogo" title="' .  esc_attr( get_bloginfo( 'name', 'display' )) . '" src="' .  $tlset['logo'] . '" /></a>';
					} else {
						echo '&nbsp;';
					}
				}
			?>
		<div id="mainmen">

			<div id="access">	
				<?php 
					if ( has_nav_menu('primary' ) ) {
						wp_nav_menu( array( 'container_class' => 'menu-header', 'theme_location' => 'primary', 'menu_id'  => 'cro-menu' ) ); 
				} ?>

			</div>	
		</div>
		<div id="social-links">social media</div>
		<div class="clearfix"></div>
		<?php echo ntfetch_social(); ?>	
	</div>
</div>
