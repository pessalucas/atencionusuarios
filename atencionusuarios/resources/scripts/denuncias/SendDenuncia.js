jQuery(document).ready(function($) {

    //Obtengo url nativa para definir las redirecciones
    var urlnative = location.href;
    const url_nueva_denuncia = urlnative + 'denuncias/';
    const $formMessage       = $( '#frmmessage' );
    const ModalApro          = $( '#modalapro' );
    const MainModalApro      = $( '#main-modalapro' );
    const Fade               = $( '#fade2' );
    const EffectSuccess      = $( '#success-icon-effect' );
    
    $('form#denuncia').on('submit', function(e){
        e.preventDefault();

        //Muestro loader
        $('.containerloader').show();
        $('.btn-outline').attr("style", "display: none !important");
                
         
        //AJAX con archivo asociado. Se crea el data{ } como un form_data para generar todos los campos de envio
        var file_data = $('form#denuncia #file')[0].files[0];
        var form_data = new FormData();                  
        form_data.append('file',      file_data);
        form_data.append('action',    'ajaxdenuncia');
        form_data.append('direccion', $('form#denuncia #direccion').val() );
        form_data.append('vereda',    $('form#denuncia #vereda').val() );
        form_data.append('anomalia',  $('form#denuncia #anomalia').val() );
        form_data.append('geolat',    $('form#denuncia #geolat').val() );
        form_data.append('email',     $('form#denuncia #email').val() );
        form_data.append('geolong',   $('form#denuncia #geolong').val() );
        form_data.append('comuna',    $('form#denuncia #comuna').val() );
        form_data.append('barrio',    $('form#denuncia #barrio').val() );
        form_data.append('obs',       $('form#denuncia #obs').val() );

        $.ajax({
            type:        'POST',
            dataType:    'json',
            url:         ajax_denuncia_object.ajaxurl,
            data:        form_data,
            contentType: false,
            cache:       false,
            processData: false,
            
            success:     function( json ){
                console.log(json);
                
              

                //Muestro mensaje de error
                if ( json.success == false) { 

                //Oculto loader
                $('.containerloader').hide();
                $('.btn-outline').attr("style", "display: inline-block !important");
                
                addMessage( json.data );
                return;
                }

                //Modal de positivo
                if ( json.success == true ) { 
                    
                    $('.containerloader').hide();

                    console.log( json );

                    //Si salio todo correctamente muestro cuadro de aprobacion
                    //Agrego class show
                    //Cambio modal display a block.
                    //Segun el user_status muestro distintos caminos
                    ModalApro.addClass('show');
                    Fade.addClass('fade2');
                    
                    EffectSuccess.addClass('success-icon-effect');
                        //Acomodo al top la segunda seccion
                    ModalApro.show();
                    MainModalApro.append( function( ) {
                          //Nuevo usuario, primer denuncia realizada
                        if( json.data.user_status == '1' ){ 
                                var article=`
                                <h4 style='margin-bottom:10px; color:black;' >Su usuario ha sido creado, en el podra realizar el seguimiento.</h4>
                                <a href="`+ url_nueva_denuncia + /segdenuncia/ + `" class='menu-modal-success' style='border-bottom: solid grey 1px;'>Ir a seguimiento de denuncia</a>
                                <a href="`+ url_nueva_denuncia + /profile/ + `"   class='menu-modal-success' style='border-bottom: solid grey 1px;'>Generar contraseña de acceso</a>
                                <a href="`+ url_nueva_denuncia + /denuncias/ + `" class='menu-modal-success' style='border-bottom: solid grey 1px;'>Realizar otra denuncia</a>   
                                <a href="`+ url_nueva_denuncia + /home/ + `"   class='menu-modal-success''>Volver al inicio</a>
                                `;
                                return article; }

                        //Usuario logueado realiza denuncia
                        if( json.data.user_status == '2' ){ 
                                var article=`
                                <a href="`+ url_nueva_denuncia + /segdenuncia/ + `" class='menu-modal-success' style='border-bottom: solid grey 1px;'>Ir a seguimiento de denuncia</a>
                                <a href="`+ url_nueva_denuncia + /denuncias/ + `" class='menu-modal-success' style='border-bottom: solid grey 1px;'>Realizar otra denuncia</a>    
                                <a href="`+ url_nueva_denuncia + /home/ + `" class='menu-modal-success'>Volver al inicio</a>    
                                `;
                                return article; }
                    
                        //Posee usuario pero no esta logueado
                        if( json.data.user_status == '3' ){ 
                                var article=`  
                                <h4 style='margin-bottom:10px; color:black;'>Usted ya cuenta con un usuario, para poder hacer segumiento de la misma debe iniciar sesion.</h4>
                                <a href="`+ url_nueva_denuncia + /login/ + `" class='menu-modal-success' style=' border-bottom: solid grey 1px;'>Iniciar sesion e ir a segumiento de denuncia</a>
                                <a href="`+ url_nueva_denuncia + /denuncias/ + `" class='menu-modal-success' style='border-bottom: solid grey 1px;'>Realizar otra denuncia</a>   
                                <a href="`+ url_nueva_denuncia + /home/ + `"  class='menu-modal-success' >Volver al inicio</a>
                                `;
                                return article; }
                            });

                return;
                }

			return;
            },
            fail: function( json ){

                 //console.log(json);
                 addMessage( json.data );
            }
        }).fail( function(){
                console.log( 'Ocurrio una falla en la conexion.' );
        });
     
    });


	function addMessage( message ) {
		$formMessage.html( '' );
		$formMessage.append(
			$( '<div />' ).addClass( 'alert alert-danger alert-dismissible' ).append(
				$( '<i />' ).addClass( 'fas fa-exclamation-triangle' ),
				$( '<span />' ).text( message )
			)
		);
	}
	
	
});