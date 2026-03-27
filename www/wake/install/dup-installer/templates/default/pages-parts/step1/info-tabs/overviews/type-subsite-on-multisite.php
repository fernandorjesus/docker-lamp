<?php

/**
 *
 * @package templates/default
 */

use Duplicator\Installer\Core\InstState;

defined('ABSPATH') || defined('DUPXABSPATH') || exit;

if (InstState::instTypeAvailable(InstState::TYPE_SUBSITE_ON_SUBDOMAIN)) {
    $instTypeClass = 'install-type-' . InstState::TYPE_SUBSITE_ON_SUBDOMAIN;
    $title         = 'Install - Selected Subsite in Subdomain Multisite';
} elseif (InstState::instTypeAvailable(InstState::TYPE_SUBSITE_ON_SUBFOLDER)) {
    $instTypeClass = 'install-type-' . InstState::TYPE_SUBSITE_ON_SUBFOLDER;
    $title         = 'Install - Selected Subsite in Subfolder Multisite';
} else {
    return;
}

$display = InstState::getInstance()->isInstType(
    array(
        InstState::TYPE_SUBSITE_ON_SUBDOMAIN,
        InstState::TYPE_SUBSITE_ON_SUBFOLDER,
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
                        This installation will insert the selected subsite of the package into the current multisite installation.
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
