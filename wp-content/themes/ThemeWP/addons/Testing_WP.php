<?php
/**
 * @package WordPress
 * @subpackage ProjectName
 **/
####################################################################################################

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) { exit; }


/**
 * Testing_WP
 * @since 1.0
 **/
new Testing_WP();
class Testing_WP {

	/**
	 * public_get_key
	 *
	 * @access public
	 * @var string
	 * @since 1.0
	 **/
	private $public_get_key = 'wp-testing';

	/**
	 * public_get_val
	 *
	 * @access public
	 * @var string
	 * @since 1.0
	 * New strings: https://www.random.org/strings/?num=5&len=10&digits=on&upperalpha=on&loweralpha=on&unique=on&format=plain&rnd=new
	 **/
	private $public_get_val = 'wrqmydO70C*7layt2aplE@jS5YDTgrUp*fdBsplphFd-dgFnDP8BVe';

	/**
	 * __construct
	 **/
	function __construct() {

		if ( $this->have_key_and_password() ) {
			// make sure this loads after the code you need to test :)
			add_action( 'init', [ $this, 'init_api' ], 11 );
		}

	} // end function __construct


	####################################################################################################
	/**
	 * Set Get
	 **/
	####################################################################################################


	/**
	 * set
	 * @since 1.0
	 **/
	function set( $key, $val = false ) {

		if ( isset( $key ) AND ! empty( $key ) ) {
			$this->$key = $val;
		}

	} // end function set


	/**
	 * get
	 * @since 1.0
	 **/
	function get( $key ) {

		if ( isset( $key ) AND ! empty( $key ) AND isset( $this->$key ) AND ! empty( $this->$key ) ) {
			return $this->$key;
		} else {
			return false;
		}

	} // end function get


	/**
	 * get_case
	 * @since 1.0
	 **/
	function get_case() {

		if (
			isset( $_GET['case'] )
			AND ! empty( $_GET['case'] )
		) {
			return $_GET['case'];
		} else {
			return false;
		}

	} // end function get_case


	####################################################################################################
	/**
	 * Functionality
	 **/
	####################################################################################################


	/**
	 * init_api
	 * @since 1.0
	 **/
	function init_api() {

		switch ( $this->get_case() ) {
			case 'example' :
				// ?case=example&wp-testing=wrqmydO70C*7layt2aplE@jS5YDTgrUp*fdBsplphFd-dgFnDP8BVe
				$this->example();
				break;
			case 'button-shortcode' :
				// ?case=button-shortcode&wp-testing=wrqmydO70C*7layt2aplE@jS5YDTgrUp*fdBsplphFd-dgFnDP8BVe
				echo do_shortcode('[button id="css-id" title="Title" class="white" link="http://example.com" href="http://example.com/things" target="_blank" text="Button Text" inline="false"]');
				die();
				break;
			default :
				die(__method__);
				break;
		}

	} // end function init_api


	/**
	 * example
	 * @since 1.0
	 **/
	function example() {
		die(__method__);
	}


	####################################################################################################
	/**
	 * Conditionals
	 **/
	####################################################################################################


	/**
	 * have_key_and_password
	 * @since 1.0
	 **/
	function have_key_and_password() {

		if (
			isset( $_GET[$this->public_get_key] )
			AND ! empty( $_GET[$this->public_get_key] )
			AND $_GET[$this->public_get_key] === $this->public_get_val
		) {
			return true;
		} else {
			return false;
		}

	} // end function have_key_and_password


} // end class Testing_WP
