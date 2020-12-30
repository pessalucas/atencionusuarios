(function( $, window ){
	'use strict';

	//Obtengo url nativa para definir las redirecciones
	var urlnative = location.origin;
    const url_nueva_denuncia = urlnative + '/atencionusuarios/administrador/';
	const $formLogin  = $( '#frmSignIn' );
	const $formErrors = $( '#loginError' );

	function onSubmitLogin( event ) {
		event.preventDefault();

		if ( $formLogin.find( '.is-invalid' ).length > 0 ) {
			return;
		}

		const $email    = $formLogin.find( '[name="email"]' );
		const $pass     = $formLogin.find( '[name="password"]' );
		const $remember = $formLogin.find( '[name="rememberme"]' );

		$.post(
			WP_Auth.ajax,
			{
				email: $email.val(),
				pass: $pass.val(),
				remember: $remember.is( ':checked' ),
				nonce: WP_Auth.nonce,
				action: 'wp_auth_login',
			}
		).done( function( json ) {

			console.log( json );
			console.log(urlnative );

			if ( ! json.success ) {
			addError( json.data );
			return;
			}else{
				window.location.href = url_nueva_denuncia;
				return;
			}
			
		}).fail( function() {
			addError( 'Error al procesar lo solicitado. Intente nuevamente o contacte con soporte.' );
		});
	}

	function addError( message ) {
		$formErrors.html( '' );
		$formErrors.append(
			$( '<div />' ).addClass( 'alert alert-danger alert-dismissible' ).append(
				$( '<i />' ).addClass( 'fas fa-exclamation-triangle' ),
				$( '<span />' ).text( message )
			)
		);
	}
	

	if ( $formLogin.length > 0 ) {
		$formLogin.on( 'submit', onSubmitLogin );
	}

})( jQuery, window );