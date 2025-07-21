<?php

add_action('rest_api_init', function () {
	register_rest_route('onyx/v1', '/wp-info', [
		'methods' => 'GET',
		'callback' => 'onyx_wp_info_callback',
		'permission_callback' => 'onyx_wp_info_permission_check'
	]);
});

function onyx_wp_info_permission_check(WP_REST_Request $request) {
	$token = $request->get_param('auth_token');
	$stored = get_option('onyx_auth_token');
	return $token && $stored && hash_equals($stored, $token);
}

function onyx_wp_info_callback(WP_REST_Request $request) {
	$theme = wp_get_theme();
	return new WP_REST_Response([
		'wordpress_version' => get_bloginfo('version'),
		'php_version' => phpversion(),
		'active_theme' => [
			'name' => $theme->get('Name'),
			'version' => $theme->get('Version'),
			'author' => $theme->get('Author'),
		],
		'plugin_version' => '1.0.0'
	], 200);
}
