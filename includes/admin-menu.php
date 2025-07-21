<?php

add_action('admin_menu', function () {
	add_menu_page(
		'Onyx Connector',
		'Onyx Connector',
		'manage_options',
		'onyx-connector',
		'onyx_connector_settings_page',
		'dashicons-admin-network'
	);
});

function onyx_connector_settings_page() {
	if (!current_user_can('manage_options')) return;

	if (isset($_POST['onyx_auth_token'])) {
		check_admin_referer('onyx_save_token');
		update_option('onyx_auth_token', sanitize_text_field($_POST['onyx_auth_token']));
		echo '<div class="notice notice-success"><p>Auth token saved.</p></div>';
	}

	$token = esc_attr(get_option('onyx_auth_token', ''));

	echo '<div class="wrap">';
	echo '<h1>Onyx Connector</h1>';
	echo '<form method="post">';
	wp_nonce_field('onyx_save_token');
	echo '<table class="form-table"><tr>';
	echo '<th scope="row"><label for="onyx_auth_token">Auth Token</label></th>';
	echo '<td><input type="text" name="onyx_auth_token" id="onyx_auth_token" value="' . $token . '" class="regular-text" required /></td>';
	echo '</tr></table>';
	submit_button('Save Token');
	echo '</form>';
	echo '<p style="margin-top:1em;">You can find your Auth Token in the Onyx dashboard under your site settings.</p>';
	echo '</div>';
}
