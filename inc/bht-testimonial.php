<?php
if ( ! function_exists('bht_testimonials') ) {

// Custom Post Type - Testimonial 
function bht_testimonials() {

    $labels = array(
        'name'                => _x('Testimonials', 'Post Type General Name', 'business-hub-toolbox'),
        'singular_name'       => _x('Testimonial', 'Post Type Singular Name', 'business-hub-toolbox'),
        'add_new'               => __('Add Testimonial', 'business-hub-toolbox'),
        'add_new_item'          => __('Add New', 'business-hub-toolbox'),
        'edit_item'             => __('Edit Testimonial', 'business-hub-toolbox'),
        'new_item'              => __('New Testimonial', 'business-hub-toolbox'),
        'view_item'             => __('View Testimonial', 'business-hub-toolbox'),
        'search_items'          => __('Search Testimonials', 'business-hub-toolbox'),
        'not_found'             => __('No Testimonial found', 'business-hub-toolbox'),
        'not_found_in_trash'    => __('No Testimonial found in Trash', 'business-hub-toolbox'),
        'parent_item_colon'     => '',
        'menu_name'             => __('Testimonials', 'business-hub-toolbox')
    );
    $args = array(
        'label'                 => __( 'testimonials', 'business-hub-toolbox' ),
        'description'           => __( 'Post type to manage testimonials', 'business-hub-toolbox' ),
        'labels'                => $labels,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'show_in_nav_menus'     => true,
        'show_in_admin_bar'     => true,
        'menu_icon'             => 'dashicons-id',
        'capability_type'       => 'post',
        'hierarchical'          => true,        
        'supports'              => array( 'title', 'thumbnail', 'editor' ),
        'menu_position'         => 25425,       
        'taxonomies'            => array('testimonials-category')
    );

    register_post_type('bht_testimonials', $args);     
    }
}

add_action('init', 'bht_testimonials');

//Create Meta box
function bht_testimonials_metabox() {
    add_meta_box( 'bht_testimonials_meta_box', 'Testimonials Details', 'bht_testimonials_meta_box', 'bht_testimonials', 'normal', 'high' );
}
add_action('add_meta_boxes','bht_testimonials_metabox');

// Meta box
function bht_testimonials_meta_box( ) {
    global $post;

    $values     = get_post_meta( $post->ID );

    $designation   = isset( $values['designation_value'] ) ? esc_html( $values['designation_value'][0] ) : '';

    $facebook   = isset( $values['facebook_value'] ) ? esc_url( $values['facebook_value'][0] ) : '';

    $twitter    = isset( $values['twitter_value'] ) ? esc_url( $values['twitter_value'][0] ) : '';

    $linkedin      = isset( $values['linkedin_value'] ) ? esc_attr( $values['linkedin_value'][0] ) : '';

    $googleplus   = isset( $values['googleplus_value'] ) ? esc_attr( $values['googleplus_value'][0] ) : '';

    $instagram  = isset( $values['instagram_value'] ) ? esc_attr( $values['instagram_value'][0] ) : '';

    $youtube  = isset( $values['youtube_value'] ) ? esc_attr( $values['youtube_value'][0] ) : '';

    wp_nonce_field( 'bht_meta_box_nonce', 'meta_box_nonce' );

    ?>

    <table class="form-table">
        <tr>
            <td> <?php esc_html_e( 'Designation', 'business-hub-toolbox' ); ?> </td>
            <td><input type="text" class="widefat" name="designation_value" value="<?php echo esc_attr($designation); ?>" /></td>
        </tr>
       
        <th> <?php esc_html_e( 'SOCIAL MEDIA DETAILS', 'business-hub-toolbox' ); ?> </th>

        <tr>
            <td> <?php esc_html_e( 'Facebook', 'business-hub-toolbox' ); ?> </td>
            <td><input type="text" class="widefat" name="facebook_value" value="<?php echo esc_url($facebook); ?>" /></td>
        </tr>

        <tr>
            <td> <?php esc_html_e( 'Twitter', 'business-hub-toolbox' ); ?> </td>
            <td><input type="text" class="widefat" name="twitter_value" value="<?php echo esc_url($twitter); ?>" /></td>
        </tr>

        <tr>
            <td> <?php esc_html_e( 'Linkedin', 'business-hub-toolbox' ); ?> </td>
            <td><input type="text" class="widefat" name="linkedin_value" value="<?php echo esc_url($linkedin); ?>" /></td>
        </tr>

        <tr>
            <td> <?php esc_html_e( 'Google Plus', 'business-hub-toolbox' ); ?> </td>
            <td><input type="text" class="widefat" name="googleplus_value" value="<?php echo esc_url($googleplus); ?>" /></td>
        </tr>

        <tr>
            <td> <?php esc_html_e( 'Instagram', 'business-hub-toolbox' ); ?> </td>
            <td><input type="text" class="widefat" name="instagram_value" value="<?php echo esc_url($instagram); ?>" /></td>
        </tr>

        <tr>
            <td> <?php esc_html_e( 'Youtube', 'business-hub-toolbox' ); ?> </td>
            <td><input type="text" class="widefat" name="youtube_value" value="<?php echo esc_url($youtube); ?>" /></td>
        </tr>
       
    </table>
    <?php
}

add_action( 'save_post', 'bht_testimonials_save' );

// Save post
function bht_testimonials_save( $post_id )
{
    global $post;  

    $custom_meta_fields = array( 'designation_value', 'facebook_value', 'twitter_value', 'linkedin_value', 'googleplus_value', 'instagram_value', 'youtube_value');

    // Bail if we're doing an auto save
    if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
    
    // if our nonce isn't there, or we can't verify it, bail
    if( !isset( $_POST['meta_box_nonce'] ) || !wp_verify_nonce( $_POST['meta_box_nonce'], 'bht_meta_box_nonce' ) ) return;
    
    // if our current user can't edit this post, bail

    if ( ! current_user_can( 'edit_post', $post_id ) ){
        return;
    }
    
    // now we can actually save the data
    $allowed = array( 
        'em'        => array(),
        'strong'    => array(),
        'span'      => array(),
    );    
 
    foreach( $custom_meta_fields as $custom_meta_field ){

        if( isset( $_POST[$custom_meta_field] ) )           

            update_post_meta($post->ID, $custom_meta_field, wp_kses( $_POST[$custom_meta_field], $allowed) );      
    } 
}
