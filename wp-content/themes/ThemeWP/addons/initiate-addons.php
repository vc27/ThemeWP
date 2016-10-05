<?php
/**
 * @package WordPress
 * @subpackage ThemeWP
 *
 **/
#################################################################################################### */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) { exit; }


if ( ! defined('ADDONS_INIT') ) {

	require_once('ACFWP.php');

	require_once('Admin_Customizations_WP.php');
	require_once('ACF_Theme_Options_WP.php');
	require_once('Yoast_SEO_WP.php');
	require_once('Shortcodes_WP.php');

	require_once('Testing_WP.php');

	define( 'ADDONS_INIT', true );

} // end if ( ! defined('ADDONS_INIT') )
