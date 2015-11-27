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

add_action( 'init', 'register_cpt_music_review' );

function lulav_shortcode() {
	$posts = get_posts( array(
		'orderby'     => 'rand',
		'post_type'   => 'music_review',
		'post_status' => 'publish',
	) );

	return 'LULAV';
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
