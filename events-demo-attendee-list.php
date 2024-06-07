<?php
/**
 * Plugin Name: Demo Attendee List
 * Description: Displays a list of attendees based on the current user.
 * Version: 1.0.0
 * Author: Sam Dokus
 * Author URI: https://www.linkedin.com/in/sam-dokus/
 * Text Domain: sdokus-demo-attendee-list
 */

use Sdokus\Demo_Attendee_List\Plugin;

/**
 * Loads the plugin class.
 *
 * @since 1.0.0
 */
add_action(
	'plugins_loaded',
	static function () {
		// Load Composer autoload file.
		require_once __DIR__ . '/vendor/autoload.php';
		Plugin::get_instance()->boot( __FILE__ );
	}
);