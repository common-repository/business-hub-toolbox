<?php get_header(); ?>
<section id="blog" class=" news-event-wrapper ">
    <div class="event-page-container">
        <div class="event-page-row">
            <div class="event-col-12">

            <div id="container">
            <div id="parentHorizontalTab">
                <ul class="resp-tabs-list hor_1">
                    <li><?php _e( 'Past Events', 'business-hub-toolbox' ); ?></li>
                    <li><?php _e( 'Today Events', 'business-hub-toolbox' ); ?></li>
                    <li><?php _e( 'Upcoming Events', 'business-hub-toolbox' ); ?></li>
                </ul>
                <div class="resp-tabs-container hor_1">
                    <div id="tab-item-1" class="tab-content">
                           <div class="event-fun-wrapper">
                                <?php bht_view_all_events( true, false, false ); ?>
                            </div>
                            <div class="event-tab-btn">
                                <a href="#" id="loadMore"><?php _e( 'Load More', 'business-hub-toolbox' ); ?></a>
                            </div>
                    </div><!-- .tab-content -->
                    <div id="tab-item-2" class="tab-content">
                        <?php bht_view_all_events( false, true, false ); ?>
                    </div><!-- .tab-content -->
                    <div id="tab-item-3" class="tab-content">
                        <div class="event-fun-wrapper">
                                <?php bht_view_all_events( false, false, true ); ?>
                            </div> 
                            <div class="event-tab-btn">
                                <a href="#" id="loadMore_future"><?php _e( 'Load More', 'business-hub-toolbox' ); ?></a>
                            </div>
                    </div><!-- .tab-content -->
             
                </div>
            </div>
        </div><!-- .container -->

        </div>
        </div>
    </div>
</section>


<?php
/**
* for view all events
* */

function bht_view_all_events( $past = false, $present = false, $future = false ) {
    $events_design = get_option( 'rwsec_add_setting', 'pagination' );
    $today         = date("Y-m-d");
    $paged         = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 0;
    $meta_type     = array( 'key'   => 'date_timepicker_start',
                            'value' => $today,
                            'type'  =>'DATE'
                        );
    $class_name    = '';
    $order_posts    = '';
    if( $past == true ) {
        $class_name           = 'past';
        $meta_type['compare'] = '<';
        $order_posts          = 'DESC';
    }
    elseif( $future == true ) {
        $class_name           = 'future';
        $meta_type['compare'] = '>';
        $order_posts          = 'ASC';
    }
    elseif( $present == true ) {
        $meta_type['compare'] = '=';
        $order_posts          = 'ASC';
    }

    $events_posts_past = new WP_Query( array(  
        'post_type'       =>'bht-event', 
        'post_status'     =>'publish', 
        'meta_key'        => 'date_timepicker_start',
        'orderby'         => 'meta_value', 
        'posts_per_page'  => -1 ,
        'order'           => $order_posts,
        'paged'           => $paged,
        'meta_query'      => array(
                               $meta_type
                                )
                            ) 
                        );
    if( $events_posts_past->have_posts() ) : 
        $count = 0; 
        while( $events_posts_past->have_posts() ) : 
            $events_posts_past->the_post();
            $count++;
            $start_date = get_post_meta( get_the_ID() , 'date_timepicker_start', true );
            $date_arr   = explode(" ", $start_date);
            $date       = $date_arr[0];
            if( $events_design == 'pagination' ) { ?>
                <div class="list-gap <?php echo esc_attr($class_name); ?>">
                    <div class="event-col-2">
                        <?php if( has_post_thumbnail() ) {
                                $event_thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id( ), 'event-thumbnail'); ?>
                                <img src="<?php echo esc_url( $event_thumbnail['0'] );?>" width="100%" alt="all event image">
                      <?php }
                        else { ?> 
                            <img src="<?php echo ECP_IMAGE_DIR .'/dummy-image.jpg' ; ?>" width="100%" alt="all event image">
                        <?php } ?>
                    </div>
                    <div class="event-col-10">
                        <div class="all-event-list">
                            <p><span>
                                <?php echo date( 'F j Y', strtotime( $date ) );?>
                            </span></p>
                            <h3>
                                <a href="<?php the_permalink();?>"><?php the_title(); ?></a>
                            </h3>
                            <p>
                                <?php echo esc_html( bht_limit_words( get_the_content(),5 ) ); ?>
                            </p>
                        </div>
                    </div>
                </div>
                <?php if  ($count % 4 == 0) { ?>
                        </div>
                        <div class="event-fun-wrapper">
                <?php }
            }
        elseif ( $events_design == 'normal' ) { ?>
            <div class="event-col-3 <?php echo esc_attr($class_name); ?>">
                <div class="list-event">
                    <div class="list-event-img">
                        <?php if(has_post_thumbnail()){
                                $event_thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id( ), 'event-thumbnail');?> 
                                <img src="<?php echo esc_url( $event_thumbnail['0'] );?>" width="100%" alt="all event image">
                        <?php } 
                        else { ?> 
                            <img src="<?php echo ECP_IMAGE_DIR .'/dummy-image.jpg'; ?>" width="100%" alt="all event image">
                        <?php } ?>
                    </div>
                    <div class="list-event-detail">
                        <div class="list-event-btn"> 
                            <a href="<?php the_permalink();?>" class="style-2-btn">
                                <?php _e( 'View Event', 'business-hub-toolbox' ); ?>
                            </a> 
                        </div>
                        <span>
                            <?php echo date( 'F j Y', strtotime( $date ) );?>
                        </span>
                        <h3><?php the_title(); ?></h3>
                    </div>
                </div>
            </div>
            <?php if  ($count % 4 == 0) { ?>
                    </div>
                    <div class="event-fun-wrapper">
            <?php }
            }
        else { ?>
            <div class="event-col-3 <?php echo esc_attr($class_name); ?>">
                <div class="design-3">
                    <div class="box-event">
                        <div class="circle-event">
                            <?php if( has_post_thumbnail() ) {
                                    $event_thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id( ), 'event-thumbnail');?> 
                                    <img src="<?php echo esc_url( $event_thumbnail['0'] );?>" width="100%" alt="all event image">
                                <?php } 
                                else { ?> 
                                    <img src="<?php echo ECP_IMAGE_DIR .'/dummy-image.jpg'; ?>" width="100%" alt="all event image">
                                <?php } ?>
                        </div>
                        <!-- .circle-event -->
                        <div class="circle-event-detail">
                            <span><?php echo date( 'F j Y', strtotime( $date ) );?></span>
                            <h3><?php the_title(); ?></h3>
                        </div>
                        <!-- .circle-event-detail -->
                        <div class="circle-event-btn">
                            <a href="<?php the_permalink();?>" class="style-3-btn">
                                <?php _e( 'View Event', 'business-hub-toolbox' ); ?>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <?php if  ($count % 4 == 0) { ?>
                </div>
                <div class="event-fun-wrapper">
            <?php }
            }
    endwhile;
    wp_reset_query();
    else : ?>
        <p><?php _e( 'There is no Events', 'business-hub-toolbox' ); ?></p>
    <?php endif; 
}

get_footer(); ?>