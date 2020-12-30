
<?php

/**
 * Funciones globales de la aplicacion templates. Insercion de templates con variables asociadas
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

/*
*	Activador de Imagen destacada de wordpress carga.
*
*/
if ( function_exists( 'add_theme_support' ) )
add_theme_support( 'post-thumbnails' );

/*
*	Empresa segun anomalia y comuna
*
*/
if ( ! function_exists( 'get_idempresa_by' ) ) {
	function get_idempresa_by ( $service_depto_id , $comuna_number , $tipo_servicio){

		/*  Datos obtenidos de worpdress. Inmodificables. 
			IDs definidos por wordpress en los Departamentos en la taxonomy de Servicios
		Departamento de alumbrado publico = 322
		Departamento de estacionamiento medido = 260
		Departamento de higiene urbana = 7
		Departamento de subte = 123
		Departamento de transporte = 141
		
			IDs definidos por wordpress en los Departamentos en la taxonomy de Empresas
		Departamendo de alumbrado = 445
		Departamento de higiene urbana = 34

			IDs definidos por wordpress en las Empresas en la taxonomy de Empresas
				ALUMBRADO:
					Z1 = 446
					Z2 = 447
					Z3 = 448
				HIGIENE URBANA:
					Z1 = 35
					Z2 = 36
					Z3 = 37
					Z4 = 38
					Z5 = 40
					Z6 = 41
					Z7 = 42
		*/

		//Obtengo el id del departamento tax empresa
		switch ($service_depto_id) {
			case 322:
				$empresas_depto_id=445;
				break;
			case 260:
				$empresas_depto_id=0;
				break;
			case 7:
				$empresas_depto_id=34;
				break;
			case 123:
				$empresas_depto_id=0;
				break;
			case 141:
				$empresas_depto_id=0;
				break;
		}

		//Obtengo la empresa asociada a esa comuna y la retorno
		switch ($empresas_depto_id) {
			case 445:
							//Departamento de alumbrado. Segun comuna devuelvo la zona correspondiente
							//Primero verifico que se trate del servicio de alumbrado publico ID = 323
							if($tipo_servicio == 323){ 
								if (($comuna_number==2) OR ($comuna_number==5) OR ($comuna_number==3) OR ($comuna_number==4) OR ($comuna_number==1)){
									//Devuelvo zona 1
									return 446;
								} else if (($comuna_number==13) OR ($comuna_number==15) OR ($comuna_number==14) OR ($comuna_number==12)){
									//Devuelco zona 2
									return 447;
								} else if (($comuna_number==6) OR ($comuna_number==7) OR ($comuna_number==9) OR ($comuna_number==10) OR ($comuna_number==11) OR ($comuna_number==8)){
									//Devuelvo zona 3
									return 448;
								} else {
									//Comuna invalida
									return 0;
								}
							}
						return 0;
				break;
			case 34:
							//Departamento de Higiene urbana. Segun comuna devuelvo la zona correspondiente
							//Primero verifico que se trate del servicio de Higiene urbana ID = 78
							if($tipo_servicio == 78){ 
								if (($comuna_number==1)){
									//Devuelvo zona 1
									return 35;
								} else if (($comuna_number==13) OR ($comuna_number==2) OR ($comuna_number==14)){
									//Devuelco zona 2
									return 36;
								} else if (($comuna_number==12) OR ($comuna_number==11) OR ($comuna_number==15)){
									//Devuelvo zona 3
									return 37;
								} else if (($comuna_number==9) OR ($comuna_number==10)){
									//Devuelvo zona 4
									return 38;
								} else if (($comuna_number==8)){
									//Devuelvo zona 5
									return 40;
								} else if (($comuna_number==6) OR ($comuna_number==7) OR ($comuna_number==5)){
									//Devuelvo zona 6
									return 41;
								} else if (($comuna_number==3) OR ($comuna_number==4)){
									//Devuelvo zona 7
									return 42;
								} else {
									//Comuna invalida
									return 0;
								}
							}
							return 0;
				break;
			case 0:
				//No se posee informacion asociada a dichos departamentos.
				return 0;
				break;
		}
	} }
