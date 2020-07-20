<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Spellolite
 */

$template = locate_template( 'template-parts/content-404.php' );

if ( $template ) {
	include $template;
}
