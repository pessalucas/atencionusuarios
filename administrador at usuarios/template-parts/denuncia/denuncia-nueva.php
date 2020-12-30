<?php  
/*
Realiza tu denuncia
*/

//Focaliza en mapa CABA como zona de fiscalizacion del organismo, previo a busqueda
$address='CABA';

?>

<div id='datosdenuncia'>
        <section  class="section custom-section-full-width bg-color-transparent border-0 mt-1 mb-1" style="background-image: url(img/demos/it-services/backgrounds/dots-background-4.png); background-repeat: no-repeat; background-position: top right;">
                    <div class="container container-lg mt-3" style='position: relative;'>
                        <div class="row justify-content-center" style='position:relative;'>
                            <div class="col-lg-10">
                                <div class="overflow-hidden mb-2">
                                    <span class="d-block font-weight-bold custom-text-color-grey-1 text-center line-height-1 mb-0 appear-animation" data-appear-animation="maskUp" data-appear-animation-delay="100">NUEVA DENUNCIA</span>
                                </div>
                                <div class="overflow-hidden mb-4">
                                    <h2 class="text-color-dark font-weight-bold text-center text-8 line-height-2 mb-0 appear-animation" data-appear-animation="maskUp" data-appear-animation-delay="200">Informacion del denunciante</h2>
                                </div>
                                <h6 class="font-weight-bold text-6" id='selector' name='selector' style='text-align:center;' data-appear-animation="maskUp" data-appear-animation-delay="100"></h6>
                                    <div class="row" id='anomalias'data-appear-animation="maskUp" data-appear-animation-delay="100" >
                                           <form id='formdenunciante' method='POST'  autocomplete="off">
                                                <input type="hidden" name='type' id='type' value='new'>
                                                <input type="hidden" name='userid' id='userid' value=''>
                                                <div class="row" style='margin-right:100px;  margin-left:100px; margin-bottom:15px;'>
                                                    <label>Realice la busqueda por email o DNI</label><br>
                                                    <input  type="text" name='searcheruser' id='searcheruser' style='margin-left:50px;' class='datanewdensearch'><br>
                                                    <ul id='ulsearcheruser'>
                                                        <?php  
                                                        /*
                                                        ** Inserta jquery
                                                        */
                                                        ?>
                                                    </ul>
                                                </div>
                                                <div class="row">
                                                    <div class="col">
                                                            <label>Nombre</label><br>
                                                        <input type="text" name='firstname' id='firstname' class='datanewden'><br>
                                                            <label>Apellido</label><br>
                                                        <input type="text" name='lastname' id='lastname' class='datanewden'><br>
                                                    </div>
                                                    <div class="col">
                                                            <label>Email</label><br>
                                                        <input type="text" name='email' id='email' class='datanewden'><br>
                                                            <label>DNI</label><br>
                                                        <input type="text" name='dni' id='dni' class='datanewden'><br>
                                                    </div>
                                                    <div class="col">
                                                            <label>Telefono</label><br>
                                                        <input type="text" name='phone' id='phone' class='datanewden'><br>
                                                            <label>Domicilio</label><br>
                                                        <input type="text" name='adress' id='adress' class='datanewden'><br>
                                                    </div>
                                                    <div class="col">
                                                        <button type='submit' id='registeruser' class='buttonmas' style='margin: 30px;'>Registrar usuario</button>
                                                        <button type='submit' id='updateuser'  class='buttonmas' style='margin: 30px; display:none;'>Actualizar usuario</button>
                                                    </div>
                                                </div>
                                           </form>
                                           <div id='user_messages'></div>
									</div>
                                </div>
                            </div>
                        </div>
        </section>
                <section class="section border-0 py-0 m-0" id='direcciondenuncia' style='margin: 0px!important; padding: 0px!important;'>
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
                                                    <h4 class="text-color-light font-weight-bold text-6">Informacion de la denuncia</h4>
                                                    <p class="text-color-light opacity-5 font-weight-light custom-text-size-1 pb-2 mb-4">Indica la informacion correspondiente.</p>
                                                
                                                    <form method="GET" id="formdenuncia" action="formdenuncia" class='formdenuncia'  autocomplete="off">
                                                        <input type="hidden" name='user_id' id='user_id'>
                                                        <label>Procedencia</label><br>
                                                            <select name="procedencia" id='procedencia'>
                                                                <?php  
                                                                    //Genero la estrucutra de los diferentes tipos de denuncia que se pueden lograr
                                                                    $terms_procedencias = get_terms( array(
                                                                        'taxonomy'   => 'procedencia',
                                                                        'hide_empty' => false,
                                                                        'parent'     => 0
                                                                    ) );

                                                                            foreach ( $terms_procedencias as $terms_procedencia ){
                                                                                $procedencia_id   = $terms_procedencia->term_id;
                                                                                $procedencia_name =  $terms_procedencia->name;
                                                                ?>
                                                                    <option value="<?php echo $procedencia_id; ?>"><?php echo $procedencia_name; ?></option>
                                                                <?php  
                                                                            }
                                                                ?>
                                                            </select><br>
                                                        <label>Servicio</label><br>
                                                            <select name="servicio" id='servicio'>
                                                                <option value="">--Seleccione uno--</option>
                                                            <?php  
                                                                //Genero la estrucutra de los diferentes tipos de denuncia que se pueden lograr
                                                                $terms_deptos = get_terms( array(
                                                                    'taxonomy' => 'servicios',
                                                                    'hide_empty' => false,
                                                                    'parent'   => 0
                                                                ) );
                                                                    foreach ( $terms_deptos as $terms_depto ) {
                                                                        $depto_id = $terms_depto->term_id;
                                                                        $terms_servicios = get_terms( array(
                                                                            'taxonomy' => 'servicios',
                                                                            'hide_empty' => false,
                                                                            'parent'   => $depto_id
                                                                        ) );

                                                                        foreach ( $terms_servicios as $terms_servicio ){
                                                                            $servicios_id = $terms_servicio->term_id;
                                                                            $servicios_name =  $terms_servicio->name;
                                                                            $terms_grupoanomalias = get_terms( array(
                                                                                'taxonomy' => 'servicios',
                                                                                'hide_empty' => false,
                                                                                'parent'   => $servicios_id
                                                                            ) );
                                                            ?>
                                                                <option value="<?php echo $servicios_id; ?>"><?php echo $servicios_name; ?></option>
                                                            <?php  
                                                                        }}
                                                            ?>
                                                            </select><br>
                                                        <label>Gupos de anomalias</label><br>
                                                            <select name="grupoanomalias" id='grupoanomalias'><br>
                                                                <option value="">--Seleccione uno--</option>
                                                                <?php  
                                                                        //Inserta jquery
                                                                ?>
                                                            </select><br>
                                                        <label>Anomalias</label><br>
                                                            <select name="anomalia" id='anomalia'>
                                                                <option value="">--Seleccione una--</option>
                                                                <?php  
                                                                        //Inserta jquery
                                                                ?>
                                                            </select><br>
                                                        <label>Direccion</label><br>
                                                            <input type="text" placeholder="Direccion" id="direccion" name="direccion" style='border:none; position:relative;'><br>
                                                        <ul id='searcherdireccion'>
                                                                <?php  
                                                                        //Inserta jquery
                                                                ?>
                                                        </ul>
                                                        <select name="selectorbarrido" id="selectorbarrido">
                                                            <option value="AMBAS VEREDAS">Ambas veredas</option>
                                                            <option value="VEREDA PAR">Vereda par</option>
                                                            <option value="VEREDA IMPAR">Vereda impar</option>
                                                        </select><br>
                                                        <input type="hidden" name='geolat' id='geolat'>
                                                        <input type="hidden" name='geolong' id='geolong'>
                                                        <label>Barrio</label><br>
                                                            <input type="text" name='barrio' id='barrio' placeholder='Auto-completado' readonly><br>
                                                        <label>Comuna</label><br>
                                                            <input type="text" name='comuna' id='comuna' placeholder='Auto-completado' readonly><br><br>
                                                        <textarea maxlength="5000" data-msg-required="Please enter your message." rows="4" class="form-control border-0 custom-box-shadow-1 py-3 px-4 h-auto text-3 text-color-dark" name="obs" id="obs" placeholder="Realiza una observacion"></textarea>
                                                        <div id='denuncia_messages'>
                                                                <?php  
                                                                        //Inserta jquery
                                                                ?>
                                                        </div>
                                                        <div class='containerloader'>
                                                            <p>Cargando...</p>
                                                        </div>
                                                        <button type='submit' class='buttonmas' style='color:none;'>Cargar denuncia</button>
                                                    </form>
                                                </div>
                                                
                                            </div>
                                        </div>
                            
                                    </div>
                        
                                </div>
                            </div>

                            <div class="col-lg-7 px-0" style='position:relative; overflow:hidden; min-height: 300px;'>
                                <img src="<?php echo home_url(); ?>/wp-content/themes/administrador%20at%20usuarios/assets/img/newden/puntero.png" alt="" style='position: absolute; left: 50%; top: 50%; -webkit-transform: translateY(-50%) translateX(-50%);' id='map'>
                            </div>
                        </div>
                    </div>
                </section>