/*
*	Obtengo el id de la tax comuna con el numero de comuna
*
*/
if ( ! function_exists( 'get_idcomuna_by' ) ) {
	function get_idcomuna_by ( $comuna_number ){

		/*  Datos obtenidos de worpdress. Inmodificables. 
			IDs de las comunas
				Comuna 1: 19
				Comuna 2: 20
				Comuna 3: 21
				Comuna 4: 22
				Comuna 5: 23
				Comuna 6: 24
				Comuna 7: 25
				Comuna 8: 26
				Comuna 9: 27
				Comuna 10: 28
				Comuna 11: 29
				Comuna 12: 30
				Comuna 13: 31
				Comuna 14: 32
				Comuna 15: 33
		*/

		//Obtengo el id del departamento tax empresa
		switch ($comuna_number) {
			case 1:
				return 19;
			case 2:
				return 20;
			case 3:
				return 21;
			case 4:
				return 22;
			case 5:
				return 23;
			case 6:
				return 24;
			case 7:
				return 25;
			case 8:
				return 26;
			case 9:
				return 27;
			case 10:
				return 28;
			case 11:
				return 29;
			case 12:
				return 30;
			case 13:
				return 31;
			case 14:
				return 32;
			case 15:
				return 32;
		}
 } }


 /**
 * Recursively sort an array of taxonomy terms hierarchically. Child categories will be
 * placed under a 'children' member of their parent term.
 * @param Array   $cats     taxonomy term objects to sort
 * @param Array   $into     result array to put them in
 * @param integer $parentId the current parent ID to put them in
 */
function sort_terms_hierarchically( $cats, $into, $parentId = 0)
{
    foreach ($cats as $i => $cat) {
        if ($cat->parent == $parentId) {
            $into[$cat->term_id] = $cat;
            unset($cats[$i]);
        }
    }

    foreach ($into as $topCat) {
        $topCat->children = array();
        sort_terms_hierarchically($cats, $topCat->children, $topCat->term_id);
    }
}







/*
**
* Sistema de Mails At Usuario
*
*/

