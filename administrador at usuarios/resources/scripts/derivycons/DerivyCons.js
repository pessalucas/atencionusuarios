(function( $, window ){
	'use strict';

    //Del main
    const TableList     = $( '#tablelist' );
    const TbodyList     = $( '#tbodylist' );

    //Formulario de carga
    const FormCarga    = $( '#formcarga' );
    const FormTipo     = $( '#tipo' );
    const FormDerivado = $( '#derivado' );
    const FormObs      = $( '#obs' );
    
    var   count;
    var   fila_html;

    //Formulario de busqueda
    const FormSearchDyC = $( '#searchderivycons' );
    const FechaDesdeDyC = $( '#fechadesdedyc' );
    const FechaHastaDyC = $( '#fechahastadyc' );
    const TipoDyC       = $( '#tipodyc' );
    
    var  ButtonDelete = $( '.delete' )

    //Boton de borrado
    setInterval( function( ){
        ButtonDelete = $( '.delete' );

        ButtonDelete.click( function ( ){ 
            console.log( 'llego' );
            var $id_button = $(this).attr('id');
    
            $.post(
                wp_ListDerivyCons.ajax,
                {
                    action    : 'wp_deletederivycons',
                    id        : $id_button,
                }
            ).done( function( json ) {
    
                console.log(json);
                location.reload();
    
            }).fail( function( json ) {
                console.log('Failed');
             });
    
        });
    }, 2000);
   
    
        //Fila html
        //Defino la estrucutra html de una fila
        function FilaHtml( id , tipo , derivacion , observacion, rellamado , fecha ){
        
            var Fila = ` <tr>
                            <td>
                                `+  id +`
                            </td>
                            <td>
                                `+  tipo +`
                            </td>
                            <td>
                                `+  derivacion +`
                            </td>
                            <td>
                                `+  observacion +`
                            </td>
                            <td>
                                `+  fecha +`
                            </td>
                            <td>
                                <button class='deletehome' id='`+  id +`'><i class="fas fa-times"></i></button>
                            </td>
                    </tr>`
      
                    return Fila;
        }
    
    //Actualizacion inicial de la tabla
    function  listar_derivycons() {

        $.post(
            wp_ListDerivyCons.ajax,
            {
                action    : 'wp_listarderivycons',
                listar    : 'true',
            }
        ).done( function( json ) {

            console.log(json);

            count = 0;
            TbodyList.empty();
            json.data.forEach( function() {
                TbodyList.append( function() {
                    fila_html = FilaHtml( json.data[count].id , json.data[count].tipo , json.data[count].derivacion , json.data[count].observacion, json.data[count].rellamado , json.data[count].fecha )
                    return fila_html;
                });
                count++;
              });

        }).fail( function( json ) {
            console.log('Failed');
         });

    }

    listar_derivycons();
    
    //Creo un nuevo usuario.
    FormSearchDyC.on( 'submit' , function( event ) {
        event.preventDefault();

        $.post(
            wp_ListDerivyCons.ajax,
            {
                fechadesde  : FechaDesdeDyC.val(),
                fechahasta  : FechaHastaDyC.val(),
                tipo        : TipoDyC.val(),
                action      : 'wp_listarderivycons',
                listar      : 'false',
            }
        ).done( function( json ) {
            console.log(json);

            TbodyList.empty();

            count = 0;
            TbodyList.empty();
            json.data.forEach( function() {
                TbodyList.append( function() {
                    fila_html = FilaHtml( json.data[count].id , json.data[count].tipo , json.data[count].derivacion , json.data[count].observacion, json.data[count].rellamado , json.data[count].fecha )
                    return fila_html;
                });
                count++;
              });

        }).fail( function( json ) {
            console.log('Failed');
         });

    })



    //Creo un nuevo usuario.
    FormCarga.on( 'submit' , function( event ) {
        event.preventDefault();

        $.post(
            wp_ListDerivyCons.ajax,
            {
                tipo        : FormTipo.val(),
                derivado    : FormDerivado.val(),
                observacion : FormObs.val(),
                action      : 'wp_insertarderivycons',
            }
        ).done( function( json ) {
            console.log(json);

            location.reload();

        }).fail( function( json ) {
            console.log('Failed');
         });

    })
    

    
})( jQuery, window );