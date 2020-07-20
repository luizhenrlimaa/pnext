<?php
/**
 * Menus configuration.
 *
 * @package Spellolite
 */

add_action( 'after_setup_theme', 'spellolite_register_menus', 5 );
/**
 * Register menus.
 */
function spellolite_register_menus() {

	register_nav_menus( array(
		'top'          => esc_html__( 'Top', 'spellolite' ),
		'main'         => esc_html__( 'Main', 'spellolite' ),
		'main_landing' => esc_html__( 'Landing Main', 'spellolite' ),
		'footer'       => esc_html__( 'Footer', 'spellolite' ),
		'social'       => esc_html__( 'Social', 'spellolite' ),
	) );
}
