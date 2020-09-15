
jQuery(document).ready(function($) {

    //Oculto el segundo paso
    $('#infodenuncia').hide();
    $('#datosdenuncia').hide();

    //Evengo para todos los p dentro toggles
    $('section.toggle p').click(function(e){

    //Traigo id del elemento para conocer la anomalia
    var idanomalia = $(this).attr("id");
    
    //Obtengo texto del id
    var textanomalia= $(this).text();

    //La asigno al formulario de envio de denuncia
    $('form#denuncia #anomalia').val(idanomalia);


    //Ejecuto el cambio de pantalla para mostrar ahora otra informacion
        $('#denselector').hide();
        $('#denuncias').hide();
        $('#infodenuncia').show();
        $('#datosdenuncia').show();
        $('#selector').show().text(textanomalia);
    });

    $('#back').click(function(e){
            //Ejecuto el cambio de pantalla para mostrar ahora otra informacion
            $('#denselector').show();
            $('#denuncias').show();
            $('#infodenuncia').hide();
            $('#datosdenuncia').hide();
    });


    //Ajax de direccion normalizador
    $('form#ddenuncia').on('submit', function(e){
      e.preventDefault();
      $('form#ddenuncia p.status').show().text(ajax_ddenuncia_object.loadingmessage);
      $.ajax({
          type: 'GET',
          dataType: 'json',
          url: ajax_ddenuncia_object.ajaxurl + 'rest/normalizar_y_geocodificar_direcciones',
          data: { 
              //'action': 'ajaxddenuncia', 
              'calle' : $('form#ddenuncia #direccion').val(),
              'altura' : $('form#ddenuncia #altura').val(),
              'desambiguar' : '1'/*, 
          'security': $('form#denuncia #security').val() */},

          success: function(data){

            //Punto de control de data de entrada
            console.log(data);

              if(data.Normalizacion.TipoResultado == 'ErrorCalleInexistente'){ 
                $('form#ddenuncia p.status').show().text('Calle inexistente o mal escrita');
                //borro direccion en formulario de envio de denuncia
                $('form#denuncia #direccion').val('');
                return;
             }
              if(data.Normalizacion.TipoResultado == 'ErrorCalleInexistenteAEsaAltura'){
                $('form#ddenuncia p.status').show().text('No existe a esa altura la calle indicada');
                //borro direccion en formulario de envio de denuncia
                $('form#denuncia #direccion').val('');
                return;
            }
              if(data.Normalizacion.TipoResultado == 'Ambiguedad'){ 
                $('form#ddenuncia p.status').show().text('Ambiguedad, sea mas especifico');
                //borro direccion en formulario de envio de denuncia
                $('form#denuncia #direccion').val('');
                return;
            }
                    //Asigno nuevo valor a los inputs de direccion
                    $('form#ddenuncia #direccion').val(data.Normalizacion.DireccionesCalleAltura.direcciones[0].Calle); 
                    $('form#ddenuncia #altura').val(data.Normalizacion.DireccionesCalleAltura.direcciones[0].Altura);

                      //Uno direccion y manipulo para marcador de maps
                      var direccioncompleta = data.Normalizacion.DireccionesCalleAltura.direcciones[0].Calle + ' ' + data.Normalizacion.DireccionesCalleAltura.direcciones[0].Altura;  
                      var direccioncompletatransformada = direccioncompleta.replace(/\s/g, '+');

                      //console.log(direccioncompletatransformada);

                      //Muestro en mapa direccion
                      var direccioncompletatransformadaembed =  'https://maps.google.com/maps?q=' + direccioncompletatransformada + '&output=embed'
                      $("#mapembed").attr("src",direccioncompletatransformadaembed);


                      //Inserto geo localizacion en formulario de envio de denuncia
                      $('form#denuncia #geo-x').val(data.GeoCodificacion.x);
                      $('form#denuncia #geo-y').val(data.GeoCodificacion.y);

                      //Inserto direccion en formulario de envio de denuncia
                      $('form#denuncia #direccion').val(direccioncompleta);

                      //Borro loading message
                      $('form#ddenuncia p.status').show().text('');

                      //Realizo la busqueda de comuna
                      $.ajax({
                        type: 'GET',
                        dataType: 'json',
                        url: ajax_ddenuncia_object.ajaxurl + 'datos_utiles',
                        data: { 
                            //'action': 'ajaxddenuncia', 
                            'x' : data.GeoCodificacion.x,
                            'y' : data.GeoCodificacion.y
                            /*, 
                        'security': $('form#denuncia #security').val() */},
                        success: function(data){

                          //Punto de control de data de entrada
                          console.log(data);

                          //Inserto comuna y barrio en formulario de envio de denuncia
                          $('form#denuncia #comuna').val(data.comuna);
                          $('form#denuncia #barrio').val(data.barrio);
                        },
                        fail: function(data){
                          //Error de calle inexistente
                          $('form#ddenuncia p.status').show().text('Falla conexion.');
                        }

                        });

                      
          },
          fail: function(data){
              //Error de calle inexistente
              $('form#ddenuncia p.status').show().text('Calle inexistente o mal escrita.');
          }
      }).fail( function(data){
        //Falla de conexion a api
      });
     
  });


});