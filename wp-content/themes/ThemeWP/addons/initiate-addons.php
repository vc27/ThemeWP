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

	/**
	 * add customizations to the wp admin to hide
	 * menu items for users and remove powerful plugin
	 * tools
	 **/
	require_once('Admin_Customizations_WP.php');
	$Admin_Customizations_WP = new Admin_Customizations_WP();
	$Admin_Customizations_WP->init();

	/**
	 * add options pages to the wp admin
	 * hide the ACF interface for all users execpt the
	 * specificly defined users.
	 **/
	require_once('ACF_Theme_Options_WP.php');
	$ACF_Theme_Options_WP = new ACF_Theme_Options_WP();
	$ACF_Theme_Options_WP->set( 'users_allowed_to_manage_acf', ['randy'] );
	$ACF_Theme_Options_WP->init();

	/**
	 * general shortcodes
	 **/
	require_once('Shortcodes_WP.php');
	$Shortcodes_WP = new Shortcodes_WP();
	$Shortcodes_WP->init();

	// require_once('Testing_WP.php');
	// new Testing_WP();

	define( 'ADDONS_INIT', true );

} // end if ( ! defined('ADDONS_INIT') )
