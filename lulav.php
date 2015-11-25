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

    $prefix = $wpdb->prefix;
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $prefix" . LULAV_TABLE_NAME . " (
  id INT NOT NULL AUTO_INCREMENT,
  title VARCHAR NOT NULL,
  UNIQUE KEY id (id)) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

    dbDelta($sql);
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
    return lulav_render( 'tpl/shortcode.tpl.php' );
}

add_action('admin_menu', 'lulav_add_admin_menu_pages');

function lulav_add_admin_menu_pages()
{
    add_menu_page('Lulav: Page Title ', 'Lulav', 'administrator', __FILE__, 'lulav_all_markers');
    add_submenu_page( __FILE__, 'Lulav: Page Title', 'All Marks','administrator', __FILE__, 'lulav_all_markers');
    add_submenu_page( __FILE__, 'Lulav: Page Title', 'Add New','administrator', __FILE__ . '_add', 'lulav_add_marker');
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
