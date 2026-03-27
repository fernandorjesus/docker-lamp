<?php

/**
 *
 * @package templates/default
 */

defined('ABSPATH') || defined('DUPXABSPATH') || exit;
?>
<div id="error_action" class="bottom-step-action margin-top-2 no-display" >   
    <div class="s1-err-msg" >
        <i>
            This installation will not be able to proceed until the archive and validation sections both pass. 
            Please adjust your servers settings click validate buttom or contact your server administrator, 
            hosting provider or visit the resources below for additional help.
        </i>
        <div style="padding:10px">
            &raquo; <a href="https://duplicator.com/knowledge-base-article-categories/troubleshooting" target="_blank">Technical FAQs</a> <br/>
            &raquo; <a href="<?php echo DUPX_Constants::FAQ_URL; ?>" target="_blank">Online Documentation</a> <br/>
        </div>
    </div>
</div>
