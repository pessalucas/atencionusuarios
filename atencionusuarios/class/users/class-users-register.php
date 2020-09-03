<?php
/**
 * Ejecuta las funciones para el login.
 *
 * @package LucasPessa
 */

if ( ! class_exists( 'Users_Register' ) ) {
	/**
	 * Class User Profile.
	 */
	class Users_Register {
		/**
		 * Static accessor.
		 *
		 * @var Users_Register
		 */
		public static $instance;
		/**
		 * Constructor.
		 */
		public function __construct() {
			add_action( 'wp_ajax_au_register', array( $this, 'register_user' ) );
			add_action( 'wp_ajax_nopriv_au_register', array( $this, 'register_user' ) );
		}
		/**
		 * Logueamos al usuario
		 */
		public function register_user() {
			

			$user_email    = $_POST['email'];
			$user_password = $_POST['pass'];
			$user_dni      = $_POST['dni'];

			$user_id = register_new_user( $user_email, $user_password );
			
			if ( is_wp_error( $user_id ) ) {
				wp_send_json_error(
					$user->get_error_message()
				);
				die();
			}

			update_user_meta( $user_id, 'dni', $user_dni );


			die();
		}
		/**
		 * Static accessor.
		 *
		 * @return Users_Register singleton.
		 */
		public static function instance() {
			if ( ! is_object( self::$instance ) ) {
				self::$instance = new Users_Register();
			}
			return self::$instance;
		}
	}
	Users_Register::instance();
}
