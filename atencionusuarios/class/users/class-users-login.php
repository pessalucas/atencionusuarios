<?php
/**
 * Ejecuta las funciones para el login.
 *
 * @package LucasPessa
 */

if ( ! class_exists( 'Users_Login' ) ) {
	/**
	 * Class User Profile.
	 */
	class Users_Login {
		/**
		 * Static accessor.
		 *
		 * @var Users_Login
		 */
		public static $instance;
		/**
		 * Constructor.
		 */
		public function __construct() {
			add_action( 'wp_ajax_au_login', array( $this, 'login_user' ) );
			add_action( 'wp_ajax_nopriv_au_login', array( $this, 'login_user' ) );
		}
		/**
		 * Logueamos al usuario
		 */
		public function login_user() {
			if ( is_user_logged_in() ) {
				$current_user = wp_get_current_user();
				wp_send_json_success(
					array(
						'email' => $current_user->data->user_email,
						'todo'  => $current_user,
					)
				);
				die();
			}

			$user_login    = $_POST[ '' ];
			$user_pass     = $_POST[ '' ];
			$user_remember = $_POST[ '' ];

			$creds = array(
				'user_login'    => $user_login,
				'user_password' => $user_pass,
				'remember'      => $user_remember,
			);

			$user = wp_signon( $creds, false );

			if ( is_wp_error( $user ) ) {
				wp_send_json_error(
					$user->get_error_message()
				);
			} else {
				wp_send_json_success(
					$user
				);
			}

			die();
		}
		/**
		 * Static accessor.
		 *
		 * @return Users_Login singleton.
		 */
		public static function instance() {
			if ( ! is_object( self::$instance ) ) {
				self::$instance = new Users_Login();
			}
			return self::$instance;
		}
	}
	Users_Login::instance();
}
