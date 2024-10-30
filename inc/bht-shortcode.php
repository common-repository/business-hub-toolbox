<?php 

//====================================
// For Recent Event Design
//====================================

add_shortcode( 'rwsec-display-recent-event', 'bht_recent_event_listing' );

function bht_recent_event_listing( $atts ) {
    ob_start(); ?>
     <?php 
     extract(shortcode_atts(
                    array(
                        'posts' => 3,
                    ), 
                    $atts
                )
            );
     $today = date("Y-m-d");
     $loop =  new WP_Query( array(  'post_type'       =>'bht-event', 
                                    'post_status'     =>'publish', 
                                    'posts_per_page'  => $posts ,
                                    'meta_key'        => 'date_timepicker_start',
                                    'orderby'         => 'meta_value', 
                                    'order'           => 'ASC',
                                    'meta_query' => array(
                                        array(
                                            'key'   => 'date_timepicker_start',
                                            'value' => $today,
                                           'compare'=> '>=',
                                           'type'   =>'DATE'
                                            )
                                        )
                                ) 
                            ); ?>
    <div class="news-event-wrapper">
        <div class="event-page-container">
            <div class="event-page-row">


            <header class="entry-header">
                <h2 class="widget-title">
                     <?php _e( 'Upcoming Events', 'business-hub-toolbox' ); ?><span class="view-more">
                        <a href="<?php echo get_post_type_archive_link( 'bht-event' ); ?>">
                            <?php _e( 'View All Events', 'business-hub-toolbox' ); ?>
                        </a>
                    </span>
                </h2>
            </header>

            
               
                <?php if ( $loop->have_posts() ) : while ( $loop->have_posts() ) : $loop->the_post();
                         $start_date_recent = get_post_meta( get_the_ID() , 'date_timepicker_start', true );
                         $recent_event_date = explode(" ", $start_date_recent);
                         $organizer_name    = get_post_meta( get_the_ID() , 'name', true ); 
                         $recent_hour       = get_post_meta( get_the_ID() , 'start_hour', true ); ?>
                        
                        <div class="event-col-4">
                            <div class="event-detail">
                                <div class="main-content">
                                    <h4><a href="<?php the_permalink(); ?>"><?php echo the_title();?></a></h4>
                                    <?php echo date( 'M j, Y', strtotime( $recent_event_date[1] ) ); 
                                    if( !empty( $organizer_name ) ) { ?>
                                        <p><a href="<?php the_permalink(); ?>"><?php _e( 'By', 'business-hub-toolbox' ) ?><?php echo esc_html( $organizer_name ); ?></a></p>
                                    <?php } 
                                    if(  '' !== get_post()->post_content ) { ?>
                                        <p><?php echo esc_html( bht_limit_words(get_the_content() , 3) );?></p>
                                    <?php } ?>  
                                    <div class="view-link">
                                        <a href="<?php the_permalink();?>" class="view-link-btn"><?php _e( 'View Details', 'business-hub-toolbox' ); ?></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; 
                        wp_reset_query();
                    endif; ?>
            </div>
        </div>
    </div>

<?php $variable2 = ob_get_clean();
return $variable2;

} 

//====================================
// Display all Events
//====================================

add_shortcode( 'rwsec-display-all-event', 'bht_all_event_listing' );

function bht_all_event_listing( $atts ) {
    ob_start(); ?>
    <div class="news-event-wrapper">
        <div class="event-page-container">
            <div class="event-page-row">
                <div class="event-col-12">
                    <div class="event-btn">
                        <a href="<?php echo get_post_type_archive_link( 'bht-event' ); ?>" class="all-event-btn"><?php _e( 'View all news & events', 'business-hub-toolbox' ) ?></a> 
                    </div>       
                </div>
            </div>    
        </div>
    </div>
<?php 
$all_event = ob_get_clean();
return $all_event;
} 


//====================================
// Upcoming Events
//====================================

add_shortcode( 'rwsec-display-upcoming-events', 'bht_upcoming_event_listing' );

function bht_upcoming_event_listing( $atts ) {
    ob_start(); ?>
     <?php
     extract(shortcode_atts(
                    array(
                        'posts' => 5,
                    ), 
                    $atts
                )
            ); 
     $upcoming_today = date("Y-m-d");
     $upcoming_loop =  new WP_Query( array(  'post_type'       =>'bht-event', 
                                             'post_status'     =>'publish',
                                             'posts_per_page'  => $posts ,
                                             'meta_key'        => 'date_timepicker_start',
                                             'orderby'         => 'meta_value', 
                                             'order'           => 'ASC',
                                             'meta_query' => array(
                                                  array(
                                                    'key'       => 'date_timepicker_start',
                                                    'value'     => $upcoming_today,
                                                    'compare'   => '>=',
                                                    'type'      =>'DATE'
                                                    )
                                                )
                                        )       
                                    ); ?>
    <div class="news-event-wrapper">
        <div class="event-page-container">
            <div class="event-page-row">
                <div class="event-col-12">
                    <div class="events-wrapper">

                    <header class="entry-header">
                        <h2 class="widget-title">
                            <?php _e( 'Upcoming Events', 'business-hub-toolbox' ) ?>
                            <span class="view-more">
                                <a href="<?php echo get_post_type_archive_link( 'bht-event' ); ?>">
                                    <?php _e( 'View All Events', 'business-hub-toolbox' ); ?>
                                </a>
                            </span>
                        </h2>
                        </header>
                        <?php if ( $upcoming_loop->have_posts() ) : while ( $upcoming_loop->have_posts() ) : $upcoming_loop->the_post();
                                $upcoming_start_date = get_post_meta( get_the_ID() , 'date_timepicker_start', true );
                                $date_arr            = explode(" ", $upcoming_start_date);
                                $date                = $date_arr[0];
                                $upcoming_end_date   = get_post_meta( get_the_ID() , 'date_timepicker_end', true );
                                $upcoming_start_time = explode(" ", $upcoming_start_date);
                                $upcoming_end_time   = explode(" ", $upcoming_end_date);
                                $organizer_name      = get_post_meta( get_the_ID() , 'name', true ); 
                                $start_hour          = get_post_meta( get_the_ID() , 'start_hour', true );
                                $end_hour            = get_post_meta( get_the_ID() , 'end_hour', true );?>
                                <div class="events">
                                    <dl class="event-list">
                                        <dt><span class="date"><?php echo date( 'd M', strtotime( $date ) );?></span></dt>
                                        <dd>
                                            <h5><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
                                            <span class="time">
                                                <?php echo date( 'g:i ', strtotime( $upcoming_start_time[1] ) ); ?>
                                                <?php echo $start_hour; ?>
                                                <?php _e( 'to', 'business-hub-toolbox' ); ?> 
                                                <?php echo date( 'g:i ', strtotime( $upcoming_end_time[1] ) ); ?> 
                                                <?php echo esc_html($end_hour); ?>
                                            </span>
                                            <a class="link" href="#"><i class="fa fa-calendar"></i></a>
                                        </dd>
                                    </dl>
                                </div>
                        <?php endwhile; 
                        wp_reset_query();
                        endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $variable2 = ob_get_clean();
return $variable2;
} 
