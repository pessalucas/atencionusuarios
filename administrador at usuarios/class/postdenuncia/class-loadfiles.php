<?php
/**
 * Agrega y quita archivos
*
*
*

 * @package LucasPessa
 */

if ( ! class_exists( 'LoadFiles' ) ) {
	/**
	 * Class User Profile.
	 */
	class LoadFiles {
		/**
		 * Static accessor.
		 *
		 * @var LoadFiles
		 */
		public static $instance;
		/**
		 * Constructor.
		 */
		public function __construct() {

				//Ejecuto la carga del archivo
				add_action( 'wp_ajax_ajaxloadfiles',array($this, 'ajax_loadfiles'));

				//Ejecuto el borrado de archivo
				add_action( 'wp_ajax_ajaxdeleteattached',array($this, 'ajax_deleteattached'));

				//Inicializo el action
				add_action('init', array($this,'ajax_loadfiles_init'));
		}
		/*
		*	Encargada de iniciar la funcionalidad del ajax que realiza la creacion del post de denuncia
		*/
		public function ajax_loadfiles_init(){

			wp_register_script('ajax-loadfiles-script', get_template_directory_uri() . '/resources/scripts/denunciapost/FilesLoad.js', array('jquery') ); 
			wp_enqueue_script('ajax-loadfiles-script');
		
			wp_localize_script( 'ajax-loadfiles-script', 'ajax_loadfiles_object', array( 
				'ajaxurl' => admin_url( 'admin-ajax.php' ),
				'loadingmessage' => __('Chequeando informacion, espere...')
			));
		
		}
		/*
		* Realizo la carga de denuncia como post 
		*/
		public function ajax_loadfiles(){
            
            //Cambio la global para operar wordpress y sus funciones sobre el sitio At Usuarios
			global $switched;
            switch_to_blog(1);

			global $post_id;
			global $type;

			//Traigo las variables post
            $type		= isset( $_POST['type'] )    ? sanitize_text_field( $_POST['type'] ) : '' ;
            $post_id    = isset( $_POST['post_id'] ) ? sanitize_text_field( $_POST['post_id'] ) : '' ;
  
			if (
                '' === $type     OR
                '' === $post_id
			) {
				wp_send_json_error( 'Error en la carga ($type or $post_id) . Contacte con Modernizacion.');	
				 wp_die();
            }

			//Verifico que este cargado
            if( ! isset( $_FILES['files'] ) ) { 
                wp_send_json_error( 'Debe realizar una carga de archivo antes de enviar.');	
                wp_die();
			}
			
			$j=0;
			$picture = array();

			//print_r( $_FILES['files'] );

			foreach ( $_FILES['files']['name'] as $file_name ) {

					//Desarmo la carga multiple en individuales
					$picture['name']     = $_FILES['files']['name'][$j];
					$picture['type']     = $_FILES['files']['type'][$j];
					$picture['tmp_name'] = $_FILES['files']['tmp_name'][$j];
					$picture['error']    = $_FILES['files']['error'][$j];
					$picture['size']     = $_FILES['files']['size'][$j];

				if ( $type == 'public' ){
					if (( $picture['type'] != 'image/jpeg' ) AND ( $picture['type'] != 'image/png' )  AND ( $picture['type'] != 'image/jpg' )){
						wp_send_json_error( 'En la seccion de public solo puede cargar imagenes cuya extension sea .png , .jpeg o .jgp.');	
						wp_die();
					}
					$attachment_type = 'Fiscalizacion';
				}else if (  $type == 'private' ){
					$attachment_type = 'Otros';
				}else{
					wp_send_json_error( 'Error en la carga ($type). Contacte con Modernizacion.');	
					wp_die();
				}

			
				//Directorio de subida de wordpress
				$wordpress_upload_dir = wp_upload_dir();
				
				//File path
				$new_file_path = $wordpress_upload_dir['path'] . '/' . $picture['name'];

				//File mime
				$new_file_mime = mime_content_type( $picture['tmp_name'] );

					//Verifico tamano, errores, tipo de archivo y enrutamiento corrrecto. 	
					//Controlo archivo de subida
					if( $picture['error'] ){ 
						wp_send_json_error( 'Se ha producido un error de carga de imagen, intente nuevamente.');
						wp_die();
					}

					if( $picture['size'] > wp_max_upload_size() ){ 
						wp_send_json_error('La imagen es muy pesada, cargue una mas liviana o envie el formulario sin imagen.');
						wp_die();
					}

					if( !in_array( $new_file_mime, get_allowed_mime_types() ) ){ 
						wp_send_json_error( 'El formato de la imagen es inapropiado. Intente nuevamente.');
						wp_die();
					};
					
					while( file_exists( $new_file_path ) ) {
						$i++;
						$new_file_path = $wordpress_upload_dir['path'] . '/' . $i . '_' . $picture['name'];
					}

					//Realizo la carga del archivo
					if( move_uploaded_file( $picture['tmp_name'], $new_file_path ) ) {
		
						$upload_id = wp_insert_attachment( array(
							'guid'           => $new_file_path, 
							'post_mime_type' => $new_file_mime,
							'post_title'     => preg_replace( '/\.[^.]+$/', '', $profilepicture['name'] ),
							'post_content'   => '',
							'post_status'    => 'inherit'
						), $new_file_path, $post_id );
					
					}else{
						wp_send_json_error( 'Error en la carga (move_upload_file). Contacte con Modernizacion.');	
						wp_die();
					}

					// wp_generate_attachment_metadata() won't work if you do not include this file
					require_once( ABSPATH . 'wp-admin/includes/image.php' );

					// Generate and save the attachment metas into the database
					wp_update_attachment_metadata( $upload_id, wp_generate_attachment_metadata( $upload_id, $new_file_path ) );
					
					$data = array(
						'attachment_type'    =>  $attachment_type,
						'post_type'			 => 'denuncia'
					);

					// Genera el tipo de attachment que requiero para filtrar posteriormente
					wp_update_attachment_metadata( $upload_id, $data );
					
			$j=$j+1;
			}

				wp_send_json_success('Se ha realizado la carga correctamente.');		
				wp_die();
		}
			/*
		* Realizo la carga de denuncia como post 
		*/
		public function ajax_deleteattached(){

		   //Cambio la global para operar wordpress y sus funciones sobre el sitio At Usuarios
		   global $switched;
		   switch_to_blog(1);

		   //Traigo las variables post
		   $id_attachment = isset( $_POST['id_attachment'] ) ? sanitize_text_field( $_POST['id_attachment'] ) : '' ;
 
		   if (
			   '' === $id_attachment
		   ) {
			   wp_send_json_error( 'Error en la carga ($id_attachment) . Contacte con Modernizacion.');	
				wp_die();
		   }

		   if( wp_delete_attachment( $id_attachment ) ){
				wp_send_json_success('Se ha realizado el borrado correctamente.');		
			}else{
				wp_send_json_error( 'Error en el borrado del archivo.');	
		   }

		 wp_die();
		}
		/**
		 * Static accessor.
		 *
		 * @return LoadFiles singleton.
		 */
		public static function instance() {
			if ( ! is_object( self::$instance ) ) {
				self::$instance = new LoadFiles();
			}
			return self::$instance;
		}
	}
	LoadFiles::instance();
}
