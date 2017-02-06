<?php
/**
 * @package WordPress
 * @subpackage ThemeWP
 *
 **/
#################################################################################################### */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) { exit; }


/**
 * Initiate Library
 **/
require_once( 'includes/initiate-lib.php' );


/**
 * Initiate Addons
 **/
require_once( 'addons/initiate-addons.php' );


/**
 * ThemeFunctions Class
 **/
$ThemeFunctions = new ThemeFunctions();
$ThemeFunctions->init();
class ThemeFunctions {

	/**
	 * Sidebar Args
	 *
	 * @access public
	 * @var array
	 **/
	var $sidebar_args = [
		'before_widget' => '<div id="%1$s" class="widget-box %2$s">'
		,'after_widget' => '</div>'
		,'before_title' => '<div class="h3 widget-title"><span class="widget-title-wrap">'
		,'after_title' => '</span></div>'
	];


	/**
 	 * __construct
	 **/
	function __construct() {

	} // end function __construct


	/**
	 * initiate theme function on the top level actions
	 * suggested for hooking into for themes
	 * Note: There is not theme activation function as nothing is activated
	 **/
	function init() {

		add_action( 'after_setup_theme', [ $this, 'action__after_setup_theme' ] );
		add_action( 'init', [ $this, 'action__init' ] );

	} // end function initThemeFunctions


	/**
	 * set
	 **/
	 function set( $key, $val = false ) {

		 if ( isset( $key ) AND ! empty( $key ) ) {
			 $this->$key = $val;
		 }

	 } // end function set


	/**
	 * Add support and general items that must be added
	 * before init action but are specific to the theme.
	 **/
	function action__after_setup_theme() {

		// add support the thumbnails
		add_theme_support( 'post-thumbnails' );

		// se the default thumbnail size
		set_post_thumbnail_size(
			get_option( 'thumbnail_size_w' ),
			get_option( 'thumbnail_size_h' ),
			get_option( 'thumbnail_crop' )
		);

		// add suppport for feeds
		add_theme_support( 'automatic-feed-links' );

		// add support for nav menus
		add_theme_support( 'nav-menus' );

		// Translations can be added to the /languages/ directory.
		// load_theme_textdomain( 'ThemeFunctions', "$this->template_directory/languages" );

		// add some basic image sizes for featured images
		add_image_size( 'standard', 300, 300, false );
		add_image_size( 'medium', 600, 1000, false );
		add_image_size( 'large', 1000, 2000, false );
		add_image_size( 'large-ex', 2000, 4000, false );

	} // end function after_setup_theme


	/**
	 * Standard initiate actions and filters.
	 **/
	function action__init() {

		// remove comments from the system
		$this->remove_comments();

		// remove comments menu pages
		add_action( 'admin_menu', [ $this, 'remove_comments_menu_pages' ], 99 );

		// allow shortcodes in text widgets
		add_filter( 'widget_text', 'do_shortcode' );

		// remove some unnecessary items from wp_head
		remove_action('wp_head', 'wlwmanifest_link');
		remove_action('wp_head', 'rsd_link');
		remove_action('wp_head', 'wp_generator');

		// register styles and scripts
		add_action( 'wp_enqueue_scripts', [ $this, 'register_styles_and_scripts' ], 9 );

		// enqueue scripts
		add_action( 'wp_enqueue_scripts', [ $this, 'wp_enqueue_scripts' ] );

		// add a filtered localization array
		add_action( 'wp_enqueue_scripts', [ $this, 'wp_localize_script' ], 9 );

		// add some post classes
		add_filter( 'post_class', [ $this, 'post_class' ] );

		// reomve the gallery css that comes with wp, this may not be needed anymore
		add_filter( 'gallery_style', [ $this, 'remove_gallery_css' ] );

		// add wp_head options
		add_action( 'wp_head', [ $this, 'add_options_to_wp_head' ] );

		// add wp_footer options
		add_action( 'wp_footer', [ $this, 'add_options_to_wp_footer' ] );

		// add option to after_body_tag
		add_action( 'after_body_tag', [ $this, 'add_options_to_after_body_tag' ] );

		// clean title format
		add_filter( 'protected_title_format', [ $this, 'title_format' ] );
		add_filter( 'private_title_format', [ $this, 'title_format' ] );

		// clean up login just a little
		add_filter( 'login_headerurl', [ $this, 'login_headerurl' ] );
		add_filter( 'login_headertitle', [ $this, 'login_headertitle' ] );

		// add some default features to the core theme layout
		add_action( 'template_redirect', [ $this, 'layout_options' ] );

		// register sidebars
		$this->register_sidebars( [
			'Primary Sidebar' => [
				'desc' => __( 'This is the primary widgetized area.', 'ThemeFunctions' ),
			]
		] );

		// register navigation menu locations
		register_nav_menus( [
			'primary-menu' => __( 'Primary Menu Navigation', 'ThemeFunctions' ),
			'footer-menu' => __( 'Footer Menu Navigation', 'ThemeFunctions' )
		] );

	} // end function init


	####################################################################################################
	/**
	 * init
	 **/
	####################################################################################################


