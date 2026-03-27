<?php

namespace Smashballoon\Customizer\V2;

/**
 * Class Customizer Settings Tab
 *
 * @since 1.0
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

abstract class SB_SettingsPage_Tab {


     /**
     * Get the Settings Tab
     * Merge Both Tab Info + Tab Sections
     *
     * @since 1.0
     *
     * @return array
     */
    function get_tab(){
        $tab = array_merge(
            $this->tab_info(),
            [
                'sections'	=> $this->tab_sections()
            ]
        );

        return $tab;
    }

    /**
     * Get the Settings Tab info
     *
     * @since 1.0
     *
     * @return array
     */
    abstract protected function tab_info();


    /**
     * Get the Settings Tab Sections
     *
     * @since 1.0
     *
     * @return array
     */
    abstract protected function tab_sections();

}
