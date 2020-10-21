<?php

/**
 * Only number
 *
 * 'sanitize_callback' => 'absint'
 */

/**
 * Only email
 *
 * 'sanitize_callback' => 'sanitize_email'
 */

/**
 * Text sanitization
 *
 * 'sanitize_callback' => 'doc_sanitize_text'
 */
if ( !function_exists( 'doc_sanitize_text' ) ) {
	function doc_sanitize_text( $input ) {
		if ( strpos( $input, ',' ) !== false ) {
			$input = explode( ',', $input );
		}
		if ( is_array( $input ) ) {
			foreach ( $input as $key => $value ) {
				$input[ $key ] = sanitize_text_field( $value );
			}
			$input = implode( ',', $input );
		} else {
			$input = sanitize_text_field( $input );
		}
		return $input;
	}
}

/**
 * Switch sanitization
 *
 * 'sanitize_callback' => 'doc_sanitize_switch'
 */
if ( !function_exists( 'doc_sanitize_switch' ) ) {
	function doc_sanitize_switch( $input ) {
		if ( true === $input ) {
			return 1;
		} else {
			return 0;
		}
	}
}

/**
 * Radio Button and Select sanitization
 *
 * 'sanitize_callback' => 'doc_sanitize_radio'
 */
if ( !function_exists( 'doc_sanitize_radio' ) ) {
	function doc_sanitize_radio( $input, $setting ) {
		$choices = $setting->manager->get_control( $setting->id )->choices;
		if ( array_key_exists( $input, $choices ) ) {
			return $input;
		} else {
			return $setting->default;
		}
	}
}

/**
 * Date Time sanitization
 *
 * 'sanitize_callback' => 'doc_sanitize_time'
 */
if ( !function_exists( 'doc_sanitize_time' ) ) {
	function doc_sanitize_time( $input, $setting ) {
		$datetimeformat = 'Y-m-d';
		if ( $setting->manager->get_control( $setting->id )->include_time ) {
			$datetimeformat = 'Y-m-d H:i:s';
		}
		$date = DateTime::createFromFormat( $datetimeformat, $input );
		if ( $date === false ) {
			$date = DateTime::createFromFormat( $datetimeformat, $setting->default );
		}
		return $date->format( $datetimeformat );
	}
}