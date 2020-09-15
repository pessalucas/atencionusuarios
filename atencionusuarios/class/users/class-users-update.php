<?php
/**
 * Ejecuta las funciones para la actualizacion de usuario.
 *
 * @package atencionusuarios
 */

if ( ! class_exists( 'Users_Updater' ) ) {
	/**
	 * Class User Profile.
	 */
	class Users_Updater {
		/**
		 * Static accessor.
		 *
		 * @var Users_Updater
		 */
		public static $instance;
		/**
		 * Constructor.
		 */
		public function __construct() {

			//Habilito el ajax para usuarios logueados
            add_action( 'wp_ajax_ajaxupdate', array($this, 'ajax_update'));
            add_action( 'wp_ajax_nopriv_ajaxupdate', array($this, 'ajax_update'));
			
			// Ejecuto si el usuario esta logueado
			if (is_user_logged_in()) {
				add_action('init', array($this,'ajax_update_init'));
			}
		}
		/*
			Incializacion de ajax
		*/
		public function ajax_update_init(){

			wp_register_script('ajax-update-script', get_template_directory_uri() . '/resources/scripts/ajax-update-script.js', array('jquery') ); 
			wp_enqueue_script('ajax-update-script');

			wp_localize_script( 'ajax-update-script', 'ajax_update_object', array( 
				'ajaxurl' => admin_url( 'admin-ajax.php' ),
				//'redirecturl' => home_url(),
				'loadingmessage' => __('Cargando informacion, espere...')
			));

		}
		/**
		 * Registramos usuario PORQUE REDIRECCIONA????? SI ESTA COMENTADO MISMO PARA CHANGE PASSOWRD
		 */
		 public function ajax_update(){

			$phone= sanitize_text_field( $_POST['phone'] );
			$email= sanitize_email( $_POST['email'] );
			$dni= sanitize_text_field( $_POST['dni'] );
            $address= sanitize_text_field( $_POST['address'] );
            
            //Obtengo el id de usuario
            $user_id=get_current_user_id();

            //Obrengo el mail con ese numero de ID
            $user=get_user_by('ID', $user_id);
            

            //Comparo con el mail cargado
            if($user->user_email != $email){
                //Chequeo si existe
                if( email_exists( $email )){ 
                    echo json_encode(array('updatein'=>false, 'message'=>__('Email Registrado. Elija otro y vuelva a intentarlo.')));
                    die();
                }
                //Cargo nuevo mail 
                wp_update_user( array( 'ID' => $user_id, 'user_email' => $email ) );
            }

            //Actualizo los datos no genericos
			update_user_meta( $user_id, 'dni', $dni );
		    update_user_meta( $user_id, 'telefono', $phone );
			update_user_meta( $user_id, 'direccion', $address );

            echo json_encode(array('updatein'=>true, 'message'=>__('Se ha realizado la actualizacion de su perfil.')));

            die();
			
		}

		/**
		 * Static accessor.
		 *
		 * @return Users_Updater singleton.
		 */
		public static function instance() {
			if ( ! is_object( self::$instance ) ) {
				self::$instance = new Users_Updater();
			}
			return self::$instance;
		}
	}
	Users_Updater::instance();
}
