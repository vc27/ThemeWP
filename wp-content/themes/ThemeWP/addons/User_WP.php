<?php
/**
 * @package WordPress
 * @subpackage Genesis-Atiba
 **/
#################################################################################################### */


/**
 * User_WP Class
 **/
class User_WP {

	/**
	 * nonce_action
	 *
	 * @access private
	 * @var string
	 **/
	static $nonce_action = 'user-action';

	/**
	 * user access levels
	 *
	 * @access public
	 * @var static
	 **/
	static $access_levels = [
		'guest' => [
			'id' => 'guest',
			'title' => 'Guest',
			'desc' => 'A visitor on the site who does not have an account.',
			'upgrade_path' => 1
		],
		'free' => [
			'id' => 'free',
			'title' => 'Free Membership',
			'desc' => 'A member who has a basic account with no active subsciptions.',
			'upgrade_path' => 2,
			'product_id_option_name' => 'free_membership_product'
		],
		'subscriber_member' => [
			'id' => 'subscriber_member',
			'title' => 'Paid Member',
			'desc' => 'A member who has any version of a paid subscription.'
		],
		'subscriber_monthly' => [
			'id' => 'subscriber_monthly',
			'title' => 'Subscriber Monthly',
			'upgrade_path' => 3,
			'product_id_option_name' => 'monthly_subscription_product'
		],
		'subscriber_annual' => [
			'id' => 'subscriber_annual',
			'title' => 'Subscriber Annual',
			'upgrade_path' => 4,
			'product_id_option_name' => 'annual_subscription_product'
		],
		'administrator' => [
			'id' => 'administrator',
			'title' => 'Administrator',
			'upgrade_path' => 100
		]
	];


	/**
	 * __construct
	 **/
	public function __construct() {

	}


	/**
	 * init
	 **/
	public function init() {

		// redirect uses based on page, access level and local options
		add_action( 'template_redirect', [ $this, '_redirect_user' ] );
		// update user data
		add_action( 'init', [ $this, 'update_user_data' ] );

	}


	####################################################################################################
	/**
	 * set & get
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
	 * get_key
	 * @since 1.0
	 **/
	static function get_key( $key ) {

		if (
			isset( $_POST[$key] )
			AND ! empty( $_POST[$key] )
		) {
			return $_POST[$key];
		} else {
			return false;
		}

	} // end function get_key


	/**
	 * get_current_user
	 **/
	static function get_current_user() {
		global $current_user;

		$user = wp_get_current_user();

		$user->access_status = self::get_access_level();

		$user->full_name = '';
		if ( ! empty( $user->first_name ) ) {
			$user->full_name .= $user->first_name;
			if ( ! empty( $user->last_name ) ) {
				$user->full_name .= ' ' . $user->last_name;
			}
		} else if ( ! empty( $user->last_name ) ) {
			$user->full_name .= $user->last_name;
		}
		if ( empty( $user->full_name ) ) {
			$user->full_name = '<em>empty</em>';
		}

		// space to add user data to object before return
		$user = self::set__user__object_value( $user, 'billing_phone', '<em>empty</em>' );
		$user = self::set__user__object_value( $user, 'alternate_phone' );
		$user = self::set__user__object_value( $user, 'billing_address_1' );
		$user = self::set__user__object_value( $user, 'billing_address_2' );
		$user = self::set__user__object_value( $user, 'billing_city' );
		$user = self::set__user__object_value( $user, 'billing_state' );
		$user = self::set__user__object_value( $user, 'billing_postcode' );
		$user = self::set__user__object_value( $user, 'billing_country' );

		// set global $current_user
		$current_user = $user;

		return $user;

	} // end static function get_current_user


	/**
	 * set the user data
	 * allow for the function to populate the field with an empty value
	 **/
	static function set__user__object_value( $user, $key, $empty = false ) {
		$user->$key = get_user_meta( $user->ID, $key, true );
		if ( ! $user->$key ) {
			$user->$key = $empty;
		}
		return $user;
	}


	/**
	 * get_post_id_from_wp_query
	 **/
	static function get_post_id_from_wp_query() {
		global $wp_query;

		$post_id = 0;
		if (
			isset( $wp_query->post )
			AND ! empty( $wp_query->post )
			AND isset( $wp_query->post->ID )
			AND is_numeric( $wp_query->post->ID )
		) {
			$post_id = $wp_query->post->ID;
		}

		return $post_id;

	}


