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
			add_action( 'ini', array( $this, 'register_posttype' ) );
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
