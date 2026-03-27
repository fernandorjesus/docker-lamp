<?php

/**
 *
 * @package templates/default
 */

use Duplicator\Installer\Core\InstState;

defined('ABSPATH') || defined('DUPXABSPATH') || exit;

if (InstState::instTypeAvailable(InstState::TYPE_MSUBDOMAIN)) {
    $instTypeClass = 'install-type-' . InstState::TYPE_MSUBDOMAIN;
    $title         = 'Install - Multisite-Subdomain';
} elseif (InstState::instTypeAvailable(InstState::TYPE_MSUBFOLDER)) {
    $instTypeClass = 'install-type-' . InstState::TYPE_MSUBFOLDER;
    $title         = 'Install - Multisite-Subfolder ';
} else {
    return;
}

$overwriteMode = (InstState::getInstance()->getMode() === InstState::MODE_OVR_INSTALL);
$display       = InstState::getInstance()->isInstType(
    array(
        InstState::TYPE_MSUBDOMAIN,
        InstState::TYPE_MSUBFOLDER,
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
                        This is a full multisite installation, all sites in the network will be extracted and installed.
                    </div>

                    <?php dupxTplRender('pages-parts/step1/info-tabs/overviews/overwrite-message'); ?>
                </td>
            </tr>
            <tr>
                <td>Mode:</td>
                <td>
                    <?php echo InstState::getInstance()->getHtmlModeHeader(); ?>
                    <?php dupxTplRender('pages-parts/step1/info-tabs/overviews/no-db-actions-message'); ?>
                </td>
            </tr>
        </table>
    </div>
</div>
