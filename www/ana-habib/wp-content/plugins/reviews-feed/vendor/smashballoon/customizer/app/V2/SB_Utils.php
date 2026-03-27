<?php

namespace Smashballoon\Customizer\V2;


/**
 * Class SB Utils
 * Class to create
 *
 * @since 1.0
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class SB_Utils {

    /**
 * Get All Icons Array
 *
 * @return array
 *
 * @since 1.0
 */
    public static function get_icons(){
        $icons = [];
        $icons_dir = SB_COMMON_ASSETS_DIR . '/sb-customizer/assets/icons';
        $icons_list = glob($icons_dir . "/*");
        foreach ($icons_list as $icon) {
            $icon_name = str_replace('.svg', '', basename($icon));
            $icons[$icon_name] = file_get_contents($icon);
        }
        return $icons;
    }

    /**
     * Get WP Pages List
     *
     * @return array
     *
     * @since 1.0
     */
    public static function get_wp_pages(){
        $pagesList = get_pages();
        $pagesResult = array();
        if (is_array($pagesList)) {
            foreach ($pagesList as $page) {
                array_push(
                    $pagesResult,
                        array(
                        'id' => $page->ID,
                        'title' => $page->post_title,
                    )
                );
            }
        }
        return $pagesResult;
    }

    /**
     * Is Production
     *
     * @return boolean
     *
     * @since 1.0
     */
    public static function is_production(){
        return true;
    }

}