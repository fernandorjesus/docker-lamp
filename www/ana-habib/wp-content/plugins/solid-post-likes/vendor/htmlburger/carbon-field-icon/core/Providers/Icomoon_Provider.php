<?php

namespace Carbon_Field_Icon\Providers;

class Icomoon_Provider implements Icon_Provider_Interface {
	const VERSION = '1.0.0';

/**
	 * Enqueue assets in the backend.
	 *
	 * @access public
	 *
	 * @return void
	 */
	public function enqueue_assets() {
		$root_uri = \Carbon_Fields\Carbon_Fields::directory_to_url( \Carbon_Field_Icon\DIR );
		wp_enqueue_style(
			'fontawesome',
			// '//use.fontawesome.com/releases/' . static::VERSION . '/css/all.css',
			$root_uri . '/build/icomoon.css',
			[],
			static::VERSION
		);
	}

	/**
	 * Get the provider options.
	 *
	 * @access public
	 *
	 * @return array
	 */
	public function parse_options() {
		$options = [];

		$icons = json_decode( file_get_contents( \Carbon_Field_Icon\DIR . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'icomoon.json' ), true );

		foreach ( $icons as $icon ) {
			$value = $icon['id'];

			$options[ $value ] = array(
				'value'        => $value,
				'name'         => $icon['name'],
				'class'        => "icon-" . $icon['id'],
				'search_terms' => $icon['search_terms'],
				'provider'     => 'icomoon',
			);
		}

		return $options;
	}
}
