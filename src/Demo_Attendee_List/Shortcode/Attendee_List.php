<?php

namespace Sdokus\Demo_Attendee_List\Shortcode;

use Sdokus\Demo_Attendee_List\Singleton_Abstract;
use Sdokus\Demo_Attendee_List\Plugin;

/**
 * Class Attendee_List Shortcode.
 *
 * @since   1.0.0
 *
 * @package Sdokus\Demo_Attendee_List\Shortcode
 */
class Attendee_List extends Singleton_Abstract {
	/**
	 * @inheritDoc
	 */
	protected function register(): void {
		add_shortcode( 'demo_attendee_list', [ $this, 'get_output'] );
		add_action( 'init', [ $this, 'register_assets' ] );
	}

	/**
	 * Registers the assets for the Attendee List Shortcode.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function register_assets(): void {
		tribe_asset(
			Plugin::get_instance(),
			'demo-attendee-list-shortcode',
			Plugin::get_instance()->plugin_url . 'src/resources/js/demo-attendee-list-shortcode.js'
		);
	}

	/**
	 * Returns the HTML for the Attendee List Shortcode.
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public function get_output(): string {
		$this->register_assets();
		ob_start();
		?>
			<div>
				<p>
					TESTING TESTING 123
				</p>
			</div>
		<?php
		return ob_get_clean();
	}
}