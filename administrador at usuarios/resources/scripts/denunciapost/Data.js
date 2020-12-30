
jQuery(document).ready( function($) {
    

    /*
    *   Cambio de estado selector
    */
    //Elementos y botones
    const SelectorEstado  = $('#estado' );
    const NuevoEstado     = SelectorEstado.val();
    const InputExpediente = $('#nroexpediente' );

    //Asigno el background correspondiente.
    AsignarColorSelectorEstado( NuevoEstado );


    SelectorEstado.change( function(e){
        e.preventDefault();

        const NuevoEstado    = SelectorEstado.val();
        const IdDenuncia     = SelectorEstado.data('id_denuncia');
        AsignarColorSelectorEstado( NuevoEstado );

        $.ajax({
            type:      'POST',
            dataType:  'json',
            url:       ajax_cambioestado_object.ajaxurl,
            data: { 
                'action'          :  'wp_cambioestado', //calls wp_ajax_nopriv_ajaxcomment
                'nuevoestado'     :  NuevoEstado,
                'id_denuncia'     :  IdDenuncia,
            },

            success: function(data){
                console.log(data);

            },
            fail: function(){
              console.log( 'Falla el ajax.' ); 
            }
             }).fail( function(){
                console.log( 'Falla el ajax.' ); 
            });
    });
    
    InputExpediente.change( function(e){
        e.preventDefault();

        const NroExpediente = InputExpediente.val();
        const IdDenuncia    = InputExpediente.data('id_denuncia');

        $.ajax({
            type:      'POST',
            dataType:  'json',
            url:       ajax_cambioestado_object.ajaxurl,
            data: { 
                'action'          :  'wp_cambioexpediente', //calls wp_ajax_nopriv_ajaxcomment
                'expediente'      :  NroExpediente,
                'id_denuncia'     :  IdDenuncia,
            },

            success: function(data){
                console.log(data);

            },
            fail: function(){
              console.log( 'Falla el ajax.' ); 
            }
             }).fail( function(){
                console.log( 'Falla el ajax.' ); 
            });
    });
    
    function AsignarColorSelectorEstado( NuevoEstado ){
        //Asigno el background correspondiente.
        if( NuevoEstado == 451 ){
            SelectorEstado.css("background-color", "#DC143C");
        }else if( NuevoEstado == 52 ){
            SelectorEstado.css("background-color", "#8B0000");
        }else if(( NuevoEstado == 43 )||( NuevoEstado == 49 )||( NuevoEstado == 48 )){
            SelectorEstado.css("background-color", "#FFD700");
        }else if(( NuevoEstado == 45 )||( NuevoEstado == 46 )){
            SelectorEstado.css("background-color", "#FF8C00");
        }else if(( NuevoEstado == 44 )||( NuevoEstado == 453 )){
            SelectorEstado.css("background-color", "#FF7F50");
        }else if(( NuevoEstado == 47 )||( NuevoEstado == 51 )||( NuevoEstado == 50 )){
            SelectorEstado.css("background-color", "#006400");
        }else{
            SelectorEstado.css("background-color", "grey");
        }
    }


    
});