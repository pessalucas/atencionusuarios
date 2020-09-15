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

			add_action( 'wp_ajax_nopriv_ajaxlogin',array($this, 'ajax_login'));

			// Ejectua si NO esta logueado
			if (!is_user_logged_in()) {
				add_action('init', array($this,'ajax_login_init'));
			}

		}
		public function ajax_login_init(){

			wp_register_script('ajax-login-script', get_template_directory_uri() . '/resources/scripts/ajax-login-script.js', array('jquery') ); 
			wp_enqueue_script('ajax-login-script');
		
			wp_localize_script( 'ajax-login-script', 'ajax_login_object', array( 
				'ajaxurl' => admin_url( 'admin-ajax.php' ),
				'redirecturl' => home_url(),
				'loadingmessage' => __('Chequeando informacion, espere...')
			));
		
			// Enable the user with no privileges to run ajax_login() in AJAX
		}
		//Login por ajax
		public function ajax_login(){
		
			// Loguea usuario
			$info = array();
			$info['user_login'] = sanitize_text_field(  $_POST['username'] );
			$info['user_password'] = sanitize_text_field(  $_POST['password'] );
			$info['remember'] = true;
		
			//Efectiviza el login
			$user_signon = wp_signon( $info, false );
			if ( !is_wp_error($user_signon) ){
				wp_set_current_user($user_signon->ID);
				wp_set_auth_cookie($user_signon->ID);
				echo json_encode(array('loggedin'=>true, 'message'=>__('Acceso correcto, redirigiendo.')));
			}else{
				echo json_encode(array('loggedin'=>false, 'message'=>__('Error de usuario o contraseña. Volve a intentarlo.')));
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
