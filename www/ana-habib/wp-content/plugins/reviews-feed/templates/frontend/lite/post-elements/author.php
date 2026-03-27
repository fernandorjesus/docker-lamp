<?php
/**
 * Smash Balloon Reviews Feed Author Template
 * Adds a review author
 *
 * @version 1.0 Reviews Feed by Smash Balloon
 *
 */
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
?>
<div class="sb-item-author-date-ctn sb-fs">
	<div class="sb-item-author-ctn sb-relative">
		<div class="sb-item-name-date">
			<?php if ( $this->should_show( 'author', 'name' ) ) : ?>
			<span class="sb-item-author-name sb-relative"><?php echo esc_html( $this->parser->get_reviewer_name( $post ) ); ?></span>
			<?php endif; ?>

			<?php if ( $this->should_show( 'author', 'date' ) ) : ?>
				<span class="sb-item-author-date sb-relative"><?php echo esc_html( $this->date( $post, $this->translations ) ); ?></span>
			<?php endif; ?>
		</div>
	</div>
</div>
