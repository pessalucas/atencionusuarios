(function( $, window ){
	'use strict';

	const $formUpdate  = $( '#frmUpdate' );
	const $formErrors = $( '#updateError' );

	function onSubmitupdate( event ) {
		event.preventDefault();

		if ( $formUpdate.find( '.is-invalid' ).length > 0 ) {
			return;
		}

		const $firstname   = $formUpdate.find( '[name="firstname"]' );
		const $lastname    = $formUpdate.find( '[name="lastname"]' );
		const $email       = $formUpdate.find( '[name="email"]' );
		const $phone       = $formUpdate.find( '[name="phone"]' );
		const $dni		   = $formUpdate.find( '[name="dni"]' );
		const $address     = $formUpdate.find( '[name="address"]' );

		$.post(
			WP_Profile.ajax,
			{
				firstname: $firstname.val(),
				lastname:  $lastname.val(),
				email:     $email.val(),
				phone:     $phone.val(),
				dni:       $dni.val(),
				address:   $address.val(),
				nonce:     WP_Profile.nonce,
				action:   'profile_update',
			}
		).done( function( json ) {
			console.log( json );
			
			addError( json );
		}).fail( function() {
			addError( 'Error al procesar lo solicitado. Intente nuevamente o contacte con soporte.' );
		});
	}

	function addError( message ) {
		if(message.success){
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
	

	if ( $formUpdate.length > 0 ) {
		$formUpdate.on( 'submit', onSubmitupdate );
	}

})( jQuery, window );