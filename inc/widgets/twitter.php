<?php
/**
 * The carousel widget
 *
 */
 
 
 
class cro_twitter extends WP_Widget {

	
	public function __construct() {
		parent::__construct(
	 		'cro_twitter', // Base ID
			'Twitter &nbsp;&nbsp;&nbsp; [C]', // Name
			array( 'description' => __( 'Croma twitter widget', 'localize' ), ) // Args
		);
	}


	// WIDGET OUTPUT
	public function widget( $args, $instance ) {

		$herenow = time();
		$cro_getuser = get_option('cro_tweetsave');
		$crocount = 0;
		$twitterings = array();
		$followlabel  = '';

		extract( $args );		
		$title 					= apply_filters('widget_title', $instance['title']);
		$tweets 				= esc_attr($instance['tweets']);	
		$username 				= esc_attr(str_replace('@', '', $instance['username']));	
		$followlabel 			= esc_attr($instance['followlabel']);
		$tweetmore 				= '';
		$consumer_key 			= $instance[ 'consumer_key'];
		$consumer_secret 		= $instance[ 'consumer_secret'];
		$access_token 			= $instance[ 'access_token'];
		$access_token_secret 	= $instance[ 'access_token_secret'];
		$twitterings 			= '';


		if ($tweets >= 2) {
			$tweetmore = 'tweetmore';
		}

		if (!isset($cro_getuser) || !isset($cro_getuser[$username]) || !isset($cro_getuser[$username]['consumer_key']) || !isset($cro_getuser[$username]['consumer_secret']) || !isset($cro_getuser[$username]['access_token']) || !isset($cro_getuser[$username]['access_token_secret'])) {
			$args = array(
				'consumer_key' 		=> $consumer_key,
				'consumer_secret' 	=> $consumer_secret,
				'access_token' 		=> $access_token,
				'access_token_secret' => $access_token_secret
			);
			cro_updatetweets($username, $args);
			$cro_getuser = get_option('cro_tweetsave');
		}

		$cro_getuser[$username]['time'] = $herenow;
		$cro_getuser[$username]['user'] = $username;
		update_option('cro_tweetsave', $cro_getuser);
		$twitterings = $cro_getuser[$username]['tweets'];


		echo $before_widget;


		if ( $title ) echo $before_title . $title . $after_title; 		


		if ($twitterings) {
			foreach ( $twitterings as $crot ) {

				if ($crocount == $tweets){
					break;
				}

				$text = make_clickable( esc_html( $crot['text'] ) );
				$text = cro_linkify_tweet($text);
				$tweet_id = urlencode($crot['id_str']);
				$ago =  '<a href="http://twitter.com/' . $username . '/statuses/' . $tweet_id . '" target="_blank" class="timesince">' . str_replace(' ', '&nbsp;', cro_twittertime(strtotime($crot['created_at']))) . '&nbsp;' . __('ago', 'localize') . '</a>';
				$ttime = time() - strtotime($crot['created_at']);

				if ($crocount >= 1) {
					echo '<p class="secondtweet">' . $text . '</p><span>' . $ago;
				} else {
					echo '<p class="' .  $tweetmore . '">' . $text . '</p><span>' . $ago;
				}

				echo '<a class="cro_retweet" href="http://twitter.com/intent/retweet?tweet_id=' . $tweet_id . '" target="_blank">' . __('retweet', 'localize') . '<em>' . __('retweet', 'localize') . '</em></a>';
				echo '<a class="cro_reply" href="http://twitter.com/intent/tweet?in_reply_to=' . $tweet_id .  '" target="_blank">' . __('reply', 'localize') . '<em>' . __('reply', 'localize') . '</em></a>';
				echo '<a class="cro_favorite" href="http://twitter.com/intent/favorite?tweet_id=' . $tweet_id .  '" target="_blank">' . __('favorite', 'localize') . '<em>' . __('favorite', 'localize') . '</em></a>';

				echo '</span>';

				$crocount++;

			}
		}

		echo '<a href="http://twitter.com/' . $username  . '" class="followlabel">' . $followlabel . '</a>';

		echo $after_widget;
				
	}
	
	
	

