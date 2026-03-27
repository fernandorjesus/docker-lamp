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

use QuadLayers\WP_Plugin_Suggestions\Page;

/**
 * Load class
 */
class Load {

	/**
	 * Plugin data
	 *
	 * @var array
	 */
	private $plugin_data = array(
		'author'           => 'quadlayers',
		'per_page'         => 36,
		'exclude'          => array(),
		'parent_menu_slug' => null,
		'promote_links'    => array(),
	);

	/**
	 * Page model
	 *
	 * @var Page
	 */
	public $page = null;

	/**
	 * Load constructor.
	 *
	 * @param array $plugin_data Plugin data.
	 */
	public function __construct( array $plugin_data = array() ) {
		/**
		 * Merge plugin data with default data
		 */
		$this->plugin_data = wp_parse_args(
			$plugin_data,
			$this->plugin_data
		);

		$this->page = new Page( $this->plugin_data );
	}

}
