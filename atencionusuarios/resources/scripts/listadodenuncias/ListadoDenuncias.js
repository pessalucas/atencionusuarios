
jQuery(document).ready(function($) {

    /*
    *   Defino los elementos que voy a utilizar
    */
  
    //Elementos y botones
    const DenunciaDetalle    = $('#denunciadetalle' );
    const DivComentarios     = $('#comments-div' );
    const BotonDatosDenuncia = $('.call-to-action-btn') ;
    const Back2              = $('#back2' );
    const MainComentarios    = $( '#commentsmain' );
    const ListadoDenuncias   = $( '#listadodenuncias' );
    const ImagenesDenuncia   = $( '#attacheds' );
    const DataServicio       = $( '#dataservicio' );
    const TituloComentarios  = $( '#commentstitle' );
    const AnimateScrollDen   = $( '#animatedenscroll' );

    
    //Denuncias ->datos meta y homogeneos simples 
    const NroDenunciaAnomalia = $( '#nroanomaliaden' );
    const EstadoDiv           = $( '#estadodiv' );
    const Estado              = $( '#estadoden' );
    const Fecha               = $( '#fechaden' );
    const Direccion           = $( '#dirden' );
    const Barrio              = $( '#barrioden' );
    const Observacion         = $( '#obsden' );
    
    //Oculto el segundo paso
    DenunciaDetalle.hide();
    DivComentarios.hide();
    EstadoDiv.hide();
    Fecha.hide()
    Direccion.hide();
    Barrio.hide();
    Observacion.hide();

    //Evento para los pedidos de detalles de las denuncias
    BotonDatosDenuncia.click(function(e){

        //Acomodo al top la segunda seccion
        $([document.documentElement, document.body]).animate({
            scrollTop: AnimateScrollDen.offset().top-3000
        }, 1000);
    

    //Abro evento para volver atras
        //Evento para volver a la pantalla de atras
        Back2.click(function(e){
            //Ejecuto el cambio de pantalla para mostrar ahora otra informacion 
            // y vacio los elementos de comentario e imagenes
            DenunciaDetalle.hide();
            DivComentarios.hide();
            ListadoDenuncias.show();
            MainComentarios.empty();
            ImagenesDenuncia.empty();
            DivComentarios.hide();
            EstadoDiv.hide();
            Fecha.hide()
            Direccion.hide();
            Barrio.hide();
            Observacion.hide();
            //return;
    });

    //Traigo id del elemento para conocer la anomalia
    var iddenuncia = $(this).attr("id");
    var servicioanomalia = $(this).data('servicio');

    //Obtengo los servicios a mostrar
    console.log(servicioanomalia);

        //Oculto el primer paso
        ListadoDenuncias.hide();

        $.ajax({
            type:      'POST',
            dataType:  'json',
            url:        ajax_listadodenuncias_object.ajaxurl,
            data: { 
                       'action'   : 'ajaxlistadodenuncias', //calls wp_ajax
                       'iddenuncia': iddenuncia
                    },
            success: function(data){

                console.log(data);

                //Saco el primer caracter + que viene por defecto
                servicioanomalia = servicioanomalia.substr(1,1000);
                console.log(servicioanomalia);

                servicioanomalia = servicioanomalia.replaceAll('+', " <i class='fas fa-arrow-right'></i> ");
                //'<strong>Nro Denuncia: ' + iddenuncia + '</strong> ' 
                nroanomalia = servicioanomalia ;
                NroDenunciaAnomalia.html(nroanomalia);
                count=0;
                estado= '';
                data.estado.forEach( function() {
                    estado = estado +  data.estado[count].name + '. ';
                    count++;    });
                estado = 'Estado de denuncia: ' + estado ; 
                Estado.html(estado);
                //Cambio de color div segun estado de denuncia:
                if ( data.estado[1] != undefined ){ 
                        if ( ( data.estado[0].name == 'Sumario' ) || ( data.estado[1].name == 'Sumario' ) ){
                            EstadoDiv.css("background-color", "#B22222");
                        }else if ( ( data.estado[0].name == 'Cerrado' ) || ( data.estado[1].name == 'Cerrado' ) ){
                            EstadoDiv.css("background-color", "#008000");
                        }else if ( ( data.estado[0].name == '	Fiscalización Nro' ) || ( data.estado[0].name == 'Fiscalización 1era' ) || ( data.estado[0].name == 'Fiscalización Nro' ) || ( data.estado[1].name == '	Fiscalización Nro' ) || ( data.estado[1].name == 'Fiscalización 1era' ) || ( data.estado[1].name == 'Fiscalización Nro' ) ){
                            EstadoDiv.css("background-color", "#FF8C00");
                        }else{  EstadoDiv.css("background-color", "#FFD700"); }
                }else{
                        if ( ( data.estado[0].name == 'Sumario' ) ){
                            EstadoDiv.css("background-color", "#B22222");
                        }else if ( ( data.estado[0].name == 'Cerrado' ) ){
                            EstadoDiv.css("background-color", "#008000");
                        }else if ( ( data.estado[0].name == '	Fiscalización Nro' ) || ( data.estado[0].name == 'Fiscalización 1era' ) || ( data.estado[0].name == 'Fiscalización Nro' ) ){
                            EstadoDiv.css("background-color", "#FF8C00");
                        }else{  EstadoDiv.css("background-color", "#FFD700"); }

                }
                fecha = 'Fecha de denuncia: ' + data.datageneral[0].fecha + '.';
                Fecha.html(fecha);
                if ( data.datageneral[0].direccion ){ 
                    direccion = 'Direccion: ' + data.datageneral[0].direccion + '.';
                    Direccion.html(direccion);
                    barrio = 'Barrio: ' + data.datageneral[0].barrio + '.';
                    Barrio.html(barrio);
                }
                if ( data.datageneral[0].obs ){ 
                obs = 'Observacion del denunciante: ' + data.datageneral[0].obs + '.';
                Observacion.html(obs);  }

                //Los muestro una ves cargados
                DivComentarios.show();
                EstadoDiv.show();
                Fecha.show()
                Direccion.show();
                Barrio.show();
                Observacion.show();

                //Llega data.attacheds Informacion de fotos agregadas por fiscalizadores o fotos de denunciante
                var comentarios = data.attacheds;

                count=0;
                comentarios.forEach( function() {
                    console.log( attacheds );
                    ImagenesDenuncia.append( function() {
                       
                        
                        if( data.attacheds[count].attachment_type != 'Otro'){ 
                            if( data.attacheds[count].attachment_type == 'FotoDenunciante'){ 
                                var article=`
                            <div class="isotope-item" data-appear-animation="maskUp" data-appear-animation-delay="200">
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
                            <div class="isotope-item" data-appear-animation="maskUp" data-appear-animation-delay="200">
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
                count = 0;
                data.comments.forEach(function() {
                   if ( data.comments[count].comment_type == 'public' ){ 
                        MainComentarios.fadeIn().append(function() {
                        var article=`
                        <li>
                            <div class="comment" data-appear-animation="maskUp" data-appear-animation-delay="200">
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
                 }
                    count++;
                 });
                  console.log( count );
                  if( count == 0 ) {
                    TituloComentarios.hide();
                  }else{
                    TituloComentarios.show();
                  }
            },
            fail: function(){
                console.log( 'Falla de ajax.' );
            }
        }).fail( function(){
            console.log( 'Falla de ajax.' );

        });

        //Muestro el segundo paso
        DenunciaDetalle.show();
        DivComentarios.show();

        //Asigno al comentario el post id que sera cargado posteriormente
        $('form#comment #post_id').val(iddenuncia);
    });
});