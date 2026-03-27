<?php

/**
 *
 * @package templates/default
 */

use Duplicator\Installer\Core\InstState;

defined('ABSPATH') || defined('DUPXABSPATH') || exit;

if (InstState::instTypeAvailable(InstState::TYPE_SINGLE_ON_SUBDOMAIN)) {
    $instTypeClass = 'install-type-' . InstState::TYPE_SINGLE_ON_SUBDOMAIN;
    $title         = 'Install - Archive Single Site into Subdomain Multisite';
} elseif (InstState::instTypeAvailable(InstState::TYPE_SINGLE_ON_SUBFOLDER)) {
    $instTypeClass = 'install-type-' . InstState::TYPE_SINGLE_ON_SUBFOLDER;
    $title         = 'Install - Archive Single Site into Subfolder Multisite';
} else {
    return;
}

$display = InstState::getInstance()->isInstType(
    array(
        InstState::TYPE_SINGLE_ON_SUBDOMAIN,
        InstState::TYPE_SINGLE_ON_SUBFOLDER,
    )
);
?>
<div class="overview-description <?php echo $instTypeClass . ($display ? '' : ' no-display'); ?>">
    <div class="details">
        <table>
            <tr>
                <td>Status:</td>
                <td>
                    <b><?php echo $title; ?></b>
                    <div class="overview-subtxt-1">
                        This installation will insert the package site into the current multisite installation.
                    </div>
                </td>
            </tr>
            <tr>
                <td>Mode:</td>
                <td>Custom</td>
            </tr>
        </table>
    </div>
</div>
