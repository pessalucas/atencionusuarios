
jQuery(document).ready(function($) {

    //Oculto el segundo paso
    $('#denunciadetalle').hide();
    $('#comments-div').hide();

    //Evento para los pedidos de detalles de las denuncias
    $('.call-to-action-btn').click(function(e){

    //Traigo id del elemento para conocer la anomalia
    var iddenuncia = $(this).attr("id");

        //Oculto el primer paso
        $('#listadodenuncias').hide();

        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: ajax_listadodenuncias_object.ajaxurl,
            data: { 
                'action'   : 'ajaxlistadodenuncias', //calls wp_ajax_nopriv_ajaxdenuncia
                'iddenuncia': iddenuncia
                /*, 
            'security': $('form#denuncia #security').val() */},
            success: function(data){

                console.log(data);

                //Agrego data general al principio
                nroanomalia = 'Nro Denuncia: ' + data.datageneral[0].id + '. ' + data.servicios[0].name + '. ' + data.servicios[1].name + '.';
                $('#nroanomaliaden').text(nroanomalia);
                count=0;
                estado= '';
                data.estado.forEach( function() {
                    estado = estado +  data.estado[count].name + '. ';
                    count++;
                });
                estado = 'Estado de denuncia: ' + estado ; 
                $('#estadoden').text(estado);
                fecha = 'Fecha de denuncia: ' + data.datageneral[0].fecha + '.';
                $('#fechaden').text(fecha);
                direccion = 'Direccion: ' + data.datageneral[0].direccion + '.';
                $('#dirden').text(direccion);
                barrio = 'Barrio: ' + data.datageneral[0].barrio + '.';
                $('#barrioden').text(barrio);
                obs = 'Observacion del denunciante: ' + data.datageneral[0].obs + '.';
                $('#obsden').text(obs);
                
                
                //Llega data.attacheds Informacion de fotos agregadas por fiscalizadores o fotos de denunciante
                count=0;
                data.attacheds.forEach(function() {
                    console.log(attacheds);
                    $( '#attacheds' ).append(function() {
                       
                  
                        if( data.attacheds[count].attachment_type != 'Otro'){ 
                            if( data.attacheds[count].attachment_type == 'FotoDenunciante'){ 
                                var article=`
                            <div class="isotope-item">
                                <div class="image-gallery-item">
                                        <span class="thumb-info thumb-info-centered-info thumb-info-no-borders">
                                                 <span class="thumb-info-wrapper">
                                                        <img src="`+  data.attacheds[count].guid +`" class="img-fluid" alt="">
                                                        <span class="thumb-info-title">
                                                            <span class="thumb-info-inner">Foto del denunciante: `+  data.attacheds[count].post_author +`</span>
                                                        </span>   
                                                 </span>
                                        </span>
                                </div>
                            </div> 
                                `;
                              
                
                                return article;
                            }else if ( data.attacheds[count].attachment_type == 'Fiscalizacion'){ 
                                var article=`
                            <div class="isotope-item">
                                <div class="image-gallery-item">
                                    <span class="thumb-info thumb-info-centered-info thumb-info-no-borders">
                                            <span class="thumb-info-wrapper">
                                                        <img src="`+  data.attacheds[count].guid +`" class="img-fluid" alt="">
                                                        <span class="thumb-info-title">
                                                        <span class="thumb-info-inner">Cargado por: `+  data.attacheds[count].post_author + `</span>
                                                        <span class="thumb-info-type">El dia: `+  data.attacheds[count].post_date + `</span>
                                            </span>   
                                    </span>
                                </div>
                            </div>
                                `;
                                return article;
                            }
                        }
                    });
                    count++;
                  });

                //Llega data.comments informacion de los comentarios de las distintas areas.
                count=0;
                data.comments.forEach(function() {
                    $( '#commentsmain' ).append(function() {
                       
                    var article=`
                    <li>
                        <div class="comment">
                            <div class="comment-block">
                                <div class="comment-arrow"></div>
                                <span class="comment-by">
                                    <strong class="text-dark">`+  data.comments[count].comment_author + `</strong>
                                </span>
                                <p>`+  data.comments[count].comment_content + `</p>
                                <span class="date float-right">`+  data.comments[count].comment_date + `</span>
                            </div>
                        </div>
                    </li>`

                    return article;
                    });
                    count++;
                  });
            },
            fail: function(data){

            }
        }).fail( function(data){

        });

        //Muestro el segundo paso
        $('#denunciadetalle').show();
        $('#comments-div').show();

        //Asigno al comentario el post id que sera cargado posteriormente
        $('form#comment #post_id').val(iddenuncia);
    });

    
    

});