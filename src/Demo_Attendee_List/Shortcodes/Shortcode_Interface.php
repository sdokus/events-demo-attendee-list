<?php

namespace Sdokus\Demo_Attendee_List\Shortcodes;

/**
 * Interface Shortcode_Interface
 *
 * Defines the structure for shortcodes in the Demo Attendee List plugin.
 *
 * @since   1.0.0
 *
 * @package Sdokus\Demo_Attendee_List\Shortcodes
 */
interface Shortcode_Interface {

	/**
	 * Get the WordPress shortcode slug.
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public static function get_wp_slug(): string;

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
	public static function make_for_wp( array $attributes, string $content = '' ): string;

}
