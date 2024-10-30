<?php

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Load library
require_once( BHP_DIR . 'inc/bht-showTweets.php' );

/**
 * Enqueue style
 *
 */
function bht_twitter_feed_style_enqueue() {
	wp_enqueue_style( 'owl-carousel', BHP_URI . 'assets/public/css/owl.carousel.css' );	

	wp_enqueue_style( 'bht-twitter-feed-widget', BHP_URI . 'assets/public/css/bht-twitter-feeds.css' );

	wp_enqueue_script( 'owl-carousel', BHP_URI . 'assets/public/js/owl.carousel.min.js', array('jquery'), '20160911', true );

	wp_enqueue_script( 'bht-twitter-feed-widget-js', BHP_URI . 'assets/public/js/bht-twitter-feeds.js' , array(), '1.0.0', true );
}
add_action( 'wp_enqueue_scripts', 'bht_twitter_feed_style_enqueue' ); 


class BHT_Widget_Recent_Tweets extends WP_Widget {

	/**
	 * Sets up a new Recent Tweets widget instance.
	 *
	 * @since 2.8.0
	 * @access public
	 */
	public function __construct() {
		$widget_ops = array(
			'classname' => 'twitter-feed',
			'description' => __( 'A widget that displays most recent Tweets.', 'business-hub-toolbox' ),
			'customize_selective_refresh' => true,
			);
		parent::__construct( 'recent-tweets', __( 'Business Hub: Recent Tweets', 'business-hub-toolbox' ), $widget_ops );
		$this->alt_option_name = 'widget_recent_tweets';
	}

	/**
	 * Outputs the content for the current Recent Posts widget instance.
	 *
	 * @since 2.8.0
	 * @access public
	 *
	 * @param array $args     Display arguments including 'before_title', 'after_title',
	 *                        'before_widget', and 'after_widget'.
	 * @param array $instance Settings for the current Recent Posts widget instance.
	 */
	public function widget( $args, $instance ) {

		if ( ! isset( $args['widget_id'] ) ) {
			$args['widget_id'] = $this->id;
		}

		$title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : '';

		/** This filter is documented in wp-includes/widgets/class-wp-widget-pages.php */
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );
		$number = ( ! empty( $instance['number'] ) ) ? $instance['number'] : 5;
		$oauth_access_token = ( ! empty( $instance['oauth_access_token'] ) ) ? $instance['oauth_access_token'] : '';
		$oauth_access_token_secret = ( ! empty( $instance['oauth_access_token_secret'] ) ) ? $instance['oauth_access_token_secret'] : '';
		$consumer_key = ( ! empty( $instance['consumer_key'] ) ) ? $instance['consumer_key'] : '';
		$consumer_secret = ( ! empty( $instance['consumer_secret'] ) ) ? $instance['consumer_secret'] : '';
		$username = ( ! empty( $instance['username'] ) ) ? $instance['username'] : '';

		if ( ! $number )
			$number = 5;

		$settings = array(
			'oauth_access_token'=> $oauth_access_token,
			'oauth_access_token_secret'=> $oauth_access_token_secret,
			'consumer_key'=> $consumer_key,
			'consumer_secret'=> $consumer_secret,
			);



		$bht_twitter = new bht_showTweets();

		$bht_twitter->setNoOfTweet($number);

		$bht_twitter->setUserName($username);

		$bht_twitter->setSettings($settings);


		if (function_exists('curl_init'))
        {

		$tweets = $bht_twitter->bht_getTweets();

		} else {

			$tweets = null;
		}

		echo $args['before_widget']; 

		?>
		<div class="container">
		<div class="row">
			<div class="col col-1-of-1">
				
				<?php
				if ( $title ) { ?>
					<?php echo $args['before_title'] . esc_html( $title ) . $args['after_title'];  ?>
					 
				<?php
				}
				?>
				<i class="fa fa-twitter fa-3x"></i>
				
				<?php if(!isset($tweets["errors"][0]["message"]) && count($tweets) ) { ?>

				<div  id="twitter-feed" class="owl-carousel ut-twitter-rotator">
					<?php
						foreach ($tweets as $tweet): ?>

						<?php
						
						$tweetPost = $tweet['text'];
						$hashTags = $tweet['entities']['hashtags'];
						$urls = $tweet['entities']['urls'];
						$created_at = new DateTime($tweet['created_at']);
						$current_date = new DateTime('now') ;
						$interval = date_diff($created_at, $current_date);

						foreach($hashTags as $hashTag){
							$tweetPost = str_replace('#'.$hashTag['text'], '<a target="_blank" href="https://twitter.com/hashtag/'.$hashTag['text'].'?src=hash">'.'#'.$hashTag['text'].'</a>', $tweetPost);
						}

						foreach($urls as $linksUrl){
							$tweetPost = str_replace($linksUrl['url'], '<a href="'.$linksUrl['url'].'" target="_blank">'.$linksUrl['url'].'</a>', $tweetPost);
						}

						?>
						<div class="item">
							<h2> <?php echo $tweetPost; ?> </h2>
							<span class="ut-quote-name"><?php echo esc_html($username); ?> about <?php echo absint($interval->days); ?> <?php esc_html_e( 'days ago', 'business-hub-toolbox' ); ?> </span>
						</div><!-- .item -->

							<?php
							endforeach; 
						?>
						</div><!-- .owl-carousel -->

						<?php } else { ?>

						<div class="item">
						<?php if (!function_exists('curl_init'))
							        {
							     ?>
							     <h4> <?php esc_html_e( 'Sorry, Please enable curl function in php.ini file !!!', 'business-hub-toolbox' ); ?> </h4>

							    <?php

							        } else {
							 ?>
							<h4> <?php esc_html_e( 'Sorry, Please enter the valid tokens !!!', 'business-hub-toolbox' ); ?> </h4>

							<?php } ?>
						</div><!-- .item -->

						<?php } ?>

