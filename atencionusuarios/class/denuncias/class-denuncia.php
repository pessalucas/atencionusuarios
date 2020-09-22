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
		/*
		* Realizo la carga de un file y su asignacion a un post correspondiente
		*/
		public function load_file_wp_in_post( $files,$post_id ){

			//Directorio de subida de wordpress
			$wordpress_upload_dir = wp_upload_dir();

			//Tomo el archivo
			$picture = $files;

			//File path
			$new_file_path = $wordpress_upload_dir['path'] . '/' . $picture['name'];

			//File mime
			$new_file_mime = mime_content_type( $picture['tmp_name'] );

			//Verifico tamano, errores, tipo de archivo y enrutamiento corrrecto. 
			if( empty( $picture ) )
				die( 'File is not selected.' );

			if( $picture['error'] )
				die( $picture['error'] );
			
			if( $picture['size'] > wp_max_upload_size() )
				die( 'It is too large than expected.' );
			
			if( !in_array( $new_file_mime, get_allowed_mime_types() ) )
				die( 'WordPress doesn\'t allow this type of uploads.' );
			
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
			}

			// wp_generate_attachment_metadata() won't work if you do not include this file
			require_once( ABSPATH . 'wp-admin/includes/image.php' );

			// Generate and save the attachment metas into the database
			wp_update_attachment_metadata( $upload_id, wp_generate_attachment_metadata( $upload_id, $new_file_path ) );
			
			$data = array(
				'attachment_type'    => 'FotoDenunciante',
				'post_type'			 => 'denuncia'
			);

			// Genera el tipo de attachment que requiero para filtrar posteriormente
			wp_update_attachment_metadata( $upload_id, $data );
			
			return $upload_id;
		}
		/*
		* Realizo la carga de denuncia como post 
		*/
		public function ajax_denuncia(){
			

			//Obtengo los valores cargados
			$anomalia = sanitize_text_field( $_POST['anomalia'] );
			$direccion= sanitize_text_field( $_POST['direccion'] );
			$geolat= sanitize_text_field( $_POST['geolat'] );
			$geolong= sanitize_text_field( $_POST['geolong'] );
			$comuna= sanitize_text_field( $_POST['comuna'] );
			$barrio= sanitize_text_field( $_POST['barrio'] );
			$obs= sanitize_text_field( $_POST['obs'] );
			$fechahora = date("Y-m-d H:i:s");  

			//Reconvierto el valor enviado por la api para realizar la carga de la taxonomia
			$comunaarray = explode(" ", $comuna);
			$comunanumber=$comunaarray[1];

			$ids_anomalia=array();
			//Obtengo categoria y servicio
			$term_anomalia = get_term_by('slug', $anomalia, 'servicios');
			$ids_anomalia[]=$term_anomalia->term_id;
			$ids_anomalia[]=$term_anomalia->parent;
			//Obtengo depto
			$term_service = get_term_by('id', $term_anomalia->parent, 'servicios');
			$ids_anomalia[]=$term_service->parent;

			//Asocio id user
			$user_id= get_current_user_id();

			//BUSCAR POST STATUS PUBLISH
			// Create post object
			$nueva_denuncia = array(
				'post_title'    => $anomalia,
				'post_date' 	=> $fechahora,
				'post_author'   => $user_id,
				'post_type'     => 'denuncia',
				//'post_status'   => 'publish'
			);
						

			// Inserto el post
			if ( $post_id = wp_insert_post( $nueva_denuncia ) ){ 

			// Cargo las anomalias respectivas
			wp_set_object_terms( $post_id, $ids_anomalia , 'servicios' );

			// Cargo la procedencia respectiva
			$term_procedencia = get_term_by('slug', 'web', 'procedencia');
			wp_set_object_terms( $post_id, $term_procedencia->term_id , 'procedencia' );

			// Cargo el estado de la denuncia
			$term_estado = get_term_by('slug', 'abierto', 'estado');
			wp_set_object_terms( $post_id, $term_estado->term_id , 'estado' );
			
			// Cargo la comuna respectiva
			$term_comuna = get_term_by('slug', $comunanumber , 'comuna');
			wp_set_object_terms( $post_id, $term_comuna->term_id , 'comuna' );

			// Cargo la empresa respectiva (punto a desarrollar en algun momento)
			//wp_set_object_terms( $post_id, $ids_anomalia , 'servicios' );
	
            //Actualizo los datos no genericos
			update_post_meta( $post_id, 'direccion', $direccion );
			update_post_meta( $post_id, 'geolat', $geolat );
			update_post_meta( $post_id, 'geolong', $geolong );
			update_post_meta( $post_id, 'comuna', $comuna );
			update_post_meta( $post_id, 'barrio', $barrio );
			update_post_meta( $post_id, 'obs', $obs );
			update_post_meta( $post_id, 'expediente', $expediente );
			update_post_meta( $post_id, 'fecha_inicio', $fechahora );

			// Cargo el archivo y guardo en el post asociado (consultar)
			//load_file_wp_in_post( $_FILES['file'] , $post_id);

			//Directorio de subida de wordpress
			$wordpress_upload_dir = wp_upload_dir();

			//Tomo el archivo
			$picture = $_FILES['file'];

			//File path
			$new_file_path = $wordpress_upload_dir['path'] . '/' . $picture['name'];

			//File mime
			$new_file_mime = mime_content_type( $picture['tmp_name'] );

			//Verifico tamano, errores, tipo de archivo y enrutamiento corrrecto. 
			if( empty( $picture ) )
				die( 'File is not selected.' );

			if( $picture['error'] )
				die( $picture['error'] );
			
			if( $picture['size'] > wp_max_upload_size() )
				die( 'It is too large than expected.' );
			
			if( !in_array( $new_file_mime, get_allowed_mime_types() ) )
				die( 'WordPress doesn\'t allow this type of uploads.' );
			
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
			}

			// wp_generate_attachment_metadata() won't work if you do not include this file
			require_once( ABSPATH . 'wp-admin/includes/image.php' );

			// Generate and save the attachment metas into the database
			wp_update_attachment_metadata( $upload_id, wp_generate_attachment_metadata( $upload_id, $new_file_path ) );
			
			$data = array(
				'attachment_type'    => 'FotoDenunciante',
				'post_type'			 => 'denuncia'
			);

			// Genera el tipo de attachment que requiero para filtrar posteriormente
			wp_update_attachment_metadata( $upload_id, $data );
			
				echo json_encode(array('loggedin'=>true, 'message'=>__('Se ha creado la denuncia correctamente.')));
			}else{
				echo json_encode(array('loggedin'=>false, 'message'=>__('Error en la creacion de la denuncia')));
			}

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
