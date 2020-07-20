<?php
/**
 * Template part for style-5 header layout.
 *
 * @link    https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Spellolite
 */

 $search       = get_theme_mod( 'header_search', spellolite_theme()->customizer->get_default( 'header_search' ) );

?>

<div class="header-container_wrap container">
	<div class="header-container__flex">
		<div class="site-branding">
			<?php spellolite_header_logo() ?>
			<?php spellolite_site_description(); ?>
		</div>

		<?php spellolite_main_menu(); ?>

		<?php if ( $search ) : ?>
			<div class="header-icons divider">
				<?php spellolite_header_search( '<div class="header-search"><span class="search-form__toggle"></span>%s<span class="search-form__close"></span></div>' ); ?>
			</div>
		<?php endif; ?>

		<?php spellolite_header_btn(); ?>
	</div>
</div>
