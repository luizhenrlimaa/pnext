<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Spellolite
 */
?>
<section class="error-404 not-found">
	<header class="page-header">
		<h1 class="page-title screen-reader-text"><?php esc_html_e( '404', 'spellolite' ); ?></h1>
	</header><!-- .page-header -->

	<div class="page-content">

			<h2><?php esc_html_e( 'Page Not Found.', 'spellolite' ); ?></h2>
			<p><?php esc_html_e( 'Map where your photos were taken and discover local points of interest. There&#39;s also a flip-out.', 'spellolite' ); ?></p>

		<p><a class="btn btn-primary" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Go home', 'spellolite' ); ?></a></p>

	</div><!-- .page-content -->
</section><!-- .error-404 -->
