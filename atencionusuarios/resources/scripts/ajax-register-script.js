
jQuery(document).ready(function($) {

    // Show the login dialog box on click
    $('a#show_register').on('click', function(e){
        $('body').prepend('<div class="register_overlay"></div>');
        $('form#register').fadeIn(500);
        $('div.register_overlay, form#register a.close').on('click', function(){
            $('div.register_overlay').remove();
            $('form#register').hide();
        });
        e.preventDefault();
    });

    $('form#register').on('submit', function (event) {
        event.preventDefault();
});

    // Perform AJAX login on form submit
    $('form#register').on('submit', function(e){
        $('form#register p.status').show().text(ajax_register_object.loadingmessage);
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: ajax_register_object.ajaxurl,
            data: { 
                'action': 'ajaxregister', //calls wp_ajax_nopriv_ajaxlogin
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
        e.preventDefault();
    });

});