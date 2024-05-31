<?php
/**
 * Plugin class service provider to bootstrap the plugin.
 *
 * @since 1.0.0
 */

namespace Sdokus\Demo_Attendee_List;

/**
 * The Demo Attendee List Class.
 *
 * This is the main class of the plugin.
 *
 * @since 1.0.0
 */
class Plugin {

	/**
	 * The current version of the plugin.
	 *
	 * @since 1.0.0
	 */
	public const VERSION = '1.0.0';

	/**
	 * @since 1.0.0
	 *
	 * @var string Plugin File.
	 */
	public string $plugin_file;

	/**
	 * @since 1.0.0
	 *
	 * @var string Plugin Directory.
	 */
	public string $plugin_dir;

	/**
	 * @since 1.0.0
	 *
	 * @var string Plugin Path.
	 */
	public string $plugin_path;

	/**
	 * @since 1.0.0
	 *
	 * @var string Plugin URL.
	 */
	public string $plugin_url;

	/**
	 * Static Singleton Holder.
	 *
	 * @since 1.0.0
	 *
	 * @var self
	 */
	protected static Plugin $instance;

	/**
	 * Gets (and instantiates, if necessary) the instance of the class.
	 *
	 * @since 1.0.0
	 *
	 * @return self
	 */
	public static function get_instance(): self {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Boots up the plugin.
	 *
	 * @since 1.0.0
	 *
	 * @param string $file
	 *
	 * @return void
	 */
	public function boot( string $file ): void {
		// Sets up the hooks for the plugin.
		$this->enable_hooks();

		// Set up the plugin provider properties.
		$this->plugin_file = $file;
		$this->plugin_path = trailingslashit( dirname( $this->plugin_file ) );
		$this->plugin_dir  = trailingslashit( basename( $this->plugin_path ) );
		$this->plugin_url  = str_replace( basename( $this->plugin_file ), '', plugins_url( basename( $this->plugin_file ), $this->plugin_file ) );

		// Now that the plugin is set up, enqueue the assets.
		do_action( 'sdokus_demo_attendee_list_plugin_loaded' );
	}

	/**
	 * Enables hooks for the plugin.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function enable_hooks(): void {
		/**
		 * Action to allow hooking into the plugin being loaded.
		 *
		 * @since 1.0.0
		 */
		add_action( 'sdokus_demo_attendee_list_plugin_loaded', [ $this, 'load' ], 15 );
	}

	/**
	 * Loads the other classes for the plugin.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function load(): void {
	// Once I modularize the plugin, this will act as the router
	}
}