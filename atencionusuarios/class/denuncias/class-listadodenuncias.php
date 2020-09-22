<?php
/**
 * Ejecuta las funciones para el listado de denuncias.
 *
 * @package LucasPessa
 */

if ( ! class_exists( 'ListadoDenuncias' ) ) {
	/**
	 * Class User Profile.
	 */
	class ListadoDenuncias {
		/**
		 * Static accessor.
		 *
		 * @var ListadoDenuncias
		 */
		public static $instance;
		/**
		 * Constructor.
		 */
		public function __construct() {

            add_action( 'wp_ajax_nopriv_ajaxlistadodenuncias',array($this, 'ajax_listadodenuncias'));
            add_action( 'wp_ajax_ajaxlistadodenuncias',array($this, 'ajax_listadodenuncias'));

			add_action('init', array($this,'ajax_listadodenuncias_init'));
			

		}
		public function ajax_listadodenuncias_init(){

			wp_register_script('ajax-listadodenuncias-script', get_template_directory_uri() . '/resources/scripts/ajax-listadodenuncias-script.js', array('jquery') ); 
			wp_enqueue_script('ajax-listadodenuncias-script');
		
			wp_localize_script( 'ajax-listadodenuncias-script', 'ajax_listadodenuncias_object', array( 
				'ajaxurl' => admin_url( 'admin-ajax.php' ),
				'redirecturl' => home_url(),
				'loadingmessage' => __('Chequeando informacion, espere...')
			));
		
			// Enable the user with no privileges to run ajax_listadodenuncias() in AJAX
		}
		//listadodenuncias por ajax
		public function ajax_listadodenuncias(){
        
            //Tomo id de denucia
            $iddenuncia=$_POST['iddenuncia'];

            //Obtengo taxonomys de estado y tipo de servicio
            $estado=get_the_terms( $iddenuncia, 'estado' ); //array
            $servicios=get_the_terms( $iddenuncia, 'servicios' ); //array

            //Tomo la data de la id denuncia
            $datageneral=array();
            $data['id']= $iddenuncia;
            $data['direccion'] = get_post_meta( $iddenuncia, 'direccion', true );
            $data['barrio'] = get_post_meta( $iddenuncia, 'barrio', true );
            $data['obs']= get_post_meta( $iddenuncia, 'observacion', true );
            $data['fecha']=get_the_date( 'd M Y', $iddenuncia );
            array_push($datageneral,$data); //array

            //Tomo los atachmente de la id den
            $attachedsfilter=array();
            $attacheds = get_attached_media( '' , $iddenuncia );
            foreach ($attacheds as $attached){
				$img_src = wp_get_attachment_image_src($attached->ID, 'small');
				$attachment_metadata = wp_get_attachment_metadata( $attached->ID );
                $attachedd['ID']              = $attached->ID;
                $attachedd['post_author']     = get_the_author_meta( 'nicename',  $attached->post_author );
                $attachedd['post_date']       = $attached->post_date;
                $attachedd['guid']         	  = $img_src[0];
                $attachedd['attachment_type'] = $attachment_metadata['attachment_type'];
                array_push($attachedsfilter,$attachedd);
            }   //array

           //Tomo los comentarios de la id den
            $args = array(
                'post_id' => $iddenuncia, 
            );
            $comments = get_comments( $args );  //array

            echo json_encode(array(
				'status'=>'success', 
                'estado'=> $estado ,
                'datageneral'=> $datageneral ,
                'servicios'=> $servicios ,
                'attacheds'=> $attachedsfilter ,
                'comments'=> $comments 
            ));
        

            die();
		}
		
		/**
		 * Static accessor.
		 *
		 * @return ListadoDenuncias singleton.
		 */
		public static function instance() {
			if ( ! is_object( self::$instance ) ) {
				self::$instance = new ListadoDenuncias();
			}
			return self::$instance;
		}
	}
	ListadoDenuncias::instance();
}
