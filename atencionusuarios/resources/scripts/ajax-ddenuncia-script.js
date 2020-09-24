
jQuery(document).ready(function($) {

    //Oculto el segundo paso
    $('#infodenuncia').hide();
    $('#datosdenuncia').hide();

    //Evento para todos los p dentro toggles
    $('section.toggle p').click(function(e){

    //Traigo id del elemento para conocer la anomalia y servicio
    var idgrupoanomalia = $(this).attr("id");
    var servicio = $(this).data('servicio');

    //Obtengo texto del id
    var textanomalia= $(this).text();

    //Combino los textos
    var textservicioanomalia = servicio + '. ' + textanomalia + '.';

    //Perticion ajax para obtener los ids de anomalias asociados a ese tipo de anomalia
          $.ajax({
            type: 'GET',
            dataType: 'json',
            url: ajax_denuncia_object.ajaxurl,
            data: { 
                'action': 'ajaxgrupoanomalias', 
                'id_anomalia' : idgrupoanomalia/*, 
            'security': $('form#denuncia #security').val() */},

            success: function(data){
                  console.log(data.anomalias);

                count = 0;
                data.anomalias.forEach(function() {
                        $( '#anomalias' ).append(function() {
                                var article=`
                            <div class="col-lg-3" id = '`+  data.anomalias[count].id + `'>
                                <blockquote class="blockquote-primary">
                                  <p>`+  data.anomalias[count].name + `</p>
                                  <footer>`+  data.anomalias [count].description + `</footer>
                                </blockquote>
                            </div>
                            `;
                        return article;
                   });
                count++;
                });

                 //Evento para todos los p dentro toggles
                $('#anomalias div').click(function(e){
                  var idanomalia = $(this).attr("id");
                  var textanomalia= $(this).text();

                  //Asigno al formulario el id de anomalia
                  $('form#denuncia #anomalia').val(idanomalia);

                  //Borro los div y asigno al texto de arriba lo escogido.
                  $('#anomalias').remove();

                  textserviciogrupoanomalia = textservicioanomalia + '. ' + textanomalia + '.';
                  //Inserto el nuevo texto.
                  $('#selector').show().text(textserviciogrupoanomalia);                  
                });

            },
            fail: function(data){
              console.log('failed');
            }
        }).fail( function(data){
              console.log('failed');
        });
    

    //Ejecuto el cambio de pantalla para mostrar ahora otra informacion
        $('#denselector').hide();
        $('#denunciasearch').hide();
        $('#infodenuncia').show();
        $('#datosdenuncia').show();
        $('#selector').show().text(textservicioanomalia);

    });

    
   

    //Evento para volver a la pantalla de atras
    $('#back').click(function(e){
            //Ejecuto el cambio de pantalla para mostrar ahora otra informacion
            $('#denselector').show();
            $('#denunciasearch').show();
            $('#infodenuncia').hide();
            $('#datosdenuncia').hide();
            $('#anomalias').empty();
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
                      $('form#denuncia #geolat').val(data.GeoCodificacion.x);
                      $('form#denuncia #geolong').val(data.GeoCodificacion.y);

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