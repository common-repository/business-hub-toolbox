<?php
class RWSEC_Widget extends WP_Widget {
	/**
     * Register widget with WordPress.
     */
    function __construct() {
        parent::__construct(
            'rwsec_widget', // Base ID
            __('Rigorous Event Calendar', 'business-hub-toolbox'), // Name
            array('description' => __('Rigorous Event Calendar Widget', 'business-hub-toolbox')) // Args
        );
    }

    /**
     * Front-end display of widget.
     */
    public function widget($args, $instance) {
    	echo $args['before_widget'];
        ?>
        <div class="rws-side-bar">
            <?php 
                if( !empty($instance['events']) && $instance['events']=='recent' && $instance['limit'] > 0 )
                {
                    echo do_shortcode('[rwsec-display-recent-event posts="'.$instance['limit'].'"]');
                }
                if(!empty($instance['events']) && $instance['events']=='upcoming' && $instance['limit'] > 0)
                {
                    echo do_shortcode('[rwsec-display-upcoming-events posts="'.$instance['limit'].'"]');
                }
            ?>
        </div>
    	<?php echo $args['after_widget'];
    }

    /**
     * Back-end widget form.
     */
    public function form($instance) {
        $events = !empty( $instance['events'] ) ? $instance['events'] : 'recent';
        $limit = !empty( $instance['limit'] ) ? $instance['limit'] : 0;
        ?>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id('title') ); ?>"><?php _e('Events:', 'business-hub-toolbox'); ?></label> 
            <select class="widefat ec-dropdown" id="<?php echo esc_attr( $this->get_field_id('events') ); ?>" name="<?php echo esc_attr( $this->get_field_name('events') ); ?>" >
			    <option <?php selected( $events, 'recent'); ?> value="recent"><?php _e('Design 1', 'business-hub-toolbox'); ?></option> 
			    <option <?php selected( $events, 'upcoming'); ?> value="upcoming"><?php _e('Design 2', 'business-hub-toolbox'); ?></option> 
            </select>
        </p>

        <div class="ec_post_number">
            <label for="<?php echo esc_attr( $this->get_field_id( 'limit' ) ); ?>"><?php _e( 'Show:', 'business-hub-toolbox' ); ?></label>
            <select id="<?php echo esc_attr( $this->get_field_id( 'limit' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'limit' ) ); ?>" class="widefat">
                <?php for ( $i = 1; $i <= 10; $i ++ ) { ?>
                    <option <?php if ( $i == $limit ) {
                        echo 'selected="selected"';
                    } ?> > <?php echo $i; ?> </option>
                <?php }  ?>
            </select>
        </div>
<?php 
    }

    /**
     * Sanitize widget form values as they are saved.
     */
    public function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['events'] = (!empty($new_instance['events']) ) ? strip_tags($new_instance['events']) : '';
        $instance['limit'] = (!empty($new_instance['limit']) ) ? strip_tags($new_instance['limit']) : '';
        return $instance;
    }

}