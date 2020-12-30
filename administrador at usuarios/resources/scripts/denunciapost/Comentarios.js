
jQuery(document).ready(function($) {

    /*
    *   Defino los elementos que voy a utilizar; generacion de comentarios
    */
    //Elementos y botones
    const FormCommentPublic   = $('#commentpublic' );
    const MainCommentsPublic  = $('#commentsmainpublic' );
    const FormCommentPrivate   = $('#commentprivate' );
    const MainCommentsPrivate  = $('#commentsmainprivate' );
    const ButtonsDeleteComment = $( '.deletecomment' );
    
    FormCommentPublic.on('submit', function(e){
        e.preventDefault();

        const id_denuncia    = FormCommentPublic.find( '[name="id_denuncia"]' );
		const id_user        = FormCommentPublic.find( '[name="user_id"]' );
        const message        = FormCommentPublic.find( '[name="message"]' );
        const type           = FormCommentPublic.find( '[name="public"]' );
        
        $.ajax({
            type:      'POST',
            dataType:  'json',
            url:       ajax_comments_object.ajaxurl,
            data: { 
                'action'      :  'ajaxcomments', //calls wp_ajax_nopriv_ajaxcomment
                'message'     :  message.val(),
                'id_denuncia' :  id_denuncia.val(),
                'id_user'     :  id_user.val(),
                'type'        :  type.val() 
            },

            success: function(data){
                console.log(data);

                //Agrego el comentario que cargue previamente para dar dinamismo
                MainCommentsPublic.append(function() {
                    var article=`
                        <li>
                            <div class="comment">
                                <div class="comment-block">
                                    <div class="comment-arrow"></div>
                                    <span class="comment-by">
                                        <strong class="text-dark">`+  data.data[0].user + `</strong>
                                    </span>
                                    <p>`+  data.data[0].comment + `</p>
                                    <span class="date float-right">`+  data.data[0].time + `</span>
                                </div>
                            </div>
                        </li>`
                    return article; });
                
                    //Borro lo que dice en el area de texto
                    message.val('');
            },
            fail: function(){
              console.log( 'Falla el ajax.' ); 
            }
             }).fail( function(){
                console.log( 'Falla el ajax.' ); 
            });
    });
    

    FormCommentPrivate.on('submit', function(e){
        e.preventDefault();

        const id_denuncia    = FormCommentPrivate.find( '[name="id_denuncia"]' );
		const id_user        = FormCommentPrivate.find( '[name="user_id"]' );
        const message        = FormCommentPrivate.find( '[name="message"]' );
        const type           = FormCommentPrivate.find( '[name="private"]' );
        
        $.ajax({
            type:      'POST',
            dataType:  'json',
            url:       ajax_comments_object.ajaxurl,
            data: { 
                'action'      :  'ajaxcomments', //calls wp_ajax_nopriv_ajaxcomment
                'message'     :  message.val(),
                'id_denuncia' :  id_denuncia.val(),
                'id_user'     :  id_user.val(),
                'type'        :  type.val() 
            },

            success: function(data){
                console.log(data);

                //Agrego el comentario que cargue previamente para dar dinamismo
                MainCommentsPrivate.append(function() {
                    var article=`
                        <li>
                            <div class="comment">
                                <div class="comment-block">
                                    <div class="comment-arrow"></div>
                                    <span class="comment-by">
                                        <strong class="text-dark">`+  data.data[0].user + `</strong>
                                    </span>
                                    <p>`+  data.data[0].comment + `</p>
                                    <span class="date float-right">`+  data.data[0].time + `</span>
                                </div>
                            </div>
                        </li>`
                    return article; });
                
                    //Borro lo que dice en el area de texto
                    message.val('');
            },
            fail: function(){
              console.log( 'Falla el ajax.' ); 
            }
             }).fail( function(){
                console.log( 'Falla el ajax.' ); 
            });
    });
    

    
    ButtonsDeleteComment.click( function (e){

        var id_comment = $(this).data('id_comment');

        $.ajax({
            type:      'POST',
            dataType:  'json',
            url:       ajax_comments_object.ajaxurl,
            data: { 
                'action'            :  'ajaxdeletecomments', //calls wp_ajax_nopriv_ajaxcomment
                'id_comment'        :  id_comment,
            },
            success: function(data){
                console.log(data);
                location.reload();
            },
            fail: function(){
              console.log( 'Falla el ajax.' ); 
            }
             }).fail( function(){
                console.log( 'Falla el ajax.' ); 
            });
    })

});