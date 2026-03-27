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

class SBR_Advanced_Tab extends SB_SettingsPage_Tab {

    /**
     * Get the Settings Tab info
     *
     * @since 1.0
     *
     * @return array
     */
    protected function tab_info(){
        return [
            'id' => 'sb-advanced-tab',
            'name' => __( 'Advanced', 'sb-customizer' )
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
            'optimizeimages_section' => [
                'id'        => 'optimize_images',
                'type'      => 'switcher',
                'heading'   => __('Optimize Images', 'sb-customizer'),
                'info'      => __('It will create multiple local copies of images in different sizes and use smallest size based on where the image is being displayed', 'sb-customizer'),
                'options' => [
                    'enabled' => true,
                    'disabled' => false
                ],
                'ajaxButton'    => [
                    'icon'      => 'reset',
                    'text' => __('Reset', 'sb-customizer'),
                    'action'    => 'sbr_reset_posts',
                    'notification' => [
                        'success' => [
                            'icon' => 'success',
                            'text' => __('Images Cleared', 'sb-customizer')
                        ]
                    ]
                ]
            ],
            /*
            'reseterrorlogs_section' => [
                'heading'       => __('Reset Error Log', 'sb-customizer'),
                'info'          => __('Clear all errors stored in the error log.', 'sb-customizer'),
                'type'      => 'button',
                'ajaxButton' => [
                    'icon'      => 'reset',
                    'text'      => __('Reset', 'sb-customizer'),
                    'action'    => 'sbr_reset_errors',
                    'notification' => [
                        'success' => [
                            'icon' => 'success',
                            'text' => __('Error Log Cleared', 'sb-customizer')
                        ]
                    ]
                ]
            ],
             */
            'usagetracking_section' => [
                'id'        => 'usagetracking',
                'type'      => 'switcher',
                'heading'   => __('Usage Tracking', 'sb-customizer'),
                'info'      => sprintf(
                    __('This helps us prevent plugin and theme conflicts by sending a report in the background once per week about your settings and relevant site stats. It does not send sensitive information like access tokens, email addresses, or user info. This will not affect your site performace as well. %sLearn More%s', 'sb-customizer'),
                    '<a href="https://smashballoon.com/doc/usage-tracking-reviews/" target="_blank" rel="noopener noreferrer">', '</a>' ),
                'options' => [
                    'enabled' => true,
                    'disabled' => false
                ],
                'separator' => true
            ],

            'enquejs_section' => [
                'id'        => 'enqueue_js_in_header',
                'type'      => 'switcher',
                'heading'   => __('Enqueue JavaScript in head', 'sb-customizer'),
                'info'      => __('Add the JavaScript file for the plugin in the header instead of the footer', 'sb-customizer'),
                'options' => [
                    'enabled' => true,
                    'disabled' => false
                ]
            ],
            /*
            'adminnoticeerror_section' => [
                'id'        => 'admin_error_notices',
                'type'      => 'switcher',
                'heading'   => __('Admin Error Notice', 'sb-customizer'),
                'info'      => __('This will disable or enable the feed error notice that displays in the bottom right corner for admins on the front end of your site.', 'sb-customizer'),
                'options' => [
                    'enabled' => true,
                    'disabled' => false
                ]
            ],
            'feedissuereports_section' => [
                'id'        => 'feed_issue_reports',
                'type'      => 'switcher',
                'heading'   => __('Feed Issue Email Reports', 'sb-customizer'),
                'info'      => __('If the feed is down due to a critical issue, we will switch to a cached version and notify you based on these settings. View Documentation', 'sb-customizer'),
                'options' => [
                    'enabled' => true,
                    'disabled' => false
                ],
                'separator' => true
            ],
             */

        ];
    }
}