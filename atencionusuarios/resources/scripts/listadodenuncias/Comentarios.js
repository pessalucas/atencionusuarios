
jQuery(document).ready(function($) {

    /*
    *   Defino los elementos que voy a utilizar; generacion de comentarios
    */
    //Elementos y botones
    const ComentariosTitulo   = $('#commentstitle' );
    const MainComentarios     = $('#commentsmain' );
    const MensajeFormulario   = $('form#comment #message') ;
    

    $('form#comment').on('submit', function(e){
        e.preventDefault();

         //Muestro loader
         $('.containerloader').show();
         $('.btn-outline').attr("style", "display: none !important");

        if ( MensajeFormulario.val() ){ 
        $.ajax({
            type:      'POST',
            dataType:  'json',
            url:       ajax_comment_object.ajaxurl,
            data: { 
                'action' :  'ajaxcomment', //calls wp_ajax_nopriv_ajaxcomment
                'message':  MensajeFormulario.val(),
                'post_id':  $('form#comment #post_id').val(),
                'user_id':  $('form#comment #user_id').val() 
            },

            success: function(data){
                console.log(data);

                  //Oculto loader
                  $('.containerloader').hide();
                  $('.btn-outline').attr("style", "display: inline-block !important");
                  
                ComentariosTitulo.show();

                //Agrego el comentario que cargue previamente para dar dinamismo
                MainComentarios.append(function() {
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
                    return article; });
                
                    //Borro lo que dice en el area de texto
                    MensajeFormulario.val('');
            },
            fail: function(){
              console.log( 'Falla el ajax.' ); 
            }
             }).fail( function(){
                console.log( 'Falla el ajax.' ); 
            });
        }
    });
    
});