<?php

/**
 *
 * @package templates/default
 */

use Duplicator\Installer\Core\InstState;

$overwriteMode = (InstState::getInstance()->getMode() === InstState::MODE_OVR_INSTALL);
?>

<div class="no-db-actions requires-no-db">
    The installer is not going to perform any actions on the database.         
    <?php if (\DUPX_ArchiveConfig::getInstance()->isDBExcluded()) { ?>
        The database was excluded during the build of the package.
    <?php } ?>
</div>
