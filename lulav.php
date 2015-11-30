<?php
/**
 * Plugin Name: Lulav
 * Description:
 * Version: Developing
 */

function lulav_markers() {
	$labels = array(
		'name'               => _x( 'Lulav', 'lulav' ),
		'singular_name'      => _x( 'Lulav', 'lulav' ),
		'add_new'            => _x( 'Add New', 'lulav' ),
		'add_new_item'       => _x( 'Add New Marker', 'lulav' ),
		'edit_item'          => _x( 'Edit Marker', 'lulav' ),
		'new_item'           => _x( 'New Marker', 'lulav' ),
		'view_item'          => _x( 'View Marker', 'lulav' ),
		'search_item'        => _x( 'Search Marker', 'lulav' ),
		'not_found'          => _x( 'No marker found', 'lulav' ),
		'not_found_in_trash' => _x( 'No marker found in Trash', 'lulav' ),
		'parent_item_colon'  => _x( 'Parent Marker', 'lulav' ),
		'menu_name'          => _x( 'Lulav', 'lulav' ),
	);

	$args = array(
		'labels'              => $labels,
		'hierarchical'        => false,
		'description'         => 'Google maps markers',
		'supports'            => array(
			'title',
			'editor',
			'thumbnail',
			'custom-fields',
		),
		'taxonomies'          => array( 'genres' ),
		'public'              => false,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'menu_icon'           => 'dashicons-location-alt',
		'show_in_nav_menus'   => false,
		'show_tagcloud'       => false,
		'public_queryable'    => false,
		'exclude_from_search' => true,
		'has_archive'         => false,
		'query_var'           => true,
		'can_export'          => false,
		'rewrite'             => false,
		'capability_type'     => 'post',
	);

	register_post_type( 'lulav', $args );
}

// register_activation_hook(__FILE__, 'lulav_activate');
add_action( 'init', 'lulav_markers' );

add_action( 'wp_enqueue_scripts', 'lulav_assets' );

function lulav_assets() {
	wp_enqueue_script( 'jquery-ui-core' );
	wp_enqueue_script( 'jquery-ui-widget' );
	wp_enqueue_script( 'google-maps', 'https://maps.googleapis.com/maps/api/js' );
	wp_enqueue_script( 'lulav', plugin_dir_url( __FILE__ ) . 'js/lulav.js', array( 'jquery', 'jquery-ui-core', 'jquery-ui-widget' ) );
	wp_enqueue_style( 'lulav', plugin_dir_url( __FILE__ ) . 'css/lulav.css' );
}

function lulav_shortcode() {
	$posts = get_posts( array(
		'numberposts' => - 1,
		'orderby'     => 'rand',
		'post_type'   => 'music_review',
		'post_status' => 'publish',
	) );

	$data = array(
		'markers'     => array(),
		'collections' => array(),
	);

	$collection = array();
	$row        = array();
	foreach ( $posts as $post ) {
		$custom = get_post_custom( $post->ID );

		$thumbnail = wp_get_attachment_url( get_post_thumbnail_id( $post->ID ) );

		$data['markers'][] = array(
			'id'          => $post->ID,
			'title'       => $post->post_title,
			'description' => $post->post_content,
			'coordinates' => ! empty( $custom['Coordinates'][0] ) ? $custom['Coordinates'][0] : '',
			'$thumbnail'  => $thumbnail,
		);

		$row[] = array(
			'id'          => $post->ID,
			'title'       => $post->post_title,
			'description' => $post->post_content,
			'coordinates' => ! empty( $custom['Coordinates'][0] ) ? $custom['Coordinates'][0] : '',
			'thumbnail'   => $thumbnail,
		);

		if ( sizeof( $row ) == 3 ) {
			$collection[] = $row;
			$row          = array();
		}

		if ( sizeof( $collection ) == 3 ) {
			$data['collections'][] = $collection;
			$collection            = array();
		}
	}

	if ( ! empty( $row ) ) {
		$collection[] = $row;
	}

	if ( ! empty( $collection ) ) {
		$data['collections'][] = $collection;
	}

	$output = lulav_render( 'tpl/shortcode.tpl.php', $data );

	return $output;
}

add_shortcode( 'lulav', 'lulav_shortcode' );

function lulav_render( $tpl, $data = array() ) {
	$output = '';

	$tpl = plugin_dir_path( __FILE__ ) . $tpl;
	if ( file_exists( $tpl ) ) {
		ob_start();
		extract( $data, EXTR_SKIP );
		include( $tpl );
		$output = ob_get_contents();
		ob_end_clean();
	}

	return $output;
}
