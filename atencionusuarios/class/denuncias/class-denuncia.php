<?php
/**
 * Ejecuta las funciones para la carga de Denuncias.
 *	1/ Traigo ante la seleccion de las opciones las anomalias pertenecientes al agrupamiento
 *	2/ Ejecuto ajax para normalizar direccion e indicar comuna
 *	3/ Realizo la carga de denuncia como post
 * @package LucasPessa
 */

if ( ! class_exists( 'Denuncias' ) ) {
	/**
	 * Class User Profile.
	 */
	class Denuncias {
		/**
		 * Static accessor.
		 *
		 * @var Denuncias
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

				//Dependientes del script Denuncias
				//Ejecuto el envio de las anomalias asociadas al grupo de anomalias
				add_action( 'wp_ajax_nopriv_ajaxgrupoanomalias',array($this, 'ajax_grupoanomalias'));
				add_action( 'wp_ajax_ajaxgrupoanomalias',array($this, 'ajax_grupoanomalias'));

				//Inicializo el action para normalizar y geolocalizar la direccion.
				add_action('init', array($this,'ajax_direcciondenuncia_init'));

				//Inicializo action de envio de denuncia y el envio de datos al escoger el grupo de anomalias.
				add_action('init', array($this,'ajax_denuncia_init'));

		}
		/*
		*	Encargada de iniciar la funcionalidad del ajax que realiza la busqueda ajax del mapa de ciudad
		*/
		public function ajax_direcciondenuncia_init(){

			wp_register_script('ajax-direcciondenuncia-script', get_template_directory_uri() . '/resources/scripts/denuncias/AuxiliarDenuncia.js', array('jquery') ); 
			wp_enqueue_script('ajax-direcciondenuncia-script');
		
			wp_localize_script( 'ajax-direcciondenuncia-script', 'ajax_direcciondenuncia_object', array( 
				'ajaxurl' => 'https://ws.usig.buenosaires.gob.ar/',
				'loadingmessage' => __('Chequeando informacion, espere...')
			));
		
		}
		/*
		*	Encargada de iniciar la funcionalidad del ajax que realiza la creacion del post de denuncia
		*/
		public function ajax_denuncia_init(){

			wp_register_script('ajax-denuncia-script', get_template_directory_uri() . '/resources/scripts/denuncias/SendDenuncia.js', array('jquery') ); 
			wp_enqueue_script('ajax-denuncia-script');
		
			wp_localize_script( 'ajax-denuncia-script', 'ajax_denuncia_object', array( 
				'ajaxurl' => admin_url( 'admin-ajax.php' ),
				'loadingmessage' => __('Chequeando informacion, espere...')
			));
		
		}
		/*
		* Realizo la carga de denuncia como post 
		*/
		public function ajax_denuncia(){
			
			//Obtengo los valores cargados + fecha y hora
			$idanomalia		= isset( $_POST['anomalia'] ) ? sanitize_text_field( $_POST['anomalia'] ) : '' ;
			$direccion		= isset( $_POST['direccion'] ) ? sanitize_text_field( $_POST['direccion'] ) : '';
			$vereda		    = isset( $_POST['vereda'] ) ? sanitize_text_field( $_POST['vereda'] ) : '';
			$geolat			= isset( $_POST['geolat'] ) ? sanitize_text_field( $_POST['geolat'] ) : '';
			$geolong		= isset( $_POST['geolong'] ) ? sanitize_text_field( $_POST['geolong'] ) : '';
			$comuna			= isset( $_POST['comuna'] ) ? sanitize_text_field( $_POST['comuna'] ) : '';
			$barrio			= isset( $_POST['barrio'] ) ? sanitize_text_field( $_POST['barrio'] ) : '';
			$obs			= isset( $_POST['obs'] ) ? sanitize_text_field( $_POST['obs'] ) : '';
			$email			= isset( $_POST['email'] ) ? sanitize_text_field( $_POST['email'] ) : '';
			$fechahora 		= date( "Y-m-d H:i:s" );  

			// Necesita esta logueado para realizar la denuncia, sino esta le creo cuenta y logueo.
			// @parameter user_status. Genera las 3 posibilidades de login.
			// 1/ Nuevo usuario 
			// 2/ Usuario logueado
			// 3/ Posee usuario pero no esta logueado  
			if ( ( ! is_user_logged_in() ) ) {
				if( '' === $email ){ 
					wp_send_json_error( 'Debe indicar el email para poder realizar la denuncia.');
					wp_die();
					}else{
						if ( email_exists( $email ) ) {
							$user_id = get_user_by( 'email' , $email );
							$user_status = 3;
						}else{ 

							//Creo password
							$user_password = wp_generate_password( 6 , false , false );
				
							//Creo usuario con info
							$user_id = wp_insert_user(
								array(
									'user_pass'            => $user_password,
									'user_login'           => $email,
									'user_email'           => $email,
									'show_admin_bar_front' => false,
									'role'                 => 'denunciante'
								)
							);
							//Inicio sesion
							wp_signon(
								array(
									'user_login'    => $email,
									'user_password' => $user_password,
								)
							); 

							//Sumo code md5 para acceso not_login
							$code_md5 = md5( $email );
							update_user_meta( $user_id, 'not_login_code', $code_md5 );

							$user_status = 1;

							mail_new_user_slow ( '' ,$email ,$user_password ,'' ); 
						}
						 }
			}else{ 
				$user_status = 2;
				$user_id = get_current_user_id(); }


			if (
				'' === $idanomalia
			 || '' === $direccion
			 || '' === $geolat
			 || '' === $geolong
			 || '' === $comuna
			 || '' === $barrio
			 || '' === $obs
			) {
				wp_send_json_error( 'Antes de enviar el formulario debe seleccionar el tipo de anomalia, normalizar la direccion y completar la observacion.');	
				 wp_die();
			}

			//Reconvierto el valor enviado por la api para realizar la carga de la taxonomia
			$comunaarray  = explode(" ", $comuna);
			$comunanumber = $comunaarray[1];

			//Genero una array con las categorias asociadas al desperfecto
			$ids_anomalia   = array();
			$term_anomalia  = get_term_by( 'id', $idanomalia , 'servicios' );
			$id_anomalia    = $term_anomalia->term_id;
			$name_anomalia  = $term_anomalia->name;
			$id_parent      = $term_anomalia->parent;
			$ids_anomalia[] = $id_anomalia;
			while ( $id_parent!= 0 ) { 
				$term_next      = get_term_by( 'id', $id_parent , 'servicios' );
				$id_anomalia    = $term_next->term_id;
				$id_parent      = $term_next->parent;
				$ids_anomalia[] = $id_anomalia;
			} 

			//Excepcion que consulta el estado de la vereda y lo asocia al post si es una denuncia de barrido
			if ( $ids_anomalia [1] == 8 ){
				if (
					'' === $vereda
				) {
					wp_send_json_error( 'Antes de enviar el formulario debe seleccionar las veredas a las que quiere hacer referencia.');	
					 wp_die();
				}
			}

			//Argumentos a cargar como denuncia
			$nueva_denuncia = array(
				'post_title'    => $name_anomalia,
				'post_author'   => $user_id,
				'post_type'     => 'denuncia',
				'post_status'   => 'publish'
			);
			
			// Inserto el post
			if ( $post_id = wp_insert_post( $nueva_denuncia ) ){ 

			//Excepcion que agrega la vereda a la direccion. Solo valido para barrido y limpieza
			if ( $ids_anomalia [1] == 8 ){
				update_post_meta( $post_id, 'vereda', $vereda );
			}

			// Cargo las anomalias respectivas
			wp_set_object_terms( $post_id, $ids_anomalia , 'servicios' );

			// Cargo la procedencia respectiva
			$term_procedencia = get_term_by('slug', 'web', 'procedencia');
			wp_set_object_terms( $post_id, $term_procedencia->term_id , 'procedencia' );

			// Cargo el estado de la denuncia
			$term_estado = get_term_by('slug', 'pre-abierto', 'estado');
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
			update_post_meta( $post_id, 'observacion', $obs );

			//Directorio de subida de wordpress
			$wordpress_upload_dir = wp_upload_dir();

			//Tomo el archivo
			$picture = $_FILES['file'];

			//File path
			$new_file_path = $wordpress_upload_dir['path'] . '/' . $picture['name'];

			//File mime
			$new_file_mime = mime_content_type( $picture['tmp_name'] );

			//Verifico tamano, errores, tipo de archivo y enrutamiento corrrecto. 
			if( isset( $picture ) ) { 
			
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

			$current_user = wp_get_current_user();
			$link = get_user_meta( $user_id, 'not_login_code' );
			mail_new_denuncia ( $current_user->user_firstname , $current_user->user_email , '' , $link );
			
				wp_send_json_success(
					array( 
					'data' 		     => 'La denuncia se ha creado correctamente',
					'user_status'    =>  $user_status,
					'not_login_code' =>	 $code_md5
				));		
				wp_die();
			}else{
				wp_send_json_error('Se ha producido un error de carga. Intente nuevamente.');		
				 wp_die();
			}
		}
		/*
		* Realizo la busqueda de anomalias dentro del grupo de anomalias.
		*/
		public function ajax_grupoanomalias(){

			$id_grupoanomalias = isset( $_GET['id_anomalia'] ) ? sanitize_text_field( $_GET['id_anomalia'] ) : '';

			if ( '' === $id_grupoanomalias ) {
				wp_send_json_error( 'Error en el pedido de informacion.');	
				 wp_die();
			}

			$terms_anomalias = get_terms( 
				array(
				'taxonomy'   => 'servicios',
				'hide_empty' => false,
				'parent'     => $id_grupoanomalias
			) );

			//Convierto en array para facilitar la muestra.
			$anomalias = array();
			foreach( $terms_anomalias as $term_anomalia ){
			$anomalias_part['id']          = $term_anomalia->term_id;
			$anomalias_part['name']        = $term_anomalia->name;
			$anomalias_part['description'] = $term_anomalia->description;
			array_push( $anomalias , $anomalias_part );
			}

			if ( $anomalias ){ 
				wp_send_json_success( 
					array(
                	'anomalias' => $anomalias ,
					)
				);		
			}else{
				wp_send_json_error( 'Error en la busqueda de datos con dicho id.');	
			}
			die();
		 }
		/**
		 * Static accessor.
		 *
		 * @return Denuncias singleton.
		 */
		public static function instance() {
			if ( ! is_object( self::$instance ) ) {
				self::$instance = new Denuncias();
			}
			return self::$instance;
		}
	}
	Denuncias::instance();
}
