
<?php

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

/*
Activador de Imagen destacada de wordpress carga.
*/
if ( function_exists( 'add_theme_support' ) )
add_theme_support( 'post-thumbnails' );
