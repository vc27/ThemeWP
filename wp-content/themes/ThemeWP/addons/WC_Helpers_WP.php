<?php
/**
 * @package WordPress
 * @subpackage Genesis-Atiba
 *
 * Description:
 * http://docs.woothemes.com/wc-apidocs/class-WC_Cart.html
 **/
####################################################################################################

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) { exit; }


// wcs_user_has_subscription
// wc_customer_bought_product
// wcs_get_users_subscriptions

if ( ! function_exists('wc_customer_bought_product') ) { exit; }



/**
 * WC_Helpers_WP
 *
 * Description:
 **/
class WC_Helpers_WP {

	/**
	 * __construct
	 *
	 * Description:
	 **/
	function __construct() {

	} // end function __construct


	/**
	 * init
	 *
	 * Description:
	 **/
	function init() {

		add_action( 'woocommerce_account_navigation', [ $this, 'get_template_part__my_account_header' ], 9 );

		// add wrappers to single product templates
		add_action( 'woocommerce_before_main_content', [ $this, 'add_top__wrapper' ], 9 );
		add_action( 'woocommerce_sidebar', [ $this, 'add_bottom__wrapper' ], 11 );

		add_filter( 'woocommerce_account_menu_items', [ $this, 'add_account_menu_items' ], 9 );
		add_action( 'woocommerce_account_dashboard', [ $this, 'wc_my_account_details_display' ] );

	} // end function init


	/**
	 * set
	 *
	 * Description:
	 **/
	function set( $key, $val = false ) {

		if ( isset( $key ) AND ! empty( $key ) ) {
			$this->$key = $val;
		}

	} // end function set


	/**
	 * get
	 *
	 * Description:
	 **/
	function get( $key ) {

		if ( isset( $key ) AND ! empty( $key ) AND isset( $this->$key ) AND ! empty( $this->$key ) ) {
			return $this->$key;
		} else {
			return false;
		}

	} // end function get


	/**
	 * get_order_product_ids
	 * @since 1.0
	 **/
	static function get_order_product_ids( $order_id ) {

		$product_ids = [];
		$order = new WC_Order( $order_id );
		$products = $order->get_items();
		foreach ( $products as $product ) {
			$product_ids[] = $product['product_id'];
		}

		return $product_ids;

	} // end function get_order_product_ids


	/**
	 * get_order_user_id
	 * @since 1.0
	 **/
	static function get_order_user_id( $order_id ) {

		$order = new WC_Order( $order_id );
		return $order->get_user_id();

	} // end function get_order_user_id


	/**
	 * get_product_price
	 * @since 1.0
	 **/
	static function get_product_price( $post_id ) {

		return get_post_meta( $post_id, '_regular_price', true );

	} // end function get_product_price


	/**
	 * get_product_price
	 * @since 1.0
	 **/
	static function get_product_price_subscription( $post_id ) {

		$subscription_price = get_post_meta( $post_id, '_subscription_price', true );
		if ( ! $subscription_price ) {
			$subscription_price = '0';
		}
		return $subscription_price;

	} // end function get_product_price


	/**
	 * get_add_to_cart_url
	 * @since 1.0
	 **/
	static function get_add_to_cart_url( $post_id ) {

		return WC_Cart::get_checkout_url() . "?add-to-cart=" . $post_id;

	} // end function get_add_to_cart_url


	/**
	 * get_orders
	 **/
	static function get_orders( $user_id ) {

		$output = false;
		$query = [
			'post_type' => 'shop_order',
			'fields' => 'ids',
			'post_status' => 'wc-completed',
			'meta_query' => [
				[
					'key' => '_customer_user',
					'value' => $user_id,
					'type' => 'NUMERIC'
				]
			]
		];
		$wp_query = new \WP_Query();
		$wp_query->query( $query );
		if ( isset( $wp_query->posts ) AND ! empty( $wp_query->posts ) ) {
			$output = $wp_query->posts;
		}

		return $output;

	} // end function get_orders


	/**
	 * get_purchase_product_ids
	 **/
	static function get_purchase_product_ids( $user_id ) {

		$product_ids = [];
		$orders = self::get_orders( $user_id );
		if ( $orders ) {
			foreach ( $orders as $order_id ) {
				$order = new \WC_Order( $order_id );
				$products = $order->get_items();
				foreach ( $products as $product ) {
					$product_ids[] = $product['product_id'];
				}
			}
			// print_r($orders);
		}

		return $product_ids;

	} // end function get_purchase_product_ids


	/**
	 * get_product_ids_from_order_items
	 *
	 * Description:
	 **/
	static function get_product_ids_from_order_items( $order_items ) {

		$output = array();

		foreach ( $order_items as $order_item ) {
			$output[] = $order_item['product_id'];
		}

		return $output;

	} // end function have_single_product_in_cart


