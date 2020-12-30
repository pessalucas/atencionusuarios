<?php
/**
 * Creamos toda la funcionalidad necesaria para el "ChangePassword" y el "UpdateProfile".
 *
 * @package AtencionUsuarios
 */

if ( ! class_exists( 'Profile' ) ) {
	/**
	 * Class User Profile.
	 */
	class Profile {
		/**
		 * ID de la pagina de login.
		 *
		 * @var integer
		 */
		private $page_login_id = 30;
		/**
		 * ID de la pagina de seguimiendo denuncias.
		 *
		 * @var integer
		 */
		private $page_profile_id = 176;
		/**
		 * Static accessor.
		 *
		 * @var Profile
		 */
		public static $instance;
		/**
		 * Constructor.
		 */
		public function __construct() {
			// Generamos la respuesta del ajax para el login.
			add_action( 'wp_ajax_profile_changepass', array( $this, 'ajax_changepassword' ) );
			// Generamos la respuesta del ajax para el registro.
			add_action( 'wp_ajax_profile_update', array( $this, 'ajax_update' ) );
			// Registramos los scripts o estilos necesarios.
			add_action( 'wp_enqueue_scripts', array( $this, 'register_assets_profile' ) );
			// Antes de que se elija que php se va a utilizar con esa url, revisamos las redirecciones.
			add_action( 'template_redirect', array( $this, 'redirect_is_not_loggedin' ) );
		}
		/**
		 * Generamos la respuesta para el ajax de registro.
		 */
		public function ajax_update() {

			// Verificamos a traves de la funcionalidad de captcha de WordPress: Los nonces.
			if ( ! isset( $_POST['nonce'] ) ) {
				wp_send_json_error( 'Error al procesar lo solicitado. Intente nuevamente o contacte con soporte.' );
				wp_die();
			}
			if ( ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), 'Profile_nonce' ) ) {
				wp_send_json_error( 'Error al procesar lo solicitado. Intente nuevamente o contacte con soporte.' );
				wp_die();
            }

			$user_firstname = isset( $_POST['firstname'] ) ? sanitize_text_field( wp_unslash( $_POST['firstname'] ) ) : '';
			$user_lastname  = isset( $_POST['lastname'] ) ? sanitize_text_field( wp_unslash( $_POST['lastname'] ) ) : '';
			$user_email     = isset( $_POST['email'] ) ? sanitize_email( wp_unslash( $_POST['email'] ) ) : '';
			$user_phone     = isset( $_POST['phone'] ) ? sanitize_text_field( wp_unslash( $_POST['phone'] ) ) : '';
			$user_dni       = isset( $_POST['dni'] ) ? sanitize_text_field( wp_unslash( $_POST['dni'] ) ) : '';
			$user_address   = isset( $_POST['address'] ) ? sanitize_text_field( wp_unslash( $_POST['address'] ) ) : '';

            //Obtengo el id e info asociada al usuario
            $user_id=get_current_user_id();
            $user_data=get_user_by('ID', $user_id);

			if (
				   '' === $user_firstname
				|| '' === $user_lastname
				|| '' === $user_email
				|| '' === $user_phone
				|| '' === $user_dni
				|| '' === $user_address
			) {
				wp_send_json_error( 'Error al procesar lo solicitado. Complete los datos e intente nuevamente.' );
				wp_die();
            }
            
            //Verifico si existe le usuario
            if ( username_exists( $user_dni ) ) {
				wp_send_json_error( 'Ya existe un usuario con ese DNI.' );
				wp_die();
            }
            
             //Comparo con el mail cargado y realizo la carga si es necesario
             if( $user_data->user_email != $user_email ){
                 if( email_exists( $email )){ 
                        wp_send_json_error( 'Ya existe un usuario con ese email.' );
                     die();
                 }
                 wp_update_user( array( 
                     'ID' => $user_id, 
                     'user_email' => $user_email 
                ) );
             }

            //Update de campos genericos
            wp_update_user( array(
                 'ID' => $user_id, //ID a updatear
                 'first_name' => $user_firstname,
                 'last_name' => $user_lastname
            ) );

            //Updates de campos no-genericos
            update_user_meta( $user_id, 'dni', $user_dni );
		    update_user_meta( $user_id, 'telefono', $user_phone );
			update_user_meta( $user_id, 'direccion', $user_address );

			wp_send_json_success( 'Usuario actualizado correctamente.' );
			wp_die();
		}
		/**
		 * Generamos la respuesta para el ajax de login.
		 */
		public function ajax_changepassword() {

			// Verificamos a traves de la funcionalidad de captcha de WordPress: Los nonces.
			if ( ! isset( $_POST['nonce'] ) ) {
				wp_send_json_error( 'Error al procesar lo solicitado. Intente nuevamente o contacte con soporte.' );
				wp_die();
			}
			if ( ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), 'Profile_nonce' ) ) {
				wp_send_json_error( 'Error al procesar lo solicitado. Intente nuevamente o contacte con soporte.' );
				wp_die();
			}
		
			$password1  = isset( $_POST['password1'] ) ? sanitize_text_field( wp_unslash( $_POST['password1'] ) ) : '';
			$password2  = isset( $_POST['password2'] ) ? sanitize_text_field( wp_unslash( $_POST['password2'] ) ) : '';
            $user_id = get_current_user_id();

        //Chequeo que puso igual las contraseñas
        if( $password1 == $password2 ){
            //Seteo password
            wp_update_user( array( 
                'ID'        => $user_id, 
                'user_pass' => $password1 
           ));
            wp_send_json_success( 'Has cambiado la contraseña satisfactoriamente.' );
        }else{
            wp_send_json_error( 'Las contraseñas no coinciden. Vuelva a intentarlo.' );
        }
			wp_die();
		}
		/**
		 * Registramos los assets necesarios para el template de login.
		 */
		public function register_assets_profile() {
			wp_enqueue_script(
				'profile-changepassword',
				get_stylesheet_directory_uri() . '/resources/scripts/users/ChangePassword.js',
				array(),
				'1.0.0',
				true
			);
			wp_enqueue_script(
				'profile-update',
				get_stylesheet_directory_uri() . '/resources/scripts/users/Update.js',
				array(),
				'1.0.0',
				true
			);
			wp_localize_script(
				'profile-update',
				'WP_Profile',
				array(
					'ajax'     => admin_url( 'admin-ajax.php' ),
					'nonce'    => wp_create_nonce( 'Profile_nonce' ),
				)
            );
            wp_localize_script(
				'profile-changepassword',
				'WP_Profile',
				array(
					'ajax'     => admin_url( 'admin-ajax.php' ),
					'nonce'    => wp_create_nonce( 'Profile_nonce' ),
				)
			);
		}
		/**
		 * Revisamos los redirect en funcion de si el usuario esta lougeado o no.
		 */
		public function redirect_is_not_loggedin() {
			// Si el no esta logueado y entra en la pagina del perfil lo redireccionamos al login
			if ( ( ! is_user_logged_in() ) && is_page( $this->page_profile_id ) ) {
				wp_redirect( get_permalink( $this->page_login_id ));
				exit;
			}   
		}
		/**
		 * Static accessor.
		 *
		 * @return Profile singleton.
		 */
		public static function instance() {
			if ( ! is_object( self::$instance ) ) {
				self::$instance = new Profile();
			}
			return self::$instance;
		}
	}
	Profile::instance();
}
