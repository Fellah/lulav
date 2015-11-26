<?php

function lulav_edit_marker() {
	$data = array(
		'title' => 'Edit',
		'action' => admin_url('admin.php?page=lulav'),
	);

	global $wpdb;
	$table_name = $wpdb->prefix . LULAV_TABLE_NAME;

	if (!empty($_REQUEST['submit'])) {
		$res = $wpdb->insert(
			$table_name,
			array(
				'title' => $_REQUEST['title'],
				'lat' => $_REQUEST['lat'],
				'lng' => $_REQUEST['lng'],
				'description' => $_REQUEST['description'],
			),
			array(
				'%s',
				'%.06lf',
				'%.06lf',
				'%s',
			)
		);

		$id = $wpdb->insert_id;
	} elseif (!empty($_REQUEST['id'])) {
		$mark = $wpdb->get_row( "SELECT * FROM $table_name WHERE id = " .  $_REQUEST['id'] );
	}


	echo lulav_render('tpl/marker.tpl.php', $data);
}
