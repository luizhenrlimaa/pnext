<?php get_header( spellolite_template_base() ); ?>

	<?php spellolite_site_breadcrumbs(); ?>

	<?php do_action( 'spellolite_render_widget_area', 'full-width-header-area' ); ?>

	<?php spellolite_single_modern_header(); ?>

	<div <?php spellolite_content_wrap_class(); ?>>

		<?php do_action( 'spellolite_render_widget_area', 'before-content-area' ); ?>

		<div class="row">

			<div id="primary" <?php spellolite_primary_content_class(); ?>>

				<?php do_action( 'spellolite_render_widget_area', 'before-loop-area' ); ?>

				<main id="main" class="site-main" role="main">

					<?php include spellolite_template_path(); ?>

				</main><!-- #main -->

				<?php do_action( 'spellolite_render_widget_area', 'after-loop-area' ); ?>

			</div><!-- #primary -->

			<?php get_sidebar(); // Loads the sidebar.php. ?>

		</div><!-- .row -->

		<?php do_action( 'spellolite_render_widget_area', 'after-content-area' ); ?>

	</div><!-- .container -->

	<?php do_action( 'spellolite_render_widget_area', 'after-content-full-width-area' ); ?>

<?php get_footer( spellolite_template_base() ); ?>
