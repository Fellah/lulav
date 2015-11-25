<?php

function lulav_add_marker() {
    if (!empty($_REQUEST['submit'])) {
        global $wpdb;

        $res = $wpdb->insert(
            LULAV_TABLE_NAME,
            array(
                'title' => $_REQUEST['title'],
            ),
            array(
                '%s',
            )
        );

        echo $res;

        $id = $wpdb->insert_id;

        echo $id;
    }

    $data = array(
        'title' => 'Add',
        'action' => plugin_dir_url(__FILE__) . 'admin/post.php'
    );
    echo lulav_render('tpl/marker.tpl.php', $data);
}
