<?php

/**
 *
 * @package templates/default
 */

use Duplicator\Installer\Core\InstState;

defined('ABSPATH') || defined('DUPXABSPATH') || exit;

if (!InstState::isRecoveryMode()) {
    return;
}
$created     = DUPX_ArchiveConfig::getInstance()->created;
$packageLife = DUPX_ArchiveConfig::getInstance()->getPackageLife('hours');
?>
<div class="overview-description recovery">
    <div class="details">
        <table>
            <tr>
                <td>Status:</td>
                <td>
                    <h2 class="overview-install-type">Restore Backup - <?php echo InstState::installTypeToString(); ?></h2>
                    <div class="overview-subtxt-1">
                        Overwrite this site with Backup made on <b><?php echo $created; ?></b> [<?php echo $packageLife; ?> hour(s) old].
                    </div>
                    <?php dupxTplRender('pages-parts/step1/info-tabs/overviews/overwrite-message'); ?>
                </td>
            </tr>
        </table>
    </div>
</div>
