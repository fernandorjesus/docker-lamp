<?php

/**
 *
 * @package templates/default
 */

use Duplicator\Installer\Core\InstState;

defined('ABSPATH') || defined('DUPXABSPATH') || exit;

if (InstState::instTypeAvailable(InstState::TYPE_STANDALONE)) {
    $instTypeClass = 'install-type-' . InstState::TYPE_STANDALONE;
} else {
    return;
}

$overwriteMode = (InstState::getInstance()->getMode() === InstState::MODE_OVR_INSTALL);
$display       = InstState::getInstance()->isInstType(InstState::TYPE_STANDALONE);
?>
<div class="overview-description <?php echo $instTypeClass . ($display ? '' : ' no-display'); ?>">
    <div class="details">
        <table>
            <tr>
                <td>Status:</td>
                <td>
                    <b>Install - Standalone Site</b>
                    <div class="overview-subtxt-1">
                        This installation converts the selected subsite into a standalone website.
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
