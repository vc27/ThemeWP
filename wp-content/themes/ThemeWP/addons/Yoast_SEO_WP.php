<?php
/**
 * File Name Yoast_SEO_WP.php
 * @package WordPress
 * @subpackage ThemeWP
 *
 **/
#################################################################################################### */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) { exit; }


/**
 * Yoast_SEO_WP
 * @since 1.0
 **/
$Yoast_SEO_WP = new Yoast_SEO_WP();
$Yoast_SEO_WP->init();
class Yoast_SEO_WP {


	/**
	 * __construct
	 **/
	function __construct() {
	}


	/**
	 * init
	 **/
	function init() {

		add_action( 'init', [ $this, 'action__init' ] );
		add_action( 'admin_init', [ $this, 'action__admin_init' ], 9 );

	} // end function __construct


	/**
	 * action__init
	 **/
	function action__init() {

		remove_action( 'admin_bar_menu', 'wpseo_admin_bar_menu', 95 );
		add_action( 'admin_menu', [ $this, 'remove_submenus' ], 999 );

	} // end function action__init


	/**
	 * action__admin_init
	 **/
	function action__admin_init() {

		add_filter( 'wpseo_use_page_analysis', '__return_false' );
		add_filter( 'wpseo_stopwords', '__return_empty_array' );

	} // end function action__admin_init


	/**
	 * Remove Sub Menu Pages
	 **/
	function remove_submenus() {

		// global $submenu; print_r($submenu);
		remove_submenu_page( 'wpseo_dashboard', 'wpseo_files' );

	} // end function remove_submenus


} // end class Yoast_SEO_WP
