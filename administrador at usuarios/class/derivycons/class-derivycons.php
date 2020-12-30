<?php
/**
 * Derivaciones y consultas. Class
 *
 * @package atencionusuarios
 */

if ( ! class_exists( 'DerivyCons' ) ) {
	/**
	 * Class DerivyCons
	 */
	class DerivyCons {
		/**
		 * Static accessor.
		 *
		 * @var DerivyCons
		 */
        public static $instance;
		/**
		 * Constructor
		 */
		public function __construct() {

            // Ejecuto la carga de la lista pedida
            add_action( 'wp_ajax_wp_listarderivycons', array( $this, 'ajax_wp_listarderivycons' ) );

            // Ejecuto la carga de la nueva consulta/derivacion
            add_action( 'wp_ajax_wp_insertarderivycons', array( $this, 'ajax_wp_insertarderivycons' ) );

			// Ejecuto el borrado consulta/derivacion
            add_action( 'wp_ajax_wp_deletederivycons', array( $this, 'ajax_wp_deletederivycons' ) );

	
			

            // Registramos los scripts o estilos necesarios.
            add_action( 'wp_enqueue_scripts', array( $this, 'register_assets' ) );
        }
        
         /**
		 * Registramos los assets necesarios para el template.
		 */
		public function register_assets() {
			wp_enqueue_script(
				'wp_ListDerivyCons',
				get_stylesheet_directory_uri() . '/resources/scripts/derivycons/DerivyCons.js',
				array(),
				'1.0.0',
                true
			);
			wp_localize_script(
				'wp_ListDerivyCons',
				'wp_ListDerivyCons',
				array(
					'ajax'     => admin_url( 'admin-ajax.php' ),
				)
			);
        }
        /**
		 *  Devuelvo json con listado de anomalias o derivaciones segun peticion
         *  
		 */
		public function ajax_wp_listarderivycons( ) {

            $listar  = isset( $_POST['listar'] ) ? sanitize_text_field( wp_unslash ( $_POST['listar'] ) ) : '';	
	    
            if (
                '' === $listar 
		 	) {
				wp_send_json_error( 'Error al procesar lo solicitado, campos incompletos.');
             }
             
             if ( $listar == 'true' ){

				 $array = select_derivycons( 'true', '' , '' );
				 
                 wp_send_json_success( $array );
				 wp_die();

             }else{
				$fechadesde  = isset( $_POST['fechadesde'] ) ? sanitize_text_field( wp_unslash ( $_POST['fechadesde'] ) ) : '';	
				$fechahasta  = isset( $_POST['fechahasta'] ) ? sanitize_text_field( wp_unslash ( $_POST['fechahasta'] ) ) : '';	
				$tipo        = isset( $_POST['tipo'] ) ? sanitize_text_field( wp_unslash ( $_POST['tipo'] ) ) : '';	
				
				if (
					'' === $tipo 
				 ) {
					wp_send_json_error( 'Error al procesar lo solicitado, campos incompletos.');
				 }

				$array = select_derivycons( $tipo , $fechadesde , $fechahasta );
				
				wp_send_json_success( $array );
				wp_die();
			 }

             wp_die();
        }   
        /**
		 *  Devuelvo json con listado de anomalias o derivaciones segun peticion
         *  
		 */
		public function ajax_wp_insertarderivycons( ) {

            $tipo      = isset( $_POST['tipo'] )             ? sanitize_text_field( wp_unslash ( $_POST['tipo'] ) ) : '';	
            $derivado  = isset( $_POST['derivado'] )         ? sanitize_text_field( wp_unslash ( $_POST['derivado'] ) ) : '';	
            $obs       = isset( $_POST['observacion'] )      ? sanitize_text_field( wp_unslash ( $_POST['observacion'] ) ) : '';	
	    
            if (
                '' === $tipo OR
                '' === $obs 
		 	) {
                wp_send_json_error( 'Error al procesar lo solicitado, campos incompletos.');
                wp_die();
             }
             
             if ( insertar_derivycons( $tipo , $derivado , $obs ) ){
                wp_send_json_success( 'La carga se realizo correctamente' );
             }else{
                wp_send_json_error( 'Error al procesar lo solicitado');
             }

             wp_die();
		}   
		/**
		 *  Borrar fila de derivycons
         *  
		 */
		public function ajax_wp_deletederivycons( ) {

            $id = isset( $_POST['id'] ) ? sanitize_text_field( wp_unslash ( $_POST['id'] ) ) : '';	

            if (
                '' === $id 
		 	) {
                wp_send_json_error( 'Error al procesar lo solicitado, campos incompletos.');
                wp_die();
             }
             
             if ( delete_derivycons( $id ) ){
                wp_send_json_success( 'El borrado se realizo correctamente' );
             }else{
                wp_send_json_error( 'Error al procesar lo solicitado');
             }

             wp_die();
        }   
		/**
		 * Static accessor.
		 *
		 * @return DerivyCons singleton.
		 */
		public static function instance() {
			if ( ! is_object( self::$instance ) ) {
				self::$instance = new DerivyCons();
			}
			return self::$instance;
		}
	}
	DerivyCons::instance();
}
