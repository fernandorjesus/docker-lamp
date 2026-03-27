<?php

/**
 *
 * @package templates/default
 */

use Duplicator\Installer\Core\InstState;

defined('ABSPATH') || defined('DUPXABSPATH') || exit;

if (InstState::instTypeAvailable(InstState::TYPE_SINGLE)) {
    $instTypeClass = 'install-type-' . InstState::TYPE_SINGLE;
} else {
    return;
}

$display = InstState::getInstance()->isInstType(InstState::TYPE_SINGLE);
?>
<div class="overview-description <?php echo $instTypeClass . ($display ? '' : ' no-display'); ?>">
    <div class="details">
        <table>
            <tr>
                <td>Status:</td>
                <td>
                    <b>Install - Single Site</b>
                    <div class="overview-subtxt-1">
                        This will perform the installation of a single WordPress site.
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
