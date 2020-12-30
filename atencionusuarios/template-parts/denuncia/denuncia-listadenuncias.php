<?php

    /*
    *   Permito acceder a informacion del usuario con un codigo MD5 y un GET o usuario logueado
    *   Estructura // http://localhost/atencionusuarios/segdenuncia/?not_login_code=b416991ed37401344e32a2dcc4354da7
    */

    //Tomo GET
    if ( isset ( $_GET['not_login_code'] )){
        $not_login_code = $_GET['not_login_code'];

        //Busco un codigo de not login asignado igual
        $user_query = new WP_User_Query( 
            array(
                'meta_query'    => array(
                    array( 
                        'key'     => 'not_login_code',
                        'value'   => $not_login_code,
                    )
                )
            ) 
        );

        if ( $user_query->results ){ 
        $user_id = $user_query->results[0]->data->ID;   
     
        }else{  echo '<script> location.replace("http://localhost/atencionusuarios/home/"); </script>';   }

            //Reviso si existe un usuario logueado
    } else if ( ! ( $user_id = get_current_user_id() ) ){   echo '<script> location.replace("http://localhost/atencionusuarios/home/"); </script>';  }

    //Traigo los posts asociados al autor por orden de fecha descreciente
    $query = new WP_Query( array( 
        'author'    => $user_id, 
        'post_type' => 'denuncia', 
        'orderby' => 'date',
        'order'   => 'DESC'
        ) );
    
    //Verifico si posee denuncias asociadas
    if ( $posts = $query->posts ) {

        //Inicio contador de denuncias
        $countdenuncias = 0;
?>
    <div class="row" id='listadodenuncias' style='margin-top: 3%;' >
<?php
//Listo denuncias segun autor.
    foreach( $posts as $denuncia ){

        //Traigo info asociada al post, meta y taxonomys.
        $direccion = get_post_meta( $denuncia->ID, 'direccion', true );
        $barrio = get_post_meta( $denuncia->ID, 'barrio', true );
        $servicios = get_the_terms( $denuncia->ID, 'servicios' );
        $fecha     = get_the_date( 'd M Y', $denuncia->ID );

        //Busco el child id de menor jerarquia
        $count = 0;
        foreach ( $servicios as $servicio ) {
        if( ! get_term_children( $servicios[$count]->term_id, 'servicios' ) ){
            $term_id_anomalia = $servicios[$count]->term_id; }
            $count ++ ;
        }
            
        //Genero una array con las categorias asociadas a la anomalia, de menor jerarquia con orden y estrucutra array para recorrer
        $ids_anomalia   = array();
        $term_anomalia  = get_term_by( 'id', $term_id_anomalia , 'servicios' );
        $id_anomalia    = $term_anomalia->term_id;
        $name_anomalia  = $term_anomalia->name;
        $id_parent      = $term_anomalia->parent;
        $ids_anomalia[] = $id_anomalia;
        while ( $id_parent!= 0 ) { 
            $term_next      = get_term_by( 'id', $id_parent , 'servicios' );
            $id_anomalia    = $term_next->term_id;
            $id_parent      = $term_next->parent;
            $ids_anomalia[] = $id_anomalia;
        } 

    ?>
    <div class="col-listadodenuncias" style='margin:auto;' data-appear-animation="maskUp" data-appear-animation-delay="<?php echo ( 100+70*$countdenuncias ); ?>">
        <section class="call-to-action featured featured-primary mb-5">
                            <div class="col-sm-9 col-lg-10">
                                <div class="call-to-action-content">
                                <h3>
                                    <span class="text-primary font-weight-bold alternative-font-2" style='margin-right:40px;'>
                                      <strong> Denuncia nro: <?php echo $denuncia->ID; ?> </strong>
                                    </span> 
                                    <?php 
                                            $count = 0;
                                            $dataservicio = '';
                                            $ids_anomalia = array_reverse($ids_anomalia);
                                            foreach ( $ids_anomalia as $id_anomalia){
                                            //Para todos menos el primero (Departamento)
                                            if ($id_anomalia != reset($ids_anomalia)) {
                                                $data =  get_term_by( 'id', $id_anomalia , 'servicios' );
                                                echo $data->name;
                                                $dataservicio = $dataservicio . '+' . $data->name;
                                                    if ($id_anomalia != end($ids_anomalia)) {
                                                    echo ' <i class="fas fa-arrow-right"></i> ';
                                                    }
                                            }  $count++; }
                                    ?>
                                </h3>
                                <p class="mb-0"><?php echo $fecha; if ( $direccion ) { ?> / <?php echo $direccion; ?> / <?php echo $barrio; } ?></p>	
                                </div>
                            </div>
                    <div class="col-sm-3 col-lg-2">
                             <div class=""  >
                                <button type="button" class="btn btn-outline btn-quaternary rounded-0 mb-2 call-to-action-btn" id='<?php echo $denuncia->ID; ?>' data-servicio='<?php echo $dataservicio; ?>'>Ver mas</button>
                            </div>
                    </div>
        </section>
    </div>
<?php
    //Voy realizando el conteo denuncias y corto en 20 para mostrar
    $countdenuncias++;
    if( $countdenuncias == 20 ){ break; }
}
?>
    </div>

<div id='denunciadetalle'>
        <div class="card border-0 border-radius-0 mb-5">
                    <div class="card-body p-0 z-index-1">


                <section class="page-header page-header-modern page-header-background page-header-background-md overlay overlay-color-quaternary overlay-show overlay-op-8 mb-0" style="background-image: url(img/page-header/page-header-background.jpg); background-color:#212529!important; padding:20px!important; position:relative;" id='animatedenscroll'>
					<div class="container">
						<div class="row">
							<div class="col align-self-center p-static text-center">
								<h1 id='nroanomaliaden' data-appear-animation="fadeIn" data-appear-animation-delay="300" ></h1>
                                <h4  class="sub-title" id='nroanomaliaden'  data-appear-animation="fadeIn" data-appear-animation-delay="300"></h4>
                                <p   class="sub-title" id='fechaden' data-appear-animation="fadeIn" data-appear-animation-delay="300"></p>
                                <p   class="sub-title" id='dirden' data-appear-animation="fadeIn" data-appear-animation-delay="300"></p>
                                <p   class="sub-title" id='barrioden' data-appear-animation="fadeIn" data-appear-animation-delay="300"></p>
                                <p   class="sub-title" id='obsden' data-appear-animation="fadeIn" data-appear-animation-delay="300"></p>
							</div>
						</div>
					</div>
                    <h1 id='back2' name='back2' class='back' style='color:white;'><i class="fas fa-arrow-circle-left"></i></h1>
				</section>

                <section class="page-header page-header-modern page-header-background page-header-background-md overlay-color-quaternary overlay-show overlay-op-8 mb-0" style="padding:20px!important; position:relative; " id='estadodiv' >
					<div class="container">
						<div class="row">
							<div class="col align-self-center p-static text-center">
			                    <h3  class="sub-title" id='estadoden' style='text-shadow: 0px 0px 4px rgba(0,0,0,0.84); color:white; font-weight: 800;' data-appear-animation="fadeIn" data-appear-animation-delay="300"></h3>
               		        </div>
						</div>
					</div>
               </section>



                    
				<div class="image-gallery sort-destination full-width" id='attacheds' style='margin:0px!important;'  data-appear-animation="fadeIn" data-appear-animation-delay="600">
                                    <?php
                                    /*
                                    *   Aqui jquery inseta fotos de denunciante y fiscalizaciones
                                    */
                                    ?>  
                </div>
            <div class="col-10" style='margin:auto;'  data-appear-animation="fadeIn" data-appear-animation-delay="900">
                <div id="comments-div" class="post-block post-comments">
                    <h3 class="text-color-dark text-capitalize font-weight-bold text-5 m-0 mb-3" id='commentstitle' style='text-align:center; margin-top:30px!important;'>Comentarios</h3>

                                                    <ul class="comments" id='commentsmain'>
                                                    <?php
                                                    /*
                                                    *   Aqui jquery inserta los comentarios
                                                    */
                                                    ?>  
                                                    </ul>

                                                    <h3 class="text-color-dark text-capitalize font-weight-bold text-5 m-0 mb-3 mt-5">Dejar un comentario</h3>

                                                    <form class="custom-form-simple-validation rounded" id="comment" action="comment" method="POST" >         
                                                        <input type="hidden" name='post_id' id='post_id'>
                                                        <input type="hidden" name='user_id' id='user_id' value='<?php echo $user_id; ?>'>
                                                        <div class="form-row">
                                                            <div class="form-group col mb-4">
                                                                <textarea maxlength="5000" data-msg-required="Please enter your message." rows="4" class="form-control border-0 custom-box-shadow-1 py-3 px-4 h-auto text-3 text-color-dark" name="message" id="message" placeholder="Comentario." required></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="form-row">
                                                            <div class='containerloader'>
                                                                <img src="http://localhost/atencionusuarios/wp-content/uploads/2020/10/toptal-blog-image-1489080120310-07bfc2c0ba7cd0aee3b6ba77f101f493.gif" class="loader" alt="">
                                                            </div>
                                                            <div class="form-group col mb-0">
                                                                <button type="submit" class="btn btn-secondary btn-outline text-color-dark font-weight-semibold border-width-4 custom-link-effect-1 text-1 text-xl-3 d-inline-flex align-items-center px-4 py-3" data-loading-text="Loading...">CARGAR <i class="custom-arrow-icon ml-5"></i></button>
                                                            </div>
                                                        </div>
                                                    </form>

                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>                                    
         
</div>

<?php 
        }else{
?>

    <div class="row" id='listadodenuncias' style='margin-top: 3%;' >

    <div class="col-listadodenuncias" style='margin:auto;' data-appear-animation="maskUp" data-appear-animation-delay="<?php echo ( 100+70*$countdenuncias ); ?>">
        <section class="call-to-action featured featured-primary mb-5">
                            <div class="col-12 col-lg-10" style="text-align:center; margin:auto;">
                                <div class="call-to-action-content">
                                <h3>
                                    <span class="text-primary font-weight-bold alternative-font-2" style='margin-right:40px;'>
                                      <strong>No posees denuncias</strong>
                                      <a href="/denuncias/">
                                      Hace click aquí para iniciar la primera.
                                      </a>
                                    </span> 
                                    
                                </h3>	
                                </div>
                            </div>
                    <div class="col-sm-3 col-lg-2">
                             <div class=""  >
                                <button type="button" class="btn btn-outline btn-quaternary rounded-0 mb-2 call-to-action-btn" id='<?php echo $denuncia->ID; ?>' data-servicio='<?php echo $dataservicio; ?>'>Ver mas</button>
                            </div>
                    </div>
        </section>
    </div>
    </div>
<?php
        }
?>