<?php
// tested on wordpress version 5.7 on 17-march-2021
$prefix = 'event_';

$fields = array(
	array( 
		'label'	=> __( 'Speaker Details', 'business-hub-toolbox' ), 
		'id'	=> $prefix.'repeatable', 
		'type'	=> 'repeatable', 
		'sanitizer' => array( // array of sanitizers with matching kets to next array
			'featured' => 'event_calendar_meta_box_santitize_boolean',
			'title' => 'sanitize_text_field',
			'desc' => 'wp_kses_data'
		),
		'repeatable_fields' => array ( 
			 array(
				'label' => __( 'Name', 'business-hub-toolbox' ),
				'id' 	=> 'speaker_name',
				'type' 	=> 'text'
			),
			 array(
				'label' => __( 'Designation', 'business-hub-toolbox' ),
				'id' 	=> 'speaker_designation',
				'type' 	=> 'text'
			),
			array( 
				'label'	=> __( 'Image', 'business-hub-toolbox' ), 
				'id'	=> 'speaker_image', 
				'type'	=> 'image' 
			),
			 array(
				'label' => __( 'Facebook Url', 'business-hub-toolbox' ),
				'id' 	=> 'fb_url',
				'type' 	=> 'text'
			),
			 array(
				'label' => __( 'Twitter Url', 'business-hub-toolbox' ),
				'id' 	=> 'tw_url',
				'type' 	=> 'text'
			),
			 array(
				'label' => __( 'Instagram Url', 'business-hub-toolbox' ),
				'id' 	=> 'inst_url',
				'type' 	=> 'text'
			)
		)
	)
);
$sample_box = new event_calendar_custom_Add_Meta_Box( 'event_calendar', 'Event Speaker', $fields, 'bht-event', true );
