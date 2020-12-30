
jQuery(document).ready(function($) {

    /*
    * Creo las constantes con los bloques y elemenots a utilizar
    */

    //Hace referencia al bloque que indica la direccion y mapa de la denuncia
    const DireccionDenuncia  = $( '#direcciondenuncia' );
    // Datos generales, Direccion y Observacion (Hace referencia a la segunda pantalla principal)
    const DatosDenuncia  = $( '#datosdenuncia' );
    //El texto principal que se modifica al indicar la anomalia seleccionada
    const TextoAnomaliaSeleccionada  = $( '#selector' );
    //Main de tipos de servicios y sus diversos grupos de anomalias (Hace referencia a la primer pantalla principal)
    const DenunciaSelector  = $( '#denselector' );
    //Anomalias asociadas al grupo de anomalias seleccionado en la pantalla principal
    const Anomalias  = $( '#anomalias' );
    //Cartel que indica que tenes que escoger a una anomalia en pantalla secundaria
    const DescSelector  = $( '#description-selector' );
    //Boton Back para volver de la pantalla secundaria a la primaria
    const Back  = $( '#back' );
    //Boton Back para volver de la pantalla secundaria a la primaria
    const Map  = $( '#mapembed' );
    //Scroll Animate Aux
    const ScrollAnimate  = $( '#scrollanimate' );
    //Selector barridos
    const VeredasDir  = $( '#veredasdir' );
     //Dato de envio de info
     const VeredaData  = $( '#vereda' );
    //Searcher direccion
    const SearcherDireccion = $( '#direccion' );
    //Selector direccion
    const UlSearcherDireccion = $( '#searcherdireccion' );
    //url variable del map
    var   urlmap
    //Latitudes y longiutes variables.
    var   lat
    var   long

    //Oculto el segundo paso
    DireccionDenuncia.hide();
    DatosDenuncia.hide();
    VeredasDir.hide();

    //Evento para todos los p dentro toggles
    $('section.toggle p').click(function(e){


      //Acomodo al top la segunda seccion
        $([document.documentElement, document.body]).animate({
            scrollTop: ScrollAnimate.offset().top-30
        }, 1000);
    

    //Traigo id del elemento para conocer la anomalia y servicio
    var idgrupoanomalia = $(this).attr("id");
    var servicio        = $(this).data('servicio');

    //Muestro el selector si se trata de un barrido
    if ( idgrupoanomalia == 8 ){
      VeredasDir.show();
    }

    //Obtengo texto del id
    var textanomalia    = $(this).text();

    //Combino los textos
    var textservicioanomalia = servicio + ' <i class="fas fa-arrow-right"></i> ' + textanomalia;

    //Perticion ajax para obtener los ids de anomalias asociados a ese tipo de anomalia
          $.ajax({
            type:     'GET',
            dataType: 'json',
            url:       ajax_denuncia_object.ajaxurl,
            data: { 
                'action'      :  'ajaxgrupoanomalias', 
                'id_anomalia' :  idgrupoanomalia
              },

            success: function(json){
                  console.log(json);

                count = 0;
                json.data.anomalias.forEach(function() {
                          Anomalias.append(function() {
                                var article=`
                            <div class="col-lg-3" id = '`+  json.data.anomalias[count].id + `'>
                                <blockquote class="blockquote-primary">
                                  <p>`+  json.data.anomalias[count].name + `</p>
                                  <footer>`+  json.data.anomalias [count].description + `</footer>
                                </blockquote>
                            </div>
                            `;
                        return article;
                   });
                count++;
                });

                 //Evento para todos los p dentro Anomalias
                $('#anomalias div').click(function(e){
                  var idanomalia   = $(this).attr("id");
                  var textanomalia = $(this).text();

                  //Asigno al formulario de envio de denuncia el id de anomalia en un campo oculto
                  $('form#denuncia #anomalia').val(idanomalia);

                  //Borro los div y asigno al texto de arriba lo escogido.
                  Anomalias.empty();

                  textserviciogrupoanomalia = textservicioanomalia + ' <i class="fas fa-arrow-right"></i> ' + textanomalia ;
                  
                  //Elimino lo que posee el selector
                  TextoAnomaliaSeleccionada.empty();

                  //Oculto el parrafo
                  DescSelector.hide();

                  //Inserto el nuevo texto.
                  TextoAnomaliaSeleccionada.show().append(textserviciogrupoanomalia);                  
                });

            },
            fail: function(data){
                  //Falla de conexion a api
                  console.log('Falla conexion.');
            }
        }).fail( function(data){
              //Falla de conexion a api
              console.log('Falla conexion.');
        });
    

    //Ejecuto el cambio de pantalla para mostrar ahora otra informacion
        DenunciaSelector.hide();
        DireccionDenuncia.show();
        DatosDenuncia.show();
        TextoAnomaliaSeleccionada.show().append(textservicioanomalia);

    });

    //Evento para volver a la pantalla de atras
    Back.click(function(e){
            //Ejecuto el cambio de pantalla para mostrar ahora otra informacion
            DenunciaSelector.show();
            DireccionDenuncia.hide();
            DatosDenuncia.hide();
            Anomalias.empty();
            TextoAnomaliaSeleccionada.empty();

        //Acomodo al top la segunda seccion
        $([document.documentElement, document.body]).animate({
          scrollTop: ScrollAnimate.offset().top-90
      }, 1000);
  
    });


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
                                   $('form#denuncia #geolat') .val(data.GeoCodificacion.x);
                                   $('form#denuncia #geolong').val(data.GeoCodificacion.y);

                                   //Asigno nuevo valor a los inputs hidden direccion del formulario de envio de denuncia
                                  $('form#denuncia #direccion').val(direccioncompleta);

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
                                       $('form#denuncia #comuna').val(data.comuna);
                                       $('form#denuncia #barrio').val(data.barrio);
           
                                       urlmap = 'https://servicios.usig.buenosaires.gov.ar/LocDir/mapa.phtml?x=' + lat + '&y=' + long + '&h=400&w=1000&punto=1&r=250';
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


 
  VeredasDir.change( function(e){
    var VeredasDirValue = VeredasDir.val();
    VeredaData.val( VeredasDirValue );
  })
  //Delay para no realizar multiples ajax
  var delay = (function(){ 
    var timer = 0; 
    return function(callback, ms){ 
    clearTimeout (timer); 
    timer = setTimeout(callback, ms); 
    }; 
})(); 


});









