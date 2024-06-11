<?php

namespace Sdokus\Demo_Attendee_List\Shortcodes;

use Sdokus\Demo_Attendee_List\Singleton_Abstract;
use Sdokus\Demo_Attendee_List\Plugin;

/**
 * Class Attendee_List Shortcode.
 *
 * @since   1.0.0
 *
 * @package Sdokus\Demo_Attendee_List\Shortcode
 */
class Controller extends Singleton_Abstract {

	/**
	 * @inheritDoc
	 */
	protected function register(): void {
		add_shortcode( Attendee_List::get_wp_slug(), [ Attendee_List::class, 'make_for_wp' ] );

        add_action( 'init', [ Attendee_List::class, 'register_assets' ] )
	}

}