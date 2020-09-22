<?php
/**
 * Ejecuta las funciones para la carga de Denuncia_PostType.
 *
 * @package LucasPessa
 */

if ( ! class_exists( 'Denuncia_PostType' ) ) {
	/**
	 * Class User Profile.
	 */
	class Denuncia_PostType {
		/**
		 * Static accessor.
		 *
		 * @var Denuncia_PostType
		 */
		public static $instance;
		/**
		 * Constructor.
		 */
		public function __construct() {
			add_action( 'init', array( $this, 'register_posttype' ) );
			add_action( 'init', array( $this, 'register_taxonomyservice'));
			add_action( 'init', array( $this, 'register_taxonomyprocedencia'));
			add_action( 'init', array( $this, 'register_taxonomycomuna'));
			add_action( 'init', array( $this, 'register_taxonomyempresa'));
			add_action( 'init', array( $this, 'register_taxonomyestado'));

			add_action( 'add_meta_boxes',  array( $this, 'wpdocs_register_meta_boxes') );
			add_action( 'save_post',  array( $this, 'wpdocs_save_meta_box') );
		}

		/**
		 * Registrmos el post type de denucia.
		 */
		public function register_posttype() {
			$labels = array(
				'name'                  => _x( 'Denuncia', 'atencionusuarios' ),
				'singular_name'         => _x( 'Denuncia', 'textdomain' ),
				'menu_name'             => _x( 'Denuncias', 'textdomain' ),
				'name_admin_bar'        => _x( 'Denuncia', 'textdomain' ),
				'add_new'               => __( 'Agregar nueva', 'textdomain' ),
				'add_new_item'          => __( 'Agregar nueva denuncia', 'textdomain' ),
				'new_item'              => __( 'Nueva denuncia', 'textdomain' ),
				'edit_item'             => __( 'Editar denuncia', 'textdomain' ),
				'view_item'             => __( 'Ver denuncia', 'textdomain' ),
				'all_items'             => __( 'Todas las denuncias', 'textdomain' ),
				'search_items'          => __( 'Buscar denuncias', 'textdomain' ),
				'parent_item_colon'     => __( 'Denuncias padres:', 'textdomain' ),
				'not_found'             => __( 'No se encontraron denunucias.', 'textdomain' ),
				'not_found_in_trash'    => __( 'No se encontraron denuncias eliminadas.', 'textdomain' ),
				'featured_image'        => _x( 'Imagen destacada', 'textdomain' ),
				'set_featured_image'    => _x( 'Cargar imagen destacada', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'textdomain' ),
				'remove_featured_image' => _x( 'Eliminar imagen destacada', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'textdomain' ),
				'use_featured_image'    => _x( 'Usar imagen destacada', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'textdomain' ),
				'archives'              => _x( 'Archivos de denuncias', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'textdomain' ),
				'insert_into_item'      => _x( 'Insertar en la denuncia', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'textdomain' ),
				'uploaded_to_this_item' => _x( 'Actualizar esta denuncia', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'textdomain' ),
				'filter_items_list'     => _x( 'Filtrar listado de denuncias', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4', 'textdomain' ),
				'items_list_navigation' => _x( 'Lista de navegacion de denuncias', 'atencionusuarios' ),
				'items_list'            => _x( 'Listado de denuncias', 'atencionusuarios' ),
			);

			$args = array(
				'labels'              => $labels,
				'public'              => true,
				'exclude_from_search' => true,
				'publicly_queryable'  => true,
				'show_ui'             => true,
				'show_in_menu'        => true,
				'query_var'           => true,
				'rewrite'             => array( 'slug' => 'denuncia' ),
				'capability_type'     => 'post',
				'has_archive'         => true,
				'menu_position'       => null,
				'supports'            => array( 'author', 'comments' ),
			);
			register_post_type( 'denuncia', $args );
		}
		/*
			Registro de taxonomia procedencia
		*/
		public function register_taxonomyprocedencia() {
			// Add new taxonomy, make it hierarchical (like categories)
			$labels = array(
				'name'              => _x( 'Procedencia', 'taxonomy general name', 'textdomain' ),
				'singular_name'     => _x( 'Procedencia', 'taxonomy singular name', 'textdomain' ),
				'search_items'      => __( 'Buscar procedencia', 'textdomain' ),
				'all_items'         => __( 'Todas las procedencias', 'textdomain' ),
				'parent_item'       => __( '', 'textdomain' ),
				'parent_item_colon' => __( '', 'textdomain' ),
				'edit_item'         => __( 'Editar procedencia', 'textdomain' ),
				'update_item'       => __( 'Actualizar procedencia', 'textdomain' ),
				'add_new_item'      => __( 'Agregar nueva procedencia', 'textdomain' ),
				'new_item_name'     => __( 'Agregar nuevo nombre de procedencia', 'textdomain' ),
				'menu_name'         => __( 'Procedencias', 'textdomain' ),
			);
		 
			$args = array(
				'hierarchical'      => true,
				'labels'            => $labels,
				'show_ui'           => true,
				'show_admin_column' => true,
				'query_var'         => true,
				'rewrite'           => array( 'slug' => 'procedencia' ),
			);

			register_taxonomy( 'procedencia', array( 'denuncia' ), $args );
		}
		/*
			Registro de taxonomia estado
		*/
		public function register_taxonomyestado() {
			// Add new taxonomy, make it hierarchical (like categories)
			$labels = array(
				'name'              => _x( 'Estado', 'taxonomy general name', 'textdomain' ),
				'singular_name'     => _x( 'Estado', 'taxonomy singular name', 'textdomain' ),
				'search_items'      => __( 'Buscar por estado', 'textdomain' ),
				'all_items'         => __( 'Todos los estados', 'textdomain' ),
				'parent_item'       => __( '', 'textdomain' ),
				'parent_item_colon' => __( '', 'textdomain' ),
				'edit_item'         => __( 'Editar estado', 'textdomain' ),
				'update_item'       => __( 'Actualizar estado', 'textdomain' ),
				'add_new_item'      => __( 'Agregar nuevo estado', 'textdomain' ),
				'new_item_name'     => __( 'Agregar nuevo nombre de estado', 'textdomain' ),
				'menu_name'         => __( 'Estados', 'textdomain' ),
			);
		 
			$args = array(
				'hierarchical'      => true,
				'labels'            => $labels,
				'show_ui'           => true,
				'show_admin_column' => true,
				'query_var'         => true,
				'rewrite'           => array( 'slug' => 'estado' ),
			);

			register_taxonomy( 'estado', array( 'denuncia' ), $args );
		}
		/*
			Registro de taxonomia comuna
		*/
		public function register_taxonomycomuna() {
			// Add new taxonomy, make it hierarchical (like categories)
			$labels = array(
				'name'              => _x( 'Comuna', 'taxonomy general name', 'textdomain' ),
				'singular_name'     => _x( 'Comuna', 'taxonomy singular name', 'textdomain' ),
				'search_items'      => __( 'Buscar comunas', 'textdomain' ),
				'all_items'         => __( 'Todas las comunas', 'textdomain' ),
				'parent_item'       => __( '', 'textdomain' ),
				'parent_item_colon' => __( '', 'textdomain' ),
				'edit_item'         => __( 'Editar comunas', 'textdomain' ),
				'update_item'       => __( 'Actualizar comunas', 'textdomain' ),
				'add_new_item'      => __( 'Agregar nueva comuna', 'textdomain' ),
				'new_item_name'     => __( 'Agregar nuevo nombre de comuna', 'textdomain' ),
				'menu_name'         => __( 'Comunas', 'textdomain' ),
			);
		 
			$args = array(
				'hierarchical'      => true,
				'labels'            => $labels,
				'show_ui'           => true,
				'show_admin_column' => true,
				'query_var'         => true,
				'rewrite'           => array( 'slug' => 'comuna' ),
			);

			register_taxonomy( 'comuna', array( 'denuncia' ), $args );
		}
		/*
			Registro de taxonomia servicio
		*/
		public function register_taxonomyservice() {
			// Add new taxonomy, make it hierarchical (like categories)
			$labels = array(
				'name'              => _x( 'Servicios', 'taxonomy general name', 'textdomain' ),
				'singular_name'     => _x( 'Servicio', 'taxonomy singular name', 'textdomain' ),
				'search_items'      => __( 'Buscar servicio', 'textdomain' ),
				'all_items'         => __( 'Todos los servicios', 'textdomain' ),
				'parent_item'       => __( 'Departamentos', 'textdomain' ),
				'parent_item_colon' => __( 'Departamentos :', 'textdomain' ),
				'edit_item'         => __( 'Editar servicios', 'textdomain' ),
				'update_item'       => __( 'Actualizar servicios', 'textdomain' ),
				'add_new_item'      => __( 'Agregar nuevo servicio', 'textdomain' ),
				'new_item_name'     => __( 'Agregar nuevo nombre de servicio', 'textdomain' ),
				'menu_name'         => __( 'Servicios', 'textdomain' ),
			);
		 
			$args = array(
				'hierarchical'      => true,
				'labels'            => $labels,
				'show_ui'           => true,
				'show_admin_column' => true,
				'query_var'         => true,
				'rewrite'           => array( 'slug' => 'servicios' ),
			);

			register_taxonomy( 'servicios', array( 'denuncia' ), $args );
		}
		/*
			Registro de taxonomia empresa
		*/
		public function register_taxonomyempresa() {
			// Add new taxonomy, make it hierarchical (like categories)
			$labels = array(
				'name'              => _x( 'Empresa', 'taxonomy general name', 'textdomain' ),
				'singular_name'     => _x( 'Empresa', 'taxonomy singular name', 'textdomain' ),
				'search_items'      => __( 'Buscar empresa', 'textdomain' ),
				'all_items'         => __( 'Todas las empresas', 'textdomain' ),
				'parent_item'       => __( '', 'textdomain' ),
				'parent_item_colon' => __( '', 'textdomain' ),
				'edit_item'         => __( 'Editar empresa', 'textdomain' ),
				'update_item'       => __( 'Actualizar empresas', 'textdomain' ),
				'add_new_item'      => __( 'Agregar nueva empresa', 'textdomain' ),
				'new_item_name'     => __( 'Agregar nuevo nombre de empresa', 'textdomain' ),
				'menu_name'         => __( 'Empresas', 'textdomain' ),
			);
		 
			$args = array(
				'hierarchical'      => true,
				'labels'            => $labels,
				'show_ui'           => true,
				'show_admin_column' => true,
				'query_var'         => true,
				'rewrite'           => array( 'slug' => 'servicios' ),
			);

			register_taxonomy( 'empresa', array( 'denuncia' ), $args );
		}
		/*

		*/
		public function wpdocs_register_meta_boxes() {

			//Agrego el meta box asociado a la function render metabox para poder insertar funcion con el html asociado. Todo en el posttype denuncia
			add_meta_box( '1', __( 'Datos de denuncia', 'textdomain' ),  array( $this, 'data_metabox' ), 'denuncia' );
			add_meta_box( '2', __( 'Fotos del denunciante', 'textdomain' ),  array( $this, 'fotodenunciante_metabox' ), 'denuncia' );
			add_meta_box( '3', __( 'Fiscalizacion', 'textdomain' ),  array( $this, 'fiscalizacion_metabox' ), 'denuncia' );
			add_meta_box( '4', __( 'Rutas, actas y Otros (No puede ser visto por el usuario)', 'textdomain' ),  array( $this, 'otros_metabox' ), 'denuncia' );
			add_meta_box( '5', __( 'Expediente (No puede ser visto por el usuario)', 'textdomain' ),  array( $this, 'expediente_metabox' ), 'denuncia' );
		

		}
		/*
		*	Inserto data box de denuncia.
		*/
		public function data_metabox( $post ) {

			//print_r($post);
			//Seguridad auntenticacion
			//wp_nonce_field( 'custom_nonce_action', 'custom_nonce' );

			//Traigo los valores anteriores para mostrar, si posee.
			$direccion = get_post_meta( $post->ID, 'direccion', true );
			$geolat = get_post_meta( $post->ID, 'geolat', true );
			$geolong = get_post_meta( $post->ID, 'geolong', true );
			$comuna = get_post_meta( $post->ID, 'comuna', true );
			$barrio = get_post_meta( $post->ID, 'barrio', true );
			$obs = get_post_meta( $post->ID, 'obs', true );

		?>
			<form>
				<label>Ingreso calle y altura</label><br>
					<input type="text" placeholder='direccion' id='direccion' name='direccion' value='<?php echo $direccion; ?>'><br>
				<label>Geo. Latitud</label><br>
					<input type="text" placeholder='geolat' id='geolat' name='geolat' value='<?php echo $geolat; ?>'><br>
				<label>Geo. Longitud</label><br>
					<input type="text" placeholder='geolong' id='geolong' name='geolong' value='<?php echo $geolong; ?>'><br>
				<label>Comuna</label><br>
					<input type="text" placeholder='comuna' id='comuna' name='comuna' value='<?php echo $comuna; ?>'><br>
				<label>Barrio</label><br>
					<input type="text" placeholder='barrio' id='barrio' name='barrio' value='<?php echo $barrio; ?>'><br>
				<label>Observaciones</label><br>
					<textarea name="obs" id="obs" cols="30" rows="10"><?php echo $obs; ?></textarea> <br>
			</form>		
		<?php 
		}
		/*
		* Inserto la foto del denunciante
		*/
		public function fotodenunciante_metabox( $post_id ) {

			$attacheds = get_attached_media( '' , $post_id );
			foreach ( $attacheds as $attached ) { 

				$img_src = wp_get_attachment_image_src($attached->ID, 'small');
				$attachment_metadata = wp_get_attachment_metadata( $attached->ID );
				if($attachment_metadata['attachment_type']=='FotoDenunciante') {
			?>
				<p>Cargado por: <?php echo ( get_the_author_meta( 'nicename',  $attached->post_author )) ; ?> </p>
				<p>El dia: <?php echo $attached->post_date ?> </p>
				<img src="<?php echo $img_src[0] ?>" alt=""> <br>
			<?php 
				 }
				}
			 }
		/*
		*	Inserto las imagenes de las fiscalizaciones
		*/
		public function fiscalizacion_metabox( $post_id ) {

			$attacheds = get_attached_media( '' , $post_id );
			foreach ( $attacheds as $attached ) { 

				$img_src = wp_get_attachment_image_src($attached->ID, 'small');
				$attachment_metadata = wp_get_attachment_metadata( $attached->ID );
				if($attachment_metadata['attachment_type']=='Fiscalizacion') {
			?>
				<p>Cargado por: <?php echo ( get_the_author_meta( 'nicename',  $attached->post_author )) ; ?> </p>
				<p>El dia: <?php echo $attached->post_date ?> </p>
				<img src="<?php echo $img_src[0] ?>" alt=""> <br>
			<?php 
				 }
				}
			?>
				<label>Insertar url de fiscalizacion: </label> <br>
				<input type="text" id="urlfisc" name="urlfisc" value="" size="25" /> <br>
			<?php 
			}
		/*
		*	Inserto otros archivos no vistos por el user
		*/
		public function otros_metabox( $post_id) {

			$attacheds = get_attached_media( '' , $post_id );
			foreach ( $attacheds as $attached ) { 

				$img_src = wp_get_attachment_image_src($attached->ID, 'full');
				$attachment_metadata = wp_get_attachment_metadata( $attached->ID );
				if($attachment_metadata['attachment_type']=='Otros') {

			?>
				<p>Cargado por: <?php echo ( get_the_author_meta( 'nicename',  $attached->post_author )) ; ?> </p>
				<p>El dia: <?php echo $attached->post_date ?> </p>
				<img src="<?php echo $img_src[0] ?>" alt=""> <br>
			<?php 
				 }
				}
				/*
			?>
				<input type="file" id="wp_custom_attachment" name="wp_custom_attachment" value="" size="25" />
			<?php 
				*/
			}
		/*
		*	Inserto numero de expediente.
		*/
		public function expediente_metabox( $post ) {

			$expediente = get_post_meta( $post->ID, 'expediente', true );

		?>
			<form>
				<label>Numero de expediente</label><br>
					<input type="text" placeholder='expediente' id='expediente' name='expediente' value='<?php echo $expediente; ?>'><br>
				</form>		
		<?php 
		}
		/*
		* Realizo el updates de las metas cargadas
		*/
		public function wpdocs_save_meta_box( $post_id ) {
		
			//Obtengo los valores cargados
			$direccion= sanitize_text_field( $_POST['Direccion'] );
			$geolat= sanitize_text_field( $_POST['geolat'] );
			$geolong= sanitize_text_field( $_POST['geolong'] );
			$comuna= sanitize_text_field( $_POST['comuna'] );
			$barrio= sanitize_text_field( $_POST['barrio'] );
			$obs= sanitize_text_field( $_POST['obs'] );
			$expediente= sanitize_text_field( $_POST['expediente'] );
			$urlfisc= sanitize_text_field( $_POST['urlfisc'] );
			$fechahora = date("Y-m-d H:i:s");  

            //Actualizo los datos no genericos
			update_post_meta( $post_id, 'direccion', $direccion );
			update_post_meta( $post_id, 'geolat', $geolat );
			update_post_meta( $post_id, 'geolong', $geolong );
			update_post_meta( $post_id, 'comuna', $comuna );
			update_post_meta( $post_id, 'barrio', $barrio );
			update_post_meta( $post_id, 'obs', $obs );
			update_post_meta( $post_id, 'expediente', $expediente );
			update_post_meta( $post_id, 'fecha_inicio', $fechahora );


			if ($urlfisc){ 

			$new_file_mime=	mime_content_type( $urlfisc );
			$upload_id = wp_insert_attachment( array(
				'guid'           => $urlfisc, 
				'post_mime_type' => 'image/png',
				'post_title'     => 'TestingTitle',
				'post_content'   => '',
				'post_status'    => 'inherit'
			), $urlfisc, $post_id );

			// wp_generate_attachment_metadata() won't work if you do not include this file
			require_once( ABSPATH . 'wp-admin/includes/image.php' );

			// Generate and save the attachment metas into the database
			wp_update_attachment_metadata( $upload_id, wp_generate_attachment_metadata( $upload_id, $urlfisc ) );
						
			$data = array(
					'attachment_type'    => 'Fiscalizacion',
					'post_type'			 => 'denuncia'
						);
			
			// Genera el tipo de attachment que requiero para filtrar posteriormente
			wp_update_attachment_metadata( $upload_id, $data );
		}

		}
		/**
		 * Static accessor.
		 *
		 * @return Denuncia_PostType singleton.
		 */
		public static function instance() {
			if ( ! is_object( self::$instance ) ) {
				self::$instance = new Denuncia_PostType();
			}
			return self::$instance;
		}
	}
	Denuncia_PostType::instance();
}
