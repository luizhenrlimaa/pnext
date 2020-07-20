<?php
/**
 * Tm-mega-menu hooks.
 *
 * @package Spellolite
 */

// Mega menu mobile data.
add_filter( 'tm_mega_menu_mobile_button', '__return_true' );

// Add animation option to tm-mega-menu.
add_filter( 'tm_mega_menu_options', 'spellolite_add_animation_mega_menu_option' );

/**
 * Add animation option to tm-mega-menu.
 *
 * @param array $menu_options Mega menu options.
 *
 * @return array
 */
function spellolite_add_animation_mega_menu_option( $menu_options ) {

	$menu_options['tm-mega-menu-effect']['callback_args']['options']['slide-bottom'] = esc_html__( 'Slide from bottom', 'spellolite' );

	return $menu_options;
}
