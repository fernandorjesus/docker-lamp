<?php
/**
 * QuadLayers WP Plugin Suggestions
 *
 * @package   quadlayers/wp-plugin-suggestions
 * @author    QuadLayers
 * @link      https://github.com/quadlayers/wp-plugin-suggestions
 * @copyright Copyright (c) 2023
 * @license   GPL-3.0
 */

?>

<style>
	.wrap.wrap {
		position: relative;
		margin: 25px 40px 0 20px;
		max-width: 1200px;
	}
	.wp-badge.wp-badge {
		background: #006bff url(<?php echo esc_url( plugins_url( '../../assets/img/logo.jpg', __FILE__ ) ); ?>) no-repeat;
		background-position: top center;
		background-size: 130px 130px;
		color: #fff;
		font-size: 14px;
		text-align: center;
		font-weight: 600;
		margin: 5px 0 0;
		padding-top: 120px;
		height: 40px;
		display: inline-block;
		width: 140px;
	}
	@media screen and (max-width: 2299px) and (min-width: 1600px) {
		#the-list {
			display: flex;
			flex-wrap: wrap;
		}
		.plugin-card {
			margin: 8px !important;
			width: calc(50% - 4px - 16px) !important;
		}
	}
</style>
<div class="wrap about-wrap full-width-layout">
	<h1>
		<?php esc_html_e( 'Suggestions', 'wp-plugin-suggestions' ); ?>
	</h1>
	<p class="about-text">
		<?php esc_html_e( 'Thanks for using our product! We recommend these extensions that will add new features to stand out your business and improve your sales.', 'wp-plugin-suggestions' ); ?>
	</p>
	<p class="about-text">
	<?php
	if ( ! empty( $this->plugin_data['promote_links'] ) ) {
		$promote_links = $this->plugin_data['promote_links'];
		foreach ( $promote_links as $index => $link ) {
			if ( $index > 0 ) {
				echo ' | ';
			}
			$link = wp_parse_args(
				$link,
				array(
					'text'   => '',
					'url'    => '',
					'target' => '_blank',
				)
			);
			echo sprintf( '<a href="%s" target="%s">%s</a>', esc_url( $link['url'] ), esc_attr( $link['target'] ), esc_html( $link['text'] ) );
		}
	}
	?>
	</p>
	<?php
		printf(
			'<a href="%s" target="_blank">
				<div class="wp-badge">%s</div>
			</a>',
			'https://quadlayers.com/?utm_source=WordPress&utm_medium=page&utm_campaign=suggestions',
			esc_html__( 'QuadLayers', 'wp-plugin-suggestions' )
		);
		?>
</div>
<div class="wrap">
	<?php
		$wp_list_table->prepare_items();
	?>
	<form id="plugin-filter" method="post" class="importer-item">
		<?php $wp_list_table->display(); ?>
	</form>
</div>
