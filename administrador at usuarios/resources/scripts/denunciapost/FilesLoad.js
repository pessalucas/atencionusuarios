jQuery(document).ready(function($) {

    //Obtengo url nativa para definir las redirecciones
    var urlnative            = location.href;
    const FormLoadPublic     = $( '#loadpublic' );
    const FormLoadPrivate    = $( '#loadprivate' );
    const ButtonsDelete      = $( '.delete' );


    FormLoadPublic.on('submit', function(e){
        e.preventDefault();

        //Muestro loader
        $('form#loadpublic .containerloader').show();
        $('.buttonmas').hide();
         
        var form_data = new FormData(); 
        var files_data = $('form#loadpublic .files-data'); // The <input type="file" /> field
       
        // Loop through each data and create an array file[] containing our files data.
        $.each($(files_data), function(i, obj) {
            $.each(obj.files,function(j,file){
                form_data.append('files[' + j + ']', file);
            })
        });
       
        //AJAX con archivo asociado. Se crea el data{ } como un form_data para generar todos los campos de envio
        form_data.append('action',    'ajaxloadfiles');
        form_data.append('type',    $('form#loadpublic #public').val() );
        form_data.append('post_id',    $('form#loadpublic #post_id').val() );

        $.ajax({
            type:        'POST',
            dataType:    'json',
            url:         ajax_loadfiles_object.ajaxurl,
            data:        form_data,
            contentType: false,
            cache:       false,
            processData: false,
            
            success:     function( json ){
                console.log(json);
                location.reload();
            },
            fail: function( json ){

                 //console.log(json);
                 addMessage( json.data );
            }
        }).fail( function(){
                console.log( 'Ocurrio una falla en la conexion.' );
        });
     
    });

    FormLoadPrivate.on('submit', function(e){
        e.preventDefault();

       //Muestro loader
       $('form#loadprivate .containerloader').show();
       $('.buttonmas').hide();
        
        var form_data2 = new FormData(); 
        var files_data2 = $('form#loadprivate .files-data'); // The <input type="file" /> field
       
        // Loop through each data and create an array file[] containing our files data.
        $.each($(files_data2), function(i, obj) {
            $.each(obj.files,function(j,file){
                form_data2.append('files[' + j + ']', file);
            })
        });
       
        form_data2.append('action',    'ajaxloadfiles');
        form_data2.append('type',    $('form#loadprivate #private').val() );
        form_data2.append('post_id',    $('form#loadprivate #post_id').val() );

        $.ajax({
            type:        'POST',
            dataType:    'json',
            url:         ajax_loadfiles_object.ajaxurl,
            data:        form_data2,
            contentType: false,
            cache:       false,
            processData: false,
            
            success:     function( json ){
                console.log(json);
                location.reload();
            },
            fail: function( json ){

                 //console.log(json);
                 addMessage( json.data );
            }
        }).fail( function(){
                console.log( 'Ocurrio una falla en la conexion.' );
        });
     
    });

    ButtonsDelete.click( function (e){

        var id_attachment = $(this).data('id_attachment');

        $.ajax({
            type:      'POST',
            dataType:  'json',
            url:       ajax_loadfiles_object.ajaxurl,
            data: { 
                'action'            :  'ajaxdeleteattached', //calls wp_ajax_nopriv_ajaxcomment
                'id_attachment'     :  id_attachment,
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
    })


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