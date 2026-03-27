<?php

/**
 *
 * @package templates/default
 */

use Duplicator\Installer\Core\InstState;

defined('ABSPATH') || defined('DUPXABSPATH') || exit;

if (InstState::instTypeAvailable(InstState::TYPE_RBACKUP_SINGLE)) {
    $instTypeClass = 'install-type-' . InstState::TYPE_RBACKUP_SINGLE;
    $title         = 'Restore - Single Site Backup';
} elseif (InstState::instTypeAvailable(InstState::TYPE_RBACKUP_MSUBDOMAIN)) {
    $instTypeClass = 'install-type-' . InstState::TYPE_RBACKUP_MSUBDOMAIN;
    $title         = 'Restore - Multisite-Subdomain Backup';
} elseif (InstState::instTypeAvailable(InstState::TYPE_RBACKUP_MSUBFOLDER)) {
    $instTypeClass = 'install-type-' . InstState::TYPE_RBACKUP_MSUBFOLDER;
    $title         = 'Restore - Multisite-Subdomain Backup';
} else {
    return;
}

$overwriteMode = (InstState::getInstance()->getMode() === InstState::MODE_OVR_INSTALL);
$display       = InstState::getInstance()->isInstType(
    array(
        InstState::TYPE_RBACKUP_SINGLE,
        InstState::TYPE_RBACKUP_MSUBDOMAIN,
        InstState::TYPE_RBACKUP_MSUBFOLDER,
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
                        The restore backup mode restores the original site by not performing any processing on the database or tables.
                        This ensures that the exact copy of the original site is restored.
                    </div>
                    <?php dupxTplRender('pages-parts/step1/info-tabs/overviews/overwrite-message'); ?>
                </td>
            </tr>
            <tr>
                <td>Mode:</td>
                <td>Custom <i>(Restore Install)</i></td>
            </tr>
        </table>
    </div>
</div>
