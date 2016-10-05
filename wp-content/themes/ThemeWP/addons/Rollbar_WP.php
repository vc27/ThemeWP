<?php
/**
 * @package WordPress
 * @subpackage ProjectName
 **/
####################################################################################################

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

// ROLLBAR_ACCESS_TOKEN must be set
if ( ! defined('ROLLBAR_ACCESS_TOKEN') ) {
	return false;
}

if ( ! class_exists( 'Rollbar' ) ) {
	return false;
}



/**
 * Rollbar_WP
 * @since 1.0
 **/
class Rollbar_WP {

	/**
	 * $access_token
	 *
	 * @access public
	 * @var string
	 * @since 1.0
	 **/
	private $access_token = false;

	/**
	 * $environment
	 *
	 * @access public
	 * @var string
	 * @since 1.0
	 **/
	private $environment = false;

	/**
	 * $environment
	 *
	 * @access public
	 * @var string
	 * @since 1.0
	 **/
	private $root = false;


	/**
	 * __construct
	 **/
	function __construct() {

		if ( defined('ROLLBAR_ACCESS_TOKEN') ) {
			$this->set( 'access_token', ROLLBAR_ACCESS_TOKEN );
		}
		if ( defined('ROLLBAR_ENV') ) {
			$this->set( 'environment', ROLLBAR_ENV );
		}
		// optional - '/Users/some-folder/www/myapp' path to directory your code is in. used for linking stack traces.
		if ( defined('ROLLBAR_ROOT') ) {
			$this->set( 'root', ROLLBAR_ROOT );
		}

		$this->init();

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


	####################################################################################################
	/**
	 * Functionality
	 **/
	####################################################################################################


	/**
	 * init
	 * @since 1.0
	 **/
	function init() {

		$config = [
			'access_token' => $this->access_token,
			'environment' => $this->environment, // optional - environment name. any string will do.
			'root' => $this->root, // '/Users/brian/www/myapp' // optional - path to directory your code is in. used for linking stack traces.
			// 'handler' => 'agent',
			// 'agent_log_location' => ''
		];

		Rollbar::init($config);

	} // end function init


	/**
	 * test_message
	 * @since 1.0
	 **/
	static function test_message( $message = 'default message' ) {

		try {
			if ( $message ) {
				throw new Exception( $message );
			} else {
				return true;
			}
		} catch (Exception $e) {
			Rollbar::report_exception($e);
		}

	} // end function test_message


} // end class Rollbar_WP
