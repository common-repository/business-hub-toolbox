<div class="input_fields_wrap">

	<div class="meta-th">

		<h4><?php _e( 'Time and Date', 'business-hub-toolbox' ); ?></h4>

	</div> 

	<label><?php _e( 'Start Date & Time', 'business-hub-toolbox' ); ?></label>

        <input id="date_timepicker_start" name= "date_timepicker_start" type="text" value="<?php if ( ! empty ( $rwsec_stored_meta_option['date_timepicker_start'] ) ) {

			echo  esc_attr( $rwsec_stored_meta_option['date_timepicker_start'][0] ) ;

			} ?>">

            <select id="start_hour" name="start_hour">

                <option value="am"  <?php if ( isset ( $rwsec_stored_meta_option['start_hour'] ) ) selected($rwsec_stored_meta_option['start_hour'][0], 'am' ); ?>>am</option>

                <option value="pm"  <?php if ( isset ( $rwsec_stored_meta_option['start_hour'] ) ) selected($rwsec_stored_meta_option['start_hour'][0], 'pm' ); ?>>pm</option>

            </select>   <br><br>       

	<label><?php _e( 'End Date & Time', 'business-hub-toolbox' ); ?></label>

	    <input id="date_timepicker_end" name= "date_timepicker_end" type="text" value="<?php if ( ! empty ( $rwsec_stored_meta_option['date_timepicker_end'] ) ) {

			echo  esc_attr( $rwsec_stored_meta_option['date_timepicker_end'][0] ) ;

		} ?>" >	

            <select id="end_hour" name="end_hour">

                <option value="am"  <?php if ( isset ( $rwsec_stored_meta_option['end_hour'] ) ) selected($rwsec_stored_meta_option['end_hour'][0], 'am' ); ?>>am</option>

                <option value="pm"  <?php if ( isset ( $rwsec_stored_meta_option['end_hour'] ) ) selected($rwsec_stored_meta_option['end_hour'][0], 'pm' ); ?>>pm</option>

            </select>
</div>

<div class="input_fields_wrap">

    <h4><?php _e( 'Location', 'business-hub-toolbox' ); ?></h4>

	<label><?php _e( 'Address', 'business-hub-toolbox' ); ?></label>
    <input id="address" name= "address" type="text" value="<?php if ( ! empty ( $rwsec_stored_meta_option['address'] ) ) {
				echo  esc_attr( $rwsec_stored_meta_option['address'][0] ) ;
			} ?>"><br><br>

	<h4><?php _e( 'For detail Information', 'business-hub-toolbox' ); ?></h4>

    <label><?php _e( 'Organizer Name', 'business-hub-toolbox' ); ?></label>
    <input id="name" name= "name" type="text" value="<?php if ( ! empty ( $rwsec_stored_meta_option['name'] ) ) {
				echo  esc_attr( $rwsec_stored_meta_option['name'][0] ) ;
			} ?>"><br><br>

    <div name="pop_message_phone" class="hidden" style="color:red;"><?php _e( 'Enter valid contact number', 'business-hub-toolbox' ); ?></div>    
	<label><?php _e( 'Phone', 'business-hub-toolbox' ); ?></label>
    <input id="phone" name= "phone" type="text" value="<?php if ( ! empty ( $rwsec_stored_meta_option['phone'] ) ) {
				echo  esc_attr( $rwsec_stored_meta_option['phone'][0] ) ;
			} ?>">
    <br><br>

    <div name="pop_message" class="hidden" style="color:red;"><?php _e( 'Enter valid email address', 'business-hub-toolbox' ); ?></div>
    <label><?php _e( 'Email', 'business-hub-toolbox' ); ?></label>
    <input id="email" class="email" name= "email" type="text" value="<?php if ( ! empty ( $rwsec_stored_meta_option['email'] ) ) {
                echo  esc_attr( $rwsec_stored_meta_option['email'][0] ) ;
            } ?>"> 
    <br><br>

    <h4><?php _e( 'Others', 'business-hub-toolbox' ); ?></h4>

    <label><?php _e( 'Event Logo', 'business-hub-toolbox' ); ?></label>
    <?php
        if ( !empty($rwsec_stored_meta_option['event_logo'] ) ) :

             echo '<img class="custom_media_image" id ="rws_logo_event" src="' . esc_url($rwsec_stored_meta_option['event_logo'][0]) . '" style="margin:0;padding:0;max-width:100px;display:inline-block" /><br />';

        endif;
    ?>
    <input type="hidden" class="widefat custom_media_url" name="event_logo" id="event_logo" value="<?php if ( ! empty ( $rwsec_stored_meta_option['event_logo'] ) ) {
                echo esc_attr( $rwsec_stored_meta_option['event_logo'][0] );
            } ?>" style="margin-top:5px;">
    
    <input type="button" class="button button-primary custom_media_button" id="custom_media_button"  value="Upload Image" style="margin-top:5px;" />
    <a href="#" class="meta_box_clear_logo_button"><?php _e( 'Remove Image', 'business-hub-toolbox' ); ?></a>
    <br><br>

    <label><?php _e( 'Description Title', 'business-hub-toolbox' ); ?></label>
    <input id="desc_title" name= "desc_title" type="text" value="<?php if ( ! empty ( $rwsec_stored_meta_option['desc_title'] ) ) {
                echo  esc_attr( $rwsec_stored_meta_option['desc_title'][0] ) ;
            } ?>">
    <br><br>
    
    <label><?php _e( 'Speaker Title', 'business-hub-toolbox' ); ?></label>
    <input id="speaker_title" name= "speaker_title" type="text" value="<?php if ( ! empty ( $rwsec_stored_meta_option['speaker_title'] ) ) {
                echo  esc_attr( $rwsec_stored_meta_option['speaker_title'][0] ) ;
            } ?>">
    <br><br>
</div>