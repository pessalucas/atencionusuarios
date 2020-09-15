jQuery(document).ready(function($) {



    $('form#denuncia').on('submit', function(e){
        e.preventDefault();
        
		
        $('form#denuncia p.status').show().text(ajax_denuncia_object.loadingmessage);
        $.ajax({
            xhr: function()
            {
              var xhr = new window.XMLHttpRequest();
              //Upload progress
              xhr.upload.addEventListener("progress", function(evt){
                if (evt.lengthComputable) {
                  var percentComplete = evt.loaded / evt.total;
                  //Do something with upload progress
                  console.log(percentComplete);
                }
              }, false);
              //Download progress
              xhr.addEventListener("progress", function(evt){
                if (evt.lengthComputable) {
                  var percentComplete = evt.loaded / evt.total;
                  //Do something with download progress
                  console.log(percentComplete);
                }
              }, false);
              return xhr;
            },
            type: 'POST',
            dataType: 'json',
            url: ajax_denuncia_object.ajaxurl,
            data: { 
                'action'   : 'ajaxdenuncia', //calls wp_ajax_nopriv_ajaxdenuncia
                'direccion': $('form#denuncia #direccion').val(), 
                'anomalia' : $('form#denuncia #anomalia').val(),
                'geo-x'    : $('form#denuncia #geo-x').val(),
                'geo-y'    : $('form#denuncia #geo-y').val(),
                'comuna'   : $('form#denuncia #comuna').val(),
                'barrio'   : $('form#denuncia #barrio').val(),
                'obs'      : $('form#denuncia #obs').val()
                /*, 
            'security': $('form#denuncia #security').val() */},
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