<?php

require_once 'class/users/class-users-profile.php';
require_once 'class/users/class-users-login.php';
//require_once 'class/users/class-users-logintest.php'; (FALLA)
require_once 'class/users/class-users-register.php';



//Incializacion de ajax
function ajax_login_init(){

    wp_register_script('ajax-login-script', get_template_directory_uri() . '/ajax-login-script.js', array('jquery') ); 
    wp_enqueue_script('ajax-login-script');

    wp_localize_script( 'ajax-login-script', 'ajax_login_object', array( 
        'ajaxurl' => admin_url( 'admin-ajax.php' ),
        'redirecturl' => home_url(),
        'loadingmessage' => __('Chequeando informacion, espere...')
    ));

    // Enable the user with no privileges to run ajax_login() in AJAX
    add_action( 'wp_ajax_nopriv_ajaxlogin', 'ajax_login' );
}

// Execute the action only if the user isn't logged in
if (!is_user_logged_in()) {
    add_action('init', 'ajax_login_init');
}

//Login por ajax
function ajax_login(){

    // Nonce is checked, get the POST data and sign user on
    $info = array();
    $info['user_login'] = $_POST['username'];
    $info['user_password'] = $_POST['password'];
    $info['remember'] = true;

    $user_signon = wp_signon( $info, false );
    if ( !is_wp_error($user_signon) ){
        wp_set_current_user($user_signon->ID);
        wp_set_auth_cookie($user_signon->ID);
		echo json_encode(array('loggedin'=>true, 'message'=>__('Acceso correcto, redirigiendo.')));
	/*	$return= array(
			'message'=>__('Acceso correcto, redirigiendo.')
		);
		wp_send_json_success( $return);*/
    }else{
		echo json_encode(array('loggedin'=>false, 'message'=>__('Error de usuario o contraseña. Volve a intentarlo.')));
	}

    die();
}


//Incializacion de ajax
function ajax_register_init(){

    wp_register_script('ajax-register-script', get_template_directory_uri() . '/resources/scripts/ajax-register-script.js', array('jquery') ); 
    wp_enqueue_script('ajax-register-script');

    wp_localize_script( 'ajax-register-script', 'ajax_register_object', array( 
        'ajaxurl' => admin_url( 'admin-ajax.php' ),
        'redirecturl' => home_url(),
        'loadingmessage' => __('Cargando informacion, espere...')
    ));

    // Enable the user with no privileges to run ajax_login() in AJAX
    add_action( 'wp_ajax_nopriv_ajaxregister', 'ajax_register' );
}

// Execute the action only if the user isn't logged in
if (!is_user_logged_in()) {
    add_action('init', 'ajax_register_init');
}

//Login por ajax
function ajax_register(){

	$name=$_POST['name'];
	$phone=$_POST['phone'];
	$email=$_POST['email'];
	$dni=$_POST['dni'];
	$username=$_POST['username'];
	$password=$_POST['password'];
	$name=$_POST['name'];
	$address=$_POST['address'];

	if ( wp_create_user($username, $password, $email) ) {
	
		// Loguearse posterior a registro.
	$info = array();
	$info['user_login'] = $username;
	$info['user_password'] = $password;
	$info['remember'] = true;
	$user_signon = wp_signon( $info, false );

		//Tomo id para cargar campos especiales
	$user_id= get_current_user_id();

		//Actualizo campos especiales (FALLA)
	update_user_meta( $user_id, 'firstname', $name );
	update_user_meta( $user_id, 'dni', $dni );
	update_user_meta( $user_id, 'telefono', $phone );
	update_user_meta( $user_id, 'direccion', $address );
		
	echo json_encode(array('registerin'=>true, 'message'=>__('Registro correcto, redirigiendo.')));
	}else{
		echo json_encode(array('registerin'=>false, 'message'=>__('Error de registro.')));
		
	}
	die();
}



//Incializacion de ajax
function ajax_update_init(){

    wp_register_script('ajax-update-script', get_template_directory_uri() . '/resources/scripts/ajax-update-script.js', array('jquery') ); 
    wp_enqueue_script('ajax-update-script');

    wp_localize_script( 'ajax-update-script', 'ajax_update_object', array( 
        'ajaxurl' => admin_url( 'admin-ajax.php' ),
        'redirecturl' => home_url(),
        'loadingmessage' => __('Cargando informacion, espere...')
    ));

    // Enable the user with no privileges to run ajax_login() in AJAX
	add_action( 'wp_ajax_nopriv_ajaxupdate', 'ajax_update' );
	add_action( 'wp_ajax_priv_ajaxupdate', 'ajax_update' );
}

    add_action('init', 'ajax_update_init');


//Login por ajax
function ajax_update(){

	$name=$_POST['name'];
	$phone=$_POST['phone'];
	$email=$_POST['email'];
	$dni=$_POST['dni'];
	$username=$_POST['username'];
	$password=$_POST['password'];
	$name=$_POST['name'];
	$address=$_POST['address'];

	if (false ) {
	
		//Tomo id para cargar campos especiales
	$user_id= get_current_user_id();

		//Actualizo campos especiales y no especiales (FALLA)
	update_user_meta( $user_id, 'dni', $dni );
	update_user_meta( $user_id, 'telefono', $phone );
	update_user_meta( $user_id, 'direccion', $address );
		
	echo json_encode(array('updatein'=>true, 'message'=>__('Registro correcto, redirigiendo.')));
	}else{
		echo json_encode(array('updatein'=>false, 'message'=>__('Error de registro.')));
		
	}
	die();
}






/**
 * Funciones globales de la aplicacion
 *
 */

if ( ! function_exists( 'ente_get_template_part' ) ) {
	/**
	 * Obtiene un template part seteando una variable global que puede ser leida dentro del elemento.
	 *
	 * $name Puede ser omitido, y las $variables pueden ser el segundo argumento. por ejemplo.
	 *      ente_get_template_part( 'sidebar', array( 'image_size' => 'thumbnail' ) )
	 *
	 * @param string $slug Slug del elemento similiar a @see get_template_part().
	 * @param string $name Opcional. Nombre del elemento. @see get_template_part().
	 * @param array  $variables Opcional. key => value que luego usaras en el elemento.
	 * @since 1.0.0
	 */
	function ente_get_template_part( $slug, $name = null, $variables = array() ) {
		global $ente_vars;
		if ( ! is_array( $ente_vars ) ) {
			$ente_vars = array();
		}
		// $name es opcional; si el segundo es un array, entonces son las $variables
		if ( is_array( $name ) && empty( $variables ) ) {
			$variables = $name;
			$name      = null;
		}
		$ente_vars[] = $variables;
		get_template_part( $slug, $name );
		array_pop( $ente_vars );
	}
}

if ( ! function_exists( 'ente_get_var' ) ) {
	/**
	 * Obtiene el valor de una variable seteada en @see iconosur_get_template_part.
	 *
	 * @param  string $key El key o ID de la variable en el array.
	 * @param  mixed  $default Opcional. Si el ID no existe, la funcion devuelve este valor. Por defecto es null.
	 * @since 1.0.0
	 */
	function ente_get_var( $key, $default = null ) {
		global $ente_vars;
		if ( empty( $ente_vars ) ) {
			return $default;
		}
		$current_template = end( $ente_vars );
		if ( isset( $current_template[ $key ] ) ) {
			return $current_template[ $key ];
		}
		return $default;
	}
}
