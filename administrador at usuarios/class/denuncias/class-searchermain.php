<?php
/**
 * SearcherMain de clases
 *
 * @package atencionusuarios
 */

if ( ! class_exists( 'SearcherMain' ) ) {
	/**
	 * Class SearcherMain
	 */
	class SearcherMain {
		/**
		 * Static accessor.
		 *
		 * @var SearcherMain
		 */
		public static $instance;
		/**
		 * Constructor.
		 */
		public function __construct() {

		// Generamos la respuesta del ajax para el registro.
        add_action( 'wp_ajax_wp_searchermain', array( $this, 'ajax_searchermain' ) );

        // Registramos los scripts o estilos necesarios.
        add_action( 'wp_enqueue_scripts', array( $this, 'register_assets' ) );
		}
        /**
		 * Registramos los assets necesarios para el template de login.
		 */
		public function register_assets() {
			wp_enqueue_script(
				'wp_searchermain',
				get_stylesheet_directory_uri() . '/resources/scripts/denuncias/SearcherMain.js',
				array(),
				'1.0.0',
				true
			);
			wp_localize_script(
				'wp_searchermain',
				'wp_searchermain',
				array(
					'ajax'     => admin_url( 'admin-ajax.php' ),
					'nonce'    => wp_create_nonce( 'auth_nonce' )
				)
			);
        }
        /**
		 * Ejecuto el buscador
		 */
		public function ajax_searchermain() {

			//Cambio la global para operar wordpress y sus funciones sobre el sitio At Usuarios
			global $switched;
            switch_to_blog(1);

            // Verificamos a traves de la funcionalidad de captcha de WordPress: Los nonces.
			if ( ! isset( $_POST['nonce'] ) ) {
				wp_send_json_error( 'Error al procesar lo solicitado. Intente nuevamente o contacte con soporte.' );
				wp_die();
			}
			if ( ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), 'auth_nonce' ) ) {
				wp_send_json_error( 'Error al procesar lo solicitado. Intente nuevamente o contacte con soporte.' );
				wp_die();
			}
			// Si el usuario no se encuentra logueado, devolvemos ok.
			if ( ! is_user_logged_in() ) {
				wp_send_json_success( 'Usuario no se encuentra logueado.' );
				wp_die();
			}

            //Traigo las variables
			$nrodenuncia  = isset( $_POST['nrodenuncia'] ) ? sanitize_text_field( wp_unslash( $_POST['nrodenuncia'] ) ) : '';
			$servicio     = isset( $_POST['servicio'] )    ? sanitize_text_field( wp_unslash( $_POST['servicio'] ) )    : '';
			$fechadesde   = isset( $_POST['fechadesde'] )  ? sanitize_text_field( wp_unslash( $_POST['fechadesde'] ) )  : '';
			$fechahasta   = isset( $_POST['fechahasta'] )  ? sanitize_text_field( wp_unslash( $_POST['fechahasta'] ) )  : '';
			$barrios      = isset( $_POST['barrios'] )     ? sanitize_text_field( wp_unslash( $_POST['barrios'] ) )     : '';
			$comuna       = isset( $_POST['comuna'] )      ? sanitize_text_field( wp_unslash( $_POST['comuna'] ) )      : '';
			$procedencia  = isset( $_POST['procedencia'] ) ? sanitize_text_field( wp_unslash( $_POST['procedencia'] ) ) : '';
			$direccion    = isset( $_POST['calle'] )       ? sanitize_text_field( wp_unslash( $_POST['calle'] ) )       : '';
			$estado       = isset( $_POST['estado'] )      ? sanitize_text_field( wp_unslash( $_POST['estado'] ) )      : '';
			$email        = isset( $_POST['email'] )       ? sanitize_email( wp_unslash( $_POST['email'] ) )            : '';
			$pagina       = isset( $_POST['pagina'] )      ? sanitize_text_field( wp_unslash ( $_POST['pagina'] ) )     : '';	
			$export       = isset( $_POST['export'] )      ? sanitize_text_field( wp_unslash ( $_POST['export'] ) )     : '';	
			
			//Si es para exportar pongo un numero grande denuncias por pagina para exportar el excel
			if( $export == 'export'){
				$nropost = '100000';
			}else{
				$nropost = '30';
			}

			// Generlo concatenacion de querys para realizar las busquedas que se necesiten.
			//Generlo los arrays de comparacion con las taxonomias	
			//Terms de comunas
			$terms_comunas = get_terms( array(
				'taxonomy' => 'comuna',
				'hide_empty' => false,
				'parent'   => 0
			) );
			$comuna_tax_query = array();
			foreach ( $terms_comunas as $terms_comuna ){
				$comuna_id = $terms_comuna->term_id;
				array_push( $comuna_tax_query , $comuna_id ); //array
			}
			if ( $comuna ){ $comuna_tax_query = array ( $comuna ); }

			//Terms servicios
			$terms_deptos = get_terms( array(
				'taxonomy' => 'servicios',
				'hide_empty' => false,
				'parent'   => 0
			) );

			$servicios_tax_query = array();
			foreach ( $terms_deptos as $terms_depto ) {
				$depto_id = $terms_depto->term_id;
				$terms_servicios = get_terms( array(
					'taxonomy' => 'servicios',
					'hide_empty' => false,
					'parent'   => $depto_id
				) );

				foreach ( $terms_servicios as $terms_servicio ){
				$servicios_id = $terms_servicio->term_id;
				array_push( $servicios_tax_query , $servicios_id ); //array
			} }
			if ( $servicio ){ $servicios_tax_query = array ( $servicio ); }

			//Terms procedencias
			$terms_procedencias = get_terms( array(
				'taxonomy' => 'procedencia',
				'hide_empty' => false,
				'parent'   => 0
			) );
			$procedencia_tax_query = array();
			foreach ( $terms_procedencias as $terms_procedencia ){
				$procedencia_id = $terms_procedencia->term_id;
				array_push( $procedencia_tax_query , $procedencia_id ); //array
			}
			if ( $procedencia ){ $procedencia_tax_query = array ( $procedencia ); }

			//Terms Estado
			$terms_estados = get_terms( array(
				'taxonomy' => 'estado',
				'hide_empty' => false,
				'parent'   => 0
			) );
			$estado_tax_query = array();
			foreach ( $terms_estados as $terms_estado ){
				$estado_slug = $terms_estado->slug;
				array_push( $estado_tax_query , $estado_slug ); //array
			}
			if ( $estado != 'todos' ){ $estado_tax_query = array ( $estado ); }

			//Defino fechas segun indicacion
			if ( ! ( ( $fechadesde ) AND ( $fechahasta ) ) ){
				$fechadesde = '2020-01-01';
				$fechahasta = '2100-01-01';
			}

			//Si indico numero de denuncia solo realizo la busqueda por id
            if ( $nrodenuncia != '' ){
				$denuncias_send = array();
                $denuncia->ID = $nrodenuncia;
                				//Traigo la id de denuncia
				$denuncia_data_send ['id']        = $denuncia->ID;
				//Traigo info asociada al post, meta y taxonomys.
				$denuncia_data_send ['direccion'] = get_post_meta( $denuncia->ID, 'direccion', true );
				$denuncia_data_send ['barrio']    = get_post_meta( $denuncia->ID, 'barrio', true );
				$servicios						  = get_the_terms( $denuncia->ID, 'servicios' );
				$denuncia_data_send ['servicios'] = $servicios;
				$denuncia_data_send ['obs']       = get_post_meta( $denuncia->ID, 'obs', true );
				$denuncia_data_send ['fecha']     = get_the_date( 'd M Y', $denuncia->ID );

				//Busco el child id de menor jerarquia
				$count = 0;
				foreach ( $servicios as $servicio ) {
				if( ! get_term_children( $servicios[$count]->term_id, 'servicios' ) ){
					$term_id_anomalia = $servicios[$count]->term_id; }
					$count ++ ;
				}
					
				//Genero una array con las categorias asociadas a la anomalia, de menor jerarquia con orden y estrucutra de array para recorrer
				$ids_anomalia   = array();
				$term_anomalia  = get_term_by( 'id', $term_id_anomalia , 'servicios' );
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

				//Traigo los datos asociados a los IDs de las terms de Servicios
				$denuncia_data_send ['data_anomalia']       = get_term_by('id', $ids_anomalia[0] , 'servicios');
				$denuncia_data_send ['data_grupoanomalia']  = get_term_by('id', $ids_anomalia[1] , 'servicios');
				$denuncia_data_send ['data_servicios']      = get_term_by('id', $ids_anomalia[2] , 'servicios');

				//Traigo la empresa asociada al post
				$denuncia_data_send ['data_empresa'] = get_the_terms( $denuncia->ID, 'empresa' );

				//Traigo la comuna asociada al post
				$denuncia_data_send ['data_comuna'] = get_the_terms( $denuncia->ID, 'comuna' );

				//Traigo estado asociada al post
				$denuncia_data_send ['data_estado'] = get_the_terms( $denuncia->ID, 'estado' );

				array_push( $denuncias_send , $denuncia_data_send ); //array
				wp_send_json_success( $denuncias_send );
				wp_die();
			}

		//Busco el user id del email.
		$user_id = get_user_by( 'email', $email );

		//Query final evaluando posibilidades
		if( $user_id AND ( $direccion OR $barrios ) ){ 
				if ( $direccion ){ 
            $args = array(
                'post_type'         => 'denuncia',
				'post_status'       => 'publish',
				'posts_per_page'    => $nropost,
				'paged'             => $pagina,
				'orderby'           => 'date',
				'order'             => 'DESC',
				'author'            => $user_id->data->ID,
                'tax_query'         => array(
					'relation'      => 'AND',
                    array(
						'taxonomy' => 'servicios',
						'field'    => 'ID',
						'terms'    => $servicios_tax_query,
					),
					array(
						'taxonomy' => 'comuna',
						'field'    => 'ID',
						'terms'    => $comuna_tax_query,
					),
					array(
						'taxonomy' => 'procedencia',
						'field'    => 'ID',
						'terms'    => $procedencia_tax_query,
					),
					array(
						'taxonomy' => 'estado',
						'field'    => 'slug',
						'terms'    => $estado_tax_query,
                    ),
				),
				'date_query'  => array(
					array(
						'after'     => $fechadesde,
						'before'    => $fechahasta,
						'inclusive' => true,
					),
				),
				'meta_query'  => array(
					array(
						'key'       => 'direccion',
						'value'     =>  $direccion,
						'compare'   => 'LIKE'
					)
				)
				);	
		}else{
				$args = array(
					'post_type'         => 'denuncia',
					'post_status'       => 'publish',
					'posts_per_page'    =>  $nropost,
					'paged'             =>  $pagina,
					'orderby'           => 'date',
					'order'             => 'DESC',
					'author'            => $user_id,
					'tax_query'         => array(
						'relation'      => 'AND',
						array(
							'taxonomy' => 'servicios',
							'field'    => 'ID',
							'terms'    => $servicios_tax_query,
						),
						array(
							'taxonomy' => 'comuna',
							'field'    => 'ID',
							'terms'    => $comuna_tax_query,
						),
						array(
							'taxonomy' => 'procedencia',
							'field'    => 'ID',
							'terms'    => $procedencia_tax_query,
						),
						array(
							'taxonomy' => 'estado',
							'field'    => 'slug',
							'terms'    => $estado_tax_query,
						),
					),
					'date_query'  => array(
						array(
							'after'     => $fechadesde,
							'before'    => $fechahasta,
							'inclusive' => true,
						),
					),
					'meta_query'  => array(
						array(
							'key'       => 'barrio',
							'value'     =>  $barrios,
							'compare'   => 'LIKE'
						)
					)
				);	
			}
	
		}else if ( $user_id ){
			$args = array(
                'post_type'   => 'denuncia',
				'post_status' => 'publish',
				'posts_per_page'    => $nropost,
				'paged'             => $pagina,
				'orderby'           => 'date',
				'order'             => 'DESC',
				'author'            => $user_id->data->ID,
                'tax_query'  => array(
					'relation' => 'AND',
                    array(
						'taxonomy' => 'servicios',
						'field'    => 'ID',
						'terms'    => $servicios_tax_query,
					),
					array(
						'taxonomy' => 'comuna',
						'field'    => 'ID',
						'terms'    => $comuna_tax_query,
					),
					array(
						'taxonomy' => 'procedencia',
						'field'    => 'ID',
						'terms'    => $procedencia_tax_query,
					),
					array(
						'taxonomy' => 'estado',
						'field'    => 'slug',
						'terms'    => $estado_tax_query,
                    ),
				),
				'date_query'  => array(
					array(
						'after'     => $fechadesde,
						'before'    => $fechahasta,
						'inclusive' => true,
					),
				),
			);	
		}else if ( $direccion OR $barrios ){
			if ( $direccion ){ 
			$args = array(
                'post_type'   => 'denuncia',
				'post_status' => 'publish',
				'posts_per_page'    => $nropost,
				'paged'             => $pagina,
				'orderby'           => 'date',
				'order'             => 'DESC',
                'tax_query'  => array(
					'relation' => 'AND',
                    array(
						'taxonomy' => 'servicios',
						'field'    => 'ID',
						'terms'    => $servicios_tax_query,
					),
					array(
						'taxonomy' => 'comuna',
						'field'    => 'ID',
						'terms'    => $comuna_tax_query,
					),
					array(
						'taxonomy' => 'procedencia',
						'field'    => 'ID',
						'terms'    => $procedencia_tax_query,
					),
					array(
						'taxonomy' => 'estado',
						'field'    => 'slug',
						'terms'    => $estado_tax_query,
                    ),
				),
				'date_query'  => array(
					array(
						'after'     => $fechadesde,
						'before'    => $fechahasta,
						'inclusive' => true,
					),
				),
				'meta_query'  => array(
					array(
						'key'       => 'direccion',
						'value'     =>  $direccion,
						'compare'   => 'LIKE'
					)
				)
			);	
		}else{
			$args = array(
                'post_type'   => 'denuncia',
				'post_status' => 'publish',
				'posts_per_page'    => $nropost,
				'paged'             => '1',
				'orderby'           => 'date',
				'order'             => 'DESC',
                'tax_query'  => array(
					'relation' => 'AND',
                    array(
						'taxonomy' => 'servicios',
						'field'    => 'ID',
						'terms'    => $servicios_tax_query,
					),
					array(
						'taxonomy' => 'comuna',
						'field'    => 'ID',
						'terms'    => $comuna_tax_query,
					),
					array(
						'taxonomy' => 'procedencia',
						'field'    => 'ID',
						'terms'    => $procedencia_tax_query,
					),
					array(
						'taxonomy' => 'estado',
						'field'    => 'slug',
						'terms'    => $estado_tax_query,
                    ),
				),
				'date_query'  => array(
					array(
						'after'     => $fechadesde,
						'before'    => $fechahasta,
						'inclusive' => true,
					),
				),
				'meta_query'  => array(
					array(
						'key'       => 'barrio',
						'value'     =>  $barrios,
						'compare'   => 'LIKE'
					)
				)
			);	
		}
		}else{
			$args = array(
                'post_type'   => 'denuncia',
				'post_status' => 'publish',
				'posts_per_page'    => $nropost,
				'paged'             => $pagina,
				'orderby'           => 'date',
				'order'             => 'DESC',
                'tax_query'  => array(
					'relation' => 'AND',
                    array(
						'taxonomy' => 'servicios',
						'field'    => 'ID',
						'terms'    => $servicios_tax_query,
					),
					array(
						'taxonomy' => 'comuna',
						'field'    => 'ID',
						'terms'    => $comuna_tax_query,
					),
					array(
						'taxonomy' => 'procedencia',
						'field'    => 'ID',
						'terms'    => $procedencia_tax_query,
					),
					array(
						'taxonomy' => 'estado',
						'field'    => 'slug',
						'terms'    => $estado_tax_query,
                    ),
				),
				'date_query'  => array(
					array(
						'after'     => $fechadesde,
						'before'    => $fechahasta,
						'inclusive' => true,
					),
				),
			);	
		}

			$query = new WP_Query( $args );
			$nroposts = $query->found_posts;
			$denuncias = $query->posts;
			//print_r($denuncias);

			//Genero para cada denuncia una fila de array
			$denuncias_send = array();
			foreach( $denuncias as $denuncia ){

				//Traigo la id de denuncia
				$denuncia_data_send ['id']        = $denuncia->ID;
				//Traigo info asociada al post, meta y taxonomys.
				$denuncia_data_send ['direccion'] = get_post_meta( $denuncia->ID, 'direccion', true );
				$denuncia_data_send ['barrio']    = get_post_meta( $denuncia->ID, 'barrio', true );
				$servicios						  = get_the_terms( $denuncia->ID, 'servicios' );
				$denuncia_data_send ['servicios'] = $servicios;
				$denuncia_data_send ['obs']       = get_post_meta( $denuncia->ID, 'obs', true );
				$denuncia_data_send ['fecha']     = get_the_date( 'd M Y', $denuncia->ID );
				$denuncia_data_send ['hora']      = get_the_time( '', $denuncia->ID );

				//Busco el child id de menor jerarquia
				$count = 0;
				foreach ( $servicios as $servicio ) {
				if( ! get_term_children( $servicios[$count]->term_id, 'servicios' ) ){
					$term_id_anomalia = $servicios[$count]->term_id; }
					$count ++ ;
				}
					
				//Genero una array con las categorias asociadas a la anomalia, de menor jerarquia con orden y estrucutra de array para recorrer
				$ids_anomalia   = array();
				$term_anomalia  = get_term_by( 'id', $term_id_anomalia , 'servicios' );
				$id_anomalia    = $term_anomalia->term_id;
				$name_anomalia  = $term_anomalia->name;
				$id_parent      = $term_anomalia->parent;
				$ids_anomalia[] = $id_anomalia;
				while ( $id_parent != 0 ) { 
					$term_next      = get_term_by( 'id', $id_parent , 'servicios' );
					$id_anomalia    = $term_next->term_id;
					$id_parent      = $term_next->parent;
					$ids_anomalia[] = $id_anomalia;
				} 

				//Traigo los datos asociados a los IDs de las terms de Servicios
				$denuncia_data_send ['data_anomalia']       = get_term_by('id', $ids_anomalia[0] , 'servicios');
				$denuncia_data_send ['data_grupoanomalia']  = get_term_by('id', $ids_anomalia[1] , 'servicios');
				$denuncia_data_send ['data_servicios']      = get_term_by('id', $ids_anomalia[2] , 'servicios');

				//Traigo la empresa asociada al post
				$denuncia_data_send ['data_empresa'] = get_the_terms( $denuncia->ID, 'empresa' );

				//Traigo la comuna asociada al post
				$denuncia_data_send ['data_comuna'] = get_the_terms( $denuncia->ID, 'comuna' );

				//Traigo estado asociada al post
				$denuncia_data_send ['data_estado'] = get_the_terms( $denuncia->ID, 'estado' );

				array_push( $denuncias_send , $denuncia_data_send ); //array
			}

			wp_send_json_success( 	
				array(
				'data'     => $denuncias_send,
				'nroposts' => $nroposts	) );

			wp_die();
		}
		/**
		 * Static accessor.
		 *
		 * @return SearcherMain singleton.
		 */
		public static function instance() {
			if ( ! is_object( self::$instance ) ) {
				self::$instance = new SearcherMain();
			}
			return self::$instance;
		}
	}
	SearcherMain::instance();
}


	//$barrios_tax_query = array ( 'Agronomía' , 'Almagro' , 'Balvanera' , 'Barracas' , 'Belgrano' , 'Boedo' , 'Caballito' , 'Chacarita', 'Coghlan','Colegiales' ,'Constitución' , 'Flores', 'Floresta', 'La Boca', 'La Paternal' , 'Liniers','Mataderos' , 'Monte Castro','Monserrat' , 'Nueva Pompeya', 'Núñez','Palermo' ,'Parque Avellaneda' , 'Parque Chacabuco', 'Parque Chas', 'Parque Patricios','Puerto Madero', 'Recoleta', 'Retiro','Saavedra' , 'San Cristóbal','San Nicolás' , 'San Telmo', 'Parque Avellaneda', 'Vélez Sársfield','Versalles' , 'Villa Crespo', 'Villa del Parque' ,'Villa Devoto' ,'Villa General Mitre','Villa Lugano' , 'Villa Luro','Villa Ortúzar' ,'Villa Pueyrredón','Villa Real' , 'Villa Riachuelo', 'Villa Santa Rita','Villa Soldati','Villa Urquiza');
	//if ( $barrios ){ $barrios_tax_query = array ( $barrios ); }
		