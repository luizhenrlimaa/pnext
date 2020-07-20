<?php
/**
 * The template for displaying the style-2 footer layout.
 *
 * @package Spellolite
 */

?>
<div class="footer-container <?php echo spellolite_get_invert_class_customize_option( 'footer_bg' ); ?>">
	<div class="site-info container">
		<?php
			spellolite_footer_logo();
			spellolite_footer_menu();
			spellolite_contact_block( 'footer' );
			spellolite_social_list( 'footer' );
			spellolite_footer_copyright();
		?>
	</div><!-- .site-info -->
</div><!-- .container -->
