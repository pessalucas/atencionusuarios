<?php
/**
 * Ejecuta las funciones para el comment.
 *
 * @package LucasPessa
 */

if ( ! class_exists( 'Users_comment' ) ) {
	/**
	 * Class User Profile.
	 */
	class Users_comment {
		/**
		 * Static accessor.
		 *
		 * @var Users_comment
		 */
		public static $instance;
		/**
		 * Constructor.
		 */
		public function __construct() {

			add_action( 'wp_ajax_ajaxcomment',array($this, 'ajax_comment'));

			add_action('init', array($this,'ajax_comment_init'));
		}
		public function ajax_comment_init(){

			wp_register_script('ajax-comment-script', get_template_directory_uri() . '/resources/scripts/ajax-comment-script.js', array('jquery') ); 
			wp_enqueue_script('ajax-comment-script');
		
			wp_localize_script( 'ajax-comment-script', 'ajax_comment_object', array( 
				'ajaxurl' => admin_url( 'admin-ajax.php' ),
				'redirecturl' => home_url(),
				'loadingmessage' => __('Chequeando informacion, espere...')
			));
		
			// Enable the user with no privileges to run ajax_comment() in AJAX
		}
		//comment por ajax
		public function ajax_comment(){
		
            $comment = $_POST['message'];
            $post_id = $_POST['post_id'];
            $user_id = get_current_user_id();
            $user_data = get_userdata( $user_id );


            $commentdata = array(
				'comment_author'    => $user_data->user_login,
				'comment_content' 	=> $comment,
				'user_id'           => $user_id,
                'comment_post_ID'   => $post_id,
                'comment_approved'  => '1'
				//'post_status'   => 'publish'
            );
            
            if ( wp_insert_comment( $commentdata ) ) { 

                //Tomo la data de la id denuncia
                $commentary=array();
                $commentaux['comment'] = $comment;
                $commentaux['user'] = $user_data->user_login;
                $commentaux['time'] = date( 'Y-m-d H:i:s', current_time( 'timestamp', 0 ) );
                array_push($commentary,$commentaux); //array

                echo json_encode(array(
                    'status'=>'success', 
                    'commentary'=> $commentary 
                ));
			}else{
				echo json_encode(array('loggedin'=>false, 'message'=>__('Error de usuario o contraseña. Volve a intentarlo.')));
			}
		
			die();
		}
		
		/**
		 * Static accessor.
		 *
		 * @return Users_comment singleton.
		 */
		public static function instance() {
			if ( ! is_object( self::$instance ) ) {
				self::$instance = new Users_comment();
			}
			return self::$instance;
		}
	}
	Users_comment::instance();
}
