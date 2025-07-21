<?php

add_action('init', function () {
	if (is_admin() || defined('REST_REQUEST') || wp_doing_ajax() || wp_doing_cron()) return;

	$user_agent = $_SERVER['HTTP_USER_AGENT'] ?? '';
	if (empty($user_agent) || preg_match('/bot|crawl|spider|slurp|facebook|discord|wget|curl|guzzlehttp/i', $user_agent)) return;

	$cookie_name = 'onyx_visitor_id';
	$cookie_lifetime = 60 * 60 * 24 * 30;

	if (isset($_COOKIE[$cookie_name])) {
		$visitor_id = sanitize_text_field($_COOKIE[$cookie_name]);
	} else {
		$visitor_id = wp_generate_uuid4();
		setcookie($cookie_name, $visitor_id, time() + $cookie_lifetime, '/');
		$_COOKIE[$cookie_name] = $visitor_id;
	}

	if (!$visitor_id) return;

	global $wpdb;
	$table = $wpdb->prefix . 'onyx_visitors';
	$today = current_time('Y-m-d');

	$wpdb->query($wpdb->prepare(
		"INSERT IGNORE INTO $table (visitor_id, visit_date) VALUES (%s, %s)",
		$visitor_id, $today
	));
});
