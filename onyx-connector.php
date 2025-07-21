<?php
/**
 * Plugin Name: Onyx Connector
 * Description: Connects this WordPress site to your Onyx dashboard.
 * Version: 1.0.3
 * Author: Hosting Me
 */

if (!defined('ABSPATH')) exit;

define('ONYX_CONNECTOR_PATH', plugin_dir_path(__FILE__));

// Load components
require_once ONYX_CONNECTOR_PATH . 'includes/admin-menu.php';
require_once ONYX_CONNECTOR_PATH . 'includes/rest-ping.php';
require_once ONYX_CONNECTOR_PATH . 'includes/rest-wp-info.php';
require_once ONYX_CONNECTOR_PATH . 'includes/rest-visitors.php';
require_once ONYX_CONNECTOR_PATH . 'includes/visitors-tracker.php';
require_once ONYX_CONNECTOR_PATH . 'includes/visitors-install.php';
require_once ONYX_CONNECTOR_PATH . 'includes/cron-cleanup.php';

require_once 'vendor/plugin-update-checker/plugin-update-checker.php';
use YahnisElsts\PluginUpdateChecker\v5\PucFactory;

$myUpdateChecker = PucFactory::buildUpdateChecker(
	'https://github.com/stevennoad/text-scroll-reveal/',
	__FILE__,
	'text-scroll-reveal'
);

$myUpdateChecker->setBranch('main');
$myUpdateChecker->getVcsApi()->enableReleaseAssets();
