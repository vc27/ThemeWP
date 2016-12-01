<?php
/**
 * @package WordPress
 * @subpackage ProjectName
 *
 **/
####################################################################################################

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) { exit; }


/**
 * ACF_Theme_Options_WP
 **/
class ACF_Theme_Options_WP {


	/**
	 * users_allowed_to_manage_acf
	 *
	 * @access public
	 * @var array
	 **/
	private $users_allowed_to_manage_acf = [];


	/**
	 * __construct
	 **/
	function __construct() {

	} // end function __construct


	/**
	 * set
	 **/
	function set( $key, $val = false ) {

		if ( isset( $key ) AND ! empty( $key ) ) {
			$this->$key = $val;
		}

	} // end function set


	/**
	 * init
	 **/
	function init() {

		add_action( 'init', [ $this, 'action__init' ] );
		if ( is_admin() ) {
			add_action( 'admin_menu', [ $this, 'remove_mene_page' ], 99 );
		}

	} // end function init


	/**
	 * action__init
	 **/
	function action__init() {

		$this->add_options_pages();

	} // end function action__init


	/**
	 * add_options_pages
	 **/
	function add_options_pages() {

		if ( function_exists('acf_add_options_sub_page') ) {

			acf_add_options_sub_page( array(
				'title' => 'Theme Options',
				'menu' => 'Theme Options',
				'slug' => 'theme-options',
				'parent' => 'themes.php',
				'capability' => 'manage_options'
			) );

		}

	} // end function add_options_pages


	/**
	 * remove_mene_page
	 **/
	function remove_mene_page() {

		if (
			! is__user( $this->users_allowed_to_manage_acf )
		) {
			remove_menu_page( 'edit.php?post_type=acf' );
			remove_menu_page( 'edit.php?post_type=acf-field-group' );
		}

	} // end function remove_mene_page


} // end class ACF_Theme_Options_WP
