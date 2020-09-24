jQuery(document).ready(function($) {



    $('form#denuncia').on('submit', function(e){
        e.preventDefault();
        $('form#denuncia p.status').show().text(ajax_denuncia_object.loadingmessage);
         
        //AJAX con archivo asociado. Se crea el data{ } como un form_data para generar todos los campos de envio
        var file_data = $('form#denuncia #file')[0].files[0];
        var form_data = new FormData();                  
        form_data.append('file',         file_data);
        form_data.append('action',      'ajaxdenuncia');
        form_data.append('direccion', $('form#denuncia #direccion').val() );
        form_data.append('anomalia',  $('form#denuncia #anomalia').val() );
        form_data.append('geolat',    $('form#denuncia #geolat').val() );
        form_data.append('geolong',   $('form#denuncia #geolong').val() );
        form_data.append('comuna',    $('form#denuncia #comuna').val() );
        form_data.append('barrio',    $('form#denuncia #barrio').val() );
        form_data.append('obs',       $('form#denuncia #obs').val() );

        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: ajax_denuncia_object.ajaxurl,
            data: form_data,
            contentType: false,
            cache: false,
            processData:false,
            success: function(data){
                $('form#denuncia p.status').text(data.message);
                
            },
            fail: function(data){
                $('form#denuncia p.status').text(data.message);
            }
        }).fail( function(data){
            $('form#denuncia p.status').text(data.message);
        });
     
    });

});