	/**
	 * get_my_account_page_url
	 **/
	function get_my_account_page_url() {
		return get_permalink( get_option('woocommerce_myaccount_page_id') );
	}


	####################################################################################################
	/**
	 * Functionality
	 **/
	####################################################################################################


	/**
	 * add_product_to_cart
	 *
	 * Description: add a product to the cart
	 **/
	static function add_product_to_cart( $product_id ) {

		WC()->session->set_customer_session_cookie(true);

		if ( self::have_products_in_cart() ) {
			if ( ! self::have_single_product_in_cart( $product_id ) ) {
				WC()->cart->add_to_cart( $product_id );
			}
		} else {
			WC()->cart->add_to_cart( $product_id );
		}

	} // end function add_product_to_cart


	/**
	 * init_wc_api
	 *
	 * Description:
	 **/
	public static function create_order( $product_id, $user_id, $coupon ) {
		$address = array(
			'first_name' => get_user_meta( $user_id, 'first_name', true ),
			'last_name' => get_user_meta( $user_id, 'last_name', true ),
			'address_1' => get_user_meta( $user_id, 'address_1', true ),
			'address_2' => get_user_meta( $user_id, 'address_2', true ),
			'city' => get_user_meta( $user_id, 'city', true ),
			'postcode' => get_user_meta( $user_id, 'postcode', true ),
			'state' => get_user_meta( $user_id, 'state', true ),
			'country' => get_user_meta( $user_id, 'country', true ),
		);

		$order = wc_create_order();
		$order->add_product( get_product( $product_id ) ); //(get_product with id and next is for quantity)
		$order->set_address( $address, 'billing' );
		$order->set_address( $address, 'shipping' );
		$order->add_coupon( $coupon );
		$order->payment_complete();

		update_post_meta( $order->id, '_customer_user', $user_id );

		return $order;

	} // end public static function create_order


	/**
	 * get_template_part__my_account_header
	 *
	 * Description: add a product to the cart
	 **/
	static function get_template_part__my_account_header() {

		get_template_part('wc-my-account-header');

	} // end function get_template_part__my_account_header


	/**
	 * add_top__wrapper
	 *
	 * Description: add an html wrapper div above the page content
	 **/
	static function add_top__wrapper() {

		?>
		<div class="container">
		<?php

	} // end function add_top__wrapper


	/**
	 * add_bottom__wrapper
	 *
	 * Description: add an html wrapper div above the page content
	 **/
	static function add_bottom__wrapper() {

		?>
		</div>
		<?php

	} // end function add_bottom__wrapper


	/**
	 * manipulate the user account sidebar items
	 **/
	function add_account_menu_items( $items ) {

		/*
		Default list
		[dashboard] => Dashboard
		[orders] => Orders
		[downloads] => Downloads
		[edit-address] => Addresses
		[edit-account] => Account Details
		[customer-logout] => Logout

		Added
		account-general-options
		*/

		unset( $items['edit-address'] );
		unset( $items['edit-account'] );
		unset( $items['downloads'] );

		return $items;
	}


	/**
	 * Add template part to the dashboard
	 **/
	function wc_my_account_details_display() {
		get_template_part('wc-my-account-details-display');
	}


	####################################################################################################
	/**
	 * Conditionals
	 **/
	####################################################################################################


	/**
	 * have_products_in_cart
	 *
	 * Description:
	 **/
	static function have_products_in_cart() {

		$output = false;
		if ( count( WC()->cart->get_cart() ) > 0 ) {
			$output = true;
		}

		return $output;

	} // end function have_products_in_cart


	/**
	 * have_single_product_in_cart
	 *
	 * Description:
	 **/
	static function have_single_product_in_cart( $product_id ) {

		$output = false;
		foreach ( WC()->cart->get_cart() as $cart_item_key => $product ) {
			if ( $product['product_id'] == $product_id ) {
				$output = true;
			}
		}

		return $output;

	} // end function have_single_product_in_cart


	/**
	 * is_subscription_in_trial_period
	 * @since 1.0
	 **/
	static function is_subscription_in_trial_period( $order, $product_id ) {

		$subscription_key = \WC_Subscriptions_Manager::get_subscription_key( $order->id, $product_id );
		$subscription = (object)\WC_Subscriptions_Manager::get_subscription( $subscription_key );

		$output = 0;
		$schedule_trial_end = strtotime( $subscription->trial_expiry_date );

		if ( $schedule_trial_end > time() ) {
			$output = 1;
		}

		return $output;

	}


} // end class WC_Helpers_WP
