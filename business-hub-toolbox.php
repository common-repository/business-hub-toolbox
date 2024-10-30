<?php
/**
 * Plugin Name: Business Hub Toolbox
 * Plugin URI:  https://rigorousthemes.com/wordpress-plugins/
 * Description: A plugin to display instagram feeds, twitter feeds, testimonial custom post types
 * Version:     1.0.4
 * Author:      Rigorous Themes
 * Author URI:  http://rigorousthemes.com
 * Text Domain: business-hub-toolbox
 * License:     GPL2
 */

// If this file is called directly, abort.
// tested on wordpress version 5.7
if ( ! defined( 'WPINC' ) ) {
    die;
}

/**
 * Define Constants
 */
if (!defined('BHP_DIR')) {
	define( 'BHP_DIR', trailingslashit( plugin_dir_path( __FILE__ ) ) );
}

if (!defined('BHP_URI')) {
	define( 'BHP_URI', trailingslashit( plugin_dir_url( __FILE__ ) ) );
}

if (!defined('ECA_IMAGE_DIR')) {
    define('ECA_IMAGE_DIR', plugin_dir_url(__FILE__) . 'assets/admin/images');
}
if (!defined('ECA_JS_DIR')) {
    define('ECA_JS_DIR', plugin_dir_url(__FILE__) . 'assets/admin/js');
}
if (!defined('ECA_CSS_DIR')) {
    define('ECA_CSS_DIR', plugin_dir_url(__FILE__) . 'assets/admin/css');
}
if (!defined('ECP_IMAGE_DIR')) {
    define('ECP_IMAGE_DIR', plugin_dir_url(__FILE__) . 'assets/public/images');
}
if (!defined('ECP_JS_DIR')) {
    define('ECP_JS_DIR', plugin_dir_url(__FILE__) . 'assets/public/js');
}
if (!defined('ECP_CSS_DIR')) {
    define('ECP_CSS_DIR', plugin_dir_url(__FILE__) . 'assets/public/css');
}

// Load instagram feeds.
require_once( BHP_DIR . 'inc/bht-insta-feeds.php' );

// Load twitter feeds.
require_once( BHP_DIR . 'inc/bht-twitter-feeds.php' );

// Load testimonial custom post type.
require_once( BHP_DIR . 'inc/bht-testimonial.php' );

/**
 * Register of widgets of event calendar
 * */
include_once('inc/bht-widget.php');
require_once( BHP_DIR . 'inc/bht-shortcode.php' );
require_once( BHP_DIR . 'inc/bht-event-function.php' );

/**
* For speakers
*/
require_once( BHP_DIR . 'speakers/event-metabox.php' );
require_once( BHP_DIR . 'speakers/repeatable-speaker.php' );

/**
* For pricing table
*/
require_once( BHP_DIR . 'inc/bht-price-table.php' );



