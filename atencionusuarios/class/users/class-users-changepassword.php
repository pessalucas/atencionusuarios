<?php
/**
 * Ejecuta las funciones para el cambio de contraseña.
 *
 * @package LucasPessa
 */

if ( ! class_exists( 'Users_changepassword' ) ) {
	/**
	 * Class User Profile.
	 */
	class Users_changepassword {
		/**
		 * Static accessor.
		 *
		 * @var Users_changepassword
		 */
		public static $instance;
		/**
		 * Constructor.
		 */
		public function __construct() {

			add_action( 'wp_ajax_ajaxchangepassword',array($this, 'ajax_changepassword'));

			// Ejectua si esta logueado
			if (is_user_logged_in()) {
				add_action('init', array($this,'ajax_changepassword_init'));
            }
            
		}
		public function ajax_changepassword_init(){

			wp_register_script('ajax-changepassword-script', get_template_directory_uri() . '/resources/scripts/ajax-changepassword-script.js', array('jquery') ); 
			wp_enqueue_script('ajax-changepassword-script');
		
			wp_localize_script( 'ajax-changepassword-script', 'ajax_changepassword_object', array( 
				'ajaxurl' => admin_url( 'admin-ajax.php' ),
				//'redirecturl' => home_url(),
				'loadingmessage' => __('Chequeando informacion, espere...')
			));
		
		}
		//changepassword por ajax
		public function ajax_changepassword(){

            $password1 = sanitize_text_field( $_POST['password1'] );
			$password2 = sanitize_text_field( $_POST['password2'] );

            //Obtengo user id
            $user_id = get_current_user_id();

            //Chequeo que puso igual las contraseñas
            if($password1==$password2){
                //Seteo password
                wp_set_password( $password1, $user_id );
				echo json_encode(array('loggedin'=>true, 'message'=>__('Contraseña actualizada.')));
			}else{
				echo json_encode(array('loggedin'=>false, 'message'=>__('Error, las contraseñas no coinciden.')));
			}
		
			die();
		}
		
		/**
		 * Static accessor.
		 *
		 * @return Users_changepassword singleton.
		 */
		public static function instance() {
			if ( ! is_object( self::$instance ) ) {
				self::$instance = new Users_changepassword();
			}
			return self::$instance;
		}
	}
	Users_changepassword::instance();
}
