<?php get_header( spellolite_template_base() ); ?>

	<?php spellolite_site_breadcrumbs(); ?>

	<div <?php spellolite_content_wrap_class(); ?>>

		<div class="row">

			<div id="primary" <?php spellolite_primary_content_class(); ?>>

				<main id="main" class="site-main" role="main">

					<?php include spellolite_template_path(); ?>

				</main><!-- #main -->

			</div><!-- #primary -->

		</div><!-- .row -->

	</div><!-- .container -->

<?php get_footer( spellolite_template_base() ); ?>
