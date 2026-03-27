<?php

namespace SmashBalloon\Reviews\Common\Customizer\Tabs;

use Smashballoon\Customizer\V2\SB_Sidebar_Tab;
use SmashBalloon\Reviews\Common\Util;

/**
 * Class Customize Tab
 *
 * @since 1.0
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class SBR_Customize_Tab extends SB_Sidebar_Tab {

    /**
     * Get the Sidebar Tab info
     *
     * @since 1.0
     *
     * @return array
     */
    protected function tab_info(){
        return [
            'id' => 'sb-customize-tab',
            'name' => __( 'Customize', 'sb-customizer' )
        ];
    }

    /**
     * Get the Sidebar Tab Section
     *
     * @since 1.0
     *
     * @return array
     */
    protected function tab_sections(){
        return [
            'template_section' => [
                'heading'     => __('Templates', 'sb-customizer'),
                'icon'        => 'templates',
                'controls'    => self::get_templates_controls(),
                'separator' => true
            ],
            /*
            'theme_section' => [
                'heading'     => __('Theme', 'sb-customizer'),
                'icon'        => 'theme',
                'controls'    => self::get_theme_controls(),
                'separator'   => true
            ],
            */
            'layout_section' => [
                'heading'     => __('Layout', 'sb-customizer'),
                'icon'        => 'layout',
                'highlight'   => 'posts-layout',
                'controls'    => self::get_layout_controls(),
            ],
            /*
            'colorpalette_section' => [
                'heading'     => __('Color Palette', 'sb-customizer'),
                'icon'        => 'colorpalette',
                'controls'    => self::get_colorpalette_controls(),
            ],
            'typography_section' => [
                'heading'     => __('Typography', 'sb-customizer'),
                'icon'        => 'typography',
                'controls'    => self::get_typography_controls(),
                'separator'   => true
            ],
            */
            'header_section' => [
                'heading'     => __('Header', 'sb-customizer'),
                'icon'        => 'header',
                'highlight'   => 'header',
                'controls'    => self::get_header_controls()
            ],
            'reviews_section' => [
                'heading'     => __('Reviews', 'sb-customizer'),
                'icon'        => 'reviews',
                'highlight'   => 'reviews',
                'controls'    => self::get_reviews_controls()
            ],
            'loadbutton_section' => [
                'heading'     => __('Load More Button', 'sb-customizer'),
                'description' => Util::sbr_is_pro() ? '' :
                        sprintf(
                            __('Upgrade to Pro to Load posts asynchronously with Load more button. %sLearn More%s', 'reviews-feed'),
                            '<a>',
                            '</a>'
                        ),
                'icon'        => 'loadbutton',
                'highlight'   => 'loadmore-button',
                'upsellModal' => 'loadMoreModal',
                'controls'    => self::get_loadbutton_controls()
            ],



        ];
    }


    /**
     * Get Templates Controls
     *
     * @since 1.0
     *
     * @return array
     */
    public static function get_templates_controls() {
        return [
            [//Feed Template
                'type'      => 'feedtemplate',
                'id'        => 'feedTemplate'
            ]
        ];
    }

    /**
     * Get Themes Controls
     *
     * @since 1.0
     *
     * @return array
     */
    public static function get_theme_controls() {
        return [

        ];
    }

    /**
     * Get Layout Controls
     *
     * @since 1.0
     *
     * @return array
     */
    public static function get_layout_controls() {
        return [
            [//Layout Type
                'type'      => 'toggleset',
                'id'        => 'layout',
                'options'   => [
                    [
                        'value' => 'list',
                        'icon'  => 'list',
                        'label' => __( 'List', 'sb-customizer' )
                    ],
                    /*
                    [
                        'value' => 'grid',
                        'icon'  => 'grid',
                        'label' => __( 'Grid', 'sb-customizer' )
                    ],
                    */
                    [
                        'value' => 'masonry',
                        'icon'  => 'masonry',
                        'label' => __( 'Masonry', 'sb-customizer' )
                    ],
                    [
                        'value' => 'carousel',
                        'icon'  => 'carousel',
                        'label' => __( 'Carousel', 'sb-customizer' ),
                        'upsellModal' => 'carouselModal'
                    ]
                ]
            ],
            [//Spacing
                'type'      => 'group',
                'id'        => 'layout_spacing',
                'heading'   => __('Spacing', 'sb-customizer'),
                'controls'  => [
                    [
                        'type'              => 'slider',
                        'id'                => 'verticalSpacing',
                        'label'             => __('Vertical', 'sb-customizer'),
                        'labelIcon'         => 'verticalspacing',
                        'unit'              => 'px',
                        'style'             => [ '.sb-post-item-wrap' => 'margin-bottom:{{value}}px;' ]
                    ],
                    [
                        'type'              => 'slider',
                        'id'                => 'horizontalSpacing',
                        'label'             => __('Horizontal', 'sb-customizer'),
                        'condition'         => [
                            'layout' => [
                                'grid',
                                'masonry',
                                'carousel'
                            ]
                        ],
                        'labelIcon'         => 'horizontalspacing',
                        'unit'              => 'px'
                    ]

                ]
            ],
            [//Number of Reviews
                'type'      => 'group',
                'id'        => 'number_reviews',
                'heading'   => __('Number of reviews to display', 'sb-customizer'),
                'controls'  => [
                    [
                        'type'      => 'list',
                        'controls'  => [
                            [
                                'type'          => 'number',
                                'id'            => 'numPostDesktop',
                                'ajaxAction'    => 'feedFlyPreview',
                                'leadingIcon'   => 'desktop',
                                'min' => 0,
                                'max' => Util::sbr_is_pro() ? 1000 : 10
                            ],
                            [
                                'type'          => 'number',
                                'id'            => 'numPostTablet',
                                'ajaxAction'    => 'feedFlyPreview',
                                'leadingIcon'   => 'tablet',
                                'min' => 0,
                                'upsellModal' => 'moreReviewsModal'
                            ],
                            [
                                'type'          => 'number',
                                'id'            => 'numPostMobile',
                                'ajaxAction'    => 'feedFlyPreview',
                                'leadingIcon'   => 'mobile',
                                'min' => 0,
                                'upsellModal' => 'moreReviewsModal'
                            ],
                        ]
                    ],
                ]
            ],
            [//Grid Columns
                'type'      => 'group',
                'id'        => 'grid_columns',
                'heading'   => __('Columns', 'sb-customizer'),
                'condition'         => [
                    'layout' => [
                        'grid'
                    ]
                ],
                'controls'  => [
                    [
                        'type'      => 'list',
                        'controls'  => [
                            [
                                'type'          => 'number',
                                'id'            => 'gridDesktopColumns',
                                'min'           => 1,
                                'max'           => 6,
                                'leadingIcon'   => 'desktop'
                            ],
                            [
                                'type'          => 'number',
                                'id'            => 'gridTabletColumns',
                                'min'           => 1,
                                'max'           => 6,
                                'leadingIcon'   => 'tablet',
                                'upsellModal' => 'responsiveModal',
                            ],
                            [
                                'type'          => 'number',
                                'id'            => 'gridMobileColumns',
                                'min'           => 1,
                                'max'           => 6,
                                'leadingIcon'   => 'mobile',
                                'upsellModal' => 'responsiveModal',
                            ],
                        ]
                    ],
                ]
            ],
            [//Masonry Columns
                'type'      => 'group',
                'id'        => 'masonry_columns',
                'heading'   => __('Columns', 'sb-customizer'),
                'condition'         => [
                    'layout' => [
                        'masonry'
                    ]
                ],
                'controls'  => [
                    [
                        'type'      => 'list',
                        'controls'  => [
                            [
                                'type'          => 'number',
                                'id'            => 'masonryDesktopColumns',
                                'min'           => 1,
                                'max'           => 6,
                                'leadingIcon'   => 'desktop'
                            ],
                            [
                                'type'          => 'number',
                                'id'            => 'masonryTabletColumns',
                                'min'           => 1,
                                'max'           => 6,
                                'leadingIcon'   => 'tablet',
                                'upsellModal' => 'responsiveModal',
                            ],
                            [
                                'type'          => 'number',
                                'id'            => 'masonryMobileColumns',
                                'min'           => 1,
                                'max'           => 6,
                                'leadingIcon'   => 'mobile',
                                'upsellModal' => 'responsiveModal',
                            ]
                        ]
                    ],
                ]
            ],
            [//Carousel Columns & Rows
                'type'      => 'group',
                'id'        => 'carousel_columns_rows',
                'heading'   => __('Columns and Rows', 'sb-customizer'),
                'condition'         => [
                    'layout' => [
                        'carousel'
                    ]
                ],
                'controls'  => [
                    [
                        'type'      => 'list',
                        'heading'   => __('Columns', 'sb-customizer'),
                        'controls'  => [
                            [
                                'type'          => 'number',
                                'id'            => 'carouselDesktopColumns',
                                'min'           => 1,
                                'max'           => 6,
                                'leadingIcon'   => 'desktop'
                            ],
                            [
                                'type'          => 'number',
                                'id'            => 'carouselTabletColumns',
                                'min'           => 1,
                                'max'           => 6,
                                'leadingIcon'   => 'tablet',
                            ],
                            [
                                'type'          => 'number',
                                'id'            => 'carouselMobileColumns',
                                'min'           => 1,
                                'max'           => 6,
                                'leadingIcon'   => 'mobile',
                            ],
                        ]
                    ],
                    /*
                    [
                        'type'      => 'list',
                        'heading'   => __('Rows', 'sb-customizer'),
                        'controls'  => [
                            [
                                'type'          => 'number',
                                'id'            => 'carouselDesktopRows',
                                'leadingIcon'   => 'desktop',
                                'min'   => 1,
                                'max'   => 3
                            ],
                            [
                                'type'          => 'number',
                                'id'            => 'carouselTabletRows',
                                'leadingIcon'   => 'tablet',
                                'min'   => 1,
                                'max'   => 3
                            ],
                            [
                                'type'          => 'number',
                                'id'            => 'carouselMobileRows',
                                'leadingIcon'   => 'mobile',
                                'min'   => 1,
                                'max'   => 3
                            ],
                        ]
                    ],
                     */
                ]
            ],
            /*
            [//Layout Alignment
                'type'      => 'group',
                'id'        => 'layout_alignment',
                'heading'   => __('Content Alignment', 'sb-customizer'),
                'condition'         => [
                    'layout' => [
                        'grid',
                        'masonry',
                        'carousel'
                    ]
                ],
                'controls'  => [
                    [
                        'type'      => 'togglebuttons',
                        'id'        => 'contentAlignment',
                        'options'   => [
                            [
                                'value' => 'left',
                                'icon'  => 'leftalign',
                            ],
                            [
                                'value' => 'center',
                                'icon'  => 'centeralign',
                            ],
                            [
                                'value' => 'right',
                                'icon'  => 'rightalign',
                            ]
                        ]
                    ]
                ]
            ],
            */
            [//Carousel Pagination
                'type'      => 'group',
                'id'        => 'carousel_pagination',
                'heading'   => __('Pagination', 'sb-customizer'),
                'condition'         => [
                    'layout' => [
                        'carousel'
                    ]
                ],
                'controls'  => [
                    [
                        'type'          => 'select',
                        'id'            => 'carouselLoopType',
                        'layout'        => 'half',
                        'strongheading' => false,
                        'stacked'       => true,
                        'heading'       => __( 'Loop Type', 'sb-customizer' ),
                        'options'       => [
                            'rewind' => __( 'Rewind', 'sb-customizer' ),
                            'infinity' => __( 'Infinity', 'sb-customizer' )
                        ]
                    ],
                    [
                        'type'          => 'number',
                        'id'            => 'carouselIntervalTime',
                        'layout'        => 'half',
                        'strongheading' => false,
                        'stacked'       => true,
                        'heading'       => __( 'Interval Time', 'sb-customizer' ),
                        'trailingText' => 'ms',
                    ],
                    [
                        'type'      => 'checkbox',
                        'id'        => 'carouselShowArrows',
                        'label'   => __('Show Navigation Arrows', 'sb-customizer'),
                        'stacked'       => true,
                        'options'   => [
                            'enabled' => true,
                            'disabled' => false
                        ]
                    ],
                    [
                        'type'      => 'checkbox',
                        'id'        => 'carouselShowPagination',
                        'label'   => __('Show Pagination', 'sb-customizer'),
                        'stacked'       => true,
                        'options'   => [
                            'enabled' => true,
                            'disabled' => false
                        ]
                    ],
                    [
                        'type'      => 'checkbox',
                        'id'        => 'carouselEnableAutoplay',
                        'label'   => __('Enable Autoplay', 'sb-customizer'),
                        'stacked'       => true,
                        'options'   => [
                            'enabled' => true,
                            'disabled' => false
                        ]
                    ],
                ]
            ],
            [//Content Length
                'type'      => 'group',
                'id'        => 'content_lengthreviews',
                'heading'   => __('Content Length', 'sb-customizer'),
                'controls'  => [
                        [
                            'type'          => 'number',
                            'id'            => 'contentLength',
                            'trailingText'   => __('characters', 'sb-customizer'),
                        ]
                    ],
            ],
        ];
    }


    /**
     * Get Color Palette Controls
     *
     * @since 1.0
     *
     * @return array
     */
    public static function get_colorpalette_controls() {
        return [
            [//Layout Type
                'type' => 'toggleset',
                'id' => 'colorScheme',
                'options' => [
                    [
                        'value' => 'inherit',
                        'label' => __( 'Inherit from Theme', 'sb-customizer' )
                    ],
                    [
                        'value' => 'light',
                        'icon' => 'sun',
                        'label' => __( 'Light', 'sb-customizer' )
                    ],
                    [
                        'value' => 'dark',
                        'icon' => 'moon',
                        'label' => __( 'Dark', 'sb-customizer' )
                    ],
                    [
                        'value' => 'custom',
                        'icon' => 'cog',
                        'label' => __( 'Custom', 'sb-customizer' )
                    ]
            ]
            ],
        ];
    }


    /**
     * Get Typography Controls
     *
     * @since 1.0
     *
     * @return array
     */
    public static function get_typography_controls() {
        return [

        ];
    }


    /**
     * Get Header Controls
     *
     * @since 1.0
     *
     * @return array
     */
    public static function get_header_controls() {
        return [
            [
                'type'      => 'switcher',
                'id'        => 'showHeader',
                'layout'    => 'third',
                'label'     => __('Enable', 'sb-customizer'),
                'options'   => [
                    'enabled' => true,
                    'disabled' => false
                ]
            ],
            [
                'type'          => 'checkboxsection',
                'id'            => 'header_content_sections',
                'settingId'     => 'headerContent',
                'topLabel'      => __('Name', 'sb-customizer'),
                'condition'         => [
                    'showHeader' => [ true ]
                ],
                'includeTop'    => true,
                'controls'   => [
                    [//Heading Section
                        'heading'   => __('Heading', 'sb-customizer'),
                        'id'        => 'heading',
                        'highlight'   => 'heading',
                        'controls'  => [
                            [
                                'type'          => 'text',
                                'layout'        => 'third',
                                'id'            => 'headerHeadingContent',
                                'heading'       => __('Content', 'sb-customizer'),
                                'stacked'       => true,
                                'strongheading'     => false,
                                'bottom'    => -2,
                            ],
                            [//Heading Font
                                'type'      => 'font',
                                'id'        => 'headingFont',
                                'stacked'   => true,
                                'bottom'    => 10,
                                'style' => [
                                    '.sb-feed-header-heading' => '{{value}}'
                                ]
                            ],
                            [//Heading Color
                                'type'      => 'group',
                                'id'        => 'heading_color',
                                'heading'   => __('Color', 'sb-customizer'),
                                'controls'  => [
                                    [
                                        'type'              => 'colorpicker',
                                        'id'                => 'headingColor',
                                        'heading'           => __('Text', 'sb-customizer'),
                                        'layout'            => 'third',
                                        'stacked'           => true,
                                        'strongheading'     => false,
                                        'style' => [
                                            '.sb-feed-header-heading' => 'color:{{value}};'
                                        ]
                                    ]
                                ]
                            ],
                            [
                                'type' => 'separator',
                                'top' => 5,
                                'bottom' => 15,
                            ],
                            [//Heading Spacing
                                'heading' => __('Element Spacing', 'sb-customizer'),
                                'type' => 'heading',
                                'stacked' => true
                            ],
                            [
                                'type' => 'distance',
                                'distancetype' => 'padding',
                                'id' => 'headerHeadingPadding',
                                'heading' => __('Padding', 'sb-customizer'),
                                'style' => [ '.sb-feed-header-heading' => 'padding:{{value}};' ]
                            ],
                            [
                                'type' => 'distance',
                                'distancetype' => 'margin',
                                'id' => 'headerHeadingMargin',
                                'heading' => __('Margin', 'sb-customizer'),
                                'style' => [ '.sb-feed-header-heading' => 'margin:{{value}};' ]
                            ]
                        ]
                    ],
                    [//Header Button Section
                        'heading'   => __('Button', 'sb-customizer'),
                        'id'        => 'button',
                        'highlight'   => 'header-button',
                        'controls'  => [
                            [//Button Link To
                                'type'      => 'group',
                                'id'        => 'button_linkto_gr',
                                'heading'   => __('Link to', 'sb-customizer'),
                                'controls'  => [
                                    [
                                        'type'          => 'select',
                                        'id'            => 'headerButtonLinkTo',
                                        'strongheading' => false,
                                        'stacked'       => true,
                                        'options'       => [
                                            'google' => __( 'Google (Write a Review)', 'sb-customizer' ),
                                            'external' => __( 'External Link', 'sb-customizer' )
                                        ]
                                    ],
                                    [
                                        'type'          => 'text',
                                        'id'            => 'headerButtonExternalLink',
                                        'leadingText'   => 'https//',
                                        'condition'     => [
                                            'headerButtonLinkTo' => [ 'external' ]
                                        ]
                                    ],

                                ]
                            ],
                            /*
                            [//Button Icon
                                'type'      => 'group',
                                'id'        => 'button_icon_gr',
                                'heading'   => __('Icon', 'sb-customizer'),
                                'controls'  => [

                                ]
                            ],
                            */
                            [//Button Text
                                'type'      => 'group',
                                'id'        => 'button_text_gr',
                                'heading'   => __('Text', 'sb-customizer'),
                                'controls'  => [
                                    [
                                        'type'      => 'font',
                                        'id'        => 'headerButtonFont',
                                        'style'     => [ '.sb-feed-header-btn' => '{{value}}']
                                    ]
                                ]
                            ],
                            [//Button Color
                                'type'      => 'group',
                                'id'        => 'button_color_gr',
                                'heading'   => __('Color', 'sb-customizer'),
                                'controls'  => [
                                    [
                                        'type'      => 'colorpicker',
                                        'id'        => 'headerButtonColor',
                                        'stacked'   => true,
                                        'strongheading' => false,
                                        'layout'    => 'third',
                                        'heading'   => __('Text', 'sb-customizer'),
                                        'style'     => [ '.sb-feed-header-btn' => 'color:{{value}};']
                                    ],
                                    [
                                        'type'      => 'colorpicker',
                                        'id'        => 'headerButtonBg',
                                        'stacked'   => true,
                                        'strongheading' => false,
                                        'layout'    => 'third',
                                        'heading'   => __('Background', 'sb-customizer'),
                                        'style'     => [ '.sb-feed-header-btn' => 'background:{{value}};']
                                    ],
                                    [
                                        'type'      => 'colorpicker',
                                        'id'        => 'headerButtonHoverColor',
                                        'stacked'   => true,
                                        'strongheading' => false,
                                        'layout'    => 'third',
                                        'heading'   => __('Text/ Hover', 'sb-customizer'),
                                        'style'     => [ '.sb-feed-header-btn:hover' => 'color:{{value}};']
                                    ],
                                    [
                                        'type'      => 'colorpicker',
                                        'id'        => 'headerButtonHoverBg',
                                        'stacked'   => true,
                                        'strongheading' => false,
                                        'layout'    => 'third',
                                        'heading'   => __('Bg/ Hover', 'sb-customizer'),
                                        'style'     => [ '.sb-feed-header-btn:hover' => 'background:{{value}};']
                                    ]

                                ]
                            ],
                            [//Button Spacing
                                'type'      => 'group',
                                'id'        => 'button_spacing',
                                'heading'   => __('Element Spacing', 'sb-customizer'),
                                'controls'  => [
                                    [
                                        'type'              => 'distance',
                                        'distancetype'      => 'padding',
                                        'id'                => 'headerButtonPadding',
                                        'heading'           => __('Padding', 'sb-customizer'),
                                        'style'             => [ '.sb-feed-header-btn' => 'padding:{{value}};' ]
                                    ],
                                    [
                                        'type'              => 'distance',
                                        'distancetype'      => 'margin',
                                        'id'                => 'headerButtonMargin',
                                        'heading'           => __('Margin', 'sb-customizer'),
                                        'style'             => [ '.sb-feed-header-btn' => 'margin:{{value}};' ]
                                    ]

                                ]
                            ],
                        ]
                    ],
                    [
                        'heading'   => __('Average Review Rating', 'sb-customizer'),
                        'id'        => 'averagereview',
                        'highlight'   => 'header-average',
                        'upsellModal' => 'averageRatingModal',
                        'controls'  => [
                            [//Rating Text
                                'type'      => 'group',
                                'id'        => 'rating_gr',
                                'heading'   => __('Rating', 'sb-customizer'),
                                'controls'  => [
                                    [
                                        'type'      => 'font',
                                        'id'        => 'headerAvReviewFont',
                                        'style'     => [ '.sb-feed-header-rating' => '{{value}}']
                                    ]
                                ]
                            ],
                            [//Rating Text
                                'type'      => 'group',
                                'id'        => 'ratingsubtext_gr',
                                'heading'   => __('Rating Subtext', 'sb-customizer'),
                                'controls'  => [
                                    [
                                        'type'      => 'font',
                                        'id'        => 'headerAvSubtextReviewFont',
                                        'style'     => [ '.sb-feed-header-rating-subtext' => '{{value}}']
                                    ]
                                ]
                            ],
                            [//Rating Color
                                'type'      => 'group',
                                'id'        => 'button_color_gr',
                                'heading'   => __('Color', 'sb-customizer'),
                                'controls'  => [
                                    [
                                        'type'      => 'colorpicker',
                                        'id'        => 'headerAvReviewIconColor',
                                        'layout'    => 'third',
                                        'stacked'   => true,
                                        'strongheading' => false,
                                        'heading'   => __('Rating Icon', 'sb-customizer'),
                                        'style'     => [ '.sb-feed-header-rating-icons' => 'color:{{value}};']
                                    ],
                                    [
                                        'type'      => 'colorpicker',
                                        'id'        => 'headerAvReviewColor',
                                        'layout'    => 'third',
                                        'stacked'   => true,
                                        'strongheading' => false,
                                        'heading'   => __('Rating', 'sb-customizer'),
                                        'style'     => [ '.sb-feed-header-rating' => 'color:{{value}};']
                                    ],
                                    [
                                        'type'      => 'colorpicker',
                                        'id'        => 'headerAvReviewSubtextColor',
                                        'layout'    => 'third',
                                        'stacked'   => true,
                                        'strongheading' => false,
                                        'heading'   => __('Subtext', 'sb-customizer'),
                                        'style'     => [ '.sb-feed-header-rating-subtext' => 'color:{{value}};']
                                    ]
                                ]
                            ],
                            [//Rating Spacing
                                'type'      => 'group',
                                'id'        => 'rating_spacing',
                                'heading'   => __('Element Spacing', 'sb-customizer'),
                                'controls'  => [
                                    [
                                        'type'              => 'distance',
                                        'distancetype'      => 'padding',
                                        'id'                => 'headerAvReviewPadding',
                                        'heading'           => __('Padding', 'sb-customizer'),
                                        'style'             => [ '.sb-feed-header-bottom' => 'padding:{{value}};' ]
                                    ],
                                    [
                                        'type'              => 'distance',
                                        'distancetype'      => 'margin',
                                        'id'                => 'headerAvReviewMargin',
                                        'heading'           => __('Margin', 'sb-customizer'),
                                        'style'             => [ '.sb-feed-header-bottom' => 'margin:{{value}};' ]
                                    ]

                                ]
                            ],
                        ]
                    ],
                ]
            ],

            [//Header Spacing
                'type' => 'group',
                'id' => 'header_spacing',
                'heading' => __('Element Header Spacing', 'sb-customizer'),
                'condition' => [
                    'showHeader' => [ true ]
                ],
                'controls' => [
                    [
                        'type' => 'distance',
                        'distancetype' => 'padding',
                        'id' => 'headerPadding',
                        'condition' => [
                            'showHeader' => [ true ]
                        ],
                        'heading' => __('Padding', 'sb-customizer'),
                        'style' => [ '.sb-feed-header' => 'padding:{{value}};' ]
                    ],
                    [
                        'type' => 'distance',
                        'distancetype' => 'margin',
                        'id' => 'headerMargin',
                        'condition' => [
                            'showHeader' => [ true ]
                        ],
                        'heading' => __('Margin', 'sb-customizer'),
                        'style' => [ '.sb-feed-header' => 'margin:{{value}};' ]
                    ]
                ]
            ],
        ];
    }


    /**
     * Get Reviews Controls
     *
     * @since 1.0
     *
     * @return array
     */
    public static function get_reviews_controls() {
        return [
                [
                    'type'              => 'section',
                    'id'                 => 'reviews_style_nested',
                    'heading'           => __('Post Style', 'sb-customizer'),
                    'icon'              => 'theme',
                    'highlight'         => 'reviews',
                    'controls'          => self::get_nested_post_style_controls(),
                ],
                [
                    'type'              => 'section',
                    'id'                 => 'reviews_individual_nested',
                    'heading'           => __('Edit Individual Elements', 'sb-customizer'),
                    'description'       => __('Hide or Show individual elements of a post or edit their options', 'sb-customizer'),
                    'icon'              => 'reviews',
                    'highlight'         => 'reviews',
                    'controls'          => self::get_nested_review_elements_controls(),
                ]
        ];
    }

    /**
     * Get Load More Button Controls
     *
     * @since 1.0
     *
     * @return array
     */
    public static function get_loadbutton_controls() {
        return [
            [
                'type'      => 'switcher',
                'id'        => 'showLoadButton',
                'layout'    => 'third',
                'label'     => __('Enable', 'sb-customizer'),
                'hidePro'   => true,
                'options'   => [
                    'enabled' => true,
                    'disabled' => false
                ]
            ],
            /*
            [//Load More Icon
                'type'      => 'group',
                'id'        => 'loadmorebutton_icon',
                'heading'   => __('Icon', 'sb-customizer'),
                'condition' => [
                    'showLoadButton' => [ true ]
                ],
                'controls'  => [
                    //ICON GOES HERE

                ]
            ],
            */[//Load More Text
                'type'      => 'group',
                'id'        => 'loadmorebutton_text',
                'heading'   => __('Text', 'sb-customizer'),
                'condition' => [
                    'showLoadButton' => [ true ]
                ],
                'controls'  => [
                    [
                        'type'              => 'text',
                        'id'                => 'loadButtonText',
                        'condition'         => [
                            'showLoadButton' => [ true ]
                        ],
                        'upsellModal' => 'loadMoreModal',
                        'heading'           => __('Text', 'sb-customizer'),
                        'headingstrong'     => false,
                        'stacked'           => true,
                        'layout'            => 'third'
                    ],
                    [
                        'type'              => 'font',
                        'id'                => 'loadButtonFont',
                        'upsellModal' => 'loadMoreModal',
                        'condition'         => [
                            'showLoadButton' => [ true ]
                        ],
                        'style'             => [ '.sb-load-button' => '{{value}}' ]
                    ],
                ]
            ],
            [//Load More Color
                'type'      => 'group',
                'id'        => 'loadmorebutton_color',
                'heading'   => __('Color', 'sb-customizer'),
                'condition' => [
                    'showLoadButton' => [ true ]
                ],
                'controls'  => [
                    [
                        'type'              => 'colorpicker',
                        'id'                => 'loadButtonColor',
                        'upsellModal'       => 'loadMoreModal',
                        'condition'         => [
                                'showLoadButton' => [ true ]
                        ],
                         'heading'          => __('Text', 'sb-customizer'),
                         'layout'           => 'third',
                         'stacked'          => true,
                         'headingstrong'    => false,
                         'style'            => [ '.sb-load-button' => 'color:{{value}};' ]
                    ],
                    [
                        'type'              => 'colorpicker',
                        'id'                => 'loadButtonBg',
                        'upsellModal' => 'loadMoreModal',
                        'condition'         => [
                                'showLoadButton' => [ true ]
                        ],
                         'heading'          => __('Text', 'sb-customizer'),
                         'layout'           => 'third',
                         'stacked'          => true,
                         'headingstrong'    => false,
                         'style'            => [ '.sb-load-button' => 'background:{{value}};' ]
                    ],
                    [
                        'type'              => 'colorpicker',
                        'id'                => 'loadButtonHoverColor',
                        'upsellModal' => 'loadMoreModal',
                        'condition'         => [
                                'showLoadButton' => [ true ]
                        ],
                         'heading'          => __('Text / Hover', 'sb-customizer'),
                         'layout'           => 'third',
                         'stacked'          => true,
                         'headingstrong'    => false,
                         'style'            => [ '.sb-load-button:hover' => 'color:{{value}};' ]
                    ],
                    [
                        'type'              => 'colorpicker',
                        'id'                => 'loadButtonHoverBg',
                        'upsellModal' => 'loadMoreModal',
                        'condition'         => [
                                'showLoadButton' => [ true ]
                        ],
                         'heading'          => __('Bg / Hover', 'sb-customizer'),
                         'layout'           => 'third',
                         'stacked'          => true,
                         'headingstrong'    => false,
                         'style'            => [ '.sb-load-button:hover' => 'background:{{value}};' ]
                    ],
                ]
            ],
            [//Load More Spacing
                'type'      => 'group',
                'id'        => 'loadmorebutton_spacing',
                'heading'   => __('Element Spacing', 'sb-customizer'),
                'condition' => [
                    'showLoadButton' => [ true ]
                ],
                'controls'  => [
                    [
                        'type'              => 'distance',
                        'distancetype'      => 'padding',
                        'id'                => 'loadButtonPadding',
                        'upsellModal'       => 'loadMoreModal',
                        'heading'           => __('Padding', 'sb-customizer'),
                        'condition'         => [
                            'showLoadButton' => [ true ]
                        ],
                        'style'             => [ '.sb-load-button' => 'padding:{{value}};' ]
                    ],
                    [
                        'type'              => 'distance',
                        'distancetype'      => 'margin',
                        'id'                => 'loadButtonMargin',
                        'upsellModal'       => 'loadMoreModal',
                        'heading'           => __('Margin', 'sb-customizer'),
                        'condition'         => [
                            'showLoadButton' => [ true ]
                        ],
                        'style'             => [ '.sb-load-button-ctn' => 'margin:{{value}};' ]
                    ]

                ]
            ],
        ];
    }

    /**
     * Get Nested Reviews Post Style Controls
     *
     * @since 1.0
     *
     * @return array
     */
    public static function get_nested_post_style_controls() {
        return [
            [
                'type'      => 'toggleset',
                'id'        => 'postStyle',
                'options'   => [
                    [
                        'value' => 'boxed',
                        'icon'  => 'post-boxed',
                        'label' => __( 'Boxed', 'sb-customizer' )
                    ],
                    [

                        'value' => 'regular',
                        'icon'  => 'regular',
                        'label' => __( 'Regular', 'sb-customizer' )
                    ]
                ]
            ],
            [
                'type'      => 'group',
                'id'        => 'reviews_boxed_background',
                'condition'	=> [
                    'postStyle' => ['boxed']
                ],
                'heading'   => __('Colors', 'sb-customizer'),
                'controls'  => [
                    [
                        'type'              => 'colorpicker',
                        'id'                => 'boxedBackgroundColor',
                        'heading'           => __('Background Color', 'sb-customizer'),
                        'condition'	=> [
                            'postStyle' => ['boxed']
                        ],
                        'stacked'           => true,
                        'strongheading'     => false,
                        'layout'            => 'half',
                        'style'             => [ '.sb-post-item-wrap' => 'background:{{value}};' ]
                    ]
                ]
            ],

            [
                'type'      => 'group',
                'id'        => 'reviews_properties',
                'heading'   => __('Properties', 'sb-customizer'),
                'controls'  => [
                    [
                        'type'      => 'boxshadow',
                        'id'        => 'boxedBoxShadow',
                        'condition'	=> [
                            'postStyle' => ['boxed']
                        ],
                        'label'     => __('Box Shadow', 'sb-customizer'),
                        'style'     => [ '.sb-post-item-wrap' => 'box-shadow:{{value}};' ]
                    ],
                    [
                        'type'      => 'borderradius',
                        'id'        => 'boxedBorderRadius',
                        'condition'	=> [
                            'postStyle' => ['boxed']
                        ],
                        'label'     => __('Corner Radius', 'sb-customizer'),
                        'style'     => [ '.sb-post-item-wrap' => 'border-radius:{{value}};' ]
                    ],
                    [
                        'type'      => 'stroke',
                        'id'        => 'postStroke',
                        'label'     => __('Stroke', 'sb-customizer'),
                        'style'     => [
                                '[data-post-style="boxed"] .sb-post-item-wrap' => 'border:{{value}};',
                                '[data-post-style="regular"] .sb-post-item-wrap' => 'border-bottom:{{value}};'
                            ]
                    ],
                ]
            ],

            [//Post Item Padding
                'type'      => 'group',
                'id'        => 'reviews_item_spacing',
                'heading'   => __('Element Spacing', 'sb-customizer'),
                'controls'  => [
                    [
                        'type'              => 'distance',
                        'distancetype'      => 'padding',
                        'id'                => 'postPadding',
                        'heading'           => __('Padding', 'sb-customizer'),
                        'style'             => [ '.sb-post-item-wrap' => 'padding:{{value}};' ]
                    ]
                ]
            ]
        ];
    }

    /**
     * Get Reviews Individual Elements Controls
     *
     * @since 1.0
     *
     * @return array
     */
    public static function get_nested_review_elements_controls() {
        return [
            [
                'type'          => 'checkboxsection',
                'id'            => 'individual_elements_sections',
                'settingId'     => 'postElements',
                'topLabel'      => __('Name', 'sb-customizer'),
                'includeTop'    => true,
                'enableSorting' => Util::sbr_is_pro() ? true : false,
                'controls'   => [
                    [//Post Rating
                        'heading'   => __('Rating', 'sb-customizer'),
                        'id'        => 'rating',
                        'highlight' => 'post-rating-icon',
                        'controls'  => [
                            [
                                'type'      => 'group',
                                'id'        => 'rating_icon',
                                'heading'   => __('Icon Color', 'sb-customizer'),
                                'controls' => [
                                    //ICON CHOOSER HERE
                                    [
                                        'type'              => 'colorpicker',
                                        'id'                => 'ratingIconColor',
                                        'heading'           => __('Color', 'sb-customizer'),
                                        'layout'            => 'third',
                                        'style'             => [ '.sb-item-rating' => 'color:{{value}}' ]
                                    ],
                                ]
                            ],

                            [//Rating Spacing
                                'type'      => 'group',
                                'id'        => 'rating_icon_spacing',
                                'heading'   => __('Element Spacing', 'sb-customizer'),
                                'controls'  => [
                                    [
                                        'type'              => 'distance',
                                        'distancetype'      => 'padding',
                                        'id'                => 'ratingIconPadding',
                                        'heading'           => __('Padding', 'sb-customizer'),
                                        'style'             => [ '.sb-item-rating' => 'padding:{{value}};' ]
                                    ],
                                    [
                                        'type'              => 'distance',
                                        'distancetype'      => 'margin',
                                        'id'                => 'ratingIconMargin',
                                        'heading'           => __('Margin', 'sb-customizer'),
                                        'style'             => [ '.sb-item-rating' => 'margin:{{value}};' ]
                                    ]
                                ]
                            ]
                        ]
                    ],
                    [//Post Review Paragraph
                        'heading'   => __('Review Paragraph', 'sb-customizer'),
                        'id'        => 'text',
                        'highlight' => 'post-text',
                        'controls'  => [
                            [//Paragraph Text Font
                                'type'      => 'group',
                                'id'        => 'text_paragraph_font',
                                'heading'   => __('Font', 'sb-customizer'),
                                'controls'  => [
                                    [
                                        'type'              => 'font',
                                        'id'                => 'paragraphFont',
                                        'style'             => [ '.sb-item-text' => '{{value}}' ]
                                    ]
                                ]
                            ],
                            [//Paragraph Text Color
                                'type'      => 'group',
                                'id'        => 'text_paragraph_color',
                                'heading'   => __('Color', 'sb-customizer'),
                                'controls'  => [
                                    [
                                        'type'              => 'colorpicker',
                                        'id'                => 'paragraphColor',
                                        'layout'            => 'third',
                                        'strongheading'     => false,
                                        'heading'           => __('Text', 'sb-customizer'),
                                        'style'             => [ '.sb-item-text' => 'color:{{value}};' ]
                                    ]
                                ]
                            ],
                            [//Paragraph Text Spacing
                                'type'      => 'group',
                                'id'        => 'text_paragraph_spacing',
                                'heading'   => __('Element Spacing', 'sb-customizer'),
                                'controls'  => [
                                    [
                                        'type'              => 'distance',
                                        'distancetype'      => 'padding',
                                        'id'                => 'paragraphPadding',
                                        'heading'           => __('Padding', 'sb-customizer'),
                                        'style'             => [ '.sb-item-text' => 'padding:{{value}};' ]
                                    ],
                                    [
                                        'type'              => 'distance',
                                        'distancetype'      => 'margin',
                                        'id'                => 'paragraphMargin',
                                        'heading'           => __('Margin', 'sb-customizer'),
                                        'style'             => [ '.sb-item-text' => 'margin:{{value}};' ]
                                    ]
                                ]
                            ]
                        ]
                    ],
                    [//Post Author Date
                        'heading'   => __('Author and Date', 'sb-customizer'),
                        'id'        => 'author',
                        'highlight' => 'post-author-date',
                        'controls'  => [
                            [
                                'type'          => 'checkboxsection',
                                'id'            => 'author_content_sections',
                                'settingId'     => 'authorContent',
                                'topLabel'      => __('Name', 'sb-customizer'),
                                'includeTop'    => true,
                                'controls'   => [
                                    [//Author Name
                                        'heading'   => __('Author Name', 'sb-customizer'),
                                        'id'        => 'name',
                                        'highlight' => 'post-author-name',
                                        'controls'  => [
                                            [//Author Font
                                                'type'      => 'group',
                                                'id'        => 'author_font',
                                                'heading'   => __('Font', 'sb-customizer'),
                                                'controls'  => [
                                                    [
                                                        'type'              => 'font',
                                                        'id'                => 'authorNameFont',
                                                        'style'             => [ '.sb-item-author-name' => '{{value}}' ]
                                                    ]
                                                ]
                                            ],
                                            [//Author Name Spacing
                                                'type'      => 'group',
                                                'id'        => 'author_name_spacing',
                                                'heading'   => __('Element Spacing', 'sb-customizer'),
                                                'controls'  => [
                                                    [
                                                        'type'              => 'distance',
                                                        'distancetype'      => 'padding',
                                                        'id'                => 'authorNamePadding',
                                                        'heading'           => __('Padding', 'sb-customizer'),
                                                        'style'             => [ '.sb-item-author-name' => 'padding:{{value}};' ]
                                                    ],
                                                    [
                                                        'type'              => 'distance',
                                                        'distancetype'      => 'margin',
                                                        'id'                => 'authorNameMargin',
                                                        'heading'           => __('Margin', 'sb-customizer'),
                                                        'style'             => [ '.sb-item-author-name' => 'margin:{{value}};' ]
                                                    ]
                                                ]
                                            ]
                                        ]
                                    ],
                                    [//Author Image
                                        'heading'   => __('Author Image', 'sb-customizer'),
                                        'id'        => 'image',
                                        'highlight' => 'post-author-image',
                                        'upsellModal' => 'authorImageModal',
                                        'controls'  => [
                                            [
                                                'type' => 'separator',
                                                'top' => 10,
                                                'bottom' => 20,
                                            ],
                                            [
                                                'type'          => 'number',
                                                'id'            => 'authorImageBorderRadius',
                                                'heading'       => __('Border Radius', 'sb-customizer'),
                                                'trailingText'  => 'px',
                                                'layout'        => 'half',
                                                'stacked'       => true,
                                                'strongheading'  => false,
                                                'bottom' => 20,
                                                'style'         => ['.sb-item-author-img img' => 'border-radius:{{value}}px;']
                                            ],
                                            [//Author Image Spacing
                                                'type'      => 'group',
                                                'id'        => 'author_image_spacing',
                                                'heading'   => __('Element Spacing', 'sb-customizer'),
                                                'controls'  => [
                                                    [
                                                        'type'              => 'distance',
                                                        'distancetype'      => 'margin',
                                                        'id'                => 'authorImageMargin',
                                                        'heading'           => __('Margin', 'sb-customizer'),
                                                        'style'             => [ '.sb-item-author-img' => 'margin:{{value}};' ]
                                                    ]
                                                ]
                                            ]
                                        ]
                                    ],
                                    [//Author Date
                                        'heading'   => __('Date', 'sb-customizer'),
                                        'id'        => 'date',
                                        'highlight' => 'post-date',
                                        'controls'  => [
                                            [//Date Font
                                                'type'      => 'group',
                                                'id'        => 'date_font',
                                                'heading'   => __('Font', 'sb-customizer'),
                                                'controls'  => [
                                                    [
                                                        'type'              => 'font',
                                                        'id'                => 'dateFont',
                                                        'style'             => [ '.sb-item-author-date' => '{{value}}' ]
                                                    ]
                                                ]
                                            ],
                                            [//Date Font
                                                'type'      => 'group',
                                                'id'        => 'date_format',
                                                'heading'   => __('Format', 'sb-customizer'),
                                                'controls'  => [
                                                    [
                                                        'type'          => 'select',
                                                        'id'            => 'dateFormat',
                                                        'stacked'       => true,
                                                        'options'       => self::get_date_format_options()
                                                    ],
                                                    [
                                                        'type'          => 'text',
                                                        'id'            => 'dateCustomFormat',
                                                        'stacked'       => true,
                                                        'condition'     => [
                                                            'dateFormat' => [ 'custom' ]
                                                        ]
                                                    ],
                                                    [
                                                        'type'          => 'text',
                                                        'id'            => 'dateBeforeText',
                                                        'heading'       => __('Add text before date', 'sb-customizer'),
                                                        'layout'        => 'half',
                                                        'stacked'       => true,
                                                        'strongheading'  => false
                                                    ],
                                                    [
                                                        'type'          => 'text',
                                                        'id'            => 'dateAfterText',
                                                        'heading'   => __('Add text after date', 'sb-customizer'),
                                                        'layout'        => 'half',
                                                        'stacked'       => true,
                                                        'strongheading'  => false
                                                    ],

                                                ]
                                            ],
                                            [//Date Spacing
                                                'type'      => 'group',
                                                'id'        => 'date_spacing',
                                                'heading'   => __('Element Spacing', 'sb-customizer'),
                                                'controls'  => [
                                                    [
                                                        'type'              => 'distance',
                                                        'distancetype'      => 'padding',
                                                        'id'                => 'datePadding',
                                                        'heading'           => __('Padding', 'sb-customizer'),
                                                        'style'             => [ '.sb-item-author-date' => 'padding:{{value}};' ]
                                                    ],
                                                    [
                                                        'type'              => 'distance',
                                                        'distancetype'      => 'margin',
                                                        'id'                => 'dateMargin',
                                                        'heading'           => __('Margin', 'sb-customizer'),
                                                        'style'             => [ '.sb-item-author-date' => 'margin:{{value}};' ]
                                                    ]
                                                ]
                                            ]
                                        ]
                                    ]

                                ]
                            ],
                            [//Author & Date Colors
                                'type'      => 'group',
                                'id'        => 'author_date_color',
                                'heading'   => __('Colors', 'sb-customizer'),
                                'controls'  => [
                                    [
                                        'type'              => 'colorpicker',
                                        'id'                => 'authorNameColor',
                                        'layout'            => 'half',
                                        'strongheading'     => false,
                                        'heading'           => __('Author Name', 'sb-customizer'),
                                        'style'             => [ '.sb-item-author-name' => 'color:{{value}};' ]
                                    ],
                                    [
                                        'type'              => 'colorpicker',
                                        'id'                => 'dateColor',
                                        'layout'            => 'half',
                                        'strongheading'     => false,
                                        'heading'           => __('Date', 'sb-customizer'),
                                        'style'             => [ '.sb-item-author-date' => 'color:{{value}};' ]
                                    ]
                                ]
                            ],
                            [//Author Content Spacing
                                'type'      => 'group',
                                'id'        => 'author_content_spacing',
                                'heading'   => __('Element Spacing', 'sb-customizer'),
                                'controls'  => [
                                    [
                                        'type'              => 'distance',
                                        'distancetype'      => 'padding',
                                        'id'                => 'authorPadding',
                                        'heading'           => __('Padding', 'sb-customizer'),
                                        'style'             => [ '.sb-item-author-ctn' => 'padding:{{value}};' ]
                                    ],
                                    [
                                        'type'              => 'distance',
                                        'distancetype'      => 'margin',
                                        'id'                => 'authorMargin',
                                        'heading'           => __('Margin', 'sb-customizer'),
                                        'style'             => [ '.sb-item-author-ctn' => 'margin:{{value}};' ]
                                    ]
                                ]
                            ]
                        ]
                    ],
                    [ //Post Media
                        'heading' => __('Images or Videos', 'sb-customizer'),
                        'id' => 'media',
                        'upsellModal' => 'reviewsMediaModal',
                        'controls' => [

                        ]
                    ]



                ]
            ],
        ];
    }

    /**
	 * Date Format Options
	 *
	 *
	 * @since 1.0
	 * @access public
	 *
	 * @return array
	*/
	public static function get_date_format_options(){
		$original = strtotime('2016-07-25T17:30:00+0000');
		return [
			'1'			=> __('2 days ago','sb-customizer'),
			'2'			=> date('F jS, g:i a', $original),
			'3'			=> date('F jS', $original),
			'4'			=> date('D F jS', $original),
			'5'			=> date('l F jS', $original),
			'6'			=> date('D M jS, Y', $original),
			'7'			=> date('l F jS, Y', $original),
			'8'			=> date('l F jS, Y - g:i a', $original),
			'9'			=> date("l M jS, 'y", $original),
			'10'		=> date('m.d.y', $original),
			'18'		=> date('m.d.y - G:i', $original),
			'11'		=> date('m/d/y', $original),
			'12'		=> date('d.m.y', $original),
			'19'		=> date('d.m.y - G:i', $original),
			'13'		=> date('d/m/y', $original),
			'14'		=> date('d-m-Y, G:i', $original),
			'15'		=> date('jS F Y, G:i', $original),
			'16'		=> date('d M Y, G:i', $original),
			'17'		=> date('l jS F Y, G:i', $original),
			'18'		=> date('Y-m-d', $original),
			'custom'	=> __('Custom','sb-customizer')
		];
	}
}