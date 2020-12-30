<?php
/**
 * Ejecuta las funciones para el listado de denuncias, detallado de las mismas y agregado de comentarios asociados.
 *
 * @package LucasPessa
 */

if ( ! class_exists( 'ListadoDenuncias' ) ) {
	/**
	 * Class User Profile.
	 */
	class ListadoDenuncias {
		/**
		 * Static accessor.
		 *
		 * @var ListadoDenuncias
		 */
		public static $instance;
		/**
		 * Constructor.
		 */
		public function __construct() {

			//Genero los ganchos para el pedido de informacion denuncia dentro del listado de denuncias
            add_action( 'wp_ajax_nopriv_ajaxlistadodenuncias',array($this, 'ajax_listadodenuncias'));
            add_action( 'wp_ajax_ajaxlistadodenuncias',array($this, 'ajax_listadodenuncias'));

			//Genero los ganchos para el envio de comentarios via ajax a las denuncias asociadas
			add_action( 'wp_ajax_ajaxcomment',array($this, 'ajax_comment'));
			add_action( 'wp_ajax_nopriv_ajaxcomment',array($this, 'ajax_comment'));

			//Inicializo los ajax para el listado de denuncias
			add_action('init', array($this,'ajax_listadodenuncias_init'));

			//Inicializo los ajax para el envio de comentarios de los vecios
			add_action('init', array($this,'ajax_comment_init'));
		}
		/*
		*	Inicializo el ajax de pedidos de denuncias dentro del listado de denuncias
		*/
		public function ajax_listadodenuncias_init(){

			wp_register_script( 'ajax-listadodenuncias-script' , get_template_directory_uri() . '/resources/scripts/listadodenuncias/ListadoDenuncias.js', array('jquery') ); 
			wp_enqueue_script( 'ajax-listadodenuncias-script' );
		
			wp_localize_script( 'ajax-listadodenuncias-script' , 'ajax_listadodenuncias_object' , array( 
				'ajaxurl'        => admin_url( 'admin-ajax.php' ),
				'redirecturl'    => home_url(),
				'loadingmessage' => __( 'Chequeando informacion, espere...' )
			));
		
			// Enable the user with no privileges to run ajax_listadodenuncias() in AJAX
		}
		/*
		*	Inicializo el ajax de realizacion de comentarios de los vecinos
		*/
		public function ajax_comment_init(){

			wp_register_script('ajax-comment-script', get_template_directory_uri() . '/resources/scripts/listadodenuncias/Comentarios.js', array('jquery') ); 
			wp_enqueue_script('ajax-comment-script');
		
			wp_localize_script( 'ajax-comment-script', 'ajax_comment_object', array( 
				'ajaxurl'        => admin_url( 'admin-ajax.php' ),
				'redirecturl'    => home_url(),
				'loadingmessage' => __('Chequeando informacion, espere...')
			));
		}
		/*
		*	Envia al listado de denuncia los ajax de las denuncias
		*/
		public function ajax_listadodenuncias(){
        
            //Tomo id de denucia
            $iddenuncia =  isset( $_POST['iddenuncia'] ) ? sanitize_text_field( wp_unslash( $_POST['iddenuncia']) ) : '';

			//Verifico que venga con informacion
			if ( '' === $iddenuncia ) {
				wp_send_json_error( 'Error en el pedido de informacion.');	
				 die();
			}
		
            //Obtengo taxonomys de estado y tipo de servicio
            $estado    = get_the_terms( $iddenuncia, 'estado' ); //array
            $servicios = get_the_terms( $iddenuncia, 'servicios' ); //array

            //Tomo la data de la id denuncia y genero un array para enviar
            $datageneral=array();
            $data['id']           = $iddenuncia;
            $data['direccion']    = get_post_meta( $iddenuncia, 'direccion', true );
            $data['barrio']       = get_post_meta( $iddenuncia, 'barrio', true );
            $data['obs']          = get_post_meta( $iddenuncia, 'observacion', true );
            $data['fecha']        = get_the_date( 'd M Y', $iddenuncia );
            array_push( $datageneral , $data ); //array

            //Tomo los atachmente de la denuncia y genero una array para el envio de informacion
            $attachedsfilter=array();
            $attacheds = get_attached_media( '' , $iddenuncia );
            foreach ($attacheds as $attached){
				$img_src = wp_get_attachment_image_src($attached->ID, 'small');
				$attachment_metadata = wp_get_attachment_metadata( $attached->ID );
                $attachedd['ID']              = $attached->ID;
                $attachedd['post_author']     = get_the_author_meta( 'email',  $attached->post_author );
                $attachedd['post_date']       = $attached->post_date;
                $attachedd['guid']         	  = $img_src[0];
                $attachedd['attachment_type'] = $attachment_metadata['attachment_type'];
                array_push($attachedsfilter,$attachedd); //array
            }   

           //Tomo los comentarios de la id den
            $args = array(
				'post_id' => $iddenuncia, 
				'orderby' => 'date',
				'order'   => 'ASC'
            );
            $comments = get_comments( $args );  //array

			//Envio la informacion completa
            echo json_encode(array(
				'status'      =>'success', 
                'estado'      => $estado ,
                'datageneral' => $datageneral ,
                'servicios'   => $servicios ,
                'attacheds'   => $attachedsfilter ,
                'comments'    => $comments 
            ));
        
            die();
		}
		/*
		*	Envio de comentarios asociados a las denuncias por parte de los vecinos
		*/
		public function ajax_comment(){
		
            $comment   = isset( $_POST['message'] ) ? sanitize_text_field(  $_POST['message'] ) : '';
            $post_id   = isset( $_POST['post_id'] ) ? sanitize_text_field(  $_POST['post_id'] ) : '';
			$user_id   = isset( $_POST['user_id'] ) ? sanitize_text_field(  $_POST['user_id'] ) : '';
			
			//Traigo data de usuario
            $user_data = get_userdata( $user_id );

			//Verifico que venga con informacion
			if (   '' === $comment 
				OR '' === $post_id
				OR '' === $user_id
			) {
				wp_send_json_error( 'Error en el pedido de informacion.');	
				 die();
			}

            $commentdata = array(
				'comment_author'    => $user_data->user_login,
				'comment_content' 	=> $comment,
				'user_id'           => $user_id,
                'comment_post_ID'   => $post_id,
				'comment_approved'  => '1',
				'comment_type'      => 'public'
            );
            
            if ( wp_insert_comment( $commentdata ) ) { 

                //Tomo la data de la id denuncia
                $commentary            = array();
                $commentaux['comment'] = $comment;
                $commentaux['user']    = $user_data->user_login;
                $commentaux['time']    = date( 'Y-m-d H:i:s', current_time( 'timestamp', 0 ) );
                array_push( $commentary , $commentaux ); //array


					$user = wp_get_current_user();
					//print_r($user);
					//Si lo puso una persona aviso a usuarios
					if ( ( $user->roles[0] == 'denunciante' ) OR ( $user->roles[0] == 'suscriptor' ) ){
							//Envio de mail
							mail_new_comment_vecino ( $user->user_nicename, '', '', $post_id );
					}

                echo json_encode( array(
                    'status'     => 'success', 
                    'commentary' => $commentary 
                ));
			}else{
				echo json_encode( array('loggedin'=>false, 'message'=>__('Error de usuario o contraseña. Volve a intentarlo.')));
			}
			
			die();	}
		/**
		 * Static accessor.
		 *
		 * @return ListadoDenuncias singleton.
		 */
		public static function instance() {
			if ( ! is_object( self::$instance ) ) {
				self::$instance = new ListadoDenuncias();
			}
			return self::$instance;
		}
	}
	ListadoDenuncias::instance();
}