	/**
	 * get_required_access_level
	 * @since 1.0
	 **/
	static function get_required_access_level( $post_id = 0 ) {

		if ( $post_id != 0 ) {
			$output = get_post_meta( $post_id, 'access_levels', true );
		} else if ( is_single() ) {
			$output = get_post_meta( self::get_post_id_from_wp_query(), 'access_levels', true );
		}

		if ( empty( $output ) ) {
			$output = 'guest';
		}

		return $output;

	} // end function get_required_access_level


	/**
	 * get_redirect_url
	 * @since 1.0
	 **/
	static function get_redirect_url( $post_id = 0 ) {

		if ( ! $post_id ) {
			$post_id = self::get_post_id_from_wp_query();
		}

		if ( $post_id AND get_field( 'redirect_url', $post_id ) ) {
			$output = get_field( 'redirect_url', $post_id );
		} else if ( get_field( 'redirect_url', 'option' ) ) {
			$output = get_field( 'redirect_url', 'option' );
		} else {
			$output = home_url();
		}

		return $output;

	} // end function get_required_access_level


	/**
	 * get_access_level
	 * subscriber = user account was created when purchasing a subscription or plain account
	 * customer = user account was created when purchaseing a regular product
	 **/
	static function get_access_level( $user_id = false ) {

		if ( self::is_not_logged_in() ) {
			return (object)static::$access_levels['guest'];
		}

		if ( current_user_can('subscriber') OR current_user_can('customer') ) {
			if ( ! $user_id ) {
				$user_id = get_current_user_id();
			}
			return (object)static::$access_levels[self::get_users_subscription_level( $user_id )];
		}

		if ( current_user_can('administrator') ) {
			return (object)static::$access_levels['administrator'];
		}

	} // end static function get_access_level


	/**
	 * get_users_subscription_level
	 *
	 * Note: Will return annual without considering if the user somehow has both annual and monthly
	 **/
	static function get_users_subscription_level( $user_id ) {

		if ( wcs_user_has_subscription( $user_id, get_field( self::$access_levels['free']['product_id_option_name'], 'option' ), 'active' ) ) {
			return 'free';
		}

		if ( wcs_user_has_subscription( $user_id, get_field( self::$access_levels['subscriber_annual']['product_id_option_name'], 'option' ), 'active' ) ) {
			return 'subscriber_annual';
		}

		if ( wcs_user_has_subscription( $user_id, get_field( self::$access_levels['subscriber_monthly']['product_id_option_name'], 'option' ), 'active' ) ) {
			return 'subscriber_monthly';
		}

		return 'guest';

	} // static function get_users_subscription_level


	/**
	 * get_users_edit_settings_url
	 *
	 * Note: Will return annual without considering if the user somehow has both annual and monthly
	 **/
	static function get_users_edit_settings_url() {
		// return WC_Helpers_WP::get_my_account_page_url() . WC_Account_Endpoint__Account_General_Options::$endpoint . '/';
	}


	####################################################################################################
	/**
	 * Conditionals
	 **/
	####################################################################################################


	/**
	 * is_logged_in
	 **/
	static public function is_logged_in() {
		if ( is_user_logged_in() ) {
			return 1;
		} else {
			return 0;
		}
	}


	/**
	 * is_not_logged_in
	 **/
	static public function is_not_logged_in() {
		if ( ! is_user_logged_in() ) {
			return 1;
		} else {
			return 0;
		}
	}


	/**
	 * can_user_access_content
	 **/
	static public function can_user_access_content( $user_id = false, $post_id = false ) {

		$user_access_level = self::get_access_level( $user_id );
		$content_access_level = (object)self::$access_levels[self::get_required_access_level( $post_id )];

		if ( $user_access_level->upgrade_path >= $content_access_level->upgrade_path ) {
			return true;
		} else {
			return false;
		}
	}


	####################################################################################################
	/**
	 * Functional
	 **/
	####################################################################################################


	/**
	 * redirect__is_not_logged_in
	 **/
	static public function redirect__is_not_logged_in( $location ) {
		if ( self::is_not_logged_in() ) {
			wp_safe_redirect( $location );
			exit;
		}
	}


