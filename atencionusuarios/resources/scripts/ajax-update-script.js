
jQuery(document).ready(function($) {

    // Show the login dialog box on click
    $('a#show_update').on('click', function(e){
        $('body').prepend('<div class="update_overlay"></div>');
        $('form#update').fadeIn(500);
        $('div.update_overlay, form#update a.close').on('click', function(){
            $('div.update_overlay').remove();
            $('form#update').hide();
        });
        e.preventDefault();
    });

    $('form#update').on('submit', function (event) {
        event.preventDefault();
});

    // Perform AJAX login on form submit
    $('form#update').on('submit', function(e){
        $('form#update p.status').show().text(ajax_update_object.loadingmessage);
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: ajax_update_object.ajaxurl,
            data: { 
                'action': 'ajaxupdate', //calls wp_ajax_nopriv_ajaxlogin
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
                if (data.updatein == true){
                    document.location.href = ajax_update_object.redirecturl;
                }
            },
            fail: function(data){
                $('form#update p.status').text(data.message);
            }
        }).fail( function(data){
            $('form#update p.status').text(data.message);
        });
        e.preventDefault();
    });

});