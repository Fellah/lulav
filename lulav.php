<?php
/**
 * Plugin Name: Lulav
 * Description:
 * Version: Developing
 */

function register_cpt_music_review() {
	$labels = array(
		'name'               => _x( 'Music Reviews', 'music_review' ),
		'singular_name'      => _x( 'Music Reviews', 'music_review' ),
		'add_new'            => _x( 'Add New', 'music_review' ),
		'add_new_item'       => _x( 'Add New Music Review', 'music_review' ),
		'edit_item'          => _x( 'Edit Music Review', 'music_review' ),
		'new_item'           => _x( 'New Music Review', 'music_review' ),
		'view_item'          => _x( 'View Music Review', 'music_review' ),
		'search_item'        => _x( 'Search Music Reviews', 'music_review' ),
		'not_found'          => _x( 'No music reviews found', 'music_review' ),
		'not_found_in_trash' => _x( 'No music reviews found in Trash', 'music_review' ),
		'parent_item_colon'  => _x( 'Parent Music Review', 'music_review' ),
		'menu_name'          => _x( 'Music Review', 'music_review' ),
	);

	$args = array(
		'labels'              => $labels,
		'hierarchical'        => false,
		'description'         => 'Music reviews filterable by genre',
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

	register_post_type( 'music_review', $args );
}

// register_activation_hook(__FILE__, 'lulav_activate');
add_action( 'init', 'register_cpt_music_review' );

add_action( 'wp_enqueue_scripts', 'lulav_assets' );

function lulav_assets() {
	wp_enqueue_script( 'jquery-ui-core' );
	wp_enqueue_script( 'google-maps', 'https://maps.googleapis.com/maps/api/js' );
	wp_enqueue_script( 'lulav', plugin_dir_url( __FILE__ ) . 'js/lulav.js', array( 'jquery', 'jquery-ui-core' ) );
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
			'title'       => $post->post_title,
			'description' => $post->post_content,
			'coordinates' => ! empty( $custom['Coordinates'][0] ) ? $custom['Coordinates'][0] : '',
			'$thumbnail'  => $thumbnail,
		);

		$row[] = array(
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
