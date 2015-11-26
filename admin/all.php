<?php

if( ! class_exists( 'WP_List_Table' ) ) {
	require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

function lulav_all_markers() {
    $data = array(
        'title' => 'List',
    );

	$list = new Lulav_List_Table;

	ob_start();
	$list->prepare_items();
	$list->display();
	$output = ob_get_contents();
	ob_end_clean();

	$data['list'] = $output;

    echo lulav_render('tpl/list.tpl.php', $data);
}

class Lulav_List_Table extends WP_List_Table {
	function get_columns(){
		$columns = array(
			'title' => 'Title',
			'lat_lng'      => 'Latitude and Longitude',
		);
		return $columns;
	}

	function prepare_items() {
		global $wpdb;

		$columns = $this->get_columns();
		$hidden = array();
		$sortable = array();
		$this->_column_headers = array($columns, $hidden, $sortable);
		$this->items = array();

		$marks = $wpdb->get_results("
    SELECT id, title, lng, lat
	FROM " . $wpdb->prefix . LULAV_TABLE_NAME);

		foreach ( $marks as $mark ) {
			$this->items[] = array(
				'ID' => $mark->id,
				'title' => $mark->title,
				'lat_lng' => $mark->lat . ' ' . $mark->lng,
			);
		}
	}

	function column_default( $item, $column_name ) {
		switch( $column_name ) {
			case 'title':
			case 'lat_lng':
				return $item[ $column_name ];
			default:
				return print_r( $item, true );
		}
	}

	function get_sortable_columns() {
		$sortable_columns = array(
			'title'  => array('title',true),
			'lat_lng' => array('lat_lng',false),
		);
		return $sortable_columns;
	}

	function column_title($item) {
		$actions = array(
			'edit'      => sprintf('<a href="?page=%s&action=%s&id=%s">Edit</a>', $_REQUEST['page'], 'edit' ,$item['ID']),
			'delete'    => sprintf('<a href="?page=%s&action=%s&id=%s">Delete</a>', $_REQUEST['page'], 'delete' ,$item['ID']),
		);

		return sprintf('%1$s %2$s', $item['title'], $this->row_actions($actions) );
	}
}
