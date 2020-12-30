(function( $, window ){
	'use strict';

	//Obtengo url nativa para definir las redirecciones
	var   urlnative        = location.href;
	const $formLogin       = $( '#frmSignIn' );

    //Informacion del usuario
    const SearcherUser     = $( '#searcheruser' );
    const UlSearcherUser   = $( '#ulsearcheruser' );
    const ButtonNewUser    = $( '#registeruser' );
    const FormNewUser      = $( '#formdenunciante' );
    const firstname        = $( '#firstname' );
    const lastname         = $( '#lastname' );
    const email            = $( '#email' );
    const dni              = $( '#dni' );
    const phone            = $( '#phone' );
    const adress           = $( '#adress' );
    const UserMessages     = $( '#user_messages' );
    const type             = $( '#type' );
    const userid           = $( '#userid' );
    const ButtonUpdateUser = $( '#updateuser' );

    //Informacion formulario de carga de denuncia
    const user_id                  = $( '#user_id' );
    const SelectorServicio         = $( '#servicio' );
    const SelectorGrupoAnomalias   = $( '#grupoanomalias' );
    const SelectorAnomalia         = $( '#anomalia' );
    const UlSearcherDireccion      = $( '#searcherdireccion' );
    const SelectorBarrido          = $( '#selectorbarrido' );
    const SearcherDireccion        = $( '#direccion' );
    const GeoLat                   = $( '#geolat' );
    const GeoLong                  = $( '#geolong' );
    const Barrio                   = $( '#barrio' );
    const Comuna                   = $( '#comuna' );
    const Map                      = $( '#mapembed' );
    const FormNewDenuncia          = $( '#formdenuncia' );
    const Observacion              = $( '#obs' );
    const DenunciaMessages         = $( '#denuncia_messages' );
    const SelectorProcedencia      = $( '#procedencia' );
    
     //url variable del map
     var   urlmap
     //Latitudes y longiutes variables.
     var   lat
     var   long
 
    //Oculto boton de actualizacion
    ButtonUpdateUser.hide();
    SelectorBarrido.hide();

    //Creo un nuevo usuario.
    FormNewUser.on( 'submit' , function( event ) {
        event.preventDefault();

        $.post(
            wp_NewDenuncia.ajax,
            {
                firstname : firstname.val(),
                lastname  : lastname.val(),
                email     : email.val(),
                dni       : dni.val(),
                phone     : phone.val(),
                adress    : adress.val(),
                type      : type.val(),
                userid    : userid.val(),
                action    : 'wp_registeruser',
            }
        ).done( function( json ) {
            console.log(json);
            addMessageUser( json );
            if ( json.success == true ){
                ButtonNewUser    .hide();
                user_id          .val( json.data.user_id );
                ButtonUpdateUser .show();
            }
        }).fail( function() {
            console.log('failed');
            //addError( 'Error al procesar lo solicitado. Intente nuevamente o contacte con soporte.' );
        });

    })

    
    //Cada vez que presiona un aletra genero un evento ajax que compara
    SearcherUser.keyup( function(){

        var SearcherUserValue = SearcherUser.val();

        if ( SearcherUserValue == '' ){
            UlSearcherUser.empty();
            return;
        }

        //Reasigno variables para posible nuevo registro de usuario
        userid           .val( '' );
        type             .val( 'new' );
        ButtonNewUser    .show();
        ButtonUpdateUser .hide();

        //Espero que termine de escribir antes de ejecutar
        delay( function(){ 
           
		$.post(
			wp_NewDenuncia.ajax,
			{
				user_data: SearcherUserValue,
				action: 'wp_searcherusers',
			}
		).done( function( json ) {

			    console.log( json );
    
             

                //Borro
                UlSearcherUser.empty();

                //Llega como .data; escribo las opciones
                var count = 0;
                json.data.forEach(function() {
                        UlSearcherUser.fadeIn().append(function() {
                        var article=`
                        <li id=' `+  json.data[count] + ` '>
                        `+  json.data[count] + `
                        </li>`
                        return article;
                        });
                 count++;
                 if( count == 5 ){ return; }
                });

                
                //Cuando se clickea un Li lo asigno al usuario.
                $( '#ulsearcheruser li' ).click( function(){

                    //Traigo id del elemento para conocer la anomalia
                    var user_email = $(this).attr("id");

                    //Borro y escribo busqueda
                    UlSearcherUser.empty();
                    SearcherUser.val( user_email );

                    
                    $.post(
                        wp_NewDenuncia.ajax,
                        {
                            user_email: user_email,
                            action: 'wp_userdata',
                        }
                    ).done( function( json ) {
                        console.log(json);

                        firstname        .val( json.data.firstname );
                        lastname         .val( json.data.lastname );
                        email            .val( json.data.email );
                        dni              .val( json.data.dni );
                        adress           .val( json.data.adress );
                        phone            .val( json.data.phone );
                        user_id          .val( json.data.ID );
                        userid           .val( json.data.ID );
                        type             .val( 'update' );
                        ButtonNewUser    .hide();
                        ButtonUpdateUser .show();

                        addMessageUser( json );
                        

                    }).fail( function() {
                        console.log('failed');
                        //addMessageUser( 'Error al procesar lo solicitado. Intente nuevamente o contacte con soporte.' );
                   
                    });

                    })
			
		}).fail( function() {
            console.log('failed');
			//addError( 'Error al procesar lo solicitado. Intente nuevamente o contacte con soporte.' );
        });
        
        }, 500); 
	});


    //Notificaciones para la primera parte. Creacion de usuario o uso de datos ateriores
	function addMessageUser( json ) {
        UserMessages.html( '' );
        if ( json.success == true ){
            UserMessages.append(
                $( '<div />' ).addClass( 'alert alert-success alert-dismissible' ).append(
                    $( '<i />' ).addClass( 'fas fa-exclamation' ),
                    $( '<span />' ).text( json.data.message )
                )
            );
        }else{ 
            UserMessages.append(
                $( '<div />' ).addClass( 'alert alert-danger alert-dismissible' ).append(
                    $( '<i />' ).addClass( 'fas fa-exclamation-triangle' ),
                    $( '<span />' ).text( json.data.message )
                )
            );
        }
	}
	

    //Delay para no realizar multiples ajax
    var delay = (function(){ 
        var timer = 0; 
        return function(callback, ms){ 
        clearTimeout (timer); 
        timer = setTimeout(callback, ms); 
        }; 
    })(); 

    //Genero el ajax que trae los grupos de anomalias dependiendo del servicio
    SelectorServicio.change(  function( event ){
        var IDServicioSelected = SelectorServicio.val();

        $.post(
            wp_NewDenuncia.ajax,
            {
                id_servicio : IDServicioSelected,
                action      : 'wp_getgrupoanomalias',
            }
        ).done( function( json ) {
            console.log(json);

            //Borro
            SelectorGrupoAnomalias.empty();
            SelectorAnomalia.empty();
   
            //Inserto el vacio antes de las opciones
            SelectorGrupoAnomalias.fadeIn().append(function() {
                var article=`
                <option value="">--Seleccione uno--</option>`
                return article;
            });

            //Llega como .data; escribo las opciones
            var count = 0;
            json.data.forEach(function() {
                SelectorGrupoAnomalias.fadeIn().append(function() {
                    var article=`
                    <option value=" `+  json.data[count].ID + `"> `+  json.data[count].name + `</option>`
                    return article;
                    });
             count++;
            });
            
        }).fail( function() {
            console.log('failed');
            //addMessageUser( 'Error al procesar lo solicitado. Intente nuevamente o contacte con soporte.' );
       
        });
        
    })

    //Genero el ajax que trae los grupos de anomalias dependiendo del servicio
    SelectorGrupoAnomalias.change(  function( event ){
        var IDGrupoAnomaliasSelected = SelectorGrupoAnomalias.val();

        if ( IDGrupoAnomaliasSelected == 8 ){
            SelectorBarrido.show();
        }else{
            SelectorBarrido.hide();
        }
        
        $.post(
            wp_NewDenuncia.ajax,
            {
                id_grupoanomalias : IDGrupoAnomaliasSelected,
                action            : 'wp_getanomalias',
            }
        ).done( function( json ) {
            console.log(json);

            //Borro
            SelectorAnomalia.empty();

            //Inserto el vacio antes de las opciones
             SelectorAnomalia.fadeIn().append(function() {
                var article=`
                <option value="">--Seleccione uno--</option>`
                return article;
            });

            //Llega como .data; escribo las opciones
            var count = 0;
            json.data.forEach(function() {
                SelectorAnomalia.fadeIn().append(function() {
                    var article=`
                    <option value=" `+  json.data[count].ID + `"> `+  json.data[count].name + `</option>`
                    return article;
                    });
             count++;
            });
            
        }).fail( function() {
            console.log('failed');
            //addMessageUser( 'Error al procesar lo solicitado. Intente nuevamente o contacte con soporte.' );
       
        });
        
    })

    //Conexion API ciudad, validacion de datos, y toma de geo localizacion, barrio y comuna.
    SearcherDireccion.keyup( function(e){

        var SearcherDireccionValue = SearcherDireccion.val();

        if ( SearcherDireccionValue == '' ){
            UlSearcherDireccion.empty();
            return;
        }

        //Limpio duplicacion de espacios
        SearcherDireccionValue = SearcherDireccionValue.replace( '   ', ' ');
        SearcherDireccionValue = SearcherDireccionValue.replace( '  ', ' ');
        var ArrayDireccion = SearcherDireccionValue.split(' ');
        var Altura;
        var CountAltura;

        var count = 0;
        ArrayDireccion.forEach( function(){
            if ( parseInt( ArrayDireccion[count] ,10 )){
                Altura = ArrayDireccion[count];
                CountAltura = count;
            }else{
                Altura = '';
                CountAltura = '';
            }
            count++;
        }),

        SearcherDireccionValue='';
        count=0;
        ArrayDireccion.forEach( function(){
            if ( count != CountAltura ){
                SearcherDireccionValue = SearcherDireccionValue + ' ' + ArrayDireccion[count];
            }
            count++;
        });

     
        //Espero que termine de escribir antes de ejecutar
        delay( function(){ 

        $.ajax({
            type:      'GET',
            dataType:  'json',
            url:       'https://ws.usig.buenosaires.gob.ar/rest/normalizar_y_geocodificar_direcciones',
            data: { 
                'calle'       : SearcherDireccionValue,
                'altura'      : Altura,
                'desambiguar' : '1'
            },
            success: function(data){
            console.log(data);

            UlSearcherDireccion.empty();

                //Evaluo el retorno de la api y muestro el error correspondiente
                 if( data.Normalizacion.TipoResultado == 'ErrorInput' ){ 
                    UlSearcherDireccion.fadeIn().append( function() {
                        var article=`
                        <li id=''>
                        Error de entrada. Ingrese nombre y numeracion.
                        </li>`
                        return article;
                        });
                 return;
                 }

                //Evaluo el retorno de la api y muestro el error correspondiente
                if( data.Normalizacion.TipoResultado == 'ErrorCalleInexistente' ){ 
                    UlSearcherDireccion.fadeIn().append( function() {
                        var article=`
                        <li id=''>
                        Error. Calle inexistente.
                        </li>`
                        return article;
                        });
                return;
                }
                if( data.Normalizacion.TipoResultado == 'ErrorCalleInexistenteAEsaAltura' ){
                    UlSearcherDireccion.fadeIn().append( function() {
                        var article=`
                        <li id=''>
                        Error. Calle inexistente a esa altura
                        </li>`
                        return article;
                        });
                return;
                }   

                if( data.Normalizacion.TipoResultado == 'Ambiguedad' ){ 
                            //Llega como .data; escribo las opciones
                            var count = 0;
                            data.Normalizacion.DireccionesCalleAltura.direcciones.forEach(function() {
                                UlSearcherDireccion.fadeIn().append(function() {
                                        var article=`
                                        <li id='`+  data.Normalizacion.DireccionesCalleAltura.direcciones[count].Calle + ' ' + data.Normalizacion.DireccionesCalleAltura.direcciones[count].Altura + `'>
                                        `+  data.Normalizacion.DireccionesCalleAltura.direcciones[count].Calle + ' ' + data.Normalizacion.DireccionesCalleAltura.direcciones[count].Altura + `
                                        </li>`
                                        return article;
                                        });
                                    count++;
                                    if( count == 5 ){ return; }
                            });
                
                }

                if( data.Normalizacion.TipoResultado == 'DireccionNormalizada' ){ 

                        UlSearcherDireccion.fadeIn().append(function() {
                                var article=`
                                <li id='`+  data.Normalizacion.DireccionesCalleAltura.direcciones[0].Calle + ' ' + data.Normalizacion.DireccionesCalleAltura.direcciones[0].Altura + `'>
                                `+  data.Normalizacion.DireccionesCalleAltura.direcciones[0].Calle + ' ' + data.Normalizacion.DireccionesCalleAltura.direcciones[0].Altura + `
                                </li>`
                                return article;
                                });
                
                }

                 //Cuando se clickea un Li lo asigno al usuario.
                 $( '#searcherdireccion li' ).click( function(){

                    //Traigo id del elemento para conocer la anomalia
                    SearcherDireccionValue = $(this).attr("id");
                    console.log(SearcherDireccionValue);

                    //Borro y escribo busqueda
                    UlSearcherDireccion.empty();
                    SearcherDireccion.val( SearcherDireccionValue );

                                //Limpio duplicacion de espacios
                    SearcherDireccionValue = SearcherDireccionValue.replace( '   ', ' ');
                    SearcherDireccionValue = SearcherDireccionValue.replace( '  ', ' ');
                    var ArrayDireccion = SearcherDireccionValue.split(' ');
                    var Altura;
                    var CountAltura;

                    var count = 0;
                    ArrayDireccion.forEach( function(){
                        if ( parseInt( ArrayDireccion[count] ,10 )){
                            Altura = ArrayDireccion[count];
                            CountAltura = count;
                        }else{
                            Altura = '';
                            CountAltura = '';
                        }
                        count++;
                    }),

                    SearcherDireccionValue='';
                    count=0;
                    ArrayDireccion.forEach( function(){
                        if ( count != CountAltura ){
                            SearcherDireccionValue = SearcherDireccionValue + ' ' + ArrayDireccion[count];
                        }
                        count++;
                    });

                    $.ajax({
                        type:      'GET',
                        dataType:  'json',
                        url:       'https://ws.usig.buenosaires.gob.ar/rest/normalizar_y_geocodificar_direcciones',
                        data: { 
                            'calle'       : SearcherDireccionValue,
                            'altura'      : Altura,
                            'desambiguar' : '1'
                        },
                        success: function(data){
                        console.log(data);
            
                                     //Uno la direccion y manipulo para marcador de maps
                                     var direccioncompleta = data.Normalizacion.DireccionesCalleAltura.direcciones[0].Calle + ' ' + data.Normalizacion.DireccionesCalleAltura.direcciones[0].Altura;  
                                     var direccioncompletatransformada = direccioncompleta.replace(/\s/g, '+');
             
                                     //Muestro en mapa direccion
                                     var direccioncompletatransformadaembed =  'https://maps.google.com/maps?q=' + direccioncompletatransformada + '&output=embed'
                                     Map.attr("src",direccioncompletatransformadaembed);
             
                                     //Asigno nuevo valor a los inputs hidden del formulario de envio denuncia - geo localizacion
                                     GeoLat.val(data.GeoCodificacion.x);
                                     GeoLong.val(data.GeoCodificacion.y);

                                     lat = data.GeoCodificacion.x;
                                     long = data.GeoCodificacion.y;

                                     //Realizo la busqueda de comuna
                                     $.ajax({
                                     type:     'GET',
                                     dataType: 'json',
                                     url:      'https://ws.usig.buenosaires.gob.ar/datos_utiles',
                                     data: { 
                                         'x' : data.GeoCodificacion.x,
                                         'y' : data.GeoCodificacion.y
                                         },
                                     success: function(data){
             
                                         //Punto de control de data de entrada
                                         console.log(data);
             
                                         //Asigno nuevo valor a los inputs hidden barrio y comuna del formulario de envio de denuncia
                                         Comuna.val(data.comuna);
                                         Barrio.val(data.barrio);

                                         urlmap = 'https://servicios.usig.buenosaires.gov.ar/LocDir/mapa.phtml?x=' + lat + '&y=' + long + '&h=1000&w=1000&punto=1&r=250';
                                         $("#map").attr("src",urlmap);
             
                                     },
                                     fail: function(){
                                             //Falla de conexion a api
                                         console.log('Falla conexion con API CABA.');
                                     }
                                     });
                        
                        },
                        fail: function(){
                            //Falla de conexion a api
                            console.log('Falla conexion con API CABA.');
                        }
                    }).fail( function(){
                    //Falla de conexion a api
                    console.log('Falla conexion con API CABA.');
                    });
                    });
            },
            fail: function(){
                //Falla de conexion a api
                console.log('Falla conexion con API CABA.');
            }
        }).fail( function(){
        //Falla de conexion a api
        console.log('Falla conexion con API CABA.');
        });
    }, 500); 
    });


    //Creo una nueva denuncia.
    FormNewDenuncia.on( 'submit' , function( event ) {
        event.preventDefault();

        //Muestro loader
       $('form#formdenuncia .containerloader').show();
       $('.buttonmas').hide();
         
        $.post(
            wp_NewDenuncia.ajax,
            {
                user_id                 : user_id                .val(),
                SelectorProcedencia     : SelectorProcedencia    .val(),
                SelectorAnomalia        : SelectorAnomalia       .val(),
                SelectorBarrido         : SelectorBarrido        .val(),
                Direccion               : SearcherDireccion      .val(),
                GeoLat                  : GeoLat                 .val(),
                GeoLong                 : GeoLong                .val(),
                Barrio                  : Barrio                 .val(),
                Comuna                  : Comuna                 .val(),
                Observacion             : Observacion            .val(),
                action                  : 'wp_newdenuncia',
            }
        ).done( function( json ) {
            console.log(json);

             //Apago loader
            $('form#formdenuncia .containerloader').hide();
            $('.buttonmas').show();

            addMessageDenuncia( json );
            if ( json.success == true ){
                console.log( 'True' );
            }
        }).fail( function() {
            console.log('failed');
            //addError( 'Error al procesar lo solicitado. Intente nuevamente o contacte con soporte.' );
        });

    })


    //Notificaciones para la segunda parte, notif de denuncias
	function addMessageDenuncia( json ) {
        DenunciaMessages.html( '' );
        if ( json.success == true ){
            DenunciaMessages.append(
                $( '<div />' ).addClass( 'alert alert-success alert-dismissible' ).append(
                    $( '<i />' ).addClass( 'fas fa-exclamation' ),
                    $( '<span />' ).text( json.data.message )
                )
            );
        }else{ 
            DenunciaMessages.append(
                $( '<div />' ).addClass( 'alert alert-danger alert-dismissible' ).append(
                    $( '<i />' ).addClass( 'fas fa-exclamation-triangle' ),
                    $( '<span />' ).text( json.data.message )
                )
            );
        }
	}
    
    
})( jQuery, window );