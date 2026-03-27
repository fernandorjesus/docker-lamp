<?php
/**
 * QuadLayers WP Plugin Table Links
 *
 * @package   quadlayers/wp-plugin-table-links
 * @author    QuadLayers
 * @link      https://github.com/quadlayers/wp-plugin-table-links
 * @copyright Copyright (c) 2023
 * @license   GPL-3.0
 */

namespace QuadLayers\WP_Plugin_Table_Links;

/**
 * Load class
 */
class Load {

	/**
	 * Link defaults
	 *
	 * @var string
	 */
	protected $link_defaults = array(
		'place'  => 'action',
		'text'   => '',
		'url'    => '',
		'target' => '_blank',
	);

	/**
	 * Constructor
	 *
	 * @param string $plugin_file Plugin file.
	 * @param array  $plugin_links Plugin links.
	 */
	public function __construct( string $plugin_file, array $plugin_links = array() ) {
		add_filter(
			'plugin_row_meta',
			function( $links, $plugin_file_name, $plugin_data, $status ) use ( $plugin_file, $plugin_links ) {

				if ( $plugin_file_name !== plugin_basename( $plugin_file ) ) {
					return $links;
				}

				foreach ( $plugin_links as $link ) {
					$link = wp_parse_args(
						$link,
						$this->link_defaults
					);
					if ( isset( $link['url'], $link['text'] ) && 'row_meta' === $link['place'] ) {
						$links[] = '<a target="' . $link['target'] . '" href="' . $link['url'] . '">' . $link['text'] . '</a>';
					}
				}
				return $links;
			},
			10,
			4
		);
		add_filter(
			'plugin_action_links_' . plugin_basename( $plugin_file ),
			function( $links ) use ( $plugin_links ) {
				foreach ( $plugin_links as $link ) {
					$link = wp_parse_args(
						$link,
						$this->link_defaults
					);
					if ( isset( $link['url'], $link['text'] ) && 'action' === $link['place'] ) {
						$links[] = '<a target="' . $link['target'] . '" href="' . $link['url'] . '">' . $link['text'] . '</a>';
					}
				}
				return $links;
			}
		);
	}
}
