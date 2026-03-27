<?php

/**
 *
 * @package templates/default
 */

use Duplicator\Installer\Core\InstState;

$overwriteMode = (InstState::getInstance()->getMode() === InstState::MODE_OVR_INSTALL);
?>


<?php if ($overwriteMode) { ?>
    <div class="overview-subtxt-2 requires-db-hide">
        This will clear all site data and the current package will be installed.  This process cannot be undone!
    </div>
<?php } ?>
