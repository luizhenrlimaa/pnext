<?php
/**
 * Template part for displaying a message that posts cannot be found.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Spellolite
 */
?>
<section class="no-results not-found invert">
	<header class="page-header">
		<h2 class="page-title"><?php esc_html_e( 'Nothing Found', 'spellolite' ); ?></h2>
	</header><!-- .page-header -->

	<div class="page-content">
		<?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>

			<p><?php printf( '%3$s <a href="%1$s">%2$s</a>', esc_url( admin_url( 'post-new.php' ) ), esc_html__( 'Get started here', 'spellolite' ), esc_html__( 'Ready to publish your first post?', 'spellolite' ) ) ?></p>

		<?php elseif ( is_search() ) : ?>

			<p><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'spellolite' ); ?></p>

			<?php get_search_form();

		else : ?>

			<p><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'spellolite' ); ?></p>

			<?php get_search_form();

		endif; ?>

	</div><!-- .page-content -->
</section><!-- .no-results -->
