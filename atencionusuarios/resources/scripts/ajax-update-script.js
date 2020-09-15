
jQuery(document).ready(function($) {


    $('form#update').on('submit', function(e){
        e.preventDefault();
        $('form#update p.status').show().text(ajax_update_object.loadingmessage);
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: ajax_update_object.ajaxurl,
            data: { 
                'action': 'ajaxupdate', //calls wp_ajax_nopriv_ajaxregistro
                'name': $('form#update #name').val(), 
                'phone': $('form#update #phone').val(),
                'email': $('form#update #email').val(), 
                'dni': $('form#update #dni').val(),
                'username': $('form#update #username').val(), 
                'password': $('form#update #password').val(),
                'address': $('form#update #address').val()

            /*'security': $('form#login #security').val() */},
            success: function(data){
                $('form#update p.status').text(data.message);
            },
            fail: function(data){
                $('form#update p.status').text(data.message);
            }
        }).fail( function(data){
            $('form#update p.status').text(data.message);
        });

    });

});