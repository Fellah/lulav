<?php
/*
Plugin Name:    Map
Version:        Developing
*/

include(plugin_dir_path(__FILE__) . 'includes/shortcode.php');

register_activation_hook(__FILE__, 'map_activate');

function map_activate()
{
    global $wpdb;

    $prefix = $wpdb->prefix;
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $prefix`map` (
  id INT NOT NULL AUTO_INCREMENT,
  title VARCHAR NOT NULL,
  UNIQUE KEY id (id)) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

    dbDelta($sql);
}

add_shortcode('map', 'map_shortcode');

add_action('admin_menu', 'map_add_menu_page');

function map_add_menu_page()
{
    add_menu_page('Map', 'Map', 'manage_options', 'map-admin-add', 'map_admin_add');
}

function map_admin_add() {
    echo 'Add';
}