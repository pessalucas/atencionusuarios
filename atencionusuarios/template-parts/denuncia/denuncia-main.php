<?php  
/*
Realiza tu denuncia
*/

//Focaliza en mapa CABA como zona de fiscalizacion del organismo, previo a busqueda
$address='CABA'
?>
                <section class="page-header margin-none page-header-modern page-header-background page-header-background-md overlay overlay-color-dark overlay-show overlay-op-5" style="background-image: url(/atencionusuarios/wp-content/themes/atencionusuarios/assets/img/hero/faros.jpg);">
					<div class="container">
						<div class="row">
							<div class="col-md-8 order-2 order-md-1 align-self-center p-static">
								<h1>Realiza tu <strong>denuncia</strong>.</h1>
								<span class="sub-title">Solicitudes de servicio</span>
                            </div>
						</div>
					</div>
				</section>

<?php  
    //Cantidad de filas por columna. @rows PARAMETRO muestra en front end distinta cantidad de filas x columna
    $rows= 5;
    $count = 0;
   
    //Genero la estrucutra de los diferentes tipos de denuncia que se pueden lograr
    $terms_deptos = get_terms( array(
        'taxonomy' => 'servicios',
        'hide_empty' => false,
        'parent'   => 0
    ) );
?>
<span id='scrollanimate'></span>
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
                                                                        <div class="toggle toggle-primary" data-plugin-toggle  data-appear-animation="maskUp" data-appear-animation-delay="<?php echo ( 100+30*$count ); ?>">  
                                                <?php 
                                                }
                                                $count++;
                                                
                                                ?>
                                                <section class="toggle" >
                                                <a class="toggle-title" style='border-radius: 50px 0px 0px 50px;'>
                                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/bots/<?php echo $servicios_slug; ?>.png" class="img-fluid" width="50" alt="" style='filter: grayscale(1); margin-right: 20px; width: 60px;'/>
                                                    <?php echo $servicios_name; ?>
                                                </a>
                                                    <div class="toggle-content">
                                                <?php  
                                                    
                                                    foreach ( $terms_grupoanomalias as $terms_grupoanomalia ){
                                                        $grupoanomalia_id = $terms_grupoanomalia->term_id;
                                                        $grupoanomalia_name =  $terms_grupoanomalia->name;
                                                    // print_r ($terms_grupoanomalias);
                                                    
                                                        ?>
                                                        <p id='<?php echo $grupoanomalia_id; ?>' data-servicio='<?php echo $servicios_name; ?>' class='toggle-hover'><?php echo $grupoanomalia_name; ?></p>
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
                    <div class="container container-lg mt-3" style='position: relative;'>
                        <div class="row justify-content-center" style='position:relative;'>
                            <div class="col-lg-10">
                                <div class="overflow-hidden mb-2">
                                    <span class="d-block font-weight-bold custom-text-color-grey-1 text-center line-height-1 mb-0 appear-animation" data-appear-animation="maskUp" data-appear-animation-delay="100">DENUNCIAS</span>
                                </div>
                                <div class="overflow-hidden mb-4">
                                    <h2 class="text-color-dark font-weight-bold text-center text-8 line-height-2 mb-0 appear-animation" data-appear-animation="maskUp" data-appear-animation-delay="200">Solicitud de servicio</h2>
                                </div>
                                <h6 class="font-weight-bold text-6" id='selector' name='selector' style='text-align:center;' data-appear-animation="maskUp" data-appear-animation-delay="100"></h6>
                                   <p style='text-align:center;' id='description-selector' data-appear-animation="maskUp" data-appear-animation-delay="100">Escoge la anomalia correspondiente.</p>
                                <div class="row" id='anomalias'data-appear-animation="maskUp" data-appear-animation-delay="100" >
                                            <?php 
                                                /*
                                                * Aqui Jquery inserta las anomalias asociadas al grupo seleccionado
                                                *
                                                */
                                            ?>
									</div>
                                </div>
                            </div>
                            <h1 id='back' name='back' class='back'><i class="fas fa-arrow-circle-left"></i></h1>
                        </div>
        </section>
                <section class="section border-0 py-0 m-0" id='direcciondenuncia'>
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-5 px-0">
                                <div class="d-flex flex-column justify-content-center bg-color-dark h-100 p-5">
                                    <div class="row justify-content-center pt-2 mt-5">
                                        <div class="col-md-9">
                                            <div class="feature-box flex-column flex-xl-row align-items-center align-items-xl-start text-center text-xl-left appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="600">
                                                 <div class="feature-box-icon bg-color-transparent w-auto h-auto pt-0">
                                                        <i class="fas fa-map-marked-alt" style='color:white; font-size:50px;'></i>
                                                </div>
                                                <div class="feature-box-info pl-2 pt-1">
                                                    <h4 class="text-color-light font-weight-bold text-6">Indica el nombre de la calle y la altura correspondiente.</h4>
                                                    <p class="text-color-light opacity-5 font-weight-light custom-text-size-1 pb-2 mb-4">No utilizar abreviaciones.</p>
                                                
                                                    <form method="GET" id="ddenuncia" action="ddenuncia">
                                                        <div style='position:relative;'>
                                                        <input type="text" autocomplete="off" placeholder="Ej: Direccion 123" id="direccion" name="direccion" style='border:none; width:250px;'>
                                                            <ul id='searcherdireccion'>
                                                                    <?php  
                                                                            //Inserta jquery
                                                                    ?>
                                                            </ul>
                                                        </div>
                                                        <select name="veredasdir" id="veredasdir" style='border:none; width:250px;'>
                                                            <option value="">Seleccionar vereda/s</option>
                                                            <option value="AMBAS VEREDAS">Ambas veredas</option>
                                                            <option value="VEREDA PAR">Vereda par</option>
                                                            <option value="VEREDA IMPAR">Vereda impar</option>
                                                        </select>
                                                                                     
                                                    </form>
                                                </div>
                                                
                                            </div>
                                        </div>
                            
                                    </div>
                        
                                </div>
                            </div>
                            <div class="col-lg-7 px-0" style='position:relative; overflow:hidden; min-height: 300px;'>
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/maindenuncias/mapagenericocaba.png" alt="" style='position: absolute; left: 50%; top: 50%; -webkit-transform: translateY(-50%) translateX(-50%);' id='map'>
                            </div>
                        </div>
                    </div>
                </section>

                <section class="section custom-section-full-width bg-color-transparent border-0 mt-1 mb-1" style="background-image: url(img/demos/it-services/backgrounds/dots-background-4.png); background-repeat: no-repeat; background-position: top right;">
                    <div class="container container-lg mt-3">
                        <div class="row justify-content-center">
                            <div class="col-lg-10">
                                <p class="custom-text-size-1 text-center mb-5 appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="700">Para finalizar debes dejar una explicación concisa de la situación.</p>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="900">
                                <form class="contact-form" method="POST" id="denuncia" action="denuncia" enctype="multipart/form-data">
                                <input type="hidden" name="MAX_FILE_SIZE" value="30000" />
                                    
                                    <input type="hidden" name='direccion' id='direccion'>
                                    <input type="hidden" name='vereda'    id='vereda'>
                                    <input type="hidden" name='anomalia'  id='anomalia'>
                                    <input type="hidden" name='geolat'    id='geolat'>
                                    <input type="hidden" name='geolong'   id='geolong'>
                                    <input type="hidden" name='comuna'    id='comuna'>
                                    <input type="hidden" name='barrio'    id='barrio'>
                                    
                                    <div class="form-row">
                                        <div class="form-group col mb-4">
                                            <textarea maxlength="5000" data-msg-required="Please enter your message." rows="5" class="form-control border-0 custom-box-shadow-1 py-3 px-4 h-auto text-3 text-color-dark" name="obs" id="obs" placeholder="Realiza una observacion"></textarea>
                                        </div>
                                    </div>

                            <?php  if ( ! is_user_logged_in() ) { ?>
                                    <label>Este mail será tu usuario de ingreso, a él recibirás la información asociada a la denuncia.</label>
                                        <div class="form-row row-gutter-sm">
                                            <div class="form-group col mb-4">
                                                <input type="email" value="" data-msg-required="Please enter your email address." data-msg-email="Please enter a valid email address." maxlength="100" class="form-control border-0 custom-box-shadow-1 py-3 px-4 h-auto text-3 text-color-dark" name="email" id="email" required="" placeholder="Indica tu mail">
                                            </div>
                                        </div>
                            <?php   } ?>

                                    <label>Si lo desea, puede subir una foto de la anomalía.</label>
                                        <div class="form-row row-gutter-sm">
                                            <div class="form-group col- mb-4">
                                                <input type="file" name="file" id="file">
                                            </div>
                                        </div>

                                    <div class="form-row">
                                        <div class="form-group col mb-0">
                                        <?php  if ( ! is_user_logged_in() ) { 
                                            $submit = 'REGISTRARSE Y ENVIAR';
                                            }else{ $submit = 'ENVIAR'; } ?>
                                            <button type="submit" id='buttonsubmit' class="btn btn-secondary btn-outline text-color-dark font-weight-semibold border-width-4 custom-link-effect-1 text-1 text-xl-3 d-inline-flex align-items-center px-4 py-3" data-loading-text="Loading..."> <?php echo $submit; ?> <i class="custom-arrow-icon ml-5"></i></button>
                                            
                                            <div class='containerloader'>
												<img src="http://localhost/atencionusuarios/wp-content/uploads/2020/10/toptal-blog-image-1489080120310-07bfc2c0ba7cd0aee3b6ba77f101f493.gif" class="loader" alt="">
											</div>

                                            <div class="form-group col" id="frmmessage" style='margin-top:15px;'></div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </section>
        </div>

                        <!-- Modal de aprobacion -->
                    <div class='' id='fade2'>
                        <div class="modal2 fade" id='modalapro' >
								<div class="featured-box featured-box-primary">
									<div class="box-content p-5" style='border-top-width: 0px!important;'>
										<div class="row">
											<div class="col" >
                                                <i class="icon-featured far fa-file-alt mt-0 icon-custom"  id='success-icon-effect'></i>
												<h2 class="font-weight-normal text-6" style='margin:10px!important;'>Denuncia <strong class="font-weight-extra-bold">enviada</strong></h2>
												<h4 class="" style='margin-bottom:10px; color:black;'>La denuncia ha sido cargada exitosamente. Recibiras a tu casilla de email informacion asociada.</h4>
                                                <div id='main-modalapro' style='display: flex; align-items: center; justify-content: center; flex-direction: column;'>
                                                    <?php 
                                                        /*
                                                        * Aqui Jquery inserta los distintos tipos de caminos segun el usuario que denuncio
                                                        *
                                                        */
                                                    ?>
                                                </div>
											</div>
										</div>
									</div>
								</div>
							</div>
                        </div>

		

