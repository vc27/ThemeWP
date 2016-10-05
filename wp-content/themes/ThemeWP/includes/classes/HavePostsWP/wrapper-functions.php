<?php
/**
 * @package WordPress
 * @subpackage ThemeWP
 *
 **/
#################################################################################################### */


/**
 * get__avatar
 **/
if ( ! function_exists( 'get__avatar' ) ) {
	function get__avatar( $args = [] ) {

		$output = false;
		if ( ! class_exists( 'HavePostsWP' ) ) {
			require_once( 'HavePostsWP.php' );
		}
		if ( class_exists( 'HavePostsWP' ) ) {
			$output = HavePostsWP::get_avatar($args);
		}
		return $output;

	}
} // end function get__avatar


/**
 * the__excerpt
 **/
if ( ! function_exists( 'the__excerpt' ) ) {
	function the__excerpt( $post, $args = [] ) {

		$output = false;
		if ( ! class_exists( 'HavePostsWP' ) ) {
			require_once( 'HavePostsWP.php' );
		}
		if ( class_exists( 'HavePostsWP' ) ) {
			$output = HavePostsWP::the_excerpt($post,$args);
		}
		return $output;

	}
} // end function the__excerpt


/**
 * the__content
 **/
if ( ! function_exists( 'the__content' ) ) {
	function the__content( $args = [] ) {

		$output = false;
		if ( ! class_exists( 'HavePostsWP' ) ) {
			require_once( 'HavePostsWP.php' );
		}
		if ( class_exists( 'HavePostsWP' ) ) {
			$output = HavePostsWP::the_content($args);
		}
		return $output;

	}
} // end function the__content


/**
 * the__title
 **/
if ( ! function_exists( 'the__title' ) ) {
	function the__title( $post, $args = [] ) {

		$output = false;
		if ( ! class_exists( 'HavePostsWP' ) ) {
			require_once( 'HavePostsWP.php' );
		}
		if ( class_exists( 'HavePostsWP' ) ) {
			$output = HavePostsWP::the_title($post,$args);
		}
		return $output;

	}
} // end function the__title


/**
 * the__comments
 **/
if ( ! function_exists( 'the__comments' ) ) {
	function the__comments( $post, $args = [] ) {

		$output = false;
		if ( ! class_exists( 'HavePostsWP' ) ) {
			require_once( 'HavePostsWP.php' );
		}
		if ( class_exists( 'HavePostsWP' ) ) {
			$output = HavePostsWP::the_comments($post,$args);
		}
		return $output;

	}
} // end function the__comments


/**
 * the__category
 **/
if ( ! function_exists( 'the__category' ) ) {
	function the__category( $post, $args = [] ) {

		$output = false;
		if ( ! class_exists( 'HavePostsWP' ) ) {
			require_once( 'HavePostsWP.php' );
		}
		if ( class_exists( 'HavePostsWP' ) ) {
			$output = HavePostsWP::the_category($post,$args);
		}
		return $output;

	}
} // end function the__category


/**
 * the__time
 **/
if ( ! function_exists( 'the__time' ) ) {
	function the__time( $post, $args = [] ) {

		$output = false;
		if ( ! class_exists( 'HavePostsWP' ) ) {
			require_once( 'HavePostsWP.php' );
		}
		if ( class_exists( 'HavePostsWP' ) ) {
			$output = HavePostsWP::the_time($post,$args);
		}
		return $output;

	}
} // end function the__time


/**
 * the__date
 **/
if ( ! function_exists( 'the__date' ) ) {
	function the__date( $post, $args = [] ) {

		$output = false;
		if ( ! class_exists( 'HavePostsWP' ) ) {
			require_once( 'HavePostsWP.php' );
		}
		if ( class_exists( 'HavePostsWP' ) ) {
			$output = HavePostsWP::the_date($post,$args);
		}
		return $output;

	}
} // end function the__date


/**
 * the__tags
 **/
if ( ! function_exists( 'the__tags' ) ) {
	function the__tags( $post, $args = [] ) {

		$output = false;
		if ( ! class_exists( 'HavePostsWP' ) ) {
			require_once( 'HavePostsWP.php' );
		}
		if ( class_exists( 'HavePostsWP' ) ) {
			$output = HavePostsWP::the_tags($post,$args);
		}
		return $output;

	}
} // end function the__tags


/**
 * the__author
 **/
if ( ! function_exists( 'the__author' ) ) {
	function the__author( $post, $args = [] ) {

		$output = false;
		if ( ! class_exists( 'HavePostsWP' ) ) {
			require_once( 'HavePostsWP.php' );
		}
		if ( class_exists( 'HavePostsWP' ) ) {
			$output = HavePostsWP::the_author($args);
		}
		return $output;

	}
} // end function the__author
