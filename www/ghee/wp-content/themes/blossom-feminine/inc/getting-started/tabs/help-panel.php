<?php
/**
 * Help Panel.
 *
 * @package Blossom_Feminine
 */

?>
<!-- Help file panel -->
<div id="help-panel" class="panel-left">

    <div class="panel-aside">
        <h4><?php _e( 'View Our Documentation Link', 'blossom-feminine' ); ?></h4>
        <p><?php _e( 'New to the WordPress world? Our documentation has step by step procedure to create a beautiful website.', 'blossom-feminine' ); ?></p>
        <a class="button button-primary" href="<?php echo esc_url( 'https://docs.blossomthemes.com/' . BLOSSOM_FEMININE_THEME_TEXTDOMAIN . '/' ); ?>" title="<?php esc_attr_e( 'Visit the Documentation', 'blossom-feminine' ); ?>" target="_blank"><?php _e( 'View Documentation', 'blossom-feminine' ); ?></a>
    </div><!-- .panel-aside -->
    
    <div class="panel-aside">
        <h4><?php _e( 'Support Ticket', 'blossom-feminine' ); ?></h4>
        <p><?php printf( __( 'It\'s always a good idea to visit our %1$sKnowledge Base%2$s before you send us a support ticket.', 'blossom-feminine' ), '<a href="'. esc_url( 'https://docs.blossomthemes.com/' . BLOSSOM_FEMININE_THEME_TEXTDOMAIN . '/' ) .'" target="_blank">', '</a>' ); ?></p>
        <p><?php _e( 'If the Knowledge Base didn\'t answer your queries, submit us a support ticket here. Our response time usually is less than a business day, except on the weekends.', 'blossom-feminine' ); ?></p>
        <a class="button button-primary" href="<?php echo esc_url( 'https://blossomthemes.com/support-ticket/' ); ?>" title="<?php esc_attr_e( 'Visit the Support', 'blossom-feminine' ); ?>" target="_blank"><?php _e( 'View Contact Support', 'blossom-feminine' ); ?></a>
    </div><!-- .panel-aside -->

    <div class="panel-aside">
        <h4><?php _e( 'View Our Demo', 'blossom-feminine' ); ?></h4>
        <p><?php _e( 'Visit the demo to get more ideas about our theme design.', 'blossom-feminine' ); ?></p>
        <a class="button button-primary" href="<?php echo esc_url( 'https://blossomthemes.com/theme-demo/?theme=' . BLOSSOM_FEMININE_THEME_TEXTDOMAIN ); ?>" title="<?php esc_attr_e( 'Visit the Demo', 'blossom-feminine' ); ?>" target="_blank"><?php _e( 'View Demo', 'blossom-feminine' ); ?></a>
    </div><!-- .panel-aside -->
</div>
