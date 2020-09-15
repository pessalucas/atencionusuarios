
jQuery(document).ready(function($) {


    $('form#changepassword').on('submit', function(e){
        e.preventDefault();
        $('form#changepassword p.status').show().text(ajax_changepassword_object.loadingmessage);
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: ajax_changepassword_object.ajaxurl,
            data: { 
                'action': 'ajaxchangepassword', 
                'password1': $('form#changepassword #password1').val(), 
                'password2': $('form#changepassword #password2').val()/*, 
            'security': $('form#changepassword #security').val() */},
            success: function(data){
                $('form#changepassword p.status').text(data.message);
            },
            fail: function(data){
                $('form#changepassword p.status').text(data.message);
            }
        }).fail( function(data){
            $('form#changepassword p.status').text(data.message);
        });
       
    });

});