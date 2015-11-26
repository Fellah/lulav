<?php
/*
Plugin Name:    Lulav
Version:        Developing
*/

const LULAV_TABLE_NAME = 'lulav';

include(plugin_dir_path(__FILE__) . 'includes/shortcode.php');
include(plugin_dir_path(__FILE__) . 'admin/all.php');
include(plugin_dir_path(__FILE__) . 'admin/add.php');

register_activation_hook(__FILE__, 'lulav_activate');

function lulav_activate()
{
    global $wpdb;

    $table_name = $wpdb->prefix . LULAV_TABLE_NAME;
    $charset_collate = $wpdb->get_charset_collate();

	$sql = "CREATE TABLE $table_name (
		id INT NOT NULL AUTO_INCREMENT,
		title VARCHAR(255) NOT NULL,
		lat FLOAT(10,6) NOT NULL,
		lng FLOAT(10,6) NOT NULL,
		description text NOT NULL,
		UNIQUE KEY id (id)
	) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

	// TODO: Check result.
    $res = dbDelta($sql);
}

add_action( 'wp_enqueue_scripts', 'lulav_assets' );

function lulav_assets() {
    wp_enqueue_script( 'jquery-ui-core' );
    wp_enqueue_script( 'google-maps', 'https://maps.googleapis.com/maps/api/js' );
    wp_enqueue_script( 'lulav', plugin_dir_url(__FILE__) . 'js/lulav.js', array( 'jquery', 'jquery-ui-core' ) );
    wp_enqueue_style( 'lulav', plugin_dir_url(__FILE__) . 'css/lulav.css' );
}

add_shortcode('lulav', 'lulav_shortcode' );

function lulav_shortcode() {
	global $wpdb;

	$data = array( 'marks' => array() );

	$marks = $wpdb->get_results("
    SELECT id, title, lng, lat, description
	FROM " . $wpdb->prefix . LULAV_TABLE_NAME);

	foreach ( $marks as $mark ) {
		$data['marks'][] = array(
			'id' => $mark->id,
			'title' => $mark->title,
			'lat' => $mark->lat,
			'lng' => $mark->lng,
			'description' => $mark->description,
		);
	}

    return lulav_render( 'tpl/shortcode.tpl.php', $data );
}

add_action('admin_menu', 'lulav_add_admin_menu_pages');

function lulav_add_admin_menu_pages()
{
	add_menu_page('Lulav: Page Title ', 'Lulav', 'administrator', 'lulav', 'lulav_all_markers');
	add_submenu_page( 'lulav', 'Lulav: Page Title', 'All Marks','administrator', 'lulav', 'lulav_all_markers');
	add_submenu_page( 'lulav', 'Lulav: Page Title', 'Add New','administrator', 'lulav_add', 'lulav_add_marker');
}

//function lulav_actions() {
	if (!empty($_REQUEST['action'])) {
		$id = !empty($_REQUEST['id']) ? $_REQUEST['id'] : 0;

		switch ($_REQUEST['action']) {
			case 'delete':
				lulav_delete($id);
				break;
			default:
				break;
		}
	}
//}

function lulav_delete($id) {
	global $wpdb;

	$prefix = $wpdb->prefix;
	$prefix . LULAV_TABLE_NAME;

	$wpdb->delete( $prefix . LULAV_TABLE_NAME, array( 'id' => $id ), array( '%d' ) );


}

function lulav_render( $tpl, $data = array()) {
    $output = '';

    $tpl = plugin_dir_path(__FILE__) . $tpl;
    if (file_exists($tpl)) {
        ob_start();
        extract($data, EXTR_SKIP );
        include( $tpl );
        $output = ob_get_contents();
        ob_end_clean();
    } else {
        echo 'error';
        // TODO: Throw error.
    }

    return $output;
}
