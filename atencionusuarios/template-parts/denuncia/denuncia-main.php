<?php  
/*
Realiza tu denuncia
*/

//Focaliza en mapa CABA como zona de fiscalizacion del organismo, previo a busqueda
$address='CABA'
?>
    <section id="denunciasearch" class="section bg-color-transparent border-0 mt-0 mb-1" style="background-image: url(img/demos/it-services/backgrounds/dots-background-3.png); background-repeat: no-repeat; background-position: top right;">
                        <div class="container container-lg pt-3 mt-4">
                            <div class="row justify-content-center">
                                <div class="col-md-10 text-center">
                                    <div class="overflow-hidden mb-2">
                                        <span class="d-block font-weight-bold custom-text-color-grey-1 line-height-1 mb-0 appear-animation" data-appear-animation="maskUp" data-appear-animation-delay="600">Solicitudes de servicio</span>
                                    </div>
                                    <div class="overflow-hidden mb-4">
                                        <h2 class="text-color-dark font-weight-bold text-8 line-height-2 mb-0 appear-animation" data-appear-animation="maskUp" data-appear-animation-delay="800">Realiza tu denuncia</h2>
                                    </div>
                                    <p class="custom-text-size-1 mb-5 appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="1000">Podes realizar la denuncia de manera 100% online a traves del buscador o los desplegables que se encuentran a contiuacion</p>
                                    <form action="">
                                    <input type="text">
                                    <p>Searcher</p>
                                    </form>
                                </div>
                            </div>
                        </div>
    </section>

<?php  
    //Cantidad de filas por columna. @rows PARAMETRO
    $rows= 5;
    $count = 0;
   
    //Genero la estrucutra de los diferentes tipos de denuncia que se pueden lograr
    $terms_deptos = get_terms( array(
        'taxonomy' => 'servicios',
        'hide_empty' => false,
        'parent'   => 0
    ) );
?>
<div class="row" id='denselector'>           
                                    <?php  
                                        foreach ( $terms_deptos as $terms_depto ) {
                                            $depto_id = $terms_depto->term_id;
                                            $terms_servicios = get_terms( array(
                                                'taxonomy' => 'servicios',
                                                'hide_empty' => false,
                                                'parent'   => $depto_id
                                            ) );
                                    
                                            foreach ( $terms_servicios as $terms_servicio ){
                                                $servicios_id = $terms_servicio->term_id;
                                                $servicios_slug = $terms_servicio->slug;
                                                $servicios_name =  $terms_servicio->name;
                                                $terms_grupoanomalias = get_terms( array(
                                                    'taxonomy' => 'servicios',
                                                    'hide_empty' => false,
                                                    'parent'   => $servicios_id
                                                ) );
                                            // print_r ($terms_grupoanomalias);

                                                if ( (($count % $rows)== 0) OR ($count == 0)){ 
                                                ?>
                                              
                                                                    <div class="col-lg-4">
                                                                        <div class="toggle toggle-primary" data-plugin-toggle>  
                                                <?php 
                                                }
                                                $count++;
                                                
                                                ?>
                                                <section class="toggle">
                                                <a class="toggle-title">
                                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/bots/<?php echo $servicios_slug; ?>.png" class="img-fluid iconsmain" width="50" alt="" style='filter: grayscale(1);'/>
                                                    <?php echo $servicios_name; ?>
                                                </a>
                                                    <div class="toggle-content">
                                                <?php  
                                                    
                                                    foreach ( $terms_grupoanomalias as $terms_grupoanomalia ){
                                                        $grupoanomalia_id = $terms_grupoanomalia->term_id;
                                                        $grupoanomalia_name =  $terms_grupoanomalia->name;
                                                    // print_r ($terms_grupoanomalias);
                                                    
                                                        ?>
                                                        <p id='<?php echo $grupoanomalia_id; ?>' data-servicio='<?php echo $servicios_name; ?>' ><?php echo $grupoanomalia_name; ?></p>
                                                        <?php  
                                                }
                                                ?>
                                                    </div>
                                                </section>
                                                <?php 
                                                if ( (($count % $rows)== 0) ){
                                                ?>
                                                        </div>
                                                    </div>
                                                <?php 
                                                    $cerrado = true;
                                                }else{
                                                    $cerrado = false;
                                                }
                                            }
                                        }
                                    ?>

<?php 
     if (! $cerrado ){
?>
                </div>
            </div>
<?php 
      }
