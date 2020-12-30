(function( $, window ){
	'use strict';

	//Obtengo url nativa para definir las redirecciones
	var urlnative = location.href;
    const url_nueva_denuncia = urlnative + 'denuncias/';
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
			console.log(document.referrer );

			if ( ! json.success ) {
			addError( json.data );
			return;
			}
			
			if ( json.success ) {
				window.location.href = WP_Auth.redirect;
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


	//Recupero de contrasena
	const $formPass  = $( '#formnewpass' );
	const $formErrorsPass = $( '#errordiv' );

	function onSubmitReset( event ) {
		event.preventDefault();

		if ( $formPass.find( '.is-invalid' ).length > 0 ) {
			return;
		}

		//Muestro loader
        $('.containerloader').show();
        $('.btn-primary').attr("style", "display: none !important");

		const $email    = $formPass.find( '[name="email"]' );

		if ( $email.val() ){ 
		$.post(
			WP_Auth.ajax,
			{
				email: $email.val(),
				nonce: WP_Auth.nonce,
				action: 'wp_reset_pass',
			}
		).done( function( json ) {

			  //Oculto loader
			  $('.containerloader').hide();
			  $('.btn-primary').attr("style", "display: block !important");

			console.log( json );
			console.log(document.referrer );

			if ( ! json.success ) {
				$('.btn-primary').attr("style", "display: inline-block !important");
			addErrorPass( json.data );
			return;
			}
			
			if ( json.success ) {
				addSuccessPass( json.data );
				return;
			}
			
		}).fail( function() {
			addErrorPass( 'Error al procesar lo solicitado. Intente nuevamente o contacte con soporte.' );
		});
	}
}

	function addErrorPass( message ) {
		$formErrorsPass.html( '' );
		$formErrorsPass.append(
			$( '<div />' ).addClass( 'alert alert-danger alert-dismissible' ).append(
				$( '<i />' ).addClass( 'fas fa-exclamation-triangle' ),
				$( '<span />' ).text( message )
			)
		);
	}
	function addSuccessPass( message ) {
		$formErrorsPass.html( '' );
		$formErrorsPass.append(
			$( '<div />' ).addClass( 'alert alert-success alert-dismissible' ).append(
				$( '<i />' ).addClass( 'fas fa-exclamation' ),
				$( '<span />' ).text( message )
			)
		);
	}
	

	if ( $formPass.length > 0 ) {
		$formPass.on( 'submit', onSubmitReset );
	}
})( jQuery, window );