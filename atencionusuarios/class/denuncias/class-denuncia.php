<?php
/**
 * Ejecuta las funciones para la carga de ddenuncias.
 *
 * @package LucasPessa
 */

if ( ! class_exists( 'ddenuncia' ) ) {
	/**
	 * Class User Profile.
	 */
	class ddenuncia {
		/**
		 * Static accessor.
		 *
		 * @var ddenuncia
		 */
		public static $instance;
		/**
		 * Constructor.
		 */
		public function __construct() {

				//Ejecuto envio de denuncia
				add_action( 'wp_ajax_nopriv_ajaxdenuncia',array($this, 'ajax_denuncia'));
				add_action( 'wp_ajax_ajaxdenuncia',array($this, 'ajax_denuncia'));

				//Inicializo el action para normalizar y geolocalizar la direccion.
				add_action('init', array($this,'ajax_ddenuncia_init'));

				//Inicializo action de envio de dencuncia
				add_action('init', array($this,'ajax_denuncia_init'));
		}
		public function ajax_ddenuncia_init(){

			wp_register_script('ajax-ddenuncia-script', get_template_directory_uri() . '/resources/scripts/ajax-ddenuncia-script.js', array('jquery') ); 
			wp_enqueue_script('ajax-ddenuncia-script');
		
			wp_localize_script( 'ajax-ddenuncia-script', 'ajax_ddenuncia_object', array( 
				'ajaxurl' => 'https://ws.usig.buenosaires.gob.ar/',
				//'redirecturl' => home_url(),
				'loadingmessage' => __('Chequeando informacion, espere...')
			));
		
		}
		public function ajax_denuncia_init(){

			wp_register_script('ajax-denuncia-script', get_template_directory_uri() . '/resources/scripts/ajax-denuncia-script.js', array('jquery') ); 
			wp_enqueue_script('ajax-denuncia-script');
		
			wp_localize_script( 'ajax-denuncia-script', 'ajax_denuncia_object', array( 
				'ajaxurl' => admin_url( 'admin-ajax.php' ),
				//'redirecturl' => home_url(),
				'loadingmessage' => __('Chequeando informacion, espere...')
			));
		
		}
		//ddenuncia por ajax
		public function ajax_denuncia(){
			
			$direccion = $_POST['direccion'];
			$anomalia = $_POST['anomalia'];
			$geox = $_POST['geo-x'];
			$geoy = $_POST['geo-y'];
			$comuna = $_POST['comuna'];
			$barrio = $_POST['barrio'];
			
			//Asocio id user
			$user_id= get_current_user_id();

		
			die();
		}
		
		/**
		 * Static accessor.
		 *
		 * @return ddenuncia singleton.
		 */
		public static function instance() {
			if ( ! is_object( self::$instance ) ) {
				self::$instance = new ddenuncia();
			}
			return self::$instance;
		}
	}
	ddenuncia::instance();
}
