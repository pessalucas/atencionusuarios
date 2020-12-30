(function( $, window ){
	'use strict';

	const $formChangePass  = $( '#frmChangePass' );
	const $formErrors = $( '#changepassError' );

	function onSubmitChangePass( event ) {
		event.preventDefault();

		if ( $formChangePass.find( '.is-invalid' ).length > 0 ) {
			return;
		}

		const $password1    = $formChangePass.find( '[name="password1"]' );
		const $password2    = $formChangePass.find( '[name="password2"]' );

		$.post(
			WP_Profile.ajax,
			{
				password1: $password1.val(),
				password2: $password2.val(),
				nonce: WP_Profile.nonce,
				action: 'profile_changepass',
			}
		).done( function( json ) {
			console.log( json );
			
			addError( json );
		}).fail( function() {
			addError( 'Error al procesar lo solicitado. Intente nuevamente o contacte con soporte.' );
		});
	}

	function addError( message ) {
		if( message.success ){
			var ClassBox = 'alert alert-success alert-dismissible';
			var exclamation = '';
		}else{
			var ClassBox = 'alert alert-danger alert-dismissible';
			var exclamation = 'fas fa-exclamation-triangle';
		}
		$formErrors.html( '' );
		$formErrors.append(
			$( '<div />' ).addClass( ClassBox ).append(
				$( '<i />' ).addClass( exclamation ),
				$( '<span />' ).text( message.data )
			)
		);
	}
	

	if ( $formChangePass.length > 0 ) {
		$formChangePass.on( 'submit', onSubmitChangePass );
	}

})( jQuery, window );