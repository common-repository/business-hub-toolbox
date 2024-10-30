<?php get_header(); ?>
<div class="rws-single-event">
    <?php
    if (has_post_thumbnail()) {
        $event_background_img = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
        ?>
        <div class="rws-single-event-heading" style="background:url(<?php echo esc_url( $event_background_img['0'] ); ?>) no-repeat; background-size: cover;";>

        <?php } else { ?>
            <div class="rws-single-event-heading">
            <?php } ?>

            <div class="event-page-container">
                <div class="event-page-row">
                    <div class="event-col-12">
                        <?php
                        while (have_posts()) {
                            the_post();
                            $speaker_details = get_post_meta(get_the_ID(), 'event_repeatable', true);
                            $start_date = get_post_meta(get_the_ID(), 'date_timepicker_start', true);
                            $end_date = get_post_meta(get_the_ID(), 'date_timepicker_end', true);
                            $address = get_post_meta(get_the_ID(), 'address', true);
                            $name = get_post_meta(get_the_ID(), 'name', true);
                            $phone = get_post_meta(get_the_ID(), 'phone', true);
                            $email = get_post_meta(get_the_ID(), 'email', true);
                            $date_arr = explode(" ", $start_date);
                            $date = $date_arr[0];
                            $time = $date_arr[1];
                            $date_arr2 = explode(" ", $end_date);
                            $end_date = $date_arr2[0];
                            $end_time = $date_arr2[1];
                            $start_hour = get_post_meta(get_the_ID(), 'start_hour', true);
                            $speaker_id = get_post_meta(get_the_ID(), 'speaker_id', true);
                            $rws_speaker = explode(",", $speaker_id);
                            $end_hour = get_post_meta(get_the_ID(), 'end_hour', true);
                            ?>

                            <?php
                            $event_logo = get_post_meta(get_the_ID(), 'event_logo', true);
                            if (!empty($event_logo)) {
                                $logo_id = bht_get_image_id($event_logo);
                                $logo_img = wp_get_attachment_image_src($logo_id, 'event-logo');
                                ?>
                                <div class="event-logo">
                                    <img src="<?php echo esc_url( $logo_img[0] );
                                ; ?>" alt="logo"></div>
    <?php } ?>


                            <div class="event-info-heading">
                                <h1><?php the_title(); ?> </h1>
                                <p>
                                    <span>
                                        <i class="fa fa-calendar" aria-hidden="true"></i> <?php echo date('M j, Y ', strtotime($date)); ?>
                                    
                                        <?php if (!empty($end_date)) { ?>
                                      
                                        - 
        <?php echo date('M j, Y ', strtotime($end_date)); ?>
                                       
                                    <?php } ?> </span> 
                                    <span>
                                        <i class="fa fa-clock-o" aria-hidden="true"></i> <?php echo date('g:i ', strtotime($time)); ?> <?php echo $start_hour; ?> - <?php echo date('g:i ', strtotime($end_time)); ?> <?php echo esc_html( $end_hour ); ?>
                                    </span><br/>
    <?php if (!empty($address)) { ?>
                                        <span>
                                            <i class="fa fa-map-marker" aria-hidden="true"></i> <?php echo esc_html($address); ?>
                                        </span>
                                    <?php } ?>


    <?php if (is_email($email)) { ?>
                                        <span>
                                            <i class="fa fa-envelope" aria-hidden="true"></i> <?php echo esc_html($email); ?>
                                        </span>
    <?php }
    if (!empty($phone)) {
        ?>
                                        <span>
                                            <i class="fa fa-phone" aria-hidden="true"></i> <?php echo esc_html($phone); ?>
                                        </span>
                            <?php } ?>
                                </p>
                            </div>

<?php } wp_reset_postdata(); ?>

                    </div>

                </div>

            </div>

        </div><!-- .rws-single-event-heading -->

        <div class="rws-single-event-detail">
            <div class="event-page-container">
                <div class="event-page-row">
                    <div class="event-col-12 abt-center">
                        <?php $desc_title = get_post_meta(get_the_ID(), 'desc_title', true);
                        if (!empty($desc_title)) {
                            ?>
                            <h3><?php echo esc_html( $desc_title ); ?></h3>
<?php } ?>
                        <p><?php the_content(); ?></p>
                    </div>
                </div><!-- .row -->
            </div>
        </div><!-- .rws-single-event-detail -->

                    <?php $speaker_details = get_post_meta(get_the_ID(), 'event_repeatable', true);
                    if (!empty($speaker_details[0]['speaker_name'])) {
                        ?>
            <div class="speaker">
                <div class="event-page-container">
                    <div class="event-page-row">
    <?php $speaker_title = get_post_meta(get_the_ID(), 'speaker_title', true);
    if (!empty($speaker_title)) {
        ?>
                            <h3><?php echo esc_html( $speaker_title ); ?></h3>
                                    <?php }
                                    foreach ($speaker_details as $event_speaker) :
                                        ?>
                            <div class="event-col-3">
                                <div class="speaker-image">
                                    <div class="speaker-user">
        <?php if (!empty($event_speaker['speaker_image'])) {
            $speaker_img = wp_get_attachment_image_url($event_speaker['speaker_image'], 'event-speaker');
            ?>
                                            <img src="<?php echo esc_url( $speaker_img ); ?>" alt="logo">
                                        <?php } else {
                                            ?>
                                            <img src="<?php echo ECP_IMAGE_DIR . '/member.jpg'; ?>" alt="logo">
                                            <?php } ?>
                                    </div>
                                    <div class="speaker-name">
                                        <h4><?php echo esc_html( $event_speaker['speaker_name'] ); ?></h4>
        <?php if (!empty($event_speaker['speaker_designation'])) { ?>
                                            <p><?php echo esc_html( $event_speaker['speaker_designation'] ); ?></p>
                                            <?php } ?>
                                        <ul>
                                            <?php if (!empty($event_speaker['fb_url'])) { ?>
                                                <li> 
                                                    <a href="<?php echo esc_url($event_speaker['fb_url']); ?>" target="_blank" >
                                                        <i class="fa fa-facebook"></i>
                                                    </a> 
                                                </li>
                                            <?php }
                                            if (!empty($event_speaker['tw_url'])) {
                                                ?>
                                                <li>
                                                    <a href="<?php echo esc_url($event_speaker['tw_url']); ?>" target="_blank" >
                                                        <i class="fa fa-twitter"></i>
                                                    </a>
                                                </li>
        <?php }
        if (!empty($event_speaker['inst_url'])) {
            ?>
                                                <li>
                                                    <a href="<?php echo esc_url($event_speaker['inst_url']); ?>" target="_blank" > 
                                                        <i class="fa fa-instagram"></i>
                                                    </a>
                                                </li>
                <?php } ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>   
    <?php endforeach; ?>
                    </div>
                </div>
            </div>
<?php } ?>
    </div>
<?php
get_footer();
