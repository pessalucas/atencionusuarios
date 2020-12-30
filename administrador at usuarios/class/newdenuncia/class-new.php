<?php
/**
 * NewDenuncia de clases
 *
 * @package atencionusuarios
 */

if ( ! class_exists( 'NewDenuncia' ) ) {
	/**
	 * Class NewDenuncia
	 */
	class NewDenuncia {
		/**
		 * Static accessor.
		 *
		 * @var NewDenuncia
		 */
		public static $instance;
		/**
		 * Constructor.
		 */
		public function __construct() {

		// Generamos la respuesta del ajax para el registro.
		add_action( 'wp_ajax_wp_searcherusers', array( $this, 'ajax_wp_searcherusers' ) );
		
		// Generamos la respuesta ante el pedido de informacion del email elegido
		add_action( 'wp_ajax_wp_userdata', array( $this, 'ajax_wp_userdata' ) );
		
		// Generamos el usuario correspondiente a la informacion ofrecida
		add_action( 'wp_ajax_wp_registeruser', array( $this, 'ajax_wp_registeruser' ) );
		
		// Traigo los grupos de anomalias posterior a seleccionar el servicio
		add_action( 'wp_ajax_wp_getgrupoanomalias', array( $this, 'ajax_wp_getgrupoanomalias' ) );
		
		// Traigo las anomalias posterior a seleccionar el grupo de anomalias
		add_action( 'wp_ajax_wp_getanomalias', array( $this, 'ajax_wp_getanomalias' ) );
		
		// Ejecuto la carga de la nueva denuncia
        add_action( 'wp_ajax_wp_newdenuncia', array( $this, 'ajax_wp_newdenuncia' ) );

        // Registramos los scripts o estilos necesarios.
        add_action( 'wp_enqueue_scripts', array( $this, 'register_assets' ) );
		}
        /**
		 * Registramos los assets necesarios para el template de login.
		 */
		public function register_assets() {
			wp_enqueue_script(
				'wp_NewDenuncia',
				get_stylesheet_directory_uri() . '/resources/scripts/denuncianueva/NuevaDen.js',
				array(),
				'1.0.0',
				true
			);
			wp_localize_script(
				'wp_NewDenuncia',
				'wp_NewDenuncia',
				array(
					'ajax'     => admin_url( 'admin-ajax.php' ),
				)
			);
        }
        /**
		 * Ejecuto el buscador
		 */
		public function ajax_wp_searcherusers() {

			//Cambio la global para operar wordpress y sus funciones sobre el sitio At Usuarios
			global $switched;
            switch_to_blog(1);

			//Traigo la informacion
            $user_data  = isset( $_POST['user_data'] ) ? sanitize_text_field( wp_unslash ( $_POST['user_data'] ) ) : '';	
	
			if( is_numeric( $user_data ) ){

				$args = array( 
					'meta_key' => 'dni', 
					'meta_value' => $user_data 
				);
				
				// The Query
				$user_query = new WP_User_Query( $args );

				if ( ! empty( $user_query->get_results() ) ) {

					$user_email =  $user_query->get_results()[0]->data->user_email;
					wp_send_json_success( array ( $user_email ) );
					wp_die();
				} else {
					wp_send_json_success( array ( 'No se encontraron usuarios con ese DNI.') );
					wp_die();
				}
				
			}else{
									//search usertable
					$wp_user_query = new WP_User_Query(
						array(
						'search' => "*{$user_data}*",
						'search_columns' => array(
						'user_login',
						'user_nicename',
						'user_email',
						),
					
					) );
					$users = $wp_user_query->get_results();
					
					//search usermeta
					$wp_user_query2 = new WP_User_Query(
						array(
						'meta_query' => array(
						'relation' => 'OR',
							array(
							'key' => 'first_name',
							'value' => $user_data,
							'compare' => 'LIKE'
							),
						array(
							'key' => 'last_name',
							'value' => $user_data,
							'compare' => 'LIKE'
							)
						)
						)
					);
					
					$users2 = $wp_user_query2->get_results();
					
					$totalusers_dup = array_merge($users,$users2);
					
					$totalusers = array_unique($totalusers_dup, SORT_REGULAR);
				
				// User Loop
				if ( ! empty( $totalusers ) ) {
					$users_mail = array();
					$count = 0;
					foreach ( $totalusers as $user ) {
						array_push( $users_mail , $user->user_email ); 
						if ( $count == 5 ){ break; }
						$count++;
					}
					wp_send_json_success( $users_mail );
					wp_die();
				} else {
					wp_send_json_success( array ( 'No se encontraron usuarios con ese mail u nombre.' ) );
					wp_die();
				}
				
			}
            
			wp_send_json_fail( 'Salio al final' );
			wp_die();
		}
		 /**
		 * Ejecuto el buscador
		 */
		public function ajax_wp_userdata() {

			//Cambio la global para operar wordpress y sus funciones sobre el sitio At Usuarios
			global $switched;
            switch_to_blog(1);

			//Traigo la informacion
            $user_email  = isset( $_POST['user_email'] ) ? sanitize_text_field( wp_unslash ( $_POST['user_email'] ) ) : '';	
	
			if ( $user_info = get_user_by( 'email' ,  $user_email ) ){
				$user_data = array();
				$user_data['ID']        = $user_info->ID;
				$user_info_generic      = get_userdata( $user_info->ID );
				$user_data['firstname'] = $user_info_generic->first_name;
				$user_data['lastname']  = $user_info_generic->last_name;
				$user_data['email']     = $user_email;
				$user_data['dni']       = get_user_meta(  $user_info->ID , 'dni', true );
				$user_data['phone']     = get_user_meta(  $user_info->ID , 'telefono', true );
				$user_data['adress']    = get_user_meta(  $user_info->ID , 'direccion', true );
				$user_data['message']   = 'El usuario fue asignado a la denuncia.';
				wp_send_json_success( $user_data );
				wp_die();
			}

			wp_send_json_fail( 'Error, contactese con Modernizacion.' );
			wp_die();
		}
		 /**
		 * Ejecuto el registro de usuario
		 */
		public function ajax_wp_registeruser() {

			//Cambio la global para operar wordpress y sus funciones sobre el sitio At Usuarios
			global $switched;
            switch_to_blog(1);

			//Traigo la informacion
 			$user_firstname = isset( $_POST['firstname'] ) ? sanitize_text_field( wp_unslash( $_POST['firstname'] ) ) : '';
			$user_lastname  = isset( $_POST['lastname'] )  ? sanitize_text_field( wp_unslash( $_POST['lastname'] ) )  : '';
			$user_email     = isset( $_POST['email'] )     ? sanitize_email( wp_unslash( $_POST['email'] ) )          : '';
			$user_phone     = isset( $_POST['phone'] )     ? sanitize_text_field( wp_unslash( $_POST['phone'] ) )     : '';
			$user_dni       = isset( $_POST['dni'] )       ? sanitize_text_field( wp_unslash( $_POST['dni'] ) )       : '';
			$user_address   = isset( $_POST['address'] )   ? sanitize_text_field( wp_unslash( $_POST['address'] ) )   : '';
			$user_id 	    = isset( $_POST['userid'] )    ? sanitize_text_field( wp_unslash( $_POST['userid'] ) )    : '';
			$type           = isset( $_POST['type'] )      ? sanitize_text_field( wp_unslash( $_POST['type'] ) )      : '';


				if (
					'' === $user_email
				) {
					wp_send_json_error( array( 
						'message' => 'Error al procesar lo solicitado. Complete el campo obligatorio "Email".',
						) );
					wp_die();
				}

				//Creo nuevo tipo
			if ( $type == 'new' ){ 

				$args = array( 
					'meta_key' => 'dni', 
					'meta_value' => $user_dni 
				);
				
				// The Query
				$user_query = new WP_User_Query( $args );

				if ( ( ( $user_query->get_results() ) ) AND ( $user_dni != '' ) ) {
						wp_send_json_error( array( 
							'message' => 'Ya existe un usuario con ese DNI',
							) );
						wp_die();
				}

				if ( email_exists( $user_email ) ) {
					wp_send_json_error( array( 
						'message' => 'Ya existe un usuario con ese correo electronico.',
						) );
					wp_die();
				}


				$user_id = wp_insert_user(
					array(
						'user_pass'            => $user_pass,
						'user_login'           => $user_email,
						'user_email'           => $user_email,
						'first_name'           => $user_firstname,
						'last_name'            => $user_lastname,
						'show_admin_bar_front' => false,
						'role'                 => 'denunciante',
					)
				);

				if ( is_wp_error( $user_id ) ) {
					wp_send_json_error( array( 
						'message' => 'Error de WordPress. Contacte a soporte.',
						));
					wp_die();
				}

				//Sumo code md5 para acceso not_login
				$code_md5 = md5( $user_email );

				update_user_meta( $user_id, 'dni', $user_dni );
				update_user_meta( $user_id, 'telefono', $user_phone );
				update_user_meta( $user_id, 'direccion', $user_address );
				update_user_meta( $user_id, 'not_login_code', $code_md5 );

				wp_send_json_success( array( 
					'message'  =>  'Usuario registrado correctamente y asignado a la denuncia.',
					'user_id'  =>  $user_id
					) );
				wp_die();

				//Actualizo informacion
			}else if( $type == 'update' ){

				$args = array( 
					'meta_key' => 'dni', 
					'meta_value' => $user_dni 
				);
				
				// The Query
				$user_query = new WP_User_Query( $args );

				if ( ( ( $user_query->get_results() ) ) AND ( $user_dni != '' ) ) {
					if( $user_query->get_results()[0]->data->ID != $user_id ){ 
						wp_send_json_error( array( 
							'message' => 'Ya existe un usuario con ese DNI',
							) );
						wp_die();
					}
				}

				if ( email_exists( $user_email ) != $user_id ) {
					wp_send_json_error( array( 
						'message' => 'No puede modificar el Email del usuario.',
						) );
					wp_die();
				}

				$update_nick = wp_update_user([
					'ID'         => $user_id, 
					'first_name' => $user_firstname,
					'last_name'  => $user_lastname,
				]);

				if( is_wp_error( $update_nick ) ){
					wp_send_json_error( array( 
						'message' => 'Error de WordPress. Contacte a soporte.',
						) );
					wp_die();
				}

				update_user_meta( $user_id, 'dni', $user_dni );
				update_user_meta( $user_id, 'telefono', $user_phone );
				update_user_meta( $user_id, 'direccion', $user_address );

				wp_send_json_success( array( 
					'message' => 'Usuario actualizado correctamente y asignado a la denuncia.',
					'user_id' => $user_id
					) );
				wp_die();
			}
		}
		/**
		 * 	Traigo los grupos de anomalias
		 */
		public function ajax_wp_getgrupoanomalias() {

			//Cambio la global para operar wordpress y sus funciones sobre el sitio At Usuarios
			global $switched;
            switch_to_blog(1);

			//Traigo la informacion
            $id_servicio  = isset( $_POST['id_servicio'] ) ? sanitize_text_field( wp_unslash ( $_POST['id_servicio'] ) ) : '';	
			
			if (
				'' === $id_servicio
		 	) {
			 wp_send_json_error( array( 
				 'message' => 'Error al procesar lo solicitado. Contacte a modernizacion.',
				 ) );
			 wp_die();
			 }
			 
			 $terms_grupoanomalias = get_terms( array(
				'taxonomy'   => 'servicios',
				'hide_empty' => false,
				'parent'     => $id_servicio
			) );

			$data_grupoanomalias = array();
			foreach( $terms_grupoanomalias as $grupoanomalias ){
				$data_grupoanomalia['ID']   = $grupoanomalias->term_id;
				$data_grupoanomalia['name'] = $grupoanomalias->name;
				array_push( $data_grupoanomalias , $data_grupoanomalia ); 
			}

			wp_send_json_success( $data_grupoanomalias );
			wp_die();
		}
		/**
		 * 	Traigo los grupos de anomalias
		 */
		public function ajax_wp_getanomalias() {

			//Cambio la global para operar wordpress y sus funciones sobre el sitio At Usuarios
			global $switched;
            switch_to_blog(1);

			//Traigo la informacion
            $id_grupoanomalias  = isset( $_POST['id_grupoanomalias'] ) ? sanitize_text_field( wp_unslash ( $_POST['id_grupoanomalias'] ) ) : '';	
			
			if (
				'' === $id_grupoanomalias
		 	) {
			 wp_send_json_error( array( 
				 'message' => 'Error al procesar lo solicitado. Contacte a modernizacion.',
				 ) );
			 wp_die();
			 }
			 
			 $terms_anomalias = get_terms( array(
				'taxonomy'   => 'servicios',
				'hide_empty' => false,
				'parent'     => $id_grupoanomalias
			) );

			$data_anomalias = array();
			foreach( $terms_anomalias as $anomalia ){
				$data_anomalia['ID']   = $anomalia->term_id;
				$data_anomalia['name'] = $anomalia->name;
				array_push( $data_anomalias , $data_anomalia ); 
			}

			wp_send_json_success( $data_anomalias );
			wp_die();
		}
		 /**
		 * Ejecuto el registro de usuario
		 */
		public function ajax_wp_newdenuncia() {

			//Cambio la global para operar wordpress y sus funciones sobre el sitio At Usuarios
			global $switched;
            switch_to_blog(1);
			
			//Traigo la informacion
 			$user_id            = isset( $_POST['user_id'] )                ? sanitize_text_field( wp_unslash( $_POST['user_id'] ) )           : '';
			$idprocedencia      = isset( $_POST['SelectorProcedencia'] )    ? sanitize_text_field( wp_unslash( $_POST['SelectorProcedencia'] )): '';
			$idanomalia         = isset( $_POST['SelectorAnomalia'] )       ? sanitize_text_field( wp_unslash( $_POST['SelectorAnomalia'] ) )  : '';
			$vereda             = isset( $_POST['SelectorBarrido'] )        ? sanitize_text_field( wp_unslash( $_POST['SelectorBarrido'] ) )   : '';
			$Direccion          = isset( $_POST['Direccion'] )              ? sanitize_text_field( wp_unslash( $_POST['Direccion'] ) )         : '';
			$GeoLat             = isset( $_POST['GeoLat'] )                 ? sanitize_text_field( wp_unslash( $_POST['GeoLat'] ) )            : '';
			$GeoLong            = isset( $_POST['GeoLong'] )                ? sanitize_text_field( wp_unslash( $_POST['GeoLong'] ) )           : '';
			$Barrio 	        = isset( $_POST['Barrio'] )                 ? sanitize_text_field( wp_unslash( $_POST['Barrio'] ) )            : '';
			$Comuna             = isset( $_POST['Comuna'] )                 ? sanitize_text_field( wp_unslash( $_POST['Comuna'] ) )            : '';
			$Observacion        = isset( $_POST['Observacion'] )            ? sanitize_text_field( wp_unslash( $_POST['Observacion'] ) )       : '';


			if (
				'' === $user_id
		 	) {
			 wp_send_json_error( array( 
				 'message' => 'Debe cargar el usuario antes de realizar la carga de denuncia.',
				 ) );
			 wp_die();
			 }
			
			if (
				'' === $Anomalia	    OR
				'' === $GrupoAnomalias	
			) {
			wp_send_json_error( array( 
				'message' => 'Debe indicar el tipo de anomalia.',
				) );
			wp_die();
			}

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

			//Excepcion de autopista
			if ( ! $ids_anomalia [2] == 224 ){ 
				if (
					'' === $GeoLat	        OR
					'' === $GeoLong      	OR
					'' === $Barrio      	OR
					'' === $Comuna	
				) {
				wp_send_json_error( array( 
					'message' => 'Debe indicar la direccion correspondiente.',
					) );
				wp_die();
				}
			}
			//Reconvierto el valor enviado por la api para realizar la carga de la taxonomia
			$comunaarray  = explode(" ", $Comuna);
			$comunanumber = $comunaarray[1];

			//Argumentos a cargar como denuncia
			$nueva_denuncia = array(
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
			wp_set_object_terms( $post_id, intval( $idprocedencia ) , 'procedencia' );

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
			update_post_meta( $post_id, 'direccion', $Direccion );
			update_post_meta( $post_id, 'geolat', $GeoLat );
			update_post_meta( $post_id, 'geolong', $GeoLong );
			update_post_meta( $post_id, 'comuna', $Comuna );
			update_post_meta( $post_id, 'barrio', $Barrio );
			update_post_meta( $post_id, 'obs', $Observacion );

			$user_id = get_current_user_id();
			insert_eventos ( $post_id , 'Abierto' , 'Se ha creado la denuncia.' , $user_id );
		   
			wp_send_json_success( array( 
				'message'  =>  'Denuncia numero ' . $post_id . ' creada correctamente.',
				) );
			wp_die();

			}else{
				wp_send_json_error( array( 
					'message' => 'Error en la carga de la denuncia. Contacte a soporte.',
					) );
				wp_die();
			}
		}
		/**
		 * Static accessor.
		 *
		 * @return NewDenuncia singleton.
		 */
		public static function instance() {
			if ( ! is_object( self::$instance ) ) {
				self::$instance = new NewDenuncia();
			}
			return self::$instance;
		}
	}
	NewDenuncia::instance();
}


	//$barrios_tax_query = array ( 'Agronomía' , 'Almagro' , 'Balvanera' , 'Barracas' , 'Belgrano' , 'Boedo' , 'Caballito' , 'Chacarita', 'Coghlan','Colegiales' ,'Constitución' , 'Flores', 'Floresta', 'La Boca', 'La Paternal' , 'Liniers','Mataderos' , 'Monte Castro','Monserrat' , 'Nueva Pompeya', 'Núñez','Palermo' ,'Parque Avellaneda' , 'Parque Chacabuco', 'Parque Chas', 'Parque Patricios','Puerto Madero', 'Recoleta', 'Retiro','Saavedra' , 'San Cristóbal','San Nicolás' , 'San Telmo', 'Parque Avellaneda', 'Vélez Sársfield','Versalles' , 'Villa Crespo', 'Villa del Parque' ,'Villa Devoto' ,'Villa General Mitre','Villa Lugano' , 'Villa Luro','Villa Ortúzar' ,'Villa Pueyrredón','Villa Real' , 'Villa Riachuelo', 'Villa Santa Rita','Villa Soldati','Villa Urquiza');
	//if ( $barrios ){ $barrios_tax_query = array ( $barrios ); }
		