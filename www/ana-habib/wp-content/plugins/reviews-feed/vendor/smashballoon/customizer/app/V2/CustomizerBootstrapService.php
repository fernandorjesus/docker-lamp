<?php

namespace Smashballoon\Customizer\V2;

use Smashballoon\Stubs\Services\ServiceProvider;

/**
 * Class Settings Tab
 *
 * @since 1.0
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class CustomizerBootstrapService extends ServiceProvider {

    public function register()
    {
        $this->register_constants();
    }

    private function register_constants()
    {
        // Plugin Version
        if (!defined('SBCUSVER')) {
            define('SBCUSVER', '1.0');
        }

        // Plugin Version
        if (!defined('SBCUSVER')) {
            define('SBCUSVER', '1.0');
        }

        //Feed Locator
        if (!defined('SB_FEED_LOCATOR')) {
            define('SB_FEED_LOCATOR', 'sb_feed_locator');
        }

        //Feed Table
        if (!defined('SB_FEEDS_TABLE')) {
            define('SB_FEEDS_TABLE', 'sb_feeds');
        }

        //Feed Sources
        if (!defined('SB_SOURCES_TABLE')) {
                define('SB_SOURCES_TABLE', 'sb_sources');
        }

        //Feed Caches
        if (!defined('SB_FEED_CACHES_TABLE')) {
            define('SB_FEED_CACHES_TABLE', 'sb_feed_caches');
        }

    }
}