	// WIDGET VALUES UPDATE
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] 					= strip_tags( $new_instance['title'] );
		$instance['tweets'] 				= esc_attr( $new_instance['tweets'] );
		$instance['username'] 				= esc_attr( $new_instance['username'] );
		$instance['followlabel'] 			= esc_attr( $new_instance['followlabel'] );
		$instance['consumer_key'] 			= esc_attr( $new_instance['consumer_key']);
		$instance['consumer_secret'] 		= esc_attr( $new_instance['consumer_secret']);
		$instance['access_token'] 			= esc_attr( $new_instance['access_token']);
		$instance['access_token_secret'] 	= esc_attr( $new_instance['access_token_secret']);
		return $instance;
	}

	
	// WIDGET FORM
	public function form( $instance ) {
		if (isset($instance[ 'title' ]) || isset($instance[ 'tweets' ]) || isset($instance[ 'username' ]) || isset($instance[ 'followlabel' ]) || isset($instance[ 'consumer_key' ]) || isset($instance[ 'consumer_secret' ]) || isset($instance[ 'access_token' ]) || isset($instance[ 'access_token_secret' ])) {
			$title 					= $instance[ 'title'];
			$tweets 				= $instance[ 'tweets'];
			$username 				= $instance[ 'username'];
			$followlabel			= $instance[ 'followlabel'];
			$consumer_key 			= $instance[ 'consumer_key'];
			$consumer_secret 		= $instance[ 'consumer_secret'];
			$access_token 			= $instance[ 'access_token'];
			$access_token_secret 	= $instance[ 'access_token_secret'];

		} else {
			$title = 'New Title';
			$tweets = '';
			$username = '';
			$consumer_key = '';
			$consumer_secret = '';
			$access_token = '';
			$access_token_secret= '';
			$followlabel = __('Follow us on Twitter','localize');
		}
		

		$args = array(
			'type'		=> 'input',
			'labelfor' 	=> $this->get_field_id( 'title' ),
			'label'		=> __('Title','localize'),
			'id'		=> $this->get_field_id( 'title' ),
			'idname'	=> $this->get_field_name( 'title' ),
			'val'		=> esc_attr( $title ),
			'options'	=> ''
		);
		echo cro_make_widget_formpart($args);

		$args = array(
			'type'		=> 'input',
			'labelfor' 	=> $this->get_field_id( 'tweets' ),
			'label'		=> __('Number of tweets:','localize'),
			'id'		=> $this->get_field_id( 'tweets' ),
			'idname'	=> $this->get_field_name( 'tweets' ),
			'val'		=> esc_attr( $tweets ),
			'options'	=> ''
		);
		echo cro_make_widget_formpart($args);

		$args = array(
			'type'		=> 'input',
			'labelfor' 	=> $this->get_field_id( 'username' ),
			'label'		=> __('Username:','localize'),
			'id'		=> $this->get_field_id( 'username' ),
			'idname'	=> $this->get_field_name( 'username' ),
			'val'		=> esc_attr( $username ),
			'options'	=> ''
		);
		echo cro_make_widget_formpart($args);

		$args = array(
			'type'		=> 'input',
			'labelfor' 	=> $this->get_field_id( 'consumer_key' ),
			'label'		=> __('Consumer key:','localize'),
			'id'		=> $this->get_field_id( 'consumer_key' ),
			'idname'	=> $this->get_field_name( 'consumer_key' ),
			'val'		=> esc_attr( $consumer_key ),
			'options'	=> ''
		);
		echo cro_make_widget_formpart($args);

		$args = array(
			'type'		=> 'input',
			'labelfor' 	=> $this->get_field_id( 'consumer_secret' ),
			'label'		=> __('Consumer Secret:','localize'),
			'id'		=> $this->get_field_id( 'consumer_secret' ),
			'idname'	=> $this->get_field_name( 'consumer_secret' ),
			'val'		=> esc_attr( $consumer_secret ),
			'options'	=> ''
		);
		echo cro_make_widget_formpart($args);

		$args = array(
			'type'		=> 'input',
			'labelfor' 	=> $this->get_field_id( 'access_token' ),
			'label'		=> __('Access token:','localize'),
			'id'		=> $this->get_field_id( 'access_token' ),
			'idname'	=> $this->get_field_name( 'access_token' ),
			'val'		=> esc_attr( $access_token ),
			'options'	=> ''
		);
		echo cro_make_widget_formpart($args);

		$args = array(
			'type'		=> 'input',
			'labelfor' 	=> $this->get_field_id( 'access_token_secret' ),
			'label'		=> __('Access token secret:','localize'),
			'id'		=> $this->get_field_id( 'access_token_secret' ),
			'idname'	=> $this->get_field_name( 'access_token_secret' ),
			'val'		=> esc_attr( $access_token_secret),
			'options'	=> ''
		);
		echo cro_make_widget_formpart($args);



		$args = array(
			'type'		=> 'input',
			'labelfor' 	=> $this->get_field_id( 'followlabel' ),
			'label'		=> __('Follow us label:','localize'),
			'id'		=> $this->get_field_id( 'followlabel' ),
			'idname'	=> $this->get_field_name( 'followlabel' ),
			'val'		=> esc_attr( $followlabel ),
			'options'	=> ''
		);
		echo cro_make_widget_formpart($args);
	}

} // class Foo_Widget


add_action( 'widgets_init', create_function( '', 'register_widget( "cro_twitter" );' ) );
 

 
?>