if(!class_exists('BHT_Class'))
{
    class BHT_Class
    {
	    var $rwsec_settings;
	     /**
	     * Initializes the plugin functions 
	     */
	    function __construct() {
	    	add_action( 'admin_init', array( $this, 'bht_register_setting' ) );
	    	add_action( 'admin_menu', array( $this, 'bht_add_menu' ) ); //adds plugin menu in wp-admin
	    	add_action( 'admin_enqueue_scripts', array( $this, 'bht_register_admin_assets' ) ); //registers admin assests such as js and css
	    	add_action( 'wp_enqueue_scripts', array( $this, 'bht_register_frontend_assets' ), 999 ); //registers js and css for frontend
	    	add_action( 'init', array( $this,'bht_register_post_type' ) ); //register custom post type
	    	add_action( 'add_meta_boxes', array( $this,'bht_add_event_details' )); //add metabox
	    	add_action( 'save_post',  array( $this,'bht_meta_event_save'), 10 );
	    	add_filter( 'manage_bht-event_posts_columns', array( $this,'bht_event_new_columns' ) );
	    	add_action( 'manage_bht-event_posts_custom_column',  array( $this,'bht_event_custom_new_columns' ) );
	    	add_filter( 'mce_buttons', array( $this,'bht_register_tinymce_button' ) );
	        add_filter( 'mce_external_plugins', array( $this,'bht_add_tinymce_button' ) );
	        add_filter( 'single_template', array( $this,'bht_custom_template' ) );
			add_filter( 'archive_template', array( $this,'bht_custom_template' ) );
			add_action('widgets_init', array($this, 'bht_register_widget')); //registers the widget
	    	add_theme_support( 'post-thumbnails' );
	    	add_image_size( 'event-logo', 150, 150, false );
			add_image_size( 'event-thumbnail', 300, 250, true);
			add_image_size( 'event-speaker', 300, 250, true );
			/**
	         * Pricing table
	         */
			add_action( 'init', array( $this,'bht_register_post_type' ) ); //register custom post type
			add_action( 'add_meta_boxes', array( $this,'bht_register_shortcode' )); //register metabox
			add_action( 'add_meta_boxes', array( $this,'bht_register_meta_details' )); //register metabox
			add_action( 'add_meta_boxes', array( $this,'bht_register_meta_boxes' )); //register metabox
			add_action( 'save_post', array( $this,'bht_save_fields' ) ); //save meta post
			add_action( 'save_post', array( $this,'bht_save_fields_details' ) ); //save meta post
			add_filter( 'manage_rws-pricing-table_posts_columns', array( $this,'bht_new_columns' ) );
			add_action( 'manage_rws-pricing-table_posts_custom_column',  array( $this,'bht_custom_new_columns' ) );
    	}

    	/**
         * Registering of backend js and css
         */
    	function bht_register_admin_assets() {
    		// css
    		wp_enqueue_style( 'bht-admin-datetime', ECA_CSS_DIR . '/jquery.datetimepicker.css', array() );
    		wp_enqueue_style( 'bht-admin-repeater-css', ECA_CSS_DIR . '/bht-repeater.css', array() );

    		// js
            wp_enqueue_script( 'bht-admin-timepicker', ECA_JS_DIR . '/jquery.datetimepicker.full.min.js', array() );
            wp_enqueue_script( 'bht-admin-custom', ECA_JS_DIR . '/bht-event-custom-jquery.js', array() );
            wp_enqueue_media();
            wp_enqueue_script( 'bht-admin-logo', ECA_JS_DIR . '/bht-widget-customizer.js', array() );
            wp_enqueue_script( 'bht-admin-repeater-js', ECA_JS_DIR . '/bht-repeater.js', array() );
			wp_enqueue_script( 'bht-admin-shortcode-button-js', ECA_JS_DIR . '/bht-shortcode-button.js', array() );
    	}

    	/**
         * Registers Frontend js and css
         * */
    	function bht_register_frontend_assets() {
    		// css
    		wp_enqueue_style( 'bht-public-google-fonts', 'https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700' );
    		wp_enqueue_style('bht-public-font-awesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
    		wp_enqueue_style( 'bht-public-date', ECP_CSS_DIR.'/bht-event-style-personal.css', false );
    		wp_enqueue_style( 'bht-public-style', ECP_CSS_DIR.'/bht-event_style.css', false );
    		wp_enqueue_style( 'bht-public-style-price', ECP_CSS_DIR.'/bht-style.css', false);
         
    		// js
    		wp_enqueue_script( 'bht-public-calendar', ECP_JS_DIR . '/bht-simplecalendar.js', array('jquery') );
    		wp_enqueue_script( 'bht-public-customs', ECP_JS_DIR . '/easyResponsiveTabs.js', array('jquery') );
            wp_enqueue_script( 'bht-public-custom', ECP_JS_DIR . '/bht-event-custom.js', '' );
            
    	}

    	/**
		* Admin notice
		 */
		function bht_admin_notice() {
		    $theme  = wp_get_theme();
		    $parent = wp_get_theme()->parent();
		    if ( ($theme != 'business-hub-pro' ) ) {
		        echo '<div class="error">';
		        echo    '<p>' . __('Please note that the <strong>Business Hub Toolbox</strong> plugin is meant to be used with the Business Hub Pro theme</p>', 'business-hub-toolbox');
		        echo '</div>';          
		    }
		}

        /**
         * Plugin Admin Menu
         */
        function bht_add_menu() {
            add_submenu_page( 'edit.php?post_type=bht-event', __('Settings', 'business-hub-toolbox'), __('Settings', 'business-hub-toolbox'), 'manage_options', 'rwsec-setting', array($this, 'bht_settings') );
        }

        /**
         * Plugin Main Settings Page
         */
        function bht_settings() {
        	include('inc/bht-save-settings.php');
        }

        function bht_register_setting() {
			add_settings_section( 'rwsec_add_setting', __( 'Events Display Layout', 'business-hub-toolbox' ), array( $this, 'bht_setting_cb' ), 'business-hub-toolbox' );
			register_setting( 'business-hub-toolbox', 'rwsec_add_setting', array( $this, 'bht_sanitize_position' ) );
		}

		function bht_setting_cb() {
			echo '<p>' . __( 'Select layout for displaying all events.', 'business-hub-toolbox' ) . '</p>'; 
			$position = get_option( 'rwsec_add_setting', 'pagination' );
			include('inc/bht-settings.php');
		}

		function bht_sanitize_position( $position ) {
			if ( in_array( $position, array( 'pagination', 'normal', 'round' ), true ) ) {
	        	return $position;
	    	}
		}

        /**
         * Event Meta Box
         * */
        function bht_add_event_details() {
        	add_meta_box(
				'rwsec_event_calender_meta',
				 __( 'Event Details', 'business-hub-toolbox' ),
				array($this,'bht_add_event_details_callback'),
				'bht-event',
				'advanced',
				'high'
			);
        }

        function bht_add_event_details_callback( $post ) {
        	wp_nonce_field( basename( __FILE__ ), 'bht_event_calender_nonce' );
            $rwsec_stored_meta_option = get_post_meta( $post->ID );
            include('inc/bht-event-meta.php');
        }

        function bht_meta_event_save( $post_id ) {
        	global $post;
		    $is_autosavetag = wp_is_post_autosave( $post_id );
		    $is_revisiontag = wp_is_post_revision( $post_id );
		    $is_valid_noncetag = ( isset( $_POST[ 'bht_event_calender_nonce' ] ) && wp_verify_nonce( $_POST[ 'bht_event_calender_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';
		   
		    if ( $is_autosavetag || $is_revisiontag || !$is_valid_noncetag ) {
		        return;
		    }
			if ( isset( $_POST[ 'date_timepicker_start' ] ) ) {
		    	update_post_meta( $post_id, 'date_timepicker_start',  sanitize_text_field( $_POST[ 'date_timepicker_start' ]  ) );
		    }
		    if ( isset( $_POST[ 'date_timepicker_end' ] ) ) {
		    	update_post_meta( $post_id, 'date_timepicker_end', sanitize_text_field( $_POST[ 'date_timepicker_end' ]  ) );
		    }
		    if ( isset( $_POST[ 'address' ] ) ) {
		    	update_post_meta( $post_id, 'address', sanitize_text_field( $_POST[ 'address' ]  ) );
		    }
		    if ( isset( $_POST[ 'name' ] ) ) {
		    	update_post_meta( $post_id, 'name', sanitize_text_field( $_POST[ 'name' ]  ) );
		    }
		    if ( isset( $_POST[ 'phone' ] ) ) {
		    	update_post_meta( $post_id, 'phone', sanitize_text_field( $_POST[ 'phone' ]  ) );
		    }
		     if ( isset( $_POST[ 'email' ] ) ) {
		        update_post_meta( $post_id, 'email', sanitize_email( $_POST[ 'email' ]  ) );
		    }
		     if( isset( $_POST[ 'start_hour' ] ) ) {
		        update_post_meta( $post_id, 'start_hour',  sanitize_text_field( $_POST[ 'start_hour' ] ) );
		    }
		    if( isset( $_POST[ 'end_hour' ] ) ) {
		        update_post_meta( $post_id, 'end_hour',   sanitize_text_field( $_POST[ 'end_hour' ] ) );
		    }
		    if( isset($_POST['speaker_id']) ) {
		      $speak = implode(',', (int) $_POST['speaker_id']);
		      update_post_meta($post_id, 'speaker_id', $speak);
		    }
		    if( isset( $_POST[ 'desc_title' ] ) ) {
		        update_post_meta( $post_id, 'desc_title', sanitize_text_field( $_POST[ 'desc_title' ] ) );
		    }
		    if( isset( $_POST[ 'speaker_title' ] ) ) {
		        update_post_meta( $post_id, 'speaker_title', sanitize_text_field( $_POST[ 'speaker_title' ] ) );
		    }
		    if( isset( $_POST[ 'event_logo' ] ) ) {
		        update_post_meta( $post_id, 'event_logo', sanitize_text_field( $_POST[ 'event_logo' ] ) );
		    }
        }

        /**
         * Title Shown in Column for CPT Events
         * */
        function bht_event_new_columns( $columns ) {
        	$columns  = array(
		        "cb"                => "<input type=\"checkbox\" />",
		        "title"             => __( "Event", 'business-hub-toolbox' ),
		        "events_date"       => __( "Event Date", 'business-hub-toolbox' ),
		        "events_address"    => __( "Address", 'business-hub-toolbox' ) , 
		   
		      );
  			return $columns;
        }

        function bht_event_custom_new_columns( $column ) {
        	global $post;
		    $custom = get_post_custom();
		    switch ($column){
			    case "events_date":
			    echo $custom["date_timepicker_start"][0] . ' - ' .
			    $custom["date_timepicker_end"][0] . '</em>';
			    break;
			    case "events_address":
			    echo $custom["address"][0];
			    break; 
    		}
        }

        /**
         * RigorousWeb Event Calendar tinymce button
         */

        function bht_register_tinymce_button( $buttons ) {
		    array_push( $buttons, "button_eek" );
		    return $buttons;
		}

		function bht_add_tinymce_button( $plugin_array ) {
		    $plugin_array['my_button_script'] = ECA_JS_DIR . '/bht-eventshortcode.js' ;
		    return $plugin_array;
		}

		/**
         * RigorousWeb Event Calendar Widget
         */
		function bht_register_widget() {
			register_widget('RWSEC_Widget');
		}

		/**
         * for Single and Archive page
         * */
		function bht_custom_template( $single ) {
		    global $wp_query, $post;
		    if (  $post->post_type == 'bht-event' ) {
		        if( is_single() ){
		           if( file_exists( BHP_DIR . 'inc/single-event.php' ) )
		            return BHP_DIR . 'inc/single-event.php'; 
		        }
		        if( is_archive() ){
		            if( file_exists( BHP_DIR . 'inc/archive-events.php' ) )
		            return BHP_DIR . 'inc/archive-events.php';
		        }
		    }
		    return $single;
		}

		/**
		* Pricing Table Custom Post Type 
		* */

		public function bht_register_post_type() {
			include('inc/bht-register-post.php');
            register_post_type( 'bht-event', $args );
			$labels = array(
				'name' 			=> __( 'Pricing Table', 'business-hub-toolbox' ),
				'singular_name' => __( 'Pricing Table', 'business-hub-toolbox' ),
				'add_new' 		=> __( 'Add Pricing Table', 'business-hub-toolbox' ),
				'all_items' 	=> __( 'All Pricing Tables', 'business-hub-toolbox' ),
				'add_new_item' 	=> __( 'Add Pricing Table', 'business-hub-toolbox' ),
				'edit_item' 	=> __( 'Edit Pricing Table', 'business-hub-toolbox' ),
				'view_item' 	=> __( 'View Pricing Table', 'business-hub-toolbox' )
				);

			$args = array(
				'labels' 				=> $labels,
				'description'        	=> __( 'Description.', 'business-hub-toolbox' ),
				'public' 				=> true,
				'has_archive' 			=> true,
				'publicly_queryable' 	=> true,
				'query_var' 			=> true,
				'capability_type' 		=> 'post',
				'hierarchical' 			=> true,
				'rewrite' 				=> true,
				'menu_icon' 			=> 'dashicons-editor-table',
				'supports' 				=> 'title'
				);
			register_post_type( 'rws-pricing-table', $args );
		}

		/**
		* Pricing Table Meta Box 
		* */
		function bht_register_meta_details() {
			add_meta_box( 
				'rwspt_meta_id_details', 
				__( 'Details', 'business-hub-toolbox' ), 
				array($this,'bht_add_price_details_callback_meta'),
				'rws-pricing-table',
				'advanced',
				'default'
				);
		}

		function bht_add_price_details_callback_meta( $post ) {
			wp_nonce_field( basename( __FILE__ ), 'rwspt_pricing_details_nonce' );
	        $rwspt_stored_meta_details = get_post_meta( $post->ID ); ?>
	        <h4><?php _e( 'Details', 'business-hub-toolbox' ); ?></h4>
			<input id="rwspt_details" name= "rwspt_details" type="textarea" size="35" value="<?php if ( ! empty ( $rwspt_stored_meta_details['rwspt_details'] ) ) {
						echo  esc_attr( $rwspt_stored_meta_details['rwspt_details'][0] ) ;
					} ?>">
	<?php	}

		function bht_save_fields_details( $post_id ) {
			global $post;
		    $is_autosavetag = wp_is_post_autosave( $post_id );
		    $is_revisiontag = wp_is_post_revision( $post_id );
		    $is_valid_noncetag = ( isset( $_POST[ 'rwspt_pricing_details_nonce' ] ) && wp_verify_nonce( $_POST[ 'rwspt_pricing_details_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';
		   
		    if ( $is_autosavetag || $is_revisiontag || !$is_valid_noncetag ) {
		        return;
		    }
			if ( isset( $_POST[ 'rwspt_details' ] ) ) {
		    	update_post_meta( $post_id, 'rwspt_details',  sanitize_text_field( $_POST[ 'rwspt_details' ]  ) );
		    }

		}

		function bht_register_shortcode() {
			add_meta_box( 
				'rwspt_shortcode_id', 
				__('Shortcode', 'business-hub-toolbox') , 
				array($this,'bht_add_shortcode_callback'),
				'rws-pricing-table',
				'advanced',
				'default'
				);
		}

		function bht_add_shortcode_callback( $post ) {
			if( '' !== get_post()->post_title){ ?>
			<i><?php _e('Copy this shortcode and paste it into your Pricing plan option in customizer:', 'business-hub-toolbox'); ?></i>
				<?php echo '<input type="text" onfocus="this.select();" style="font-size:12px;" readonly value="[rwspt-pricing-table id=' . $post->ID . ']" size="30">' ;
			}
			else { ?>
				<i>
					<?php _e('Sorry! No Shortcode Available. Insert Pricing Plan Details', 'business-hub-toolbox'); ?>
				</i>
			<?php }
		}

		function bht_register_meta_boxes() {
			add_meta_box( 
				'rwspt_meta_id', 
				__( 'Pricing Table', 'business-hub-toolbox' ), 
				array($this,'bht_add_price_details_callback'),
				'rws-pricing-table',
				'advanced',
				'default'
				);
		}

		function bht_add_price_details_callback( $post ) {
			wp_nonce_field( basename( __FILE__ ), 'bht_nonce' );
			$rwspt_stored_meta_option = get_post_meta( $post->ID );

			if( isset($rwspt_stored_meta_option['rwspt_meta_fields']) ){
				$rwspt_meta_data  = json_decode( $rwspt_stored_meta_option['rwspt_meta_fields'][0] );
			}
			include('inc/bht-meta.php');

		}

		function bht_save_fields( $post_id ) {
			global $post;
			$is_autosavetag = wp_is_post_autosave( $post_id );
			$is_revisiontag = wp_is_post_revision( $post_id );
			$is_valid_noncetag = ( isset( $_POST[ 'rwspt_price_table_nonce' ] ) && wp_verify_nonce( $_POST[ 'rwspt_price_table_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';

			if ( $is_autosavetag || $is_revisiontag || !$is_valid_noncetag ) {
				return;
			}

			if ( isset( $_POST[ 'rwspt_meta_fields' ] ) ) {
				$rwspt_encode_data = sanitize_text_field ( json_encode( $_POST[ 'rwspt_meta_fields' ] ) );
				update_post_meta( $post_id, 'rwspt_meta_fields',  $rwspt_encode_data );
			}

		}

		/**
	     * Title Shown in Column for CPT Pricing Table
	     * */
		function bht_new_columns( $bht_columns ) {
			$bht_columns  = array(
				"cb"				=> "<input type=\"checkbox\" />",
				"title"				=> __( "Title", 'business-hub-toolbox' ),
				"rwspt_shortcode"	=> __( "Shortcode", 'business-hub-toolbox' ),
				);
			return $bht_columns;
		}

		function bht_custom_new_columns( $bht_columns ) {
			global $post;
			$bht_custom = get_post_custom();
			echo '<input type="text" onfocus="this.select();" style="font-size:12px;" readonly value="[rwspt-pricing-table id=' . $post->ID . ']" size="30">' ;
		}

    }

    $rwsec_obj = new BHT_Class();
}
