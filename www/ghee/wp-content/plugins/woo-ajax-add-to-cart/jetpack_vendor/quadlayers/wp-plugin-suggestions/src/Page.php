<?php
/**
 * QuadLayers WP Plugin Suggestions
 *
 * @package   quadlayers/wp-plugin-suggestions
 * @author    QuadLayers
 * @link      https://github.com/quadlayers/wp-plugin-suggestions
 * @copyright Copyright (c) 2023
 * @license   GPL-3.0
 */

namespace QuadLayers\WP_Plugin_Suggestions;

use QuadLayers\WP_Plugin_Suggestions\Table;

/**
 * Class Page
 */
class Page {

	/**
	 * Plugin data
	 *
	 * @var array
	 */
	private $plugin_data;

	/**
	 * Page constructor.
	 *
	 * @param array $plugin_data Plugin data.
	 */
	public function __construct( array $plugin_data = array() ) {

		$this->plugin_data = $plugin_data;

		/**
		 * Don't load plugin menu if parent_menu_slug is set to false
		 */
		if ( false === $this->get_parent_menu_slug() ) {
			return;
		}

		/**
		 * Load menu after all plugins loaded to make sure that parent menu is exists
		 */
		add_action(
			'plugins_loaded',
			function() {
				add_action( 'admin_menu', array( $this, 'add_menu' ), 999 );
			},
			99
		);

		add_action( 'admin_init', array( $this, 'add_redirect' ) );
		add_filter( 'network_admin_url', array( $this, 'network_admin_url' ), 10, 2 );
	}

	/**
	 * Create parent admin menu if is not exists
	 *
	 * @return void
	 */
	public function add_menu() {
		global $_parent_pages;

		$parent_menu_slug      = $this->get_parent_menu_slug();
		$suggestions_menu_slug = $this->get_suggestions_menu_slug();

		/**
		 * Don't load suggestions menu if parent_menu_slug is set to false
		 */
		if ( ! $suggestions_menu_slug ) {
			return;
		}

		if ( ! isset( $_parent_pages[ $parent_menu_slug ] ) ) {
			$menu_name = esc_html__( 'Suggestions', 'wp-plugin-suggestions' );
			if ( $menu_name ) {
				add_menu_page(
					$menu_name,
					$menu_name,
					'edit_posts',
					$suggestions_menu_slug,
					'__return_null',
					'dashicons-cloud-upload'
				);
			}
		}

		add_submenu_page(
			$parent_menu_slug,
			esc_html__( 'Suggestions', 'wp-plugin-suggestions' ),
			esc_html__( 'Suggestions', 'wp-plugin-suggestions' ),
			'manage_options',
			$suggestions_menu_slug,
			function () {
				$wp_list_table = new Table( $this->plugin_data );
				include __DIR__ . '/view/suggestions.php';
			},
			99
		);
	}

	/**
	 * Get parent menu slug
	 *
	 * @return string
	 */
	public function get_parent_menu_slug() {
		return $this->plugin_data['parent_menu_slug'];
	}

	/**
	 * Get suggestions menu slug
	 *
	 * @return string
	 */
	public function get_suggestions_menu_slug() {
		return $this->get_parent_menu_slug() . '_suggestions';
	}

	/**
	 * Fix network admin url for plugin installation
	 *
	 * @param [type] $url site url.
	 * @param [type] $path path.
	 * @return string
	 */
	public function network_admin_url( $url, $path ) {
		if ( wp_doing_ajax() && ! is_network_admin() ) {
			if ( isset( $_REQUEST['action'] ) && $_REQUEST['action'] == 'install-plugin' ) {
				if ( strpos( $url, 'plugins.php' ) !== false ) {
					$url = self_admin_url( $path );
				}
			}
		}

		return $url;
	}

	/**
	 * Redirect to the current page after activation
	 *
	 * @return void
	 */
	public function add_redirect() {
		if ( isset( $_REQUEST['activate'] ) && $_REQUEST['activate'] == 'true' ) {
			if ( wp_get_referer() == admin_url( 'admin.php?page=' . $this->get_suggestions_menu_slug() ) ) {
				wp_safe_redirect( admin_url( 'admin.php?page=' . $this->get_suggestions_menu_slug() ) );
				exit();
			}
		}
	}
}
