<?php

function lulav_all_markers() {
    $data = array(
        'title' => 'List',
        'marks' => array(),
    );

    global $wpdb;

    $marks = $wpdb->get_results("
    SELECT id, title
	FROM " . LULAV_TABLE_NAME);

    print_r($marks);

    foreach ( $marks as $mark ) {
        $data['marks'][$mark->id] = $mark->title;
    }

    echo lulav_render('tpl/list.tpl.php', $data);
}
