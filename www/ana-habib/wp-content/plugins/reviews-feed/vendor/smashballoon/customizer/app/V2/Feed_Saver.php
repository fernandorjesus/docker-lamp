<?php
/**
 * Customier Feed Saver
 *
 * @since 1.0
 */

namespace Smashballoon\Customizer\V2;

class Feed_Saver {

    /**
     * @var int
     *
     * @since 1.0
     */
    private $insert_id;

    /**
     * @var array
     *
     * @since 1.0
     */
    private $data;

    /**
     * @var array
     *
     * @since 1.0
     */
    private $sanitized_and_sorted_data;

    /**
     * @var array
     *
     * @since 1.0
     */
    private $feed_db_data;


    /**
     * @var string
     *
     * @since 1.0
     */
    private $feed_name;

    /**
     * @var bool
     *
     * @since 1.0
     */
    private $is_legacy;

    private $db;
    /**
     * @var ProxyProvider
     */
    private $proxy_provider;

    /**
     * SBY_Feed_Saver constructor.
     *
     * @since 2.0
     */
    public function __construct(DB $db, ProxyProvider $proxy_provider){
        $this->db = $db;
        $this->proxy_provider = $proxy_provider;
    }

    public function set_feed_id($insert_id){
        if ($insert_id === 'legacy') {
            $this->is_legacy = true;
            $this->insert_id = 0;
        }
        else {
            $this->is_legacy = false;
            $this->insert_id = $insert_id;
        }
    }

    /**
     * Feed insert ID if it exists
     *
     * @return bool|int
     *
     * @since 1.0
     */
    public function get_feed_id(){
        if ($this->is_legacy) {
            return 'legacy';
        }
        if (!empty($this->insert_id)) {
            return $this->insert_id;
        }
        else {
            return false;
        }
    }

    /**
     * @param array $data
     *
     * @since 1.0
     */
    public function set_data($data){
        $this->data = $data;
    }

    /**
     * @param string $feed_name
     *
     * @since 1.0
     */
    public function set_feed_name($feed_name){
        $this->feed_name = $feed_name;
    }

    /**
     *
     * @return array
     *
     * @since 1.0
     */
    public function get_feed_db_data(){
        return $this->feed_db_data;
    }

    /**
     * Adds a new feed if there is no associated feed
     * found. Otherwise updates the exiting feed.
     *
     * @return false|int
     *
     * @since 1.0
     */
    public function update_or_insert(){
        $this->sanitize_and_sort_data();

        if ($this->exists_in_database()) {
            return $this->update();
        }
        else {
            return $this->insert();
        }
    }

    /**
     * Whether or not a feed exists with the
     * associated insert ID
     *
     * @return bool
     *
     * @since 1.0
     */
    public function exists_in_database(){
        if ($this->is_legacy) {
            return true;
        }

        if ($this->insert_id === false) {
            return false;
        }

        $args = array(
            'id' => $this->insert_id,
        );

        $results = $this->db->feeds_query($args);

        return isset($results[0]);
    }

    /**
     * Inserts a new feed from sanitized and sorted data.
     * Some data is saved in the sbi_feeds table and some is
     * saved in the sbi_feed_settings table.
     *
     * @return false|int
     *
     * @since 1.0
     */
    public function insert(){
        if ($this->is_legacy) {
            return $this->update();
        }

        if (!isset($this->sanitized_and_sorted_data)) {
            return false;
        }

        $settings_array = self::format_settings($this->sanitized_and_sorted_data['feed_settings']);

        $this->sanitized_and_sorted_data['feeds'][] = array(
            'key' => 'settings',
            'values' => array(json_encode($settings_array)),
        );

        if (!empty($this->feed_name)) {
            $this->sanitized_and_sorted_data['feeds'][] = array(
                'key' => 'feed_name',
                'values' => array($this->feed_name),
            );
        }

        $this->sanitized_and_sorted_data['feeds'][] = array(
            'key' => 'status',
            'values' => array('publish'),
        );

        $insert_id = $this->db->feeds_insert($this->sanitized_and_sorted_data['feeds']);

        if ($insert_id) {
            $this->insert_id = $insert_id;

            return $insert_id;
        }

        return false;
    }

