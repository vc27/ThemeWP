<?php
/**
 * @package WordPress
 * @subpackage ThemeWP
 *
 **/
#################################################################################################### */


/**
 * get options from the db
 * currently this is a wrapper function for ACF get field
 * ACF is currently the prefered tool for adding options
 *
 * @since 3.9.0
 **/
function get__option( $option ) {

	$output = false;
	if ( function_exists('get_field') ) {
		$output = get_field( $option, 'option' );
	}

	return $output;

} // end function get__option


/**
 * check if the current user is within the provided array or string
 **/
function is__user( $user_login ) {
	$userdata = wp_get_current_user();

	if ( is_array( $user_login ) ) {
		$user_logins = $user_login;
	} else {
		$user_logins = [];
		$user_logins[] = $user_login;
	}

	if (
		! empty( $user_logins )
		AND isset( $userdata->data->user_login )
		AND in_array( $userdata->data->user_login, $user_logins )
	) {
		return true;
	} else {
		return false;
	}

} // end function is__user


/**
 * check if comments are active, at multiple levels
 **/
function do__comments() {
	global $post;
	if (
		( is_page() AND get__option( '_comments_page_deactivated' ) )
		OR get__option( '_comment_system_deactivated' )
		OR 'closed' == $post->comment_status
		OR ( $post->post_type == 'attachment' AND $post->post_mime_type == 'application/pdf' )
	) {
		return false;
	} else {
		return true;
	}
} // end function do__comments
