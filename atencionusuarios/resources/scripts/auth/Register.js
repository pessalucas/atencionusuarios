(function( $, window ){
	'use strict';
	
	//Obtengo url nativa para definir las redirecciones
	var urlnative = location.href;
    const url_nueva_denuncia = urlnative + 'denuncias/';
	const $formRegister      = $( '#frmSignUp' );
	const $formErrors        = $( '#registerError' );

	function onSubmitRegister( event ) {
		event.preventDefault();

		if ( $formRegister.find( '.is-invalid' ).length > 0 ) {
			return;
		}

		const $firstname   = $formRegister.find( '[name="firstname"]' );
		const $lastname    = $formRegister.find( '[name="lastname"]' );
		const $email       = $formRegister.find( '[name="email"]' );
		const $password    = $formRegister.find( '#register_password' );
		const $phone       = $formRegister.find( '[name="phone"]' );
		const $passport_id = $formRegister.find( '[name="passport_id"]' );
		const $address     = $formRegister.find( '[name="address"]' );

		$.post(
			WP_Auth.ajax,
			{
				firstname: $firstname.val(),
				lastname: $lastname.val(),
				email: $email.val(),
				pass: $password.val(),
				phone: $phone.val(),
				passport_id: $passport_id.val(),
				address: $address.val(),
				nonce: WP_Auth.nonce,
				action: 'wp_auth_register',
			}
		).done( function( json ) {

			console.log( json );
			
			console.log(document.referrer );
			if( document.referrer == url_nueva_denuncia ){
				window.close();
				return;
			}
			
			if ( json.success ) {
				window.location.href = WP_Auth.redirect;
				return;
			}
			addError( json.data );
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
	

	if ( $formRegister.length > 0 ) {
		$formRegister.on( 'submit', onSubmitRegister );
	}

})( jQuery, window );