//Recupero de contrasena
function mail_recu_pass ( $name, $email, $newpassword, $link ) {

	$destinatario = $email;
	$asunto = 'Nueva contraseña - Denuncias Ente';
	if ( $name ){ 
		$cuerpo= '
		<h3>Hola '. $name . '</h3>
		<p>Tu nueva contraseña asignada aleatoriamente es: ' . $newpassword. '</p>
		<p>Puedes modificarla en la sección "Editar Perfil" una vez que hayas iniciado sesión.</p>
		<a href="http://192.168.3.117/">Sitio - Denuncias Ente</a>
		<p>Cualquier duda no dudes en comuncarte con nosotros. <br>
		Telefono: 0800-222-ENTE (3686) <br>
		Mail: denuncias@entedelaciudad.gob.ar <br>
		Queremos darte la ciudad que te mereces. <br>
		</p>
		';
	}else{
		$cuerpo= '
		<h3>Hola '. $email . '</h3>
		<p>Tu nueva contraseña asignada aleatoriamente es ' . $newpassword. '</p>
		<p>Puedes modificarla en la sección "Editar Perfil" una vez que hayas iniciado sesión.</p>
		<a href="http://192.168.3.117/">Sitio - Denuncias Ente</a>
		<p>Cualquier duda no dudes en comuncarte con nosotros. <br>
		Telefono: 0800-222-ENTE (3686) <br>
		Mail: denuncias@entedelaciudad.gob.ar <br>
		Queremos darte la ciudad que te mereces. <br>
		</p>
		';
	}
	$cabeceras= array('Content-Type: text/html; charset=UTF-8');
	
	wp_mail( $destinatario, $asunto , $cuerpo, $cabeceras);
	}
	
	
	//Nuevo usuario creado via nueva denuncia
	function mail_new_user_fast ( $name, $email, $newpassword, $link ) {
	
		$destinatario = $email;
		$asunto = 'Nueva usuario - Denuncias Ente';
		$cuerpo= '
		<h3>Hola '. $email . '</h3>
		<p>Bienvenido a la nueva red de sitios del Ente Único Regulador De Servicios Públicos De La Ciudad Autónoma De Buenos Aires.</p>
		<p>En Denuncias Ente vas a poder relizar denuncias sobre los 13 servicios controlados por el organismo y hacer seguimiento de las mismas en tiempo real.</p>
		<p>Tu nueva contraseña asignada aleatoriamente es ' . $newpassword. '</p>
		<p>Puedes modificarla y terminar de completar tus datos personales en la sección "Editar Perfil" una vez que hayas iniciado sesión.</p>
		<a href="http://192.168.3.117/">Sitio - Denuncias Ente</a>
		<p>Cualquier duda no dudes en comuncarte con nosotros. <br>
		Telefono: 0800-222-ENTE (3686) <br>
		Mail: denuncias@entedelaciudad.gob.ar <br>
		Queremos darte la ciudad que te mereces. <br>
		</p>
		';
		$cabeceras= array('Content-Type: text/html; charset=UTF-8');
		
	wp_mail( $destinatario, $asunto , $cuerpo, $cabeceras);
	}
	
	//Nuevo usuario creado por via de registro
	function mail_new_user_slow ( $name, $email, $newpassword, $link ) {
	
		$destinatario = $email;
		$asunto = 'Nueva usuario - Denuncias Ente';
		$cuerpo= '
		<h3>Hola '. $name . '</h3>
		<p>Bienvenido a la nueva red de sitios del Ente Único Regulador De Servicios Públicos De La Ciudad Autónoma De Buenos Aires.</p>
		<p>En Denuncias Ente vas a poder relizar denuncias sobre los 13 servicios controlados por el organismo y hacer seguimiento de las mismas en tiempo real.</p>
		<a href="http://192.168.3.117/">Sitio - Denuncias Ente</a>
		<p>Cualquier duda no dudes en comuncarte con nosotros. <br>
		Telefono: 0800-222-ENTE (3686) <br>
		Mail: denuncias@entedelaciudad.gob.ar <br>
		Queremos darte la ciudad que te mereces. <br>
		</p>
		';
		$cabeceras= array('Content-Type: text/html; charset=UTF-8');
		
	wp_mail( $destinatario, $asunto , $cuerpo, $cabeceras);
	}
	
	//Nueva denuncia
	function mail_new_denuncia ( $name, $email, $newpassword, $link ) {

		$destinatario = $email;
		$asunto = 'Nueva denuncia - Denuncias Ente';
		if ( $name ){ 
		$cuerpo= '
		<h3>Hola '. $name . '</h3>
		<p>La denuncia se ha iniciado correctamente. Puedes hacer seguimiento de la misma ingresando a <a href="http://192.168.3.117/">Sitio - Denuncias Ente</a> con tu usuario o
		atraves del siguiente link <a href="'.$link.'">'.$link.'</a>.
		</p>
		';
	}else{
		$cuerpo= '
		<h3>Hola '. $email . '</h3>
		<p>La denuncia se ha iniciado correctamente. Puedes hacer seguimiento de la misma ingresando a <a href="http://192.168.3.117/">Sitio - Denuncias Ente</a> con tu usuario o
		atraves del siguiente link <a href="'.$link.'">'.$link.'</a>.
		</p>
		<p>Cualquier duda no dudes en comuncarte con nosotros. <br>
		Telefono: 0800-222-ENTE (3686) <br>
		Mail: denuncias@entedelaciudad.gob.ar <br>
		Queremos darte la ciudad que te mereces. <br>
		</p>
		';
	}

		$cabeceras= array('Content-Type: text/html; charset=UTF-8');

		
	wp_mail( $destinatario, $asunto , $cuerpo, $cabeceras);
	}
	

	//Nuevo comentario realizado por At Usuarios
function mail_new_comment_vecino ( $name, $email, $newpassword, $nrodenuncia ) {

	$destinatario = 'soporte@entedelaciudad.gov.ar';
	$asunto = 'Notificacion en denuncia';
	$cuerpo= '
	<h3>El usuario '. $name . ' ha realizado un comentario en la denuncia '. $nrodenuncia . '</h3>
	<p>Por favor verifique la informacion para responder el comentario en breve.</p>
	<p>Cualquier duda no dudes en comuncarte con nosotros. <br>
	Telefono: 0800-222-ENTE (3686) <br>
	Mail: denuncias@entedelaciudad.gob.ar <br>
	Queremos darte la ciudad que te mereces. <br>
	</p>
	';
	$cabeceras= array('Content-Type: text/html; charset=UTF-8');

wp_mail( $destinatario, $asunto , $cuerpo, $cabeceras);
}