					</div>
					</div>
				</div>

				<?php 

				echo $args['after_widget'];

			}

/**
	 * Handles updating the settings for the current Recent Posts widget instance.
	 *
	 * @since 2.8.0
	 * @access public
	 *
	 * @param array $new_instance New settings for this instance as input by the user via
	 *                            WP_Widget::form().
	 * @param array $old_instance Old settings for this instance.
	 * @return array Updated settings to save.
	 */
public function update( $new_instance, $old_instance ) {
	$instance = $old_instance;
	$instance['title'] = sanitize_text_field( $new_instance['title'] );
	$instance['number'] = (int) $new_instance['number'];

	$instance['oauth_access_token'] =  sanitize_text_field($new_instance['oauth_access_token']);
	$instance['oauth_access_token_secret'] =  sanitize_text_field($new_instance['oauth_access_token_secret']);
	$instance['consumer_key'] =  sanitize_text_field($new_instance['consumer_key']);
	$instance['consumer_secret'] =  sanitize_text_field($new_instance['consumer_secret']);
	$instance['username'] =  sanitize_text_field($new_instance['username']);


	return $instance;
}

/**
	 * Outputs the settings form for the Recent Posts widget.
	 *
	 * @since 2.8.0
	 * @access public
	 *
	 * @param array $instance Current settings.
	 */
public function form( $instance ) {
	$title     = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
	$number    = isset( $instance['number'] ) ? absint( $instance['number'] ) : 5;

	$oauth_access_token =  isset( $instance['oauth_access_token'] ) ? $instance['oauth_access_token'] : '';
	$oauth_access_token_secret =  isset( $instance['oauth_access_token_secret'] ) ? $instance['oauth_access_token_secret'] : '';
	$consumer_key =  isset( $instance['consumer_key'] ) ? $instance['consumer_key'] : '';
	$consumer_secret =  isset( $instance['consumer_secret'] ) ? $instance['consumer_secret'] : '';
	$username =  isset( $instance['username'] ) ? $instance['username'] : '';

	?>

	<p>
		<label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>">
			<?php esc_html_e( 'Title:', 'business-hub-toolbox' ); ?>
		</label>
		<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
	</p>



	<p>
		<label for="<?php echo esc_attr($this->get_field_id( 'oauth_access_token' )); ?>">
			<?php esc_html_e( 'Access Token:', 'business-hub-toolbox' ); ?>
		</label>
		<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'oauth_access_token' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'oauth_access_token' )); ?>" type="text"  value="<?php echo esc_attr($oauth_access_token); ?>" />
	</p>

	<p>
		<label for="<?php echo esc_attr($this->get_field_id( 'oauth_access_token_secret' )); ?>">
			<?php esc_html_e( 'Access Token Secret:', 'business-hub-toolbox' ); ?>
		</label>
		<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'oauth_access_token_secret' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'oauth_access_token_secret' )); ?>" type="text"  value="<?php echo esc_attr($oauth_access_token_secret); ?>" />
	</p>

	<p>
		<label for="<?php echo esc_attr($this->get_field_id( 'consumer_key' )); ?>">
			<?php esc_html_e( 'Consumer Key:', 'business-hub-toolbox' ); ?>
		</label>
		<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'consumer_key' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'consumer_key' )); ?>" type="text"  value="<?php echo esc_attr($consumer_key); ?>" />
	</p>

	<p>
		<label for="<?php echo esc_attr($this->get_field_id( 'consumer_secret' )); ?>">
			<?php esc_html_e( 'Consumer Secret:', 'business-hub-toolbox' ); ?>
		</label>
		<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'consumer_secret' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'consumer_secret' )); ?>" type="text"  value="<?php echo esc_attr($consumer_secret); ?>" />
	</p>

	<p>
		<label for="<?php echo esc_attr($this->get_field_id( 'username' )); ?>">
			<?php esc_html_e( 'User Name:', 'business-hub-toolbox' ); ?>
		</label>
		<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'username' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'username' )); ?>" type="text"  value="<?php echo esc_attr($username); ?>" />
	</p>

	<p>
		<label for="<?php echo esc_attr($this->get_field_id( 'number' )); ?>">
			<?php _e( 'Number of Tweets to show:' ); ?>
		</label>
		<input class="tiny-text" id="<?php echo esc_attr($this->get_field_id( 'number' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'number' )); ?>" type="number" step="1" min="1" value="<?php echo absint( $number ); ?>" size="3" />
	</p>

	<?php
}
}

function twitter_register_tweets_widgets() {

	register_widget( 'BHT_Widget_Recent_Tweets' );
}

add_action( 'widgets_init', 'twitter_register_tweets_widgets' );
