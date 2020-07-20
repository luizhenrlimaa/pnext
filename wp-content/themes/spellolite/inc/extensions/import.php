<?php
/**
 * Import remap hooks
 */

add_action( 'cherry_data_import_home_regex_replace', 'spellolite_remap_shortcodes' );
add_action( 'cherry_data_import_remap_posts',        'spellolite_remap_timetable' );

/**
 * Remap terms in shortocdes
 *
 * @param  array $regex Shortcode data for regex.
 * @return array
 */
function spellolite_remap_shortcodes( $regex ) {

	$regex[] = array(
		'shortcode' => 'tm_pb_mti_events'
	);

	return $regex;
}

/**
 * Remap timetable ID's
 *
 * @param array $posts post remapping array.
 */
function spellolite_remap_timetable( $posts ) {

	global $wpdb;

	$table_name = $wpdb->prefix . 'mp_timetable_data';

	$query = "
		SELECT *
		FROM $table_name
		WHERE 1
	";

	$data = $wpdb->get_results( $query );

	if ( empty( $data ) ) {
		return;
	}

	foreach ( $data as $row ) {

		$column_id = isset( $posts[ $row->column_id ] ) ? $posts[ $row->column_id ] : $row->column_id;
		$event_id  = isset( $posts[ $row->event_id ] ) ? $posts[ $row->event_id ] : $row->event_id;

		$wpdb->update(
			$table_name,
			array(
				'id'          => $row->id,
				'column_id'   => $column_id,
				'event_id'    => $event_id,
				'event_start' => $row->event_start,
				'event_end'   => $row->event_end,
				'user_id'     => $row->user_id,
				'description' => $row->description,
			),
			array(
				'id' => $row->id,
			),
			$format = array(
				'id'          => '%d',
				'column_id'   => '%d',
				'event_id'    => '%d',
				'event_start' => '%s',
				'event_end'   => '%s',
				'user_id'     => '%s',
				'description' => '%s',
			),
			$where_format = array(
				'term_id' => '%d',
			)
		);

	}
}

