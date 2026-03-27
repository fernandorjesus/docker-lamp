<?php

namespace Smashballoon\Customizer\V2;

use Smashballoon\Stubs\Services\ServiceProvider;

/**
 * Class Customizer
 * Class to create
 *
 * @since 1.0
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class Support_Builder extends ServiceProvider {
    public static function instance()
    {
        if (null === self::$instance) {
            self::$instance = Container::getInstance()->get(self::class);
            return self::$instance;
        }
        return self::$instance;
    }

    public function __construct()
    {
        $this->current_plugin = apply_filters('sb_current_plugin', $this->current_plugin);
    }

    /**
     * Entry point
     *
     * @return void
     *
     * @since 1.0
     */
    public function register()
    {
        $add_to_menu = isset($this->add_to_menu) ? $this->add_to_menu : true;

        if (is_admin() && $add_to_menu) {
            add_action('admin_menu', [$this, 'register_menu']);
        }
    }

    /**
     * Register Menu
     *
     *
     * @since 1.0
     */
    public function register_menu()
    {
        $support_builder = add_submenu_page(
            $this->menu['parent_menu_slug'],
            $this->menu['page_title'],
            $this->menu['menu_title'],
            'manage_options',
            $this->menu['menu_slug'],
            [$this, 'support_page_output'],
            3
        );
        add_action('load-' . $support_builder, [$this, 'support_enqueue_admin_scripts']);
    }

    /**
     * Enqueue Builder CSS & Script.
     *
     * Loads only for builder pages
     *
     * @since 1.0
     */
    public function support_enqueue_admin_scripts()
    {

        $support_data = [
            'ajaxHandler' => admin_url('admin-ajax.php'),
            'adminPostURL' => admin_url('post.php'),
            'iconsList' => SB_Utils::get_icons(),
            'reactScreen' => 'support'
        ];

        $support_js_file = SB_CUSTOMIZER_ASSETS . '/build/static/js/main.js';

        if (!SB_Utils::is_production()) {
            $support_js_file = "http://localhost:3000/static/js/main.js";
        } else {
            wp_enqueue_style(
                'sb-customizer-style',
                SB_CUSTOMIZER_ASSETS . '/build/static/css/main.css',
                false,
                false
            );
        }

        $support_data = array_merge($support_data, $this->custom_support_data()); //Data comming from the Actual plugin

        wp_enqueue_script(
            'sb-customizer-app',
            $support_js_file,
            null,
            false,
            true
        );

        wp_localize_script(
            'sb-customizer-app',
            'sb_customizer',
            $support_data
        );

        wp_enqueue_media();
    }

    public function custom_support_data()
    {
        return [];
    }

    /**
     * Feed Customizer Output
     *
     * @return HTML
     *
     * @since 1.0
     */
    public function support_page_output()
    {
    ?>
        <div id="sb-app" class="sb-fs"></div>
    <?php
    }

}