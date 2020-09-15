<?php
/**
 * Carga mas noticias en "noticias"
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

			add_action( 'wp_ajax_nopriv_ajaxloadnews',array($this, 'ajax_loadnews'));
			add_action( 'wp_ajax_ajaxloadnews',array($this, 'ajax_loadnews'));

			add_action('init', array($this,'ajax_loadnews_init'));
			
		}
		public function ajax_loadnews_init(){

			wp_register_script('ajax-loadnews-script', get_template_directory_uri() . '/resources/scripts/ajax-loadnews-script.js', array('jquery') ); 
			wp_enqueue_script('ajax-loadnews-script');
		
			wp_localize_script( 'ajax-loadnews-script', 'ajax_loadnews_object', array( 
				'ajaxurl' => admin_url( 'admin-ajax.php' ),
				//'redirecturl' => home_url(),
				'loadingmessage' => __('Chequeando informacion, espere...')
			));
		

		}
		//loadnews por ajax
		public function ajax_loadnews(){
		
			//Envio categoria post por pagina y numero de pagina
			$category= sanitize_text_field(  $_POST['category'] );
			$postperpage= sanitize_text_field(  $_POST['postperpage'] );
			$page = sanitize_text_field(  $_POST['page'] );
			if ($category){
				$query_post=new WP_Query(array(
					'posts_per_page' => $postperpage,
					'post_type' => 'post',
					'paged'  => $page ,
					'cat' => $id_category 
				));
			}else{
				$query_post=new WP_Query(array(
					'posts_per_page' => $postperpage,
					'post_type' => 'post',
					'paged'  => $page ,
				));
			}


			$news_list=array();
			while ( $query_post->have_posts() ) {
				
				$current_news=array();
				//Obtengo la informacion de los posts
				$query_post->the_post();
				$post_id=get_the_ID();
				//print_r( $query_post );
				
				//Obtengo el url de la imagen destacada
				$featured_img_url = get_the_post_thumbnail_url($post_id,'full'); 

	
				$current_news['title'] =  get_the_title();
				$current_news['excerpt'] =  get_the_excerpt();
				$current_news['permalink'] =  get_the_permalink();
				$current_news['date'] =  get_the_date();
				$current_news['author'] =  get_the_author();
				$current_news['img'] = $featured_img_url;
				
				array_push($news_list,$current_news);
			 }

			echo json_encode(array(
				'status'=>'success', 
				'news'=> $news_list ,
				'message' => 'Enviado.'
			));
			die();

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
