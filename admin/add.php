<?php

function lulav_add_marker() {
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
	}

    $data = array(
        'title' => 'Add',
        'action' => admin_url('admin.php?page=lulav&action=edit'),
    );
    echo lulav_render('tpl/marker.tpl.php', $data);
}
