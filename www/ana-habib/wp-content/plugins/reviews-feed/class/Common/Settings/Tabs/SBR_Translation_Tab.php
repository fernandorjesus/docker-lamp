<?php

namespace SmashBalloon\Reviews\Common\Settings\Tabs;

use SmashBalloon\Reviews\Common\Util;
use Smashballoon\Customizer\V2\SB_SettingsPage_Tab;

/**
 * Class Feeds Settings Tab
 *
 * @since 1.0
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class SBR_Translation_Tab extends SB_SettingsPage_Tab {

    /**
     * Get the Settings Tab info
     *
     * @since 1.0
     *
     * @return array
     */
    protected function tab_info()
    {
        return [
            'id' => 'sb-translation-tab',
            'name' => __('Language & Translation', 'sb-customizer')
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
            'localization_section' => [
                'id' => 'localization',
                'type' => 'select',
                'heading' => __('Language', 'sb-customizer'),
                'info' => sprintf(
                    __('Change the displayed language for all feeds and its displayed reviews. You can override this for each feed from the individual feed settings.%sLearn more%s <br/>
                    %sNote: Currently only Google support translated reviews.%s', 'sb-customizer'),
                    '<a href="https://smashballoon.com/doc/language-reviews-feed/" target="_blank" rel="noreferrer" >',
                    '</a>',
                    '<span class="sb-notice sb-notice-control sb-notice-default sb-text-tiny" style="padding: 0 12px; margin-top: 7px; width: auto;">',
                    '</span>'
                ),
                'options' => Util::get_translation_languages(),
                'inputLeadingIcon'  => 'translate',
                'separator' => true
            ],
            'translation_section' => [
                'type' => 'translation',
                'id' => 'translations',
                'layout' => 'full',
                'heading' => __('Custom Text/Translate', 'sb-customizer'),
                'description' => __('Enter custom text for the words below, or translate it into the language you would like to use.', 'sb-customizer'),
                'sections' => [
                    [
                        'heading' => __('Dates', 'sb-customizer'),
                        'elements' => [
                            [
                                'id' => 'writeReview',
                                'text' => __('Write a Review', 'sb-customizer'),
                                'description' => __('Used for header “Write a Review” button', 'sb-customizer'),
                            ],
                            [
                                'id' => 'second',
                                'text' => __('second', 'sb-customizer'),
                                'description' => __('Used for “Posted a second ago”', 'sb-customizer'),
                            ],
                            [
                                'id' => 'seconds',
                                'text' => __('seconds', 'sb-customizer'),
                                'description' => __('Used for “Posted a seconds ago”', 'sb-customizer'),
                            ],
                            [
                                'id' => 'minute',
                                'text' => __('minute', 'sb-customizer'),
                                'description' => __('Used for “Posted a minute ago”', 'sb-customizer'),
                            ],
                            [
                                'id' => 'minutes',
                                'text' => __('minutes', 'sb-customizer'),
                                'description' => __('Used for “Posted a minutes ago”', 'sb-customizer'),
                            ],
                            [
                                'id' => 'hour',
                                'text' => __('hour', 'sb-customizer'),
                                'description' => __('Used for “Posted a hour ago”', 'sb-customizer'),
                            ],
                            [
                                'id' => 'hours',
                                'text' => __('hours', 'sb-customizer'),
                                'description' => __('Used for “Posted a hours ago”', 'sb-customizer'),
                            ],
                            [
                                'id' => 'day',
                                'text' => __('day', 'sb-customizer'),
                                'description' => __('Used for “Posted a day ago”', 'sb-customizer'),
                            ],
                            [
                                'id' => 'days',
                                'text' => __('days', 'sb-customizer'),
                                'description' => __('Used for “Posted a days ago”', 'sb-customizer'),
                            ],
                            [
                                'id' => 'week',
                                'text' => __('week', 'sb-customizer'),
                                'description' => __('Used for “Posted a week ago”', 'sb-customizer'),
                            ],
                            [
                                'id' => 'weeks',
                                'text' => __('weeks', 'sb-customizer'),
                                'description' => __('Used for “Posted a weeks ago”', 'sb-customizer'),
                            ],
                            [
                                'id' => 'month',
                                'text' => __('month', 'sb-customizer'),
                                'description' => __('Used for “Posted a month ago”', 'sb-customizer'),
                            ],
                            [
                                'id' => 'months',
                                'text' => __('months', 'sb-customizer'),
                                'description' => __('Used for “Posted a months ago”', 'sb-customizer'),
                            ],
                            [
                                'id' => 'year',
                                'text' => __('year', 'sb-customizer'),
                                'description' => __('Used for “Posted a year ago”', 'sb-customizer'),
                            ],
                            [
                                'id' => 'years',
                                'text' => __('years', 'sb-customizer'),
                                'description' => __('Used for “Posted a years ago”', 'sb-customizer'),
                            ],
                            [
                                'id' => 'ago',
                                'text' => __('ago', 'sb-customizer'),
                                'description' => __('Used for “Posted a XXX ago”', 'sb-customizer'),
                            ]
                        ]
                    ]
                ]
            ]
        ];
    }

}