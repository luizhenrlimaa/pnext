<?php
/**
 * Thumbnails configuration.
 *
 * @package Spellolite
 */

add_action( 'after_setup_theme', 'spellolite_register_image_sizes', 5 );
/**
 * Register image sizes.
 */
function spellolite_register_image_sizes() {
	set_post_thumbnail_size( 418, 315, true );

	// Registers a new image sizes.
	add_image_size( 'spellolite-thumb-s', 150, 150, true );
	add_image_size( 'spellolite-slider-thumb', 158, 88, true );
	add_image_size( 'spellolite-thumb-m', 400, 400, true );
	add_image_size( 'spellolite-thumb-m-2', 650, 490, true );
	add_image_size( 'spellolite-thumb-masonry', 418, 9999 );
	add_image_size( 'spellolite-thumb-l', 886, 668, true );
	add_image_size( 'spellolite-thumb-l-2', 886, 315, true );
	add_image_size( 'spellolite-thumb-xl', 1920, 1080, true );
	add_image_size( 'spellolite-author-avatar', 512, 512, true );
	add_image_size( 'spellolite-thumb-1355-1020', 1355, 1020, true );
}