    /**
     * Updates an existing feed and related settings from
     * sanitized and sorted data.
     *
     * @return false|int
     *
     * @since 1.0
     */
    public function update(){
        if (!isset($this->sanitized_and_sorted_data)) {
            return false;
        }

        $args = array(
            'id' => $this->insert_id,
        );

        $settings_array = self::format_settings($this->sanitized_and_sorted_data['feed_settings']);

        if ($this->is_legacy) {

            $to_save_json = json_encode($settings_array);
            update_option('sbi_legacy_feed_settings', $to_save_json, false);
            return true;
        }

        $this->sanitized_and_sorted_data['feeds'][] = array(
            'key' => 'settings',
            'values' => array(json_encode($settings_array)),
        );

        $this->sanitized_and_sorted_data['feeds'][] = array(
            'key' => 'feed_name',
            'values' => array(sanitize_text_field($this->feed_name)),
        );

        $success = $this->db->feeds_update($this->sanitized_and_sorted_data['feeds'], $args);

        return $success;
    }

    /**
     * Converts settings that have been sanitized into an associative array
     * that can be saved as JSON in the database
     *
     * @param $raw_settings
     *
     * @return array
     *
     * @since 1.0
     */
    public static function format_settings($raw_settings){
        $settings_array = array();
        foreach ($raw_settings as $single_setting) {
            if (count($single_setting['values']) > 1) {
                $settings_array[$single_setting['key']] = $single_setting['values'];

            }
            else {
                $settings_array[$single_setting['key']] = isset($single_setting['values'][0]) ? $single_setting['values'][0] : '';
            }
        }

        return $settings_array;
    }
    /**
	 * Retrieves and organizes feed setting data for easy use in
	 * the builder
	 *
	 * @return array|bool
	 *
	 * @since 2.0
	 */
	public function get_feed_settings(){
        if (empty($this->insert_id)) {
            return false;
        }
        else {
            $args = array(
                'id' => $this->insert_id,
            );
            $settings_db_data = $this->db->feeds_query($args);
            if (false === $settings_db_data || sizeof($settings_db_data) === 0) {
                return false;
            }
            $this->feed_db_data = array(
                'id' => $settings_db_data[0]['id'],
                'feed_name' => $settings_db_data[0]['feed_name'],
                'feed_title' => $settings_db_data[0]['feed_title'],
                'status' => $settings_db_data[0]['status'],
                'last_modified' => $settings_db_data[0]['last_modified'],
                'feed_style' => isset( $settings_db_data[0]['feed_style'] ) ? $settings_db_data[0]['feed_style'] : '',

            );

            $return = json_decode($settings_db_data[0]['settings'], true);
            $return['feed_name'] = $settings_db_data[0]['feed_name'];
            $return['feed_style'] = isset($settings_db_data[0]['feed_style']) ? $settings_db_data[0]['feed_style'] : '';
        }

        $return = wp_parse_args( $return, sbr_settings_defaults() );

        if (empty($return['id'])) {
            return $return;
        }

        /*
        $args = array('id' => $return['id']);

        $source_query = DB::source_query($args);

        $return['sources'] = array();

        if (!empty($source_query)) {

            foreach ($source_query as $source) {
                $user_id = $source['account_id'];
                $return['sources'][$user_id] = self::get_processed_source_data($source);
            }
        }
        else {
            $found_sources = array();

            foreach ($return['id'] as $id_or_slug) {
                $maybe_source_from_connected = SBY_Source::maybe_one_off_connected_account_update($id_or_slug);

                if ($maybe_source_from_connected) {
                    $found_sources[] = $maybe_source_from_connected;
                }
            }

            if (!empty($found_sources)) {
                foreach ($found_sources as $source) {
                    $user_id = $source['account_id'];
                    $return['sources'][$user_id] = self::get_processed_source_data($source);

                }
            }
            else {

                $source_query = DB::source_query($args);

                if (isset($source_query[0])) {
                    $source = $source_query[0];

                    $user_id = $source['account_id'];

                    $return['sources'][$user_id] = self::get_processed_source_data($source);
                }
            }
        }
        */

        return $return;
    }

    /**
     * Retrieves and organizes feed setting data for easy use in
     * the builder
     * It will NOT get the settings from the DB, but from the Customizer builder
     * To be used for updating feed preview on the fly
     *
     * @return array|bool
     *
     * @since 1.0
     */
    public function get_feed_settings_preview($settings_db_data){
        if (false === $settings_db_data || sizeof($settings_db_data) === 0) {
            return false;
        }
        $return = $settings_db_data;
        $return = wp_parse_args($return, self::settings_defaults());
        if (empty($return['sources'])) {
            return $return;
        }
        $sources = array();
        foreach ($return['sources'] as $single_source) {
            array_push($sources, $single_source['account_id']);
        }
        $args = array('id' => $sources);
        $source_query = $this->db->source_query($args);

        $return['sources'] = array();
        if (!empty($source_query)) {
            foreach ($source_query as $source) {
                $user_id = $source['account_id'];
                $return['sources'][$user_id] = self::get_processed_source_data($source);
            }
        }

        return $return;
    }

