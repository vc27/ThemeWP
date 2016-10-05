<?php
/**
 * File Name Admin_Customizations_WP.php
 * @subpackage ProjectName
 *
 * @version 1.0
 * @updated 00.00.00
 **/
####################################################################################################

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) { exit; }



/**
 * Admin_Customizations_WP
 **/
$Admin_Customizations_WP = new Admin_Customizations_WP();
$Admin_Customizations_WP->init();
class Admin_Customizations_WP {


	/**
	 * __construct
	 **/
	function __construct() {}


	/**
	 * init
	 **/
	function init() {

		add_action( 'login_init', [ $this, 'action__login_init' ] );

		if ( is_admin() ) {
			add_action( 'admin_init', [ $this, 'action__admin_init' ] );
			// add_action( 'admin_menu', [ $this, 'remove_mene_page' ], 99 );
			add_action( 'admin_menu', [ $this, 'remove_submenus' ], 199 );
		}

	} // end function __construct


	/**
	 * action__login_init
	 **/
	function action__login_init() {

		add_action( 'login_enqueue_scripts', [ $this, 'login_enqueue_scripts' ] );

	} // end function action__login_init


	/**
	 * action__admin_init
	 **/
	function action__admin_init() {

		add_action( 'admin_footer_text', [ $this, 'admin_footer_text' ] );
		add_filter( 'update_footer', '__return_false', 9999 );

	} // end function action__admin_init


	####################################################################################################
	/**
	 * Functionality
	 **/
	####################################################################################################


	/**
	 * login_enqueue_scripts
	 **/
	function login_enqueue_scripts() {

		if (
			file_exists( get_stylesheet_directory() . "/css/admin-login.css" )
			AND file_exists( get_stylesheet_directory() . "/images/login-logo.png" )
		) {
			wp_enqueue_style( 'childtheme-admin-login', get_stylesheet_directory_uri() . "/css/admin-login.css", [], null );
		}

	} // end function login_enqueue_scripts


	/**
	 * admin_footer_text
	 **/
	function admin_footer_text( $text ) {

		$theme = wp_get_theme();
		$text = "<span id=\"footer-thankyou\">" . $theme->get('Name') . ": Version: " . $theme->get('Version') . " by <a href=\"" . $theme->get('AuthorURI') . "\" target=\"_blank\">" . $theme->get('Author') . "</a></span>";
		return $text;

	} // end function admin_footer_text


	/**
	 * remove_submenus
	 **/
	function remove_submenus() {
		// global $submenu; print_r($submenu);

		remove_submenu_page( 'plugins.php', 'plugin-editor.php' );
		remove_submenu_page( 'tools.php', 'tools.php' );
		remove_submenu_page( 'themes.php', 'theme-editor.php' );
		remove_submenu_page( 'themes.php', 'customize.php?return=%2Fwp-admin%2Foptions-general.php' );

		if ( ! current_user_can('administrator') ) {

			remove_submenu_page( 'options-general.php', 'members-settings' );
			remove_submenu_page( 'options-general.php', 'duplicatepost' );
			remove_submenu_page( 'users.php', 'roles' );

		}

		// global $submenu; print_r($submenu);

	} // end function remove_submenus



} // end class Admin_Customizations_WP
