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
	/**
	 * Array to hold instances of the class.
	 *
	 * @var array
	 */
	protected static array $instances = [];

	/**
	 * Array of shortcode attributes.
	 *
	 * @var array
	 */
	protected array $attributes = [];

	/**
	 * Content enclosed by the shortcode.
	 *
	 * @var string
	 */
	protected string $content = '';

	/**
	 * Get the WordPress shortcode slug.
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public static function get_wp_slug(): string {
		return 'demo_attendee_list';
	}

	/**
	 * Get the list of supported shortcode attributes.
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	protected function supported_attributes(): array {
		return [
			'id' => '',
		];
	}

	/**
	 * Create an instance of the shortcode for WordPress.
	 *
	 * @since 1.0.0
	 *
	 * @param array  $attributes Shortcode attributes.
	 * @param string $content    Content enclosed by the shortcode.
	 *
	 * @return string
	 */
	public static function make_for_wp( array $attributes, string $content = '' ): string {
		$instance = new static();
		$instance->set_attributes( $attributes );
		$instance->set_content( $content );

		static::$instances[] = $instance;

		return $instance->output();
	}

	/**
	 * Set the shortcode attributes.
	 *
	 * @since 1.0.0
	 *
	 * @param array $attributes Shortcode attributes.
	 *
	 * @return void
	 */
	protected function set_attributes( array $attributes ): void {
		$this->attributes = shortcode_atts( $this->supported_attributes(), $attributes, static::get_wp_slug() );
		// Sanitize attributes
		foreach ( $this->attributes as $key => $value ) {
			$this->attributes[ $key ] = sanitize_text_field( $value );
		}
	}

	/**
	 * Set the content enclosed by the shortcode.
	 *
	 * @since 1.0.0
	 *
	 * @param string $content Content enclosed by the shortcode.
	 *
	 * @return void
	 */
	protected function set_content( string $content = '' ): void {
		$this->content = $content;
	}

	/**
	 * Registers the assets for the Attendee List Shortcode using `tribe_asset()`.
	 *
	 *  This function requires the StellarWP/Assets library to be installed and included in the project.
	 *  The StellarWP/Assets library provides a robust and flexible way to manage assets with extended
	 *  functionalities such as conditional loading, localization, and advanced script attributes.
	 *
	 *  This plugin is booted on 'tribe_tickets_plugin_loaded' to ensure that the StellarWP/Assets library
	 *  is available and initialized before assets are registered.
	 *
	 *  Benefits of using `tribe_asset()`:
	 *  - **Advanced Flexibility**: Allows detailed control over asset behavior, including localization,
	 *    conditionals, and custom attributes.
	 *  - **Localization**: Simplifies the process of localizing scripts with dynamic data.
	 *  - **Conditional Loading**: Supports conditionally loading assets based on various criteria.
	 *  - **Integration**: Seamlessly integrates with StellarWP products and other Tribe plugins.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public static function register_assets(): void {
		tribe_asset(
			Plugin::get_instance(),
			'sdokus-attendee-list-demo-shortcode-style',
			'demo-attendee-list-shortcode.css',
			[],
			'sdokus_demo_attendee_list_shortcode_before_output'
		);

		tribe_asset(
			Plugin::get_instance(),
			'sdokus-attendee-list-demo-shortcode',
			'demo-attendee-list-shortcode.js',
			[ 'jquery', 'wp-i18n' ],
			'sdokus_demo_attendee_list_shortcode_before_output',
			[
				'localize' => [
					'name' => 'attendee_list_demo_shortcode_script_vars',
					'data' => static function () {
						return [
							'ajaxurl'             => admin_url( 'admin-ajax.php' ),
							'rest_endpoint'       => [
								'base'      => get_rest_url(),
								'tickets'   => tribe_events_rest_url( '/tickets' ),
								'attendees' => get_rest_url( null, 'tickets/v1/attendees' ),
							],
							'nonce'               => wp_create_nonce( 'wp_rest' ),
							'error_message'       => esc_html__( 'Error fetching attendees:', 'sdokus-demo-attendee-list' ),
							'no_attendee_message' => esc_html__( 'No attendees found.', 'sdokus-demo-attendee-list' ),
							'attendee_labels'     => [
								'email'       => esc_html__( 'Email: ', 'sdokus-demo-attendee-list' ),
								'ticket_name' => esc_html__( 'Ticket Purchased: ', 'sdokus-demo-attendee-list' ),
								'ticket_cost' => esc_html__( 'Ticket Cost: $', 'sdokus-demo-attendee-list' ),
							],
						];
					},
				],
			]
		);
	}

	/**
	 * Returns the HTML for the Attendee List Shortcode.
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public function output(): string {
		/*
		 * Action that the assets are enqueued on. Allows developers to unload assets.
		 *
		 * @since 1.0.0
		 */
		do_action( 'sdokus_demo_attendee_list_shortcode_before_output', $this );

		// @todo - Move this to a template.
		ob_start();
		?>
        <div class="test" data-id="<?php echo esc_attr( $this->attributes['id'] ); ?>">
            <h2>
				<?php __( 'All Attendees', 'sdokus-demo-attendee-list' ); ?>
            </h2>
            <div class="attendee-list">
                <!-- Attendee items will be dynamically appended here -->
            </div>
        </div>
		<?php
		return ob_get_clean();
	}
}
