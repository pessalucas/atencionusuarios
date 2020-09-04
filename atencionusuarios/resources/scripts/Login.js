(function( $, window ){

	$( '#form_login' ).on( 'submit', onSubmitFormLogin );

	function onSubmitFormLogin( event ) {
		event.preventDefault();
		
		const $form = $( this );

		if ( $form.hasClass( 'loading' ) ) {
			return;
		}

		$form.addClass( 'loading' );
		
		$.post(
			'/wp-admin/admin-ajax.php',
			{
				action: 'atencionusuarios_login',
				user: '',
				passwd: '',
				remember: '',
			},
			function( response ){
				if ( response.status === 'succes' ) {
					windows.location.href = "/";
				} else {
					$( '#login_errors' ).html( response.data );
				}
				$form.removeClass( 'loading' );
			}
		).fail( function( error ){
			$( '#login_errors' ).html( 'Hubo un error al procesar lo solicitado. Intente nuevamete o contacte con soporte.' );
			console.log( error );
			$form.addClass( 'loading' );
		})
	}


})( jQuery, window );