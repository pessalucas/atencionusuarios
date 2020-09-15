
jQuery(document).ready(function($) {


    $('form#register').on('submit', function(e){
        e.preventDefault();
        $('form#register p.status').show().text(ajax_register_object.loadingmessage);
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: ajax_register_object.ajaxurl,
            data: { 
                'action': 'ajaxregister', //calls wp_ajax_nopriv_ajaxregistro
                'name': $('form#register #name').val(), 
                'phone': $('form#register #phone').val(),
                'email': $('form#register #email').val(), 
                'dni': $('form#register #dni').val(),
                'username': $('form#register #username').val(), 
                'password': $('form#register #password').val(),
                'address': $('form#register #address').val()

            /*'security': $('form#login #security').val() */},
            success: function(data){
                $('form#register p.status').text(data.message);
                if (data.registerin == true){
                    document.location.href = ajax_register_object.redirecturl;
                }
            },
            fail: function(data){
                $('form#register p.status').text(data.message);
            }
        }).fail( function(data){
            $('form#register p.status').text(data.message);
        });
  
    });

});