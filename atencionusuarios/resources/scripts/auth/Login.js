(function( $, window ){
	'use strict';

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
	

	if ( $formLogin.length > 0 ) {
		$formLogin.on( 'submit', onSubmitLogin );
	}

})( jQuery, window );