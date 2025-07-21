<?php

register_activation_hook(__FILE__, 'onyx_create_visitors_table');

function onyx_create_visitors_table() {
	global $wpdb;
	$table_name = $wpdb->prefix . 'onyx_visitors';
	$charset_collate = $wpdb->get_charset_collate();

	$sql = "CREATE TABLE IF NOT EXISTS $table_name (
		id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
		visitor_id VARCHAR(64) NOT NULL,
		visit_date DATE NOT NULL,
		PRIMARY KEY (id),
		UNIQUE KEY unique_visitor_date (visitor_id, visit_date)
	) $charset_collate;";

	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
	dbDelta($sql);
}
