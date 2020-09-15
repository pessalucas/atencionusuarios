<?php
/**
 * Ejecuta las funciones para el registro.
 *
 * @package atencionusuarios
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

			//Habilito el ajax sin permiso especial
			add_action( 'wp_ajax_nopriv_ajaxregister', array($this, 'ajax_register'));
			
			// Ejecuto si el usuario no esta logueado
			if (!is_user_logged_in()) {
				add_action('init', array($this,'ajax_register_init'));
			}
		}
		/*
			Incializacion de ajax
		*/
		public function ajax_register_init(){

			wp_register_script('ajax-register-script', get_template_directory_uri() . '/resources/scripts/ajax-register-script.js', array('jquery') ); 
			wp_enqueue_script('ajax-register-script');

			wp_localize_script( 'ajax-register-script', 'ajax_register_object', array( 
				'ajaxurl' => admin_url( 'admin-ajax.php' ),
				'redirecturl' => home_url(),
				'loadingmessage' => __('Cargando informacion, espere...')
			));

		}
		/**
		 * Registramos usuario
		 */
		 public function ajax_register(){
		
			$name= sanitize_text_field( $_POST['name'] );
			$phone= sanitize_text_field( $_POST['phone'] );
			$email= sanitize_email( $_POST['email'] );
			$dni= sanitize_text_field( $_POST['dni'] );
			$username= sanitize_text_field( $_POST['username'] );
			$password= sanitize_text_field( $_POST['password'] );
			$address= sanitize_text_field( $_POST['address'] );
		
			//Chequeo usuario y email
			if( username_exists( $username ) ){ 
				echo json_encode(array('registerin'=>false, 'message'=>__('Usuario Registrado. Elija otro y vuelva a intentarlo.')));
				die();
			 }
			if( email_exists( $email )){ 
				echo json_encode(array('registerin'=>false, 'message'=>__('Email Registrado. Elija otro y vuelva a intentarlo.')));
				die();
			}
					//Creo usuario
					if ( wp_create_user($username, $password, $email) ) {
							
					// Loguearse posterior a registro.
					$info = array();
					$info['user_login'] = $username;
					$info['user_password'] = $password;
					$info['remember'] = true;
					$user_signon = wp_signon( $info, false );
				
						//Actualizo los datos no genericos
					update_user_meta( $user_signon->ID, 'first_name', $name );
					update_user_meta( $user_signon->ID, 'dni', $dni );
					update_user_meta( $user_signon->ID, 'telefono', $phone );
					update_user_meta( $user_signon->ID, 'direccion', $address );
						
					echo json_encode(array('registerin'=>true, 'message'=>__('Registro correcto, redirigiendo.')));

					}else{
						echo json_encode(array('registerin'=>false, 'message'=>__('Error de registro. Vuelva a intentarlo.')));
					}
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
