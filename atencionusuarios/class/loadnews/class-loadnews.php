<?php
/**
 * Carga mas noticias en "Noticias" y "Categorias"
 *
 * @package LucasPessa
 */

if ( ! class_exists( 'Users_loadnews' ) ) {
	/**
	 * Class User Profile.
	 */
	class Users_loadnews {
		/**
		 * Static accessor.
		 *
		 * @var Users_loadnews
		 */
		public static $instance;
		/**
		 * Constructor.
		 */
		public function __construct() {
			// Generamos la respuesta del ajax para el pedido de mas noticias.
			add_action( 'wp_ajax_nopriv_ajaxloadnews',array($this, 'ajax_loadnews'));
			add_action( 'wp_ajax_ajaxloadnews',array($this, 'ajax_loadnews'));
			//Inicalizamos el ajax
			add_action('init', array($this,'ajax_loadnews_init'));
		}
		public function ajax_loadnews_init(){

			wp_register_script( 
				'ajax-loadnews-script', 
				get_template_directory_uri() . '/resources/scripts/news/Loadnews.js', 
				array('jquery') ); 

			wp_enqueue_script('ajax-loadnews-script');
		
			wp_localize_script( 
				'ajax-loadnews-script', 
				'ajax_loadnews_object', 
				array( 
				'ajaxurl' 	     =>   admin_url( 'admin-ajax.php' ),
				'nonce'          =>   wp_create_nonce( 'news_nonce' )
			));
	
		}
		//loadnews por ajax
		public function ajax_loadnews(){
		
			// Verificamos a traves de la funcionalidad de captcha de WordPress: Los nonces.
			if ( ! isset( $_POST['nonce'] ) ) {
				wp_send_json_error( 'Error al procesar lo solicitado. Intente nuevamente o contacte con soporte.' );
				wp_die();
			}
			if ( ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), 'news_nonce' ) ) {
				wp_send_json_error( 'Error al procesar lo solicitado. Intente nuevamente o contacte con soporte.' );
				wp_die();
			}
			
			//Envio categoria post por pagina y numero de pagina
			$category	 =   ( ( is_numeric ( $_POST['category'] ) ) OR ( $_POST['category'] == 0 ) ) ? sanitize_text_field(  $_POST['category'] )  : 'NoNum';
			$postperpage =   is_numeric ( $_POST['postperpage'] ) ? sanitize_text_field(  $_POST['postperpage'] )  : '';
			$page 		 =   is_numeric ( $_POST['page'] ) ? sanitize_text_field(  $_POST['page'] )  : '';

			if (
				'NoNum' === $category
			 || '' 	    === $postperpage
			 || ''      === $page
		 ) {
			 wp_send_json_error( 'Error al procesar lo solicitado. Intente nuevamente o contacte con soporte.' );
			 wp_die();
		 }
		
		 	//Segun si estoy en categoria o main filtro query
			if ( $category ){
				$query_post = new WP_Query(
					array(
					'posts_per_page' => $postperpage,
					'post_type' 	 => 'post',
					'paged'  	     => $page ,
					'cat' 		     => $category 
				));
			}else{
				$query_post = new WP_Query(
					array(
					'posts_per_page' => $postperpage,
					'post_type' 	 => 'post',
					'paged'  		 => $page ,
				));
			}
			//Genero array para envio de datos con las pedidas
			$news_list    = array();
			$current_news = array();
			while ( $query_post->have_posts() ) {
				//Obtengo la informacion de los posts y lo guardo en un array
				$query_post->the_post();
				
				$post_id 				   =  get_the_ID();
				$featured_img_url   	   =  get_the_post_thumbnail_url($post_id,'full');  //Obtengo el url de la imagen destacada
				$current_news['title']     =  get_the_title();
				$current_news['excerpt']   =  get_the_excerpt();
				$current_news['permalink'] =  get_the_permalink();
				$current_news['date']      =  get_the_date();
				$current_news['author']    =  get_the_author();
				$current_news['img']       = $featured_img_url;
				array_push( $news_list , $current_news );	//Cargo al array otra rama
				
			 }

			wp_send_json_success(
				array(
				'status'  =>  'success', 
				'news'    =>  $news_list ,
				'message' =>  'Enviado.'
			));
			wp_die();
		}
		
		/**
		 * Static accessor.
		 *
		 * @return Users_loadnews singleton.
		 */
		public static function instance() {
			if ( ! is_object( self::$instance ) ) {
				self::$instance = new Users_loadnews();
			}
			return self::$instance;
		}
	}
	Users_loadnews::instance();
}