	/**
	 * content_display
	 **/
	static public function content_display( $guest = '', $membership = '' ) {

		if ( self::is_not_logged_in() ) {
			return $guest;
		} else if ( self::is_logged_in() ) {
			return $membership;
		}

	} // end static public function content


	/**
	 * redirect_user
	 **/
	public function redirect_user() {

		// All access pages
		if (
			is_page_template('tpl-create-account.php')
		) {
			return;
		}

		// redirect logged in users from the member login page to the acccount management page
		if ( self::is_logged_in() AND is_page_template('tpl-member-login.php') ) {
			wp_safe_redirect( WC_Helpers_WP::get_my_account_page_url() );
			exit;
		}

		/**
		NEEDS COMPLETION
		Needs to recognize the difference between monthly & annual
		**/
		switch ( self::get_required_access_level() ) {
			case 'guest' :
				// allow everyone !!!
				break;
			case 'free' :
				self::redirect__is_not_logged_in( self::get_redirect_url() );
				break;
			case 'subscriber_monthly' :
			case 'subscriber_annual' :
				self::redirect__is_not_logged_in( self::get_redirect_url() );
				break;
		}

	} // end public function redirect_user


	/**
	 * _redirect_user
	 **/
	public function _redirect_user() {

		self::redirect_user();

	} // end public function _redirect_user


	/**
	 * update_user_data
	 **/
	public function update_user_data() {

		if ( wp_verify_nonce( self::get_key( 'nonce' ), self::$nonce_action ) ) {

			$this->set( 'user', self::get_current_user() );

			$this->update_standard_user_data( $this->user->ID, 'first_name' );
			$this->update_standard_user_data( $this->user->ID, ['first_name','billing_first_name'] );

			$this->update_standard_user_data( $this->user->ID, 'last_name' );
			$this->update_standard_user_data( $this->user->ID, ['last_name', 'billing_last_name'] );

			$this->update_user_email();

			$this->update_standard_user_data( $this->user->ID, 'billing_phone' );
			$this->update_standard_user_data( $this->user->ID, 'alternate_phone' );
			$this->update_standard_user_data( $this->user->ID, 'billing_address_1' );
			$this->update_standard_user_data( $this->user->ID, 'billing_address_2' );
			$this->update_standard_user_data( $this->user->ID, 'billing_city' );
			$this->update_standard_user_data( $this->user->ID, 'billing_state' );
			$this->update_standard_user_data( $this->user->ID, 'billing_postcode' );
			$this->update_standard_user_data( $this->user->ID, 'billing_country' );

			$_POST['user_data_updated'] = 1;

		}

	} // end public function update_user_data


	/**
	 * update_standard_user_data
	 **/
	public function update_standard_user_data( $user_id, $key ) {

		if ( is_array( $key ) ) {
			$post_key = $key[0];
		} else {
			$post_key = $key;
		}

		if ( is_array( $key ) ) {
			foreach ( $key as $meta_key ) {
				update_user_meta( $user_id, $meta_key, self::get_key( $post_key ) );
			}
		} else  {
			update_user_meta( $user_id, $post_key, self::get_key( $post_key ) );
		}

	} // end public function update_standard_user_data


	/**
	 * update_user_email
	 **/
	public function update_user_email() {
		if ( self::get_key( 'user_email' ) ) {
			$this->update_standard_user_data( $this->user->ID, 'user_email', 'billing_email' );
			$this->update_standard_user_data( $this->user->ID, 'user_email', 'nickname' );

			wp_update_user( [
				'ID' => $this->user->ID,
				'user_email' => self::get_key( 'user_email' ),
				'user_login' => self::get_key( 'user_email' )
			] );
		}
	}


	/**
	 * display_content_lock
	 **/
	static public function display_content_lock( $post_id ) {

		if ( ! self::can_user_access_content( get_current_user_id(), $post_id ) ) {
			?>
			<div class="locked">
				<span class="fa fa-lock"></span>
				<div class="upgrade-wrap small">
					<a class="button" href="<?php the_field('become_a_member_page','option'); ?>">Upgrade Membership</a>
				</div>
			</div>
			<?php
		}

	} // end static public function display_content_lock

} // end class User_WP