?>
 </div> 

        </div>


        <div id='datosdenuncia'>
        <section  class="section custom-section-full-width bg-color-transparent border-0 mt-1 mb-1" style="background-image: url(img/demos/it-services/backgrounds/dots-background-4.png); background-repeat: no-repeat; background-position: top right;">
                    <div class="container container-lg mt-3">
                        <div class="row justify-content-center">
                            <div class="col-lg-10">
                                <div class="overflow-hidden mb-2">
                                    <span class="d-block font-weight-bold custom-text-color-grey-1 text-center line-height-1 mb-0 appear-animation" data-appear-animation="maskUp" data-appear-animation-delay="300">DENUNCIAS</span>
                                </div>
                                <div class="overflow-hidden mb-4">
                                    <h2 class="text-color-dark font-weight-bold text-center text-8 line-height-2 mb-0 appear-animation" data-appear-animation="maskUp" data-appear-animation-delay="500">Solicitud de servicio</h2>
                                </div>
                                <h6 class="font-weight-bold text-6" id='selector' name='selector'></h6>
                                    <div class="row" id='anomalias'>
                                            <?php 
                                                /*
                                                * Aqui Jquery inserta las anomalias asociadas al grupo seleccionado
                                                *
                                                */
                                            ?>
									</div>
                                </div>
                            </div>
                            <h1 id='back' name='back'>X</h1>
                        </div>
        </section>
                <section class="section border-0 py-0 m-0" id='infodenuncia'>
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-5 px-0">
                                <div class="d-flex flex-column justify-content-center bg-color-dark h-100 p-5">
                                    <div class="row justify-content-center pt-2 mt-5">
                                        <div class="col-md-9">
                                            <div class="feature-box flex-column flex-xl-row align-items-center align-items-xl-start text-center text-xl-left appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="600">
                                                <div class="feature-box-icon bg-color-transparent w-auto h-auto pt-0">
                                                    <img src="img/demos/it-services/icons/building.svg" class="img-fluid" width="95" alt="" data-icon data-plugin-options="{'onlySVG': true, 'extraClass': 'svg-fill-color-light'}" />
                                                </div>
                                                <div class="feature-box-info pl-2 pt-1">
                                                    <form method="GET" id="ddenuncia" action="ddenuncia">
                                                    <input type="text" placeholder="Direccion" id="direccion" name="direccion">
                                                    <input type="text" placeholder="1234" id="altura" name="altura">
                                                    <p class="status" style='color:white;'></p>
                                                    <button type="submit">Buscar</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                            
                                    </div>
                        
                                </div>
                            </div>
                            <div class="col-lg-7 px-0">
                            <!--<div id="myMap" style='position:relative;width:600px;height:400px;'></div>-->

 
                                <iframe width="100%" height="350" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?q=<?php echo urlencode($address); ?>&amp;output=embed" id='mapembed'></iframe><br/>

                            </div>
                        </div>
                    </div>
                </section>

                <section id='datosdenuncia' class="section custom-section-full-width bg-color-transparent border-0 mt-1 mb-1" style="background-image: url(img/demos/it-services/backgrounds/dots-background-4.png); background-repeat: no-repeat; background-position: top right;">
                    <div class="container container-lg mt-3">
                        <div class="row justify-content-center">
                            <div class="col-lg-10">
                                <p class="custom-text-size-1 text-center mb-5 appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="700">Para finalizar completa los campos que creas de importancia.</p>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="900">
                                <form class="contact-form" method="POST" id="denuncia" action="denuncia" enctype="multipart/form-data">
                                <input type="hidden" name="MAX_FILE_SIZE" value="30000" />
                                    <div class="contact-form-success alert alert-success d-none mt-4">
                                        <strong>Success!</strong> Your message has been sent to us.
                                    </div>

                                    <div class="contact-form-error alert alert-danger d-none mt-4">
                                        <strong>Error!</strong> There was an error sending your message.
                                        <span class="mail-error-message text-1 d-block"></span>
                                    </div>
                                    
                                    <input type="hidden" name='direccion' id='direccion'>
                                    <input type="hidden" name='anomalia' id='anomalia'>
                                    <input type="hidden" name='geolat' id='geolat'>
                                    <input type="hidden" name='geolong' id='geolong'>
                                    <input type="hidden" name='comuna' id='comuna'>
                                    <input type="hidden" name='barrio' id='barrio'>

                                    <div class="form-row">
                                        <div class="form-group col mb-4">
                                            <textarea maxlength="5000" data-msg-required="Please enter your message." rows="10" class="form-control border-0 custom-box-shadow-1 py-3 px-4 h-auto text-3 text-color-dark" name="obs" id="obs" placeholder="Your Message"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-row row-gutter-sm">
                                        <div class="form-group col- mb-4">
                                            <input type="file" name="file" id="file">
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group col mb-0">
                                            <button type="submit" class="btn btn-secondary btn-outline text-color-dark font-weight-semibold border-width-4 custom-link-effect-1 text-1 text-xl-3 d-inline-flex align-items-center px-4 py-3" data-loading-text="Loading...">SUBMIT <i class="custom-arrow-icon ml-5"></i></button>
                                            <p class="status"></p>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </section>

        </div>




