<?php
/**
 * Creamos toda la funcionalidad necesaria para el Login y el Registro.
 *
 * @package AtencionUsuarios
 */

if ( ! class_exists( 'Auth' ) ) {
	/**
	 * Class User Auth.
	 */
	class Auth {
		/**
		 * ID de la pagina de login.
		 *
		 * @var integer
		 */
		private $page_login_id = 5;
		/**
		 * ID de la pagina de perfil.
		 *
		 * @var integer
		 */
		private $page_profile_id = 12;
		/**
		 * Static accessor.
		 *
		 * @var Auth
		 */
		public static $instance;
		/**
		 * Constructor.
		 */
		public function __construct() {
			// Generamos la respuesta del ajax para el login.
			add_action( 'wp_ajax_nopriv_wp_auth_login', array( $this, 'ajax_login' ) );
			// Generamos la respuesta del ajax para el registro.
			add_action( 'wp_ajax_nopriv_wp_auth_register', array( $this, 'ajax_register' ) );
			// Registramos los scripts o estilos necesarios.
			add_action( 'wp_enqueue_scripts', array( $this, 'register_assets' ) );
			// Antes de que se elija que php se va a utilizar con esa url, revisamos las redirecciones.
			add_action( 'template_redirect', array( $this, 'redirect_is_loggedin' ) );
		}
		/**
		 * Generamos la respuesta para el ajax de registro.
		 */
		public function ajax_register() {
			// Verificamos a traves de la funcionalidad de captcha de WordPress: Los nonces.
			if ( ! isset( $_POST['nonce'] ) ) {
				wp_send_json_error( 'Error al procesar lo solicitado. Intente nuevamente o contacte con soporte.' );
				wp_die();
			}
			if ( ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), 'auth_nonce' ) ) {
				wp_send_json_error( 'Error al procesar lo solicitado. Intente nuevamente o contacte con soporte.' );
				wp_die();
			}
			// Si el usuario ya se encuentra logueado, devolvemos ok.
			if ( is_user_logged_in() ) {
				wp_send_json_success( 'Usuario se encuentra logueado.' );
				wp_die();
			}

			$user_firstname = isset( $_POST['firstname'] ) ? sanitize_text_field( wp_unslash( $_POST['firstname'] ) ) : '';
			$user_lastname  = isset( $_POST['lastname'] ) ? sanitize_text_field( wp_unslash( $_POST['lastname'] ) ) : '';
			$user_email     = isset( $_POST['email'] ) ? sanitize_email( wp_unslash( $_POST['email'] ) ) : '';
			$user_pass      = isset( $_POST['pass'] ) ? sanitize_text_field( wp_unslash( $_POST['pass'] ) ) : '';
			$user_phone     = isset( $_POST['phone'] ) ? sanitize_text_field( wp_unslash( $_POST['phone'] ) ) : '';
			$user_dni       = isset( $_POST['passport_id'] ) ? sanitize_text_field( wp_unslash( $_POST['passport_id'] ) ) : '';
			$user_address   = isset( $_POST['address'] ) ? sanitize_text_field( wp_unslash( $_POST['address'] ) ) : '';

			if (
				'' === $user_firstname
				|| '' === $user_lastname
				|| '' === $user_email
				|| '' === $user_pass
				|| '' === $user_phone
				|| '' === $user_dni
				|| '' === $user_address
			) {
				wp_send_json_error( 'Error al procesar lo solicitado. Intente nuevamente o contacte con soporte.' );
				wp_die();
			}

			if ( username_exists( $user_dni ) ) {
				wp_send_json_error( 'Ya existe un usuario con ese DNI.' );
				wp_die();
			}

			if ( email_exists( $user_email ) ) {
				wp_send_json_error( 'Ya existe un usuario con ese correo eléctronico.' );
				wp_die();
			}

			$user_id = wp_insert_user(
				array(
					'user_pass'            => $user_pass,
					'user_login'           => $user_dni,
					'user_email'           => $user_email,
					'first_name'           => $user_firstname,
					'last_name'            => $user_lastname,
					'show_admin_bar_front' => false,
					'role'                 => '',
				)
			);

			if ( is_wp_error( $user_id ) ) {
				wp_send_json_error( 'Hubo un error al crear la cuenta, intente nuevamente o contacte con soporte.' );
				wp_die();
			}

			update_user_meta( $user_id, 'dni', $user_dni );
			update_user_meta( $user_id, 'telefono', $user_phone );
			update_user_meta( $user_id, 'direccion', $user_address );

			wp_signon(
				array(
					'user_login'    => $user_email,
					'user_password' => $user_pass,
				)
			);

			wp_send_json_success( 'Usuario registrado correctamente.' );
			wp_die();
		}
		/**
		 * Generamos la respuesta para el ajax de login.
		 */
		public function ajax_login() {
			// Verificamos a traves de la funcionalidad de captcha de WordPress: Los nonces.
			if ( ! isset( $_POST['nonce'] ) ) {
				wp_send_json_error( 'Error al procesar lo solicitado. Intente nuevamente o contacte con soporte.' );
				wp_die();
			}
			if ( ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), 'auth_nonce' ) ) {
				wp_send_json_error( 'Error al procesar lo solicitado. Intente nuevamente o contacte con soporte.' );
				wp_die();
			}
			// Si el usuario ya se encuentra logueado, devolvemos ok.
			if ( is_user_logged_in() ) {
				wp_send_json_success( 'Usuario logueado correctamente.' );
				wp_die();
			}

			$user_email    = isset( $_POST['email'] ) ? sanitize_email( wp_unslash( $_POST['email'] ) ) : '';
			$user_pass     = isset( $_POST['pass'] ) ? sanitize_text_field( wp_unslash( $_POST['pass'] ) ) : '';
			$user_remember = isset( $_POST['remember'] ) ? sanitize_text_field( wp_unslash( $_POST['remember'] ) ) : 'false';

			$credentials = array(
				'user_login'    => $user_email,
				'user_password' => $user_pass,
				'remember'      => $user_remember,
			);

			$user = wp_signon( $credentials, false );
			// Si hay un error en el login devolvemos un error generico.
			if ( is_wp_error( $user ) ) {
				wp_send_json_error( 'El correo eléctronico o la contraseña son incorrectas.' );
				wp_die();
			}

			wp_send_json_success( 'Usuario logueado correctamente.' );
			wp_die();
		}
		/**
		 * Registramos los assets necesarios para el template de login.
		 */
		public function register_assets() {
			wp_enqueue_script(
				'auth-login',
				get_stylesheet_directory_uri() . '/resources/scripts/auth/Login.js',
				array(),
				'1.0.0',
				true
			);
			wp_enqueue_script(
				'auth-register',
				get_stylesheet_directory_uri() . '/resources/scripts/auth/Register.js',
				array(),
				'1.0.0',
				true
			);
			wp_localize_script(
				'auth-login',
				'WP_Auth',
				array(
					'ajax'     => admin_url( 'admin-ajax.php' ),
					'redirect' => get_permalink( $this->page_profile_id ),
					'nonce'    => wp_create_nonce( 'auth_nonce' ),
				)
			);
		}
		/**
		 * Revisamos los redirect en funcion de si el usuario esta lougeado o no.
		 */
		public function redirect_is_loggedin() {
			// Si el usuario esta logueado y es la pagina de ingresar, lo redirigimos a la pagina de perfil.
			if ( is_user_logged_in() && is_page( $this->page_login_id ) ) {
				wp_safe_redirect( get_permalink( $this->page_profile_id ), 301 );
				exit;
			}
		}
		/**
		 * Static accessor.
		 *
		 * @return Auth singleton.
		 */
		public static function instance() {
			if ( ! is_object( self::$instance ) ) {
				self::$instance = new Auth();
			}
			return self::$instance;
		}
	}
	Auth::instance();
}
