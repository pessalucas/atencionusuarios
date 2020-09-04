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
			add_action( 'wp_ajax_atencionusuarios_login', array( $this, 'login_user' ) );
			add_action( 'wp_ajax_nopriv_atencionusuarios_login', array( $this, 'login_user' ) );
		}
		/**
		 * Logueamos al usuario
		 */
		public function login_user() {

			/*
			2) Intentar loguear al usuario
				1) Si lo logra
					{
						"status": "succes",
						"data": "Usuario logueado correctamente"
					}

				2) Si no lo logra, 
					{
						"status": "error",
						"data": "Usuario o password incorecto"
					}
					*/

			$user_login    = $_POST[ 'username' ];
			$user_pass     = $_POST[ 'password' ];

			echo $user_login;
			echo $user_pass;
			echo "llego";
			if ( is_user_logged_in() ) {
				$current_user = wp_get_current_user();
				wp_send_json_success( "Usuario logueado correctamente." );
				die();
			}

			if ( wp_login ( $user_login , $user_pass ) ){
				wp_send_json_success( "Usuario logueado correctamente." );
				die();
			}else{
				wp_send_json_error( "Usuario y password incorrectos" );
				die();
			}



			//$user_remember = $_POST[ '' ];

			/*
			if ( si no tengo user login o passw ){
				wp_send_json_error( "Hubo un errror al procesar lo solicitado" );
				die();
			}
			*/
			/*
			$creds = array(
				'user_login'    => $user_login,
				'user_password' => $user_pass,
				'remember'      => $user_remember,
			);

			$user = wp_signon( $creds, false );

			if ( is_wp_error( $user ) ) {
				wp_send_json_error( "Usuario y password incorrectos" );
			} else {
				wp_send_json_success( "Usuario logueado correctamente." );
			}

			die();*/
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
