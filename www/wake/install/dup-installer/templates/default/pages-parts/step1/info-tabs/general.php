<?php

/**
 *
 * @package templates/default
 */

defined('ABSPATH') || defined('DUPXABSPATH') || exit;

use Duplicator\Installer\Core\InstState;
use Duplicator\Installer\Core\Params\PrmMng;

$paramsManager = PrmMng::getInstance();
?>
<div id="tabs-1">
    <?php

    dupxTplRender('pages-parts/step1/info-tabs/overview-description');
    if (!InstState::isRecoveryMode()) {
        ?>
        <div class="margin-top-1" ></div>
        <?php
        $paramsManager->getHtmlFormParam(PrmMng::PARAM_INST_TYPE);
    }

    $paramsManager->getHtmlFormParam(PrmMng::PARAM_SUBSITE_ID);
    ?>

    <div class="requires-db-hide">
    <?php if (InstState::isAddSiteOnMultisiteAvailable()) {
        ?>
        <div 
            id="overwrite-subsite-on-multisite-wrapper" 
            class="margin-top-1 <?php echo InstState::isAddSiteOnMultisite() ? '' : 'no-display'; ?>"
        >
            <div class="hdr-sub3">Subisites import</div>
            <?php $paramsManager->getHtmlFormParam(PrmMng::PARAM_SUBSITE_OVERWRITE_MAPPING); ?>
        </div>
    <?php }
    if (InstState::isMultisiteInstallAvailable() && !InstState::dbDoNothing()) {
        ?>
        <div 
            id="url-multisite-mapping-wrapper" 
            class="margin-top-1 <?php echo InstState::isMultisiteInstall() ? '' : 'no-display'; ?>"
        >
            <div class="hdr-sub3">Subisites mapping</div>
            <?php  $paramsManager->getHtmlFormParam(PrmMng::PARAM_MU_REPLACE); ?>
        </div>
    <?php } ?>
    </div>
</div>
