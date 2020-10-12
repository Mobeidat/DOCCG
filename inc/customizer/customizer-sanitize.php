<?php

/* Email sanitization callback example */
function doc_sanitize_email( $email, $setting ) {
	$email = sanitize_email( $email );
	return ( !null( $email ) ? $email : $setting->default );
}

/* Drop-down Pages sanitization callback example */
function doc_sanitize_dropdown_pages( $page_id, $setting ) {
	$page_id = absint( $page_id );
	return ( 'publish' == get_post_status( $page_id ) ? $page_id : $setting->default );
}

/* Image sanitization callback example */
function doc_sanitize_image( $image, $setting ) {
	$mimes = array(
		'jpg|jpeg|jpe' => 'image/jpeg',
		'gif' => 'image/gif',
		'png' => 'image/png',
		'bmp' => 'image/bmp',
		'tif|tiff' => 'image/tiff',
		'ico' => 'image/x-icon'
	);
	$file = wp_check_filetype( $image, $mimes );
	return ( $file[ 'ext' ] ? $image : $setting->default );
}