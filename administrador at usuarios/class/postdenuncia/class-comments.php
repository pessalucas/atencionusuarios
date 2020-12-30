<?php
/**
 * Agrega y quita comentarios
 *
 * @package LucasPessa
 */

if ( ! class_exists( 'comments' ) ) {
	/**
	 * Class User Profile.
	 */
	class comments {
		/**
		 * Static accessor.
		 *
		 * @var comments
		 */
		public static $instance;
		/**
		 * Constructor.
		 */
		public function __construct() {

			//Genero comentarios o borro
			add_action( 'wp_ajax_ajaxcomments',array($this, 'ajax_comments'));
			add_action( 'wp_ajax_ajaxdeletecomments',array($this, 'ajax_deletecomments'));

			//Inicializo los ajax para el envio de comentarios de los vecios
			add_action('init', array($this,'ajax_comments_init'));
		}
		/*
		*	Inicializo el ajax de pedidos de denuncias dentro del listado de denuncias
		*/
		public function ajax_comments_init(){

			wp_register_script( 'ajax-comments-script' , get_template_directory_uri() . '/resources/scripts/denunciapost/Comentarios.js', array('jquery') ); 
			wp_enqueue_script( 'ajax-comments-script' );
		
			wp_localize_script( 'ajax-comments-script' , 'ajax_comments_object' , array( 
				'ajaxurl'        => admin_url( 'admin-ajax.php' ),
				'loadingmessage' => __( 'Chequeando informacion, espere...' )
			));
		
			// Enable the user with no privileges to run ajax_comments() in AJAX
		}
		/*
		*	Envio de comentarios asociados a las denuncias por parte de los vecinos
		*/
		public function ajax_comments(){

            //Cambio la global para operar wordpress y sus funciones sobre el sitio At Usuarios
			global $switched;
            switch_to_blog(1);

            $comment       = isset( $_POST['message'] )     ? sanitize_text_field(  $_POST['message'] )     : '';
            $id_denuncia   = isset( $_POST['id_denuncia'] ) ? sanitize_text_field(  $_POST['id_denuncia'] ) : '';
			$id_user       = isset( $_POST['id_user'] )     ? sanitize_text_field(  $_POST['id_user'] )     : '';
			$type          = isset( $_POST['type'] )        ? sanitize_text_field(  $_POST['type'] )        : '';
			
			//Traigo data de usuario
            $user_data = get_userdata( $id_user );

			//Verifico que venga con informacion
			if (   '' === $comment 
				OR '' === $id_denuncia
				OR '' === $id_user
			) {
				wp_send_json_error( 'Error en el pedido de informacion.');	
				 die();
			}

            $commentdata = array(
				'comment_author'    => $user_data->user_login,
				'comment_content' 	=> $comment,
				'user_id'           => $id_user,
                'comment_post_ID'   => $id_denuncia,
                'comment_approved'  => '1',
                'comment_type'      => $type,
            );
            
            if ( $id_comment = wp_insert_comment( $commentdata ) ) { 

                //Tomo la data de la id denuncia
                $commentary            = array();
                $commentaux['comment'] = $comment;
                $commentaux['user']    = $user_data->user_login;
                $commentaux['time']    = date( 'Y-m-d H:i:s', current_time( 'timestamp', 0 ) );
                array_push( $commentary , $commentaux ); //array

				//Si es publico debo mandar mail
				if ( $type == 'public' ){ 
					//Chequeo si lo crea personal del ente
					$user = wp_get_current_user();
					print_r($user);

					//Si lo puso gente de usuarios le mando el mail a la persona
					if ( ( $user->roles[0] == 'usuariosjefe' ) OR ( $user->roles[0] == 'usuarios' ) ){

							$post_data = get_post( $id_denuncia );
							$user_id_mail = $post_data->post_author;
							$user_data = get_userdata( $user_id_mail );
							$link = get_user_meta( $user_id_mail, 'not_login_code' );
							mail_new_comment_atusuarios ( $user->user_nicename, $user_data->user_email, '', $link );
						}
				}
				
                wp_send_json_success( $commentary );		
			}else{
				wp_send_json_error( 'Falla en la carga del comentario. Comuncarse con Modernizacion.' );
			}
			
			wp_die();	}
		/*
		*	Envio de comentarios asociados a las denuncias por parte de los vecinos
		*/
		public function ajax_deletecomments(){

			 //Cambio la global para operar wordpress y sus funciones sobre el sitio At Usuarios
			 global $switched;
			 switch_to_blog(1);
  
			 //Traigo las variables post
			 $id_comment = isset( $_POST['id_comment'] ) ? sanitize_text_field( $_POST['id_comment'] ) : '' ;
   
			 if (
				 '' === $id_comment
			 ) {
				 wp_send_json_error( 'Error en la carga ($id_comment) . Contacte con Modernizacion.');	
				  wp_die();
			 }
  
			 if( wp_delete_comment( $id_comment ) ){
				  wp_send_json_success('Se ha realizado el borrado correctamente.');		
			  }else{
				  wp_send_json_error( 'Error en el borrado del archivo.');	
			 }
  
		   wp_die();
		}
		/**
		 * Static accessor.
		 *
		 * @return comments singleton.
		 */
		public static function instance() {
			if ( ! is_object( self::$instance ) ) {
				self::$instance = new comments();
			}
			return self::$instance;
		}
	}
	comments::instance();
}