	/**
	 * attempt to remove all comments from a simple option
	 * Note: there may be some customizations that weezle around this, be aware :)
	 **/
	function remove_comments() {

		// remove all public post type comments
		if ( get__option( '_comment_system_deactivated' ) ) {
			$get_post_types = get_post_types( [ 'public' => true ] );
			foreach ( $get_post_types as $post_type ) {
				remove_post_type_support( $post_type, 'comments' );
			}
		}

		// remove all page post type comments
		if ( get__option( '_comments_page_deactivated' ) ) {
			remove_post_type_support( 'page', 'comments' );
		}

	} // end remove_comments


	/**
	 * remove comments from wp-admin
	 **/
	function remove_comments_menu_pages() {

		if ( get__option( '_comment_system_deactivated' ) ) {
			remove_menu_page( 'edit-comments.php' );
		}

	} // end remove_comments_menu_pages


	/**
	 * add an object to the head html section
	 * this the best place to put data that needs to be utilized by js
	 * @uses apply_filters to allow other scripts to modify from elsewhere
	 **/
	function wp_localize_script() {

		$array = [
			'stylesheet_directory_uri' => get_stylesheet_directory_uri(),
			'template_directory_uri' => get_template_directory_uri(),
			'home_url' => home_url(),
		];

		wp_localize_script(
			'jquery',
			'siteObject',
			apply_filters( 'ThemeFunctions-localize_script', $array )
		);

	} // end function wp_localize_script


	/**
	 * add classes for specific css targeting
	 **/
	function post_class( $classes ) {
		global $post;

		if ( has_post_thumbnail( $post->ID ) ) {
			$classes[] = 'has-post-thumbnail';
		}

		return $classes;

	} // end function post_class


	/**
	 * remove the old wp gallery inline csss
	 * note: this may not be needed anymore
	 **/
	function remove_gallery_css( $css ) {

		return preg_replace( "#<style type='text/css'>(.*?)</style>#s", '', $css );

	} // end function remove_gallery_css


	/**
	 * add options to wp_head action
	 **/
	function add_options_to_wp_head() {

		// Favicon
		$favicon_url = "/favicon.ico";
		if ( get__option( '_use_custom_favicon' ) ) {
			$favicon_url = get__option( '_favicon_image_url' );
		}
		echo "\n<link rel=\"icon\" href=\"$favicon_url\" type=\"image/x-icon\" />\n";

		// General Options Header textarea
		if ( get__option( '_head_html' ) ) {
			echo "\n<!-- " . __( 'Start Theme Header', 'ThemeFunctions' ) . " -->\n" . get__option( '_head_html' ) . "\n<!-- " . __( 'End Theme Header', 'ThemeFunctions' ) . " -->\n";
		}

	} // end function add_options_to_wp_head


	/**
	 * add option to wp_footer action
	 **/
	function add_options_to_wp_footer() {

		if ( get__option( '_footer_html' ) ) {
			echo "\n<!-- " . __( 'Start Theme Footer', 'ThemeFunctions' ) . " -->\n" . get__option( '_footer_html' ) . "\n<!-- " . __( 'End Theme Footer', 'ThemeFunctions' ) . " -->\n";
		}

	} // end function add_options_to_wp_footer


	/**
	 * add optios to the after_body_tag action
	 **/
	function add_options_to_after_body_tag() {

		if ( get__option( '_after_opening_body_tag' ) ) {
			echo get__option( '_after_opening_body_tag' );
		}

	} // end function add_options_to_after_body_tag


	/**
	 * clean title format
	 **/
	function title_format() {

		return '%s';

	} // end function title_format


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


	####################################################################################################
	/**
	 * Utility
	 **/
	####################################################################################################


	/**
	 * utility for registering sidebars
	 **/
	function register_sidebars( $sidebars = [] ) {

		// Register Sidebars
		foreach ( $sidebars as $name => $info ) {

			$id = sanitize_title_with_dashes( $name );

			$args = [
				'name' => $name
				,'id' => $id
				,'description' => $info['desc']
				,'before_widget' => $this->sidebar_args['before_widget']
				,'after_widget' => $this->sidebar_args['after_widget']
				,'before_title' => $this->sidebar_args['before_title']
				,'after_title' => $this->sidebar_args['after_title']
			];

			register_sidebar( $args );

		} // endforeach; register sidebars

	} // end function register_sidebars


	####################################################################################################
	/**
	 * If parent theme is being used with out a child theme
	 **/
	####################################################################################################


	/**
	 * register styles and scripts
	 **/
	function register_styles_and_scripts() {

		wp_register_style( 'style-css', get_stylesheet_directory_uri() . "/css/style.css", [], null );
		wp_register_script( 'site-scripts-js', get_stylesheet_directory_uri() . "/js/siteScripts.js", [ 'jquery' ], null );

	} // end function register_styles_and_scripts


	/**
	 * enqueue scripts
	 **/
	function wp_enqueue_scripts() {

		if ( is_singular() AND get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}

		wp_enqueue_style( 'style-css' );
		wp_enqueue_script( 'site-scripts-js' );

	} // end function wp_enqueue_scripts


	/**
	 * add custom functions to layout options utilized
	 * by this specific theme.
	 **/
	function layout_options() {

		// Archive Post Navigation
		add_action( 'after-loop', 'previous_next___posts_link' );

		// Single Post Navigation
		add_action( 'after-loop', 'previous_next___post_link' );

		// Add Page Title
		add_action( 'before-loop', 'archive__title' );


	} // end function layout_options


} // end class ThemeFunctions
