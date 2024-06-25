<?php

namespace Sdokus\Demo_Attendee_List\Shortcodes;

use Sdokus\Demo_Attendee_List\Singleton_Abstract;
use Sdokus\Demo_Attendee_List\Plugin;

/**
 * Class Controller
 *
 * Controls the registration of shortcodes and assets for the Demo Attendee List plugin.
 *
 * @since   1.0.0
 *
 * @package Sdokus\Demo_Attendee_List\Shortcodes
 */
class Controller extends Singleton_Abstract {

	/**
	 * Register shortcodes and hooks.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	protected function register(): void {
		// Register the attendee list shortcode
		add_shortcode( Attendee_List::get_wp_slug(), [ Attendee_List::class, 'make_for_wp' ] );

		// Register assets for the attendee list
		Attendee_List::register_assets();
	}
}
