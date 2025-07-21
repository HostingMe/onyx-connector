<?php

add_action('rest_api_init', function () {
	register_rest_route('onyx/v1', '/visitors', [
		'methods' => 'GET',
		'callback' => 'onyx_visitors_callback',
		'permission_callback' => 'onyx_visitors_permission_check',
	]);
});

function onyx_visitors_permission_check(WP_REST_Request $request) {
	$token = $request->get_param('auth_token');
	$stored = get_option('onyx_auth_token');
	return $token && $stored && hash_equals($stored, $token);
}

function onyx_visitors_callback(WP_REST_Request $request) {
	global $wpdb;
	$table = $wpdb->prefix . 'onyx_visitors';

	$today = current_time('Y-m-d');
	$month_ago = date('Y-m-d', strtotime('-30 days', strtotime($today)));

	$daily = $wpdb->get_var($wpdb->prepare(
		"SELECT COUNT(*) FROM $table WHERE visit_date = %s",
		$today
	));

	$monthly = $wpdb->get_var($wpdb->prepare(
		"SELECT COUNT(DISTINCT visitor_id) FROM $table WHERE visit_date >= %s",
		$month_ago
	));

	return new WP_REST_Response([
		'daily_unique_visitors' => (int) $daily,
		'monthly_unique_visitors' => (int) $monthly,
	], 200);
}
