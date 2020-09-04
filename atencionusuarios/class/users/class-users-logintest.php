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
			
			//inicializo ajax
			function ajax_login_init(){

				wp_register_script('ajax-login-script', get_template_directory_uri() . '/ajax-login-script.js', array('jquery') ); 
				wp_enqueue_script('ajax-login-script');
			
				wp_localize_script( 'ajax-login-script', 'ajax_login_object', array( 
					'ajaxurl' => admin_url( 'admin-ajax.php' ),
					'redirecturl' => home_url(),
					'loadingmessage' => __('Sending user info, please wait...')
				));
			
				// Enable the user with no privileges to run ajax_login() in AJAX
				add_action( 'wp_ajax_nopriv_ajaxlogin', 'ajax_login' );
				add_action( 'wp_ajax_priv_ajaxlogin', 'ajax_login' );
			}
			
			// Execute the action only if the user isn't logged in
			if (!is_user_logged_in()) {
				add_action('init', 'ajax_login_init');
			}
		}
		/**
		 * Logueamos al usuario
		 */
		public function ajax_login(){

			// Nonce is checked, get the POST data and sign user on
			$info = array();
			$info['user_login'] = $_POST['username'];
			$info['user_password'] = $_POST['password'];
			$info['remember'] = true;
		
			$user_signon = wp_signon( $info, false );
			if ( !is_wp_error($user_signon) ){
				wp_set_current_user($user_signon->ID);
				wp_set_auth_cookie($user_signon->ID);
				echo json_encode(array('loggedin'=>true, 'message'=>__('Login successful, redirecting...')));
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
