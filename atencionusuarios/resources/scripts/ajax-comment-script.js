
jQuery(document).ready(function($) {


    $('form#comment').on('submit', function(e){
        e.preventDefault();
        if ( $('form#comment #message').val() ){ 
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: ajax_comment_object.ajaxurl,
            data: { 
                'action': 'ajaxcomment', //calls wp_ajax_nopriv_ajaxcomment
                'message': $('form#comment #message').val(),
                'post_id': $('form#comment #post_id').val() /*, 
            'security': $('form#comment #security').val() */},
            success: function(data){
                console.log(data);

                //Agrego el comentario que cargue previamente para dar dinamismo
                $( '#commentsmain' ).append(function() {
                    var article=`
                    <li>
                        <div class="comment">
                            <div class="comment-block">
                                <div class="comment-arrow"></div>
                                <span class="comment-by">
                                    <strong class="text-dark">`+  data.commentary[0].user + `</strong>
                                </span>
                                <p>`+  data.commentary[0].comment + `</p>
                                <span class="date float-right">`+  data.commentary[0].time + `</span>
                            </div>
                        </div>
                    </li>`

                    return article;

                    });
                
                    //Borro lo que dice en el area de texto
                    $('form#comment #message').val('');
            },
            fail: function(data){
              
            }
             }).fail( function(data){
            
            });
        }
    });
    
});