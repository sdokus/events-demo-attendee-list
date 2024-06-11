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
class Attendee_List implements Shortcode_Interface {
	protected static array $instances = [];

	protected array $attributes = [];

	protected string $content = '';

	public static function get_wp_slug(): string {
		return 'demo_attendee_list';
	}

	protected function supported_attributes(): array {
		return [
			'id',
		];
	}

    public static function make_for_wp( array $attributes, string $content = '' ): string {
		$instance = new static()
		$instance->set_attributes( $attributes );
		$instance->set_content( $content );

		static::$instances[] = $instance;

		return $instance->output();
	}

	protected function set_attributes( array $attributes ): void {
		$this->attributes = shortcode_atts( $this->supported_attributes(), $attributes, static::get_wp_slug() );
	}

	protected function set_content( string $content = '' ): void {
		$this->content = $content;
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
		$this->attributes['id']

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
					'tickets' => tribe_events_rest_url( '/tickets' ),
					'attendees'   => get_rest_url( null, '/wp/v1/attendees' ),
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
	public function output(): string {
		$this->enqueue_assets();
		ob_start();
		?>
			<div class="test" data-id="<?php echo esc_attr( $this->attributes['id'] ); ?>">
				<p>
					TESTING TESTING 123
				</p>
                <div class="attendee-list">
                    <!-- Attendee items will be dynamically appended here -->
                    Placeholder.
                </div>
			</div>
		<?php
		return ob_get_clean();
	}
}