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
	* initThemeFunctions
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
	 * after_setup_theme
	 **/
	function action__after_setup_theme() {

		add_theme_support( 'post-thumbnails' );
		set_post_thumbnail_size(
			get_option( 'thumbnail_size_w' ),
			get_option( 'thumbnail_size_h' ),
			get_option( 'thumbnail_crop' )
		);

		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'nav-menus' );

		// Translations can be added to the /languages/ directory.
		// load_theme_textdomain( 'ThemeFunctions', "$this->template_directory/languages" );

		add_image_size( 'standard', 300, 300, false );
		add_image_size( 'medium', 600, 1000, false );
		add_image_size( 'large', 1000, 2000, false );
		add_image_size( 'large-ex', 2000, 4000, false );

	} // end function after_setup_theme


	/**
	 * init
	 **/
	function action__init() {

		$this->remove_comments();
		add_action( 'admin_menu', [ $this, 'remove_menu_pages' ], 99 );

		add_filter( 'widget_text', 'do_shortcode' );
		remove_action('wp_head', 'wlwmanifest_link');
		remove_action('wp_head', 'rsd_link');
		remove_action('wp_head', 'wp_generator');

		add_action( 'wp_enqueue_scripts', [ $this, 'wp_enqueue_scripts' ] );
		add_action( 'wp_enqueue_scripts', [ $this, 'wp_localize_script' ], 9 );

		add_filter( 'post_class', [ $this, 'post_class' ] );
		add_filter( 'gallery_style', [ $this, 'remove_gallery_css' ] );

		add_action( 'wp_head', [ $this, 'wp_head' ] );
		add_action( 'wp_footer', [ $this, 'wp_footer' ] );
		add_action( 'after_body_tag', [ $this, 'after_body_tag' ] );

		add_filter( 'protected_title_format', [ $this, 'title_format' ] );
		add_filter( 'private_title_format', [ $this, 'title_format' ] );

		add_filter( 'login_headerurl', [ $this, 'login_headerurl' ] );
		add_filter( 'login_headertitle', [ $this, 'login_headertitle' ] );

		add_action( 'template_redirect', [ $this, 'layout_options' ] );

		$this->register_style_and_scripts();

		$this->register_sidebars( [
			'Primary Sidebar' => [
				'desc' => __( 'This is the primary widgetized area.', 'ThemeFunctions' ),
			]
		] );

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
	 * remove_comments
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
	 * remove_menu_pages
	 **/
	function remove_menu_pages() {

		if ( get__option( '_comment_system_deactivated' ) ) {
			remove_menu_page( 'edit-comments.php' );
		}

	} // end remove_menu_pages


	/**
	 * wp_localize_script
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
	 * post_class
	 **/
	function post_class( $classes ) {
		global $post;

		if ( has_post_thumbnail( $post->ID ) ) {
			$classes[] = 'has-post-thumbnail';
		}

		return $classes;

	} // end function post_class


	/**
	 * remove_gallery_css
	 **/
	function remove_gallery_css( $css ) {

		return preg_replace( "#<style type='text/css'>(.*?)</style>#s", '', $css );

	} // end function remove_gallery_css


	/**
	 * wp_head
	 **/
	function wp_head() {

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

	} // end function wp_head


	/**
	 * wp_footer
	 **/
	function wp_footer() {

		if ( get__option( '_footer_html' ) ) {
			echo "\n<!-- " . __( 'Start Theme Footer', 'ThemeFunctions' ) . " -->\n" . get__option( '_footer_html' ) . "\n<!-- " . __( 'End Theme Footer', 'ThemeFunctions' ) . " -->\n";
		}

	} // end function wp_footer


	/**
	 * after_body_tag
	 **/
	function after_body_tag() {

		if ( get__option( '_after_opening_body_tag' ) ) {
			echo get__option( '_after_opening_body_tag' );
		}

	} // end function after_body_tag


	/**
	 * title_format
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
	 * register_sidebars
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
	 * register_style_and_scripts
	 **/
	function register_style_and_scripts() {

		wp_register_style( 'style-css', get_stylesheet_directory_uri() . "/css/style.css", [], null );
		wp_register_script( 'site-scripts-js', get_stylesheet_directory_uri() . "/js/siteScripts.js", [ 'jquery' ], null );

	} // end function register_style_and_scripts


	/**
	 * wp_enqueue_scripts
	 **/
	function wp_enqueue_scripts() {

		if ( is_singular() AND get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}

		wp_enqueue_style( 'style-css' );
		wp_enqueue_script( 'site-scripts-js' );

	} // end function wp_enqueue_scripts


	/**
	 * layout_options
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
