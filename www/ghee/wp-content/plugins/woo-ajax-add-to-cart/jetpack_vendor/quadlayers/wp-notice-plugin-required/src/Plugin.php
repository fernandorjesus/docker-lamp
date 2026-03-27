<?php
/**
 * QuadLayers WP Notice Plugin Required
 *
 * @package   quadlayers/wp-notice-plugin-required
 * @author    QuadLayers
 * @link      https://github.com/quadlayers/wp-notice-plugin-required
 * @copyright Copyright (c) 2023
 * @license   GPL-3.0
 */

namespace QuadLayers\WP_Notice_Plugin_Required;

/**
 * Class Load
 *
 * @package QuadLayers\WP_Notice_Plugin_Required\Plugin
 */
class Plugin {

	/**
	 * Instance of this class.
	 *
	 * @var object
	 */
	protected static $instance = array();

	/**
	 * Required Plugin slug.
	 *
	 * @var string
	 */
	protected $plugin_slug = '';

	/**
	 * Required Plugin name.
	 *
	 * @var string
	 */
	protected $plugin_name = '';

	/**
	 * Load constructor.
	 *
	 * @param string $plugin_slug Required Plugin slug.
	 * @param string $plugin_name Required Plugin name.
	 */
	private function __construct( string $plugin_slug, string $plugin_name ) {
		if ( ! function_exists( 'is_plugin_active' ) ) {
			require_once ABSPATH . 'wp-admin/includes/plugin.php';
		}
		$this->plugin_slug = $plugin_slug;
		$this->plugin_name = $plugin_name;
	}

	/**
	 * Check if the required plugin is installed and activated.
	 *
	 * @return bool
	 */
	public function is_plugin_installed() {
		$plugin_path       = $this->get_plugin_path();
		$installed_plugins = get_plugins();
		return isset( $installed_plugins[ $plugin_path ] );
	}

	/**
	 * Check if the required plugin is activated.
	 *
	 * @return bool
	 */
	public function is_plugin_activated() {
		$plugin_path = $this->get_plugin_path();
		return is_plugin_active( $plugin_path );
	}

	/**
	 * Check if the required plugin is installed and activated.
	 *
	 * @return bool
	 */
	private function get_plugin_path() {
		return "{$this->plugin_slug}/{$this->plugin_slug}.php";
	}

	/**
	 * Get the plugin install link.
	 *
	 * @return string
	 */
	public function get_plugin_install_link() {
		return wp_nonce_url( self_admin_url( "update.php?action=install-plugin&plugin={$this->plugin_slug}" ), "install-plugin_{$this->plugin_slug}" );
	}

	/**
	 * Get the plugin activate link.
	 *
	 * @return string
	 */
	public function get_plugin_activate_link() {
		$plugin_path = $this->get_plugin_path();
		return wp_nonce_url( 'plugins.php?action=activate&amp;plugin=' . $plugin_path . '&amp;paged=1', 'activate-plugin_' . $plugin_path );
	}

	/**
	 * Get the plugin name.
	 *
	 * @return string
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * Singleton instance.
	 * Ensures only one instance of the class for each required plugin is loaded.
	 *
	 * @param string $plugin_slug Required Plugin slug.
	 * @param string $plugin_name Required Plugin name.
	 * @return Plugin
	 */
	public static function get_instance( string $plugin_slug = '', string $plugin_name = '' ) {

		$plugin_slug = $plugin_slug;

		if ( isset( self::$instance[ $plugin_slug ] ) ) {
			return self::$instance[ $plugin_slug ];
		}

		self::$instance[ $plugin_slug ] = new self( $plugin_slug, $plugin_name );

		return self::$instance[ $plugin_slug ];
	}

}
