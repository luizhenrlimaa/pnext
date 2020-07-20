<?php
/**
 * The template for displaying footer widget area.
 *
 * @package Spellolite
 */
// Check footer-area visibility.
if ( ! get_theme_mod( 'footer_widget_area_visibility', spellolite_theme()->customizer->get_default( 'footer_widget_area_visibility' ) ) || ! is_active_sidebar( 'footer-area' ) ) {
	return;
} ?>

<div class="footer-area-wrap <?php echo spellolite_get_invert_class_customize_option( 'footer_widgets_bg' ); ?>">
	<div class="container">
		<?php do_action( 'spellolite_render_widget_area', 'footer-area' ); ?>
	</div>
</div>