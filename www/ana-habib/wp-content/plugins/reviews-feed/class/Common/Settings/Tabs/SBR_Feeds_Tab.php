<?php

namespace SmashBalloon\Reviews\Common\Settings\Tabs;

use Smashballoon\Customizer\V2\SB_SettingsPage_Tab;

/**
 * Class Feeds Settings Tab
 *
 * @since 1.0
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class SBR_Feeds_Tab extends SB_SettingsPage_Tab {

    /**
     * Get the Settings Tab info
     *
     * @since 1.0
     *
     * @return array
     */
    protected function tab_info(){
        return [
            'id' => 'sb-feeds-tab',
            'name' => __('Feeds', 'sb-customizer')
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
            'caching_section' => [
                'type' => 'caching',
                'heading' => __('Caching', 'sb-customizer'),
            ],
            'gdpr_section' => [
                'id' => 'gdpr',
                'type' => 'select',
                'heading' => __('GDPR', 'sb-customizer'),
                'info' => sprintf(
                        __('We will automatically enable GDPR compliance if we detect a supported privacy consent plugin.%sLearn more%s.', 'sb-customizer'),
                        '<a href="https://smashballoon.com/gdpr-compliant/?reviews&utm_campaign=reviews-free&utm_source=settings&utm_medium=gdpr-link" target="_blank" rel="noreferrer" >',
                        '</a>'
                ),
                'options' => [
                    'auto' => __('Automatic', 'sb-customizer'),
                    'yes' => __('Yes', 'sb-customizer'),
                    'no' => __('No', 'sb-customizer')
                ],
                'separator' => true
            ],
        ];
    }
}