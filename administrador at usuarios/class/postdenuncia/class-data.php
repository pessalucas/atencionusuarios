<?php
/**
 * Cambia el estado de la denuncia
 *
 * @package LucasPessa
 */

if ( ! class_exists( 'CambioEstado' ) ) {
	/**
	 * Class User Profile.
	 */
	class CambioEstado {
		/**
		 * Static accessor.
		 *
		 * @var CambioEstado
		 */
		public static $instance;
		/**
		 * Constructor.
		 */
		public function __construct() {

			//Genero cambios de estado
			add_action( 'wp_ajax_wp_cambioestado',array($this, 'ajax_cambioestado'));

			//Genero cambios de expediente
			add_action( 'wp_ajax_wp_cambioexpediente',array($this, 'ajax_cambioexpediente'));

			//Inicializo los ajax para el envio de comentarios de los vecios
			add_action('init', array($this,'ajax_cambioestado_init'));
		}
		/*
		*	Inicializo el ajax de pedidos de denuncias dentro del listado de denuncias
		*/
		public function ajax_cambioestado_init(){

			wp_register_script( 'ajax-cambioestado-script' , get_template_directory_uri() . '/resources/scripts/denunciapost/Data.js', array('jquery') ); 
			wp_enqueue_script( 'ajax-cambioestado-script' );
		
			wp_localize_script( 'ajax-cambioestado-script' , 'ajax_cambioestado_object' , array( 
				'ajaxurl'        => admin_url( 'admin-ajax.php' ),
				'loadingmessage' => __( 'Chequeando informacion, espere...' )
			));
		
			// Enable the user with no privileges to run ajax_CambioEstado() in AJAX
		}
		/*
		*	Envio de comentarios asociados a las denuncias por parte de los vecinos
		*/
		public function ajax_cambioestado(){

            //Cambio la global para operar wordpress y sus funciones sobre el sitio At Usuarios
			global $switched;
            switch_to_blog(1);

            //Traigo nuevo estado
            $nuevoestado     = isset( $_POST['nuevoestado'] )     ? sanitize_text_field(  $_POST['nuevoestado'] ) : '';
            $id_denuncia     = isset( $_POST['id_denuncia'] )     ? sanitize_text_field(  $_POST['id_denuncia'] ) : '';
		
			//Confirmo el rol
			$user = wp_get_current_user();
			if( ! empty( $user ) && ( in_array( "usuariosjefe", (array) $user->roles ) ) OR ( in_array( "control", (array) $user->roles ) ) ) {
				
			//Verifico que venga con informacion
			if (   
                '' === $nuevoestado OR
                '' === $id_denuncia
			) {
				wp_send_json_error( 'Error en el pedido de informacion.');	
				 die();
			}

			$estado_padre = get_term_by('id', $nuevoestado, 'estado');
			$estado_padre = $estado_padre->parent;
			$estados_id   = array( intval( $estado_padre ) , intval( $nuevoestado ) );

            if ( wp_set_object_terms( $id_denuncia , $estados_id , 'estado' ) ){ 
					$nuevoestado_data = get_term( $nuevoestado , 'estado' );
					$estado_padre_data = get_term( $estado_padre , 'estado' );
					if( ! $estado_padre_data ){
						$estado = $nuevoestado_data->name;
					}else{
						$estado = $estado_padre_data->name . ' - ' . $nuevoestado_data->name;
					}
					$user_id = get_current_user_id();
				    insert_eventos ( $id_denuncia , $estado , 'Se ha realizado un cambio de estado.' , $user_id );
					wp_send_json_success( 'Se realizo el cambio de estado correctamente.' );
					wp_die();		
			}else{
				    wp_send_json_error( 'Falla en la carga del comentario. Comuncarse con Modernizacion.' );
					wp_die();
				}

			}else{
				wp_send_json_error( 'No posee los permisos para cambiar de estado la denuncia.' );
			}
			
			wp_die();	
		}
		/*
		*	Envio de comentarios asociados a las denuncias por parte de los vecinos
		*/
		public function ajax_cambioexpediente(){

            //Cambio la global para operar wordpress y sus funciones sobre el sitio At Usuarios
			global $switched;
            switch_to_blog(1);

            //Traigo nuevo estado
            $expediente      = isset( $_POST['expediente'] )      ? sanitize_text_field(  $_POST['expediente'] )  : '';
            $id_denuncia     = isset( $_POST['id_denuncia'] )     ? sanitize_text_field(  $_POST['id_denuncia'] ) : '';
        
			//Verifico que venga con informacion
			if (   
                '' === $expediente  OR
                '' === $id_denuncia
			) {
				wp_send_json_error( 'Error en el pedido de informacion.');	
				 die();
			}

            if ( update_post_meta( $id_denuncia, 'expediente', $expediente ) ){ 
                    wp_send_json_success( 'Se realizo el cambio de expediente correctamente.' );		
			}else{
				    wp_send_json_error( 'Falla en la carga del comentario. Comuncarse con Modernizacion.' );
			}
			
			wp_die();	
		}
		/**
		 * Static accessor.
		 *
		 * @return CambioEstado singleton.
		 */
		public static function instance() {
			if ( ! is_object( self::$instance ) ) {
				self::$instance = new CambioEstado();
			}
			return self::$instance;
		}
	}
	CambioEstado::instance();
}
