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
		wp_register_style(
			'sdokus-attendee-list-demo-shortcode-style',
			Plugin::get_instance()->plugin_url . 'src/resources/css/demo-attendee-list-shortcode.css',
			[],
			Plugin::VERSION
		);

		wp_register_script(
			'sdokus-attendee-list-demo-shortcode',
			Plugin::get_instance()->plugin_url . 'src/resources/js/demo-attendee-list-shortcode.js',
			[ 'jquery', 'wp-i18n' ],
			Plugin::VERSION,
			true
		);
	}

	/**
	 * Enqueues the assets for the Attendee List Demo Shortcode style and functionality.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	protected function enqueue_assets(): void {
		wp_enqueue_script( 'sdokus-attendee-list-demo-shortcode' );
        wp_enqueue_style( 'sdokus-attendee-list-demo-shortcode-style' );

		// Localize script with nonce to MyAjax object
		wp_localize_script(
			'sdokus-attendee-list-demo-shortcode',
			'attendee_list_demo_shortcode_script_vars',
			[
				'ajaxurl'               => admin_url( 'admin-ajax.php' ),
				'rest_endpoint'         => [
					'base'   => get_rest_url(),
					'events' => tribe_events_rest_url( '/events' ),
					'tags'   => get_rest_url( null, '/wp/v2/tags' ),
				],
				'nonce'                 => wp_create_nonce( 'wp_rest' ),
			]
		);

		// Set up translations for the script
		wp_set_script_translations( 'sdokus-attendee-list-demo-shortcode', 'sdokus-demo-attendee-list' );
	}

	/**
	 * Returns the HTML for the Attendee List Shortcode.
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public function get_output(): string {
		$this->enqueue_assets();
		ob_start();
		?>
			<div class="test">
				<p>
					TESTING TESTING 123
				</p>
			</div>
		<?php
		return ob_get_clean();
	}
}