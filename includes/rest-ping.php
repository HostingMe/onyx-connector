<?php

add_action('rest_api_init', function () {
	register_rest_route('onyx/v1', '/ping', [
		'methods' => 'GET',
		'callback' => 'onyx_ping_callback',
		'permission_callback' => 'onyx_ping_permission_check'
	]);
});

function onyx_ping_permission_check(WP_REST_Request $request) {
	$incoming_token = $request->get_param('auth_token');
	$stored_token   = get_option('onyx_auth_token');
	return $incoming_token && $stored_token && hash_equals($stored_token, $incoming_token);
}

function onyx_ping_callback(WP_REST_Request $request) {
	return new WP_REST_Response([
		'status' => 'connected',
		'wordpress_version' => get_bloginfo('version'),
		'site_url' => get_site_url(),
		'plugin_version' => '1.0.0'
	], 200);
}
