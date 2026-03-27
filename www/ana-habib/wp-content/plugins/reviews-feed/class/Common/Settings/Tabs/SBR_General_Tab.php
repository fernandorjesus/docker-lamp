<?php

namespace SmashBalloon\Reviews\Common\Settings\Tabs;

use Smashballoon\Customizer\V2\SB_SettingsPage_Tab;

/**
 * Class General Settings Tab
 *
 * @since 1.0
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class SBR_General_Tab extends SB_SettingsPage_Tab {

    /**
     * Get the Settings Tab info
     *
     * @since 1.0
     *
     * @return array
     */
    protected function tab_info(){
        return [
            'id' => 'sb-general-tab',
            'name' => __( 'General', 'sb-customizer' )
        ];
    }

    /**
     * Get the Settings Tab Section
     *
     * @since 1.0
     *
     * @return array
     */
    protected function tab_sections(){
        return [
            'licensekey_section' => [
                'type' => 'licensekey',
                'heading' => __('License Key', 'sb-customizer'),
                'isProSetting' => true,
                'description' => __('Your license key provides access to updates and support', 'sb-customizer'),
                'separator' => true
            ],

            'licensekeyfree_section' => [
                'type' => 'licensekeyfree',
                'heading' => __('License Key', 'sb-customizer'),
                'isFreeSetting' => true,
                'description' => __('Your license key provides access to updates and support', 'sb-customizer'),
                'separator' => true
            ],

            'sources_section' => [
                'heading' => __('Manage Sources', 'sb-customizer'),
                'inputDescription' => __('Add or remove connected accounts', 'sb-customizer'),
                'type' => 'sources',
            ],
            'apikeys_section' => [
                'heading' => __('Manage API Keys', 'sb-customizer'),
                'type' => 'apikeys',
                'inputDescription' => __('Update or modify an API key', 'sb-customizer'),
                'separator' => true
            ],

            'preservesettings_section' => [
                'id'        => 'preserve_settings',
                'type'      => 'switcher',
                'heading'   => __('Preserve settings if plugin is removed', 'sb-customizer'),
                'info'      => __('This will make sure that all of your feeds and settings are still saved even if the plugin is uninstalled', 'sb-customizer'),
                'options' => [
                    'enabled' => true,
                    'disabled' => false
                ],
                'separator' => true
            ],

            'importfeed_section' => [
                'heading' => __('Import Feed Settings', 'sb-customizer'),
                'type' => 'importfeed',
                'info'      => __('You will need a JSON file previously exported from the Reviews Feed Plugin','sb-customizer')
            ],
            'exportfeed_section' => [
                'heading' => __('Export Feed Settings', 'sb-customizer'),
                'type' => 'exportfeed',
                'info'      => __('Export settings for one or more of your feeds','sb-customizer'),
                'separator' => true
            ],
        ];
    }
}
