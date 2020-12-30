<?php
/**
 * Roles de usuarios
 *
 * @package atencionusuarios
 */

if ( ! class_exists( 'Roles' ) ) {
	/**
	 * Class Role
	 */
	class Roles {
		/**
		 * Static accessor.
		 *
		 * @var Roles
		 */
		public static $instance;
		/**
		 * Constructor.
		 */
		public function __construct() {

            //Agrego roles custom
            add_action( 'init', array( $this, 'custom_roles_add'  ) );

            //Genero redirect para cualquiera que quiera ir a /wp-admin/
            add_action( 'template_redirect', array( $this, 'redirect_is_not_access_rol' ) );
		}
		/**
		 *  Genero roles custom
		 */
		public function custom_roles_add() {

            add_role( 'denunciante', 'Denunciante', array( 
                'publish_denuncia'          => true, 
                'read'                      => true,
                'upload_files'              => true,
                'create_denuncia'           => true 
                ) );
       
            add_role( 'usuarios', 'Usuarios', array( 
                'delete_denuncia'           => true, 
                'delete_published_denuncia' => true,
                'edit_denuncia'             => true, 
                'edit_published_denuncia'   => true,
                'publish_denuncia'          => true, 
                'read'                      => true,
                'upload_files'              => true,
                'read_private_denuncia'     => true
                ) );

            add_role( 'usuariosjefe', 'UsuariosJefe', array( 
                'delete_denuncia'           => true, 
                'delete_published_denuncia' => true,
                'edit_denuncia'             => true, 
                'edit_published_denuncia'   => true,
                'publish_denuncia'          => true, 
                'read'                      => true,
                'upload_files'              => true,
                'read_private_denuncia'     => true
                ) );
       
            add_role( 'prensa', 'Prensa', array( 
                'delete_posts'           => true, 
                'delete_published_posts' => true,
                'edit_posts'             => true, 
                'edit_published_posts'   => true,
                'publish_posts'          => true, 
                'read_posts'             => true,
                'upload_files'           => true,
                'read_private_posts'     => true
                ) );
       
            add_role( 'control', 'Control', array( 
                'delete_denuncia'           => true, 
                'delete_published_denuncia' => true,
                'edit_denuncia'             => true, 
                'edit_published_denuncia'   => true,
                'publish_denuncia'          => true, 
                'read'                      => true,
                'upload_files'              => true,
                'read_private_denuncia'     => true
                )  );
        }
        /**
		 * Constructor.
		 */
		public function redirect_is_not_access_rol() {

            $urlactual = get_page_link();
            $urlwpadmin = get_home_url() . '/wp-admin/';

            //Obtengo longitud de caracteres de urlwpadmin
            $lenghturl = strlen( $urlwpadmin );

            //Corto la url actual para verificar
            $urlactualcut = substr( $urlactual , 0 ,  $lenghturl );
           
            //Obtengo info de los roles del usuario
            $user = wp_get_current_user();

            if ( $urlactualcut == $urlwpadmin ){
                if ( $user->roles[0] == 'denunciante' ){
                    wp_redirect( get_permalink( get_home_url() ));
				exit;
                }}

		}
		/**
		 * Static accessor.
		 *
		 * @return Roles singleton.
		 */
		public static function instance() {
			if ( ! is_object( self::$instance ) ) {
				self::$instance = new Roles();
			}
			return self::$instance;
		}
	}
	Roles::instance();
}