    /**
	 * Default settings, $return_array equalling false will return
	 * the settings in the general way that the "SBI_Shortcode" class,
	 * "sbi_get_processed_options" method does
	 *
	 * @param bool $return_array
	 *
	 * @return array
	 *
	 * @since 1.0
	 */
	public static function settings_defaults( $return_array = true ) {
		{
			$defaults = array();

			$defaults = self::filter_defaults( $defaults );

			// some settings are comma separated and not arrays when the feed is created
			if ( $return_array ) {
				$settings_with_multiples = array(
					'sources',
				);

				foreach ( $settings_with_multiples as $multiple_key ) {
					if ( isset( $defaults[ $multiple_key ] ) ) {
						$defaults[ $multiple_key ] = explode( ',', $defaults[ $multiple_key ] );
					}
				}
			}

			return $defaults;
		}
	}

	/**
	 * Provides backwards compatibility for extensions
	 *
	 * @param array $defaults
	 *
	 * @return array
	 *
	 * @since 1.0
	 */
	public static function filter_defaults( $defaults ) {
		return $defaults;
	}

	/**
	 * Used for taking raw post data related to settings
	 * an sanitizing it and sorting it to easily use in
	 * the database tables
	 *
	 * @since 1.0
	 */
	private function sanitize_and_sort_data() {
		$data = $this->data;

		$sanitized_and_sorted = array(
			'feeds'         => array(),
			'feed_settings' => array(),
		);

		foreach ( $data as $key => $value ) {

			$data_type        = $this->get_data_type( $key );
			$sanitized_values = array();
			if ( is_array( $value ) ) {
				foreach ( $value as $item ) {
					$type               = $this->is_boolean( $item ) ? 'boolean' : $data_type['sanitization'];
					$sanitized_values[] = $this->sanitize( $type, $item );
				}
			} else {
				$type               = $this->is_boolean( $value ) ? 'boolean' : $data_type['sanitization'];
				$sanitized_values[] = $this->sanitize( $type, $value );
			}

			$single_sanitized = array(
				'key'    => $key,
				'values' => $sanitized_values,
			);

			$sanitized_and_sorted[ $data_type['table'] ][] = $single_sanitized;
		}

		$this->sanitized_and_sorted_data = $sanitized_and_sorted;
	}

	/**
	 * Determines what table and sanitization should be used
	 * when handling feed setting data.
	 *
	 * TODO: Add settings that need something other than sanitize_text_field
	 *
	 * @param string $key
	 *
	 * @return array
	 *
	 * @since 1.0
	 */
	private function get_data_type( $key ) {
		switch ( $key ) {
			case 'feed_name':
			case 'status':
			case 'feed_title':
				$return = array(
					'table'        => 'feeds',
					'sanitization' => 'sanitize_text_field',
				);
				break;
			case 'author':
				$return = array(
					'table'        => 'feeds',
					'sanitization' => 'int',
				);
				break;
			default:
				$return = array(
					'table'        => 'feed_settings',
					'sanitization' => 'sanitize_text_field',
				);
				break;
		}

		return $return;
	}

	/**
	 * Check if boolean
	 * for a value
	 *
	 * @param string $type
	 * @param int|string $value
	 *
	 * @return int|string
	 *
	 * @since 1.0
	 */
	private function is_boolean( $value ) {
		return $value === 'true' || $value === 'false' || is_bool( $value );
	}

	private function cast_boolean( $value ) {
		return $value === 'true' || $value === true || $value === 'on';
	}

	/**
	 * Uses the appropriate sanitization function and returns the result
	 * for a value
	 *
	 * @param string $type
	 * @param int|string $value
	 *
	 * @return int|string
	 *
	 * @since 1.0
	 */
	private function sanitize( $type, $value ) {
		switch ( $type ) {
			case 'int':
				$return = (int) $value;
				break;
			case 'boolean':
				$return = $this->cast_boolean( $value );
				break;
			default:
				$return = sanitize_text_field( $value );
				break;
		}

		return $return;
	}

	/**
	 * Returns an associate array of all existing sources along with their data
	 *
	 * @param int $page
	 *
	 * @return array
	 *
	 * @since 1.0
	 */

	public function get_source_list( $page = 1 ) {
		$args['page'] = $page;
		return $this->db->source_query( $args );
	}

}