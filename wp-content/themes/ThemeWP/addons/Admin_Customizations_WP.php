<?php
/**
 * @package WordPress
 * @subpackage ThemeWP
 **/
####################################################################################################

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) { exit; }



/**
 * Admin_Customizations_WP
 **/
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
			add_action( 'admin_menu', [ $this, 'remove_mene_page' ], 99999 );
			add_action( 'admin_menu', [ $this, 'remove_submenus' ], 9999 );

			add_filter( 'all_plugins', [ $this, 'remove_some_plugins_from_admin_view' ], 9999 );
		}

		add_filter( 'login_headerurl', [ $this, 'login_headerurl' ] );
		add_filter( 'login_headertitle', [ $this, 'login_headertitle' ] );

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
	 * Changing the login page URL
	 **/
	function login_headerurl() {

		return home_url();

	} // end function login_headerurl


	/**
	 * Changing the login page URL hover text
	 **/
	function login_headertitle() {

		return get_bloginfo( 'title' );

	} // end function login_headertitle


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
	 * remove some plugins from admin view
	 **/
	function remove_some_plugins_from_admin_view( $all_plugins ) {

		// print_r($all_plugins); die();

		if (
			is__user(['rhicks','randy'])
		) {
			return $all_plugins;
		}

		unset( $all_plugins['advanced-custom-fields-pro/acf.php'] );
		unset( $all_plugins['disable-emails/disable-emails.php'] );
		unset( $all_plugins['bwp-minify/bwp-minify.php'] );

		return $all_plugins;

	} // end function remove_some_plugins_from_admin_view


	/**
	 * remove_submenus
	 **/
	function remove_submenus() {
		global $submenu; // print_r($submenu);

		remove_submenu_page( 'wpseo_dashboard', 'wpseo_licenses' );
		remove_submenu_page( 'yst_ga_dashboard', 'yst_ga_extensions' );

		if (
			is__user(['rhicks','randy'])
		) {
			return;
		}

		// remove_submenu_page( 'options-general.php', 'members-settings' );


		// remove customize
		unset( $submenu['themes.php'][6] );
		// remove_submenu_page( 'themes.php', 'customize.php' );

		if (
			is__user(['atiba'])
		) {
			return;
		}

		remove_submenu_page( 'options-general.php', 'akismet-key-config' );
		remove_submenu_page( 'plugins.php', 'plugin-editor.php' );
		remove_submenu_page( 'tools.php', 'tools.php' );
		remove_submenu_page( 'themes.php', 'theme-editor.php' );

		// remove_submenu_page( 'options-general.php', 'options-reading.php' );
		// remove_submenu_page( 'options-general.php', 'options-discussion.php' );
		// remove_submenu_page( 'options-general.php', 'options-media.php' );
		// remove_submenu_page( 'options-general.php', 'options-permalink.php' );

	} // end function remove_submenus


	/**
	 * remove_mene_page
	 **/
	function remove_mene_page() {

		if (
			is__user(['rhicks','randy'])
		) {
			return;
		}

		remove_menu_page( 'bwp_minify_general' );
		remove_menu_page( 'edit.php?post_type=acf' );
		remove_menu_page( 'edit.php?post_type=acf-field-group' );

		if (
			is__user(['atiba'])
		) {
			return;
		}

		remove_menu_page( 'jetpack' );
		remove_menu_page( 'tools.php' );
		remove_menu_page( 'plugins.php' );
		remove_menu_page( 'vc-general' );
		remove_menu_page( 'wpengine-common' );
		remove_menu_page( 'wpseo_dashboard' );
		remove_menu_page( 'avia' );

	} // end function remove_mene_page



} // end class Admin_Customizations_WP
