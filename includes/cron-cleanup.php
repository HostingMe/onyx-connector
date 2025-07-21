<?php

add_action('wp_scheduled_delete_old_visitors', 'onyx_cleanup_old_visitors');

function onyx_cleanup_old_visitors() {
	global $wpdb;
	$table = $wpdb->prefix . 'onyx_visitors';

	$cutoff = date('Y-m-d', strtotime('-90 days'));
	$wpdb->query($wpdb->prepare("DELETE FROM $table WHERE visit_date < %s", $cutoff));
}

if (!wp_next_scheduled('wp_scheduled_delete_old_visitors')) {
	wp_schedule_event(time(), 'daily', 'wp_scheduled_delete_old_visitors');
}
