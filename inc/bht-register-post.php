<?php
$labels = array(
		'name' 			=> __( 'Event', 'business-hub-toolbox' ),
		'singular_name' => __( 'Event', 'business-hub-toolbox' ),
		'add_new' 		=> __( 'Add event', 'business-hub-toolbox' ),
		'all_items' 	=> __( 'All Item', 'business-hub-toolbox' ),
		'add_new_item' 	=> __( 'Add Event', 'business-hub-toolbox' ),
		'edit_item' 	=> __( 'Edit Event', 'business-hub-toolbox' ),
		'view_item' 	=> __( 'View Event', 'business-hub-toolbox' )
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
		'menu_icon' 			=> 'dashicons-calendar-alt',
		'supports' 				=> array( 'title', 'editor', 'thumbnail' ),
	);
