<?php

//Asocio id user
$user_id= get_current_user_id();
//Traigo los posts asociados al autor
$query = new WP_Query( array( 
    'author'    => $user_id, 
    'post_type' => 'denuncia', 
    ) );

$posts=$query->posts;

    $i=0;

?>
    <div  id='listadodenuncias'>
<?php
//Listo denuncias segun autor.
foreach( $posts as $denuncia){

    $direccion = get_post_meta( $denuncia->ID, 'direccion', true );
    $servicios=get_the_terms( $denuncia->ID, 'servicios' );
    $fecha=get_the_date( 'd M Y', $denuncia->ID );

?>

<section class="call-to-action with-borders mb-5" style="margin-bottom: 0px!important;" >
        <div class="col-sm-9 col-lg-9">
			<div class="call-to-action-content">
					<h3>Denuncia nro: <?php echo $denuncia->ID; ?>. <?php echo $servicios[0]->name; ?></h3>
					<p class="mb-0"><?php echo $fecha; ?> / <?php echo $direccion; ?></p>
			</div>
        </div>
        <div class="col-sm-3 col-lg-3">
			<div class="call-to-action-btn" id='<?php echo $denuncia->ID; ?>'>
				<p>Ver mas</p>
			</div>
		</div>
</section>
<?php
}
?>
    </div>

<div id='#denunciadetalle'>
        <div class="card border-0 border-radius-0 mb-5">
                    <div class="card-body p-0 z-index-1">


                <div class="row">
						<div class="col">
                            <?php
                                    /*
                                    *   Aqui jquery inseta info general de la denuncia
                                    */
                            ?>  
							<hr class="solid my-5">
                            <h4 id='nroanomaliaden'></h4>
                            <h4 id='estadoden'></h4>
                            <p  id='fechaden'></p>
                            <p  id='dirden'></p>
                            <p  id='barrioden'></p>
                            <p  id='obsden'></p>
						</div>
					</div>
				</div>

                    
				<div class="image-gallery sort-destination full-width" id='attacheds'>
                                    <?php
                                    /*
                                    *   Aqui jquery inseta fotos de denunciante y fiscalizaciones
                                    */
                                    ?>  
                </div>
                

                <div id="comments-div" class="post-block post-comments">
                    <h3 class="text-color-dark text-capitalize font-weight-bold text-5 m-0 mb-3">Comentarios</h3>

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
                                                        <div class="form-row">
                                                            <div class="form-group col mb-4">
                                                                <textarea maxlength="5000" data-msg-required="Please enter your message." rows="8" class="form-control border-0 custom-box-shadow-1 py-3 px-4 h-auto text-3 text-color-dark" name="message" id="message" placeholder="Comment" required></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="form-row">
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
