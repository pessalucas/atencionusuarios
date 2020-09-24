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

				//Dependientes del script denuncia
				//Ejecuto envio de denuncia
				add_action( 'wp_ajax_nopriv_ajaxdenuncia',array($this, 'ajax_denuncia'));
				add_action( 'wp_ajax_ajaxdenuncia',array($this, 'ajax_denuncia'));

				//Dependientes del script ddenuncia
				//Ejecuto el envio de las anomalias asociadas al grupo de anomalias
				add_action( 'wp_ajax_nopriv_ajaxgrupoanomalias',array($this, 'ajax_grupoanomalias'));
				add_action( 'wp_ajax_ajaxgrupoanomalias',array($this, 'ajax_grupoanomalias'));

				//Inicializo el action para normalizar y geolocalizar la direccion.
				add_action('init', array($this,'ajax_ddenuncia_init'));

				//Inicializo action de envio de denuncia y el envio de datos al escoger el grupo de anomalias.
				add_action('init', array($this,'ajax_denuncia_init'));
		}
		/*
		*	Encargada de iniciar la funcionalidad del ajax que realiza la busqueda ajax del mapa de ciudad
		*/
		public function ajax_ddenuncia_init(){

			wp_register_script('ajax-ddenuncia-script', get_template_directory_uri() . '/resources/scripts/ajax-ddenuncia-script.js', array('jquery') ); 
			wp_enqueue_script('ajax-ddenuncia-script');
		
			wp_localize_script( 'ajax-ddenuncia-script', 'ajax_ddenuncia_object', array( 
				'ajaxurl' => 'https://ws.usig.buenosaires.gob.ar/',
				'loadingmessage' => __('Chequeando informacion, espere...')
			));
		
		}
		/*
		*	Encargada de iniciar la funcionalidad del ajax que realiza la creacion del post de denuncia
		*/
		public function ajax_denuncia_init(){

			wp_register_script('ajax-denuncia-script', get_template_directory_uri() . '/resources/scripts/ajax-denuncia-script.js', array('jquery') ); 
			wp_enqueue_script('ajax-denuncia-script');
		
			wp_localize_script( 'ajax-denuncia-script', 'ajax_denuncia_object', array( 
				'ajaxurl' => admin_url( 'admin-ajax.php' ),
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
			$idanomalia = sanitize_text_field( $_POST['anomalia'] );
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

			//Genero una array con las categorias asociadas al desperfecto
			$ids_anomalia=array();
			$term_anomalia = get_term_by('id', $idanomalia, 'servicios');
			$id_anomalia = $term_anomalia->term_id;
			$name_anomalia = $term_anomalia->name;
			$id_parent = $term_anomalia->parent;
			$ids_anomalia[]=$id_anomalia;
			while ($id_parent!= 0) { 
				$term_next = get_term_by('id', $id_parent, 'servicios');
				$id_anomalia =$term_next->term_id;
				$id_parent =$term_next->parent;
				$ids_anomalia[]=$id_anomalia;
			} 
			
			//Asocio id user
			$user_id= get_current_user_id();

			//BUSCAR POST STATUS PUBLISH
			// Create post object
			$nueva_denuncia = array(
				'post_title'    => $name_anomalia,
				'post_author'   => $user_id,
				'post_type'     => 'denuncia',
				'post_status'   => 'publish'
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
			$id_comuna_term = get_idcomuna_by ( $comunanumber );
			$term_comuna = get_term_by('id', $id_comuna_term , 'comuna');
			wp_set_object_terms( $post_id, $term_comuna->term_id , 'comuna' );

			// Cargo la empresa respectiva (punto a desarrollar en algun momento)
			$lenght = sizeof($ids_anomalia);
			$id_empresa = get_idempresa_by ( $ids_anomalia[$lenght-1] , $comunanumber , $ids_anomalia[$lenght-2]);
			wp_set_object_terms( $post_id, $id_empresa , 'empresa' );
	
            //Actualizo los datos no genericos
			update_post_meta( $post_id, 'direccion', $direccion );
			update_post_meta( $post_id, 'geolat', $geolat );
			update_post_meta( $post_id, 'geolong', $geolong );
			update_post_meta( $post_id, 'comuna', $comuna );
			update_post_meta( $post_id, 'barrio', $barrio );
			update_post_meta( $post_id, 'obs', $obs );
			update_post_meta( $post_id, 'expediente', $expediente );
			update_post_meta( $post_id, 'fecha_inicio', $fechahora );

			//Directorio de subida de wordpress
			$wordpress_upload_dir = wp_upload_dir();

			//Tomo el archivo
			$picture = $_FILES['file'];

			//File path
			$new_file_path = $wordpress_upload_dir['path'] . '/' . $picture['name'];

			//File mime
			$new_file_mime = mime_content_type( $picture['tmp_name'] );

			// Cargo el archivo y guardo en el post asociado (consultar)
			//load_file_wp_in_post( $_FILES['file'] , $post_id);

			//Verifico tamano, errores, tipo de archivo y enrutamiento corrrecto. 
			if( isset( $picture ) ) { 
			
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
			}
				echo json_encode(array('loggedin'=>true, 'message'=>__('Se ha creado la denuncia correctamente.')));
			}else{
				echo json_encode(array('loggedin'=>false, 'message'=>__('Error en la creacion de la denuncia')));
			}

			die();
		}
		/*
		* Realizo la busqueda de anomalias dentro del grupo de anomalias.
		*/
		public function ajax_grupoanomalias(){

			$id_grupoanomalias = sanitize_text_field($_GET['id_anomalia']);

			$terms_anomalias = get_terms( array(
				'taxonomy' => 'servicios',
				'hide_empty' => false,
				'parent'   => $id_grupoanomalias
			) );

			//Convierto en array para facilitar la muestra.
			$anomalias=array();
			foreach($terms_anomalias as $term_anomalia){
			$anomalias_part['id'] = $term_anomalia->term_id;
			$anomalias_part['name'] = $term_anomalia->name;
			$anomalias_part['description'] = $term_anomalia->description;
			array_push($anomalias,$anomalias_part);
			}

			if ($anomalias){ 
			echo json_encode(array(
				'status'=>'success', 
                'anomalias'=> $anomalias ,
            ));
			}else{
			echo json_encode(array(
				'status'=>'fail', 
            ));
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
