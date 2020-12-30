        

        //Funcion para exportar excel 
        document.getElementById('submitExport').addEventListener('click', function(e) {
			e.preventDefault();
			let export_to_excel = document.getElementById('export_to_excel');
			let data_to_send = document.getElementById('data_to_send');
			data_to_send.value = export_to_excel.outerHTML;
			document.getElementById('formExport').submit();
        });
        
(function( $, window ){
	'use strict';

	//Defino las variables y constantes a utilizar
	var    urlnative           = location.href;
    const  FormSearcher        = $( '#formsearch' );
    const  FormSearcherButton  = $( '#formsearch button' );
    const  FormNextPage        = $( '#nextpage' );
    const  ButtonProxPage      = $( '#proxpage' );
    const  ButtonPrePage       = $( '#prepage' );
    const  ButtonsMas          = $( '.buttonmaspage' );
    const  FormPrePage         = $( '#prepage' );
    const  ListadoDenuncias    = $( '#listado-denuncias' );
    const  PostsCantidad       = $( '.postscantidad' );

    var    count;
    var    fila_html;
    var    empresa;
    var    iddenuncia;
    var    Estado_2;
    var    $varexport;
    var    SelectorEstado;
    var    BorderStyle;

    //Defino la estrucutra html de una fila
    function FilaHtml( NroDenuncia , Servicio , Empresa , GrupoAnomalia, Anomalia , Direccion , Barrio , Comuna , Observaciones , Fecha, Hora , Estado1 , Estado2 ){
        if ( Empresa ){
            BorderStyle = 'border-top: 1px solid grey;';
        }else{
            BorderStyle ='';
        }
        if ( Estado2 ){ 
            SelectorEstado = AsignarColorEstado( Estado2 );
        var Fila = ` <tr>
                        <td>
                        `+  NroDenuncia +`
                        </td>
                        <td>
                        `+  Servicio +`
                        <p style='`+  BorderStyle +` color: #212529; font-size: 12px;'>
                        `+  Empresa +`
                        </p>
                      
                        </td>

                        <td>
                        `+  GrupoAnomalia +`<br>
                        `+  Anomalia +`
                        </td>
                        <td>
                        `+  Direccion +`<br>
                        `+  Barrio +`<br>
                        `+  Comuna +`
                        </td>
                        <td>
                        `+  Observaciones +`
                        </td>
                        <td style='min-width: 96px;'>
                        `+  Fecha +`<br>
                        `+  Hora  +`
                        </td>
                        <td>
                            <p style='text-align: center;  padding: 2px;  color: white; background-color: `+  SelectorEstado +`'>
                            `+  Estado1 +`<br>
                            -`+ Estado2 +`
                            </p>
                        </td>
                        <td>
                            <form action="http://localhost/atencionusuarios/administrador/denunciapost" method='GET'>
                                <input type="hidden" value='`+  NroDenuncia +`' name='id'>
                                <input type="hidden" value='data' name='type'>
                                <button type='submit' class='buttonmas' style='margin: 3px;' ><i class="icon-featured fas fa-user" style='font-size:10px; width:20px; height:auto; margin:5px;'></i></button>
                            </form>
                            <form action="http://localhost/atencionusuarios/administrador/denunciapost" method='GET'>
                                <input type="hidden" value='`+  NroDenuncia +`' name='id'>
                                <input type="hidden" value='file' name='type'>
                                <button type='submit' class='buttonmas'style='margin: 3px;'><i class="icon-featured fas fa-file"  style='font-size:10px; width:20px; height:auto; margin:5px;'></i></button>
                            </form>
                            <form action="http://localhost/atencionusuarios/administrador/denunciapost" method='GET'>
                                <input type="hidden" value='`+  NroDenuncia +`' name='id'>
                                <input type="hidden" value='comment' name='type'>
                                <button type='submit' class='buttonmas'  style='margin: 3px;'><i class="icon-featured fas fa-adjust" style='font-size:10px; width:20px; height:auto; margin:5px;'></i></button>
							</form>
                        </td>
                </tr>`
        }else{ 
            SelectorEstado = AsignarColorEstado( Estado1 );
var Fila = ` <tr>
                <td>
                `+  NroDenuncia +`
                </td>
                <td>
                `+  Servicio +`
                <p style='`+  BorderStyle +` color: #212529; font-size: 12px;' >
                `+  Empresa +`
                </p>
                </td>
                <td>
                `+  GrupoAnomalia +`<br>
                `+  Anomalia +`
                </td>
                <td>
                `+  Direccion +`<br>
                `+  Barrio +`<br>
                `+  Comuna +`
                </td>
                <td>
                `+  Observaciones +`
                </td>
                <td>
                `+  Fecha +`<br>
                `+  Hora  +`
                </td>
                <td>
                <p style='text-align: center; color: white; padding: 2px; background-color: `+  SelectorEstado +`'>
                `+  Estado1 +`
                </p>
                </td>
                <td>
                    <form action="http://localhost/atencionusuarios/administrador/denunciapost" method='GET'>
                        <input type="hidden" value='`+  NroDenuncia +`' name='id'>
                        <input type="hidden" value='data' name='type'>
                        <button type='submit' class='buttonmas' style='margin: 3px;' ><i class="icon-featured fas fa-user" style='font-size:10px; width:20px; height:auto; margin:5px;'></i></button>
                    </form>
                    <form action="http://localhost/atencionusuarios/administrador/denunciapost" method='GET'>
                        <input type="hidden" value='`+  NroDenuncia +`' name='id'>
                        <input type="hidden" value='file' name='type'>
                        <button type='submit' class='buttonmas'style='margin: 3px;'><i class="icon-featured fas fa-file"  style='font-size:10px; width:20px; height:auto; margin:5px;'></i></button>
                    </form>
                    <form action="http://localhost/atencionusuarios/administrador/denunciapost" method='GET'>
                        <input type="hidden" value='`+  NroDenuncia +`' name='id'>
                        <input type="hidden" value='comment' name='type'>
                        <button type='submit' class='buttonmas'  style='margin: 3px;'><i class="icon-featured fas fa-adjust" style='font-size:10px; width:20px; height:auto; margin:5px;'></i></button>
                    </form>
                </td>
        </tr>`
    }
                return Fila;
    }
    


        FormSearcherButton.click(function(e){
            $(this).addClass("e-clicked");
        });
        
    //Defino una funcion ajax que crea la primer vision o carga inicial de denuncias.
    FormSearcher.on('submit', function(event){
        event.preventDefault();

        PostsCantidad.html('');

		if ( FormSearcher.find( '.is-invalid' ).length > 0 ) {
			return;
        }
        var ElementoSeleccionado         = $( this ).find(".e-clicked");
        var CantidadElementoSeleccionado = ElementoSeleccionado.find( '.postscantidad' )
        var estadodenuncia               = $( this ).find(".e-clicked").attr("id");

		const $nrodenuncia       = FormSearcher.find( '[name="nrodenuncia"]' );
        const $fechadesde        = FormSearcher.find( '[name="fechadesde"]' );
        const $fechahasta        = FormSearcher.find( '[name="fechahasta"]' );
        const $barrios           = FormSearcher.find( '[name="barrios"]' );
        const $comuna            = FormSearcher.find( '[name="comuna"]' );
        const $servicio          = FormSearcher.find( '[name="servicio"]' );
        const $procedencia       = FormSearcher.find( '[name="procedencia"]' );
        const $calle             = FormSearcher.find( '[name="calle"]' );
        const $email             = FormSearcher.find( '[name="email"]' );
        const $export            = FormSearcher.find( '[name="export"]' );       
        const $estado            = estadodenuncia;

        if( $export .is(':checked') ) {  
            $varexport = 'export';
        }else{
            $varexport = '';
        }
                //Defino los parametros para la proxima pagina
        FormNextPage.find( '[name="nrodenuncia"]' )  .val( $nrodenuncia  .val() );
        FormNextPage.find( '[name="fechadesde"]' )   .val( $fechadesde   .val() );
        FormNextPage.find( '[name="fechahasta"]' )   .val( $fechahasta   .val() );
        FormNextPage.find( '[name="barrios"]' )      .val( $barrios      .val() );
        FormNextPage.find( '[name="comuna"]' )       .val( $comuna       .val() );
        FormNextPage.find( '[name="servicio"]' )     .val( $servicio     .val() );
        FormNextPage.find( '[name="procedencia"]' )  .val( $procedencia  .val() );
        FormNextPage.find( '[name="calle"]' )        .val( $calle        .val() );
        FormNextPage.find( '[name="email"]' )        .val( $email        .val() );
        FormNextPage.find( '[name="estado"]' )       .val( $estado );
        FormNextPage.find( '[name="pagina"]' )       .val( '2' );

        

            //Borro la clase que permite agregar tipo de estado
        $( this )   .find("button[type=\"submit\"]") .removeClass("e-clicked");

		$.post(
			wp_searchermain.ajax,
			{
				nrodenuncia : $nrodenuncia .val(),
                servicio    : $servicio    .val(),
                fechadesde  : $fechadesde  .val(),
                fechahasta  : $fechahasta  .val(),
                barrios     : $barrios     .val(),
                comuna      : $comuna      .val(),
                procedencia : $procedencia .val(),
                calle       : $calle       .val(),
                email       : $email       .val(),
                export      : $varexport,
                estado      : $estado,
                pagina      : '1',
				nonce:        wp_searchermain.nonce,
				action:      'wp_searchermain',
			}
		).done( function( json ) {

            console.log( json );
            
            if ( json.data.data ) { 
            var CantidadSpan = ' (' + json.data.nroposts + ')';
            CantidadElementoSeleccionado.html( CantidadSpan );
            count = 0;
            ListadoDenuncias.empty();
            json.data.data.forEach( function() {
                console.log(json);
                ListadoDenuncias.append( function() {
                  
                    if ( json.data.data[count].data_empresa ){ 
                        empresa = json.data.data[count].data_empresa[0].name
                    }else{ empresa = ''; }
                    if ( json.data.data[count].data_estado[1] ){ 
                        Estado_2 = json.data.data[count].data_estado[1].name
                    }else{ Estado_2 = false; }
                    fila_html = FilaHtml( json.data.data[count].id, json.data.data[count].data_servicios.name , empresa , json.data.data[count].data_grupoanomalia.name , json.data.data[count].data_anomalia.name , json.data.data[count].direccion , json.data.data[count].barrio , json.data.data[count].data_comuna[0].name ,  json.data.data[count].obs , json.data.data[count].fecha, json.data.data[count].hora , json.data.data[count].data_estado[0].name, Estado_2  )
                    return fila_html;
                });
                count++;
              });

            }else{
                count = 0;
                ListadoDenuncias.empty();
                ListadoDenuncias.append( function() {
                fila_html = FilaHtml( json.data[count].id, json.data[count].data_servicios.name , empresa , json.data[count].data_grupoanomalia.name , json.data[count].data_anomalia.name , json.data[count].direccion , json.data[count].barrio , json.data[count].data_comuna[0].name ,  json.data[count].obs , json.data[count].fecha, json.data[count].hora , json.data[count].data_estado[0].name, Estado_2  );
                return fila_html;
                });
            }

		}).fail( function() {
            console.log( 'Error al procesar lo solicitado' );
            return
			addError( 'Error al procesar lo solicitado. Intente nuevamente o contacte con soporte.' );
		});
	}),

    //Asigno el valor de la proxima pagina, sea la proxima o la anterior
    ButtonsMas.click(function(e){

        var ButtonMasSelected        = $( this ).attr("id");
        var PaginaActual             = $('#pagina');
        var PaginaActualNumber       = parseInt(PaginaActual.val(), 10);
        if( ButtonMasSelected == 'proxpage'){ 
        var PaginaProxima = PaginaActualNumber + 1;
            PaginaActual.val(PaginaProxima);
            console.log(PaginaProxima);
        }else{
        var PaginaProxima = PaginaActualNumber - 1;
            if ( PaginaProxima == 0 ){ PaginaProxima = 1;}
            PaginaActual.val(PaginaProxima);
            console.log(PaginaProxima);
        }

    });
    
       


    //Defino una funcion ajax que crea la primer vision o carga inicial de denuncias.
    FormNextPage.on('submit', function(event){
        event.preventDefault();

		const $nrodenuncia       = FormNextPage.find( '[name="nrodenuncia"]' );
        const $fechadesde        = FormNextPage.find( '[name="fechadesde"]' );
        const $fechahasta        = FormNextPage.find( '[name="fechahasta"]' );
        const $barrios           = FormNextPage.find( '[name="barrios"]' );
        const $comuna            = FormNextPage.find( '[name="comuna"]' );
        const $servicio          = FormNextPage.find( '[name="servicio"]' );
        const $procedencia       = FormNextPage.find( '[name="procedencia"]' );
        const $calle             = FormNextPage.find( '[name="calle"]' );
        const $email             = FormNextPage.find( '[name="email"]' );
        const $estado            = FormNextPage.find( '[name="estado"]' );
        const $pagina            = FormNextPage.find( '[name="pagina"]' );
        var   $numberpage        = parseInt($pagina.val(), 10);


                //Defino los parametros para la proxima pagina
        FormNextPage.find( '[name="nrodenuncia"]' )  .val( $nrodenuncia  .val() );
        FormNextPage.find( '[name="fechadesde"]' )   .val( $fechadesde   .val() );
        FormNextPage.find( '[name="fechahasta"]' )   .val( $fechahasta   .val() );
        FormNextPage.find( '[name="barrios"]' )      .val( $barrios      .val() );
        FormNextPage.find( '[name="comuna"]' )       .val( $comuna       .val() );
        FormNextPage.find( '[name="servicio"]' )     .val( $servicio     .val() );
        FormNextPage.find( '[name="procedencia"]' )  .val( $procedencia  .val() );
        FormNextPage.find( '[name="calle"]' )        .val( $calle        .val() );
        FormNextPage.find( '[name="email"]' )        .val( $email        .val() );
        FormNextPage.find( '[name="estado"]' )       .val( $estado        .val() );
        FormNextPage.find( '[name="pagina"]' )       .val( $numberpage ); //Proxima pagina

		$.post(
			wp_searchermain.ajax,
			{
				nrodenuncia : $nrodenuncia.val(),
                servicio    : $servicio   .val(),
                fechadesde  : $fechadesde .val(),
                fechahasta  : $fechahasta .val(),
                barrios     : $barrios    .val(),
                comuna      : $comuna     .val(),
                procedencia : $procedencia.val(),
                calle       : $calle      .val(),
                email       : $email      .val(),
                estado      : $estado     .val(),
                pagina      : $pagina     .val(),
				nonce:        wp_searchermain.nonce,
				action:      'wp_searchermain',
			}
		).done( function( json ) {

			//console.log( json);
      
            count = 0;
            ListadoDenuncias.empty();
            json.data.data.forEach( function() {
               
                console.log(json);
                ListadoDenuncias.append( function() {
                  
                    if ( json.data.data[count].data_empresa ){ 
                        empresa = json.data.data[count].data_empresa[0].name
                    }else{ empresa = ''; }
                    if ( json.data.data[count].data_estado[1] ){ 
                        Estado_2 = json.data.data[count].data_estado[1].name
                    }else{ Estado_2 = false; }
                    fila_html = FilaHtml( json.data.data[count].id, json.data.data[count].data_servicios.name , empresa , json.data.data[count].data_grupoanomalia.name , json.data.data[count].data_anomalia.name , json.data.data[count].direccion , json.data.data[count].barrio , json.data.data[count].data_comuna[0].name ,  json.data.data[count].obs , json.data.data[count].fecha , json.data.data[count].hora , json.data.data[count].data_estado[0].name, Estado_2 )
                    return fila_html;
                });
                count++;
              });

		}).fail( function() {
            console.log( 'Error al procesar lo solicitado' );
            return
			addError( 'Error al procesar lo solicitado. Intente nuevamente o contacte con soporte.' );
		});
	}),


	function addError( message ) {
		$formErrors.html( '' );
		$formErrors.append(
			$( '<div />' ).addClass( 'alert alert-danger alert-dismissible' ).append(
				$( '<i />' ).addClass( 'fas fa-exclamation-triangle' ),
				$( '<span />' ).text( message )
			)
		);
	}
    


    function AsignarColorEstado( NuevoEstado ){
        var SelectorEstado;
        //Asigno el background correspondiente.
        if( NuevoEstado == 'Pre-Abierto' ){
            SelectorEstado = "#DC143C";
        }else if( NuevoEstado == 'Abierto' ){
            SelectorEstado = "#8B0000";
        }else if(( NuevoEstado == 'Cerrado' )||( NuevoEstado == 'Pendiente' )||( NuevoEstado == 'Resuelto' )){
            SelectorEstado = "#FFD700";
        }else if(( NuevoEstado == 'Fiscalización 1era' )||( NuevoEstado == 'Fiscalización Nro' )){
            SelectorEstado = "#FF8C00";
        }else if(( NuevoEstado == 'Programado 1era' )||( NuevoEstado == 'Programado Nro' )){
            SelectorEstado = "#FF7F50";
        }else if(( NuevoEstado == 'Sumario' )||( NuevoEstado == 'Generado' )||( NuevoEstado == 'Pendiente' )){
            SelectorEstado = "#006400";
        }else{
            SelectorEstado = "grey";
        }
        return SelectorEstado;
    }



})( jQuery, window );