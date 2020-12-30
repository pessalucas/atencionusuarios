<?php

if ( isset( $_GET['id'] ) ){
	$id_denuncia = $_GET['id'];
	$type = $_GET['type'];
}

?>

<style>
.delete{
	margin: 12px;
    font-size: 17px;
    border: 1px solid grey;
    margin-left: 60px;
    margin-right: 60px;
    padding-top: 3px;
    padding-bottom: 3px;
}
.deletecomment{
	margin: 12px;
    font-size: 17px;
    border: 1px solid grey;
    margin-left: 60px;
    margin-right: 60px;
    padding-top: 3px;
    padding-bottom: 3px;

}

</style>

<div class="row">
						<div class="col">

							<div class="tabs tabs-bottom tabs-center tabs-simple">
								<ul class="nav nav-tabs">
									<li class="nav-item <?php if( $type == 'data' ){ echo 'active'; } ?>">
										<a class="nav-link <?php if( $type == 'data' ){ echo 'active'; } ?>" href="#tabsNavigationSimpleIcons1" data-toggle="tab">
											<span class="featured-boxes featured-boxes-style-6 p-0 m-0">
												<span class="featured-box featured-box-primary featured-box-effect-6 p-0 m-0" style="height: 100px;">
													<span class="box-content p-0 m-0">
														<i class="icon-featured fas fa-user"></i>
													</span>
												</span>
											</span>									
											<p class="mb-0 pb-0">Informacion General</p>
										</a>
									</li>
									<li class="nav-item <?php if( $type == 'file' ){ echo 'active'; } ?>">
										<a class="nav-link <?php if( $type == 'file' ){ echo 'active'; } ?>" href="#tabsNavigationSimpleIcons2" data-toggle="tab">
											<span class="featured-boxes featured-boxes-style-6 p-0 m-0">
												<span class="featured-box featured-box-primary featured-box-effect-6 p-0 m-0" style="height: 100px;">
													<span class="box-content p-0 m-0">
														<i class="icon-featured fas fa-file"></i>
													</span>
												</span>
											</span>									
											<p class="mb-0 pb-0">Rutas, Actas e Imagenes</p>
										</a>
									</li>
									<li class="nav-item  <?php if( $type == 'comment' ){ echo 'active'; } ?>">
										<a class="nav-link  <?php if( $type == 'comment' ){ echo 'active'; } ?>" href="#tabsNavigationSimpleIcons4" data-toggle="tab">
											<span class="featured-boxes featured-boxes-style-6 p-0 m-0">
												<span class="featured-box featured-box-primary featured-box-effect-6 p-0 m-0" style="height: 100px;">
													<span class="box-content p-0 m-0">
														<i class="icon-featured fas fa-adjust"></i>
													</span>
												</span>
											</span>									
											<p class="mb-0 pb-0">Comentarios</p>
										</a>
									</li>
								</ul>
								<div class="tab-content">
									<div class="tab-pane <?php if( $type == 'data' ){ echo 'active'; } ?>" id="tabsNavigationSimpleIcons1">
										<div class="text-center">
						<?php
								
								//Traigo info asociada al post, meta y taxonomys.
								$direccion = get_post_meta( $id_denuncia, 'direccion', true );
								$vereda    = get_post_meta( $id_denuncia, 'vereda', true );
								$barrio    = get_post_meta( $id_denuncia, 'barrio', true );
								$servicios = get_the_terms( $id_denuncia, 'servicios' );
								$obs       = get_post_meta( $id_denuncia, 'obs', true );
								$fecha     = get_the_date( 'd M Y', $id_denuncia );

								$lat = get_post_meta( $id_denuncia, 'geolat', true );
								$long    = get_post_meta( $id_denuncia, 'geolong', true );

								$urlmap = 'https://servicios.usig.buenosaires.gov.ar/LocDir/mapa.phtml?x=' . $lat . '&y=' . $long . '&h=800&w=800&punto=1&r=250';

								//Busco el child id de menor jerarquia
								$count = 0;
								foreach ( $servicios as $servicio ) {
								if( ! get_term_children( $servicios[$count]->term_id, 'servicios' ) ){
									$term_id_anomalia = $servicios[$count]->term_id; }
									$count ++ ;
								}
									
								//Genero una array con las categorias asociadas a la anomalia, de menor jerarquia con orden y estrucutra de array para recorrer
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
				
								//Traigo los datos asociados a los IDs de las terms de Servicios
								$anomalia       = get_term_by('id', $ids_anomalia[0] , 'servicios');
								$grupoanomalia  = get_term_by('id', $ids_anomalia[1] , 'servicios');
								$servicio       = get_term_by('id', $ids_anomalia[2] , 'servicios');
								$depto          = get_term_by('id', $ids_anomalia[3] , 'servicios');

								//Traigo la empresa asociada al post
								$empresa = get_the_terms( $id_denuncia, 'empresa' );
				
								//Traigo la comuna asociada al post
								$comuna  = get_the_terms( $id_denuncia, 'comuna' );

								//Traigo la comuna asociada al post
								$procedencia  = get_the_terms( $id_denuncia, 'procedencia' );
				
								//Traigo estado asociada al post
								$estado  = get_the_terms( $id_denuncia, 'estado' );

								if ( $direccion ){ 
								$address=$direccion;
								}else{
								$address='CABA';
								}

						?>
										<div class="row" style='margin-bottom:10px'>
											<div class="col">
												<h4>Denuncia realizada</h4>
													<div class='datosdiv'>
														<label>Numero de denuncia:</label>
														<p><?php echo $id_denuncia; ?></p>
													</div>
													<div  class='datosdiv'>
													<label>Departamento a cargo:</label>
													<p><?php echo $depto->name; ?></p>
													</div>
													<div  class='datosdiv'>
													<label>Servicio:</label>
													<p><?php echo $servicio->name; ?></p>
													</div>
													<div  class='datosdiv'>
													<label>Anomalia:</label>
													<p style='text-align:right;'><?php echo $grupoanomalia->name . ' <br> ' . $anomalia->name; ?></p>
													</div>
													<div  class='datosdiv'>
													<label>Fecha de denuncia:</label>
													<p><?php echo $fecha; ?></p>
													</div>
													<div  class='datosdiv'>
													<label>Direccion:</label>
													<p><?php if ( $vereda ){ echo $direccion . ' - ' .$vereda; }else{ echo $direccion; } ?></p>
													</div>
													<div  class='datosdiv'>
													<label>Empresa:</label>
													<p><?php if ( $empresa ){ echo $empresa[0]->name; }else{ echo 'N/I'; } ?></p>
													</div>
													<div  class='datosdiv'>
													<label>Comuna:</label>
													<p><?php if ( $direccion ){  echo $comuna[0]->name; } ?></p>
													</div>
													<div  class='datosdiv'>
													<label>Barrio:</label>
													<p><?php if ( $direccion ){  echo $barrio; } ?></p>
													</div>
													<div  class='datosdiv'>
													<label>Observacion:</label>
													<p><?php echo $obs; ?></p>
													</div>
												</div>
											<div class="col" style='position:relative; overflow:hidden; min-height: 300px;'>
													<img src="<?php echo $urlmap; ?>" alt="" style='position: absolute; left: 50%; top: 50%; -webkit-transform: translateY(-50%) translateX(-50%);' id='map'>
											</div>
										</div>
										<div class="row">
											<div class="col" style='width:50%;'>
												<h4>Informacion del denunciante</h4>
						<?php
								$data_denuncia = get_post($id_denuncia);
								$user_id  = $data_denuncia->post_author;
								
								$nicename = get_the_author_meta( 'nicename', $user_id );
								$email = get_the_author_meta( 'email', $user_id );
								$dni = get_the_author_meta( 'dni', $user_id );
								$telefono = get_the_author_meta( 'telefono', $user_id );
								$direccion = get_the_author_meta( 'direccion', $user_id );
						?>
												<div  class='datosdiv'>
													<label>Nombre y apellido</label>
													<p><?php echo $nicename; ?></p>
												</div>
												<div  class='datosdiv'>
													<label>Email (Para el accceso de usuario)</label>
													<p><?php echo $email; ?></p>
												</div>
												<div  class='datosdiv'>
													<label>DNI</label>
													<p><?php echo $dni; ?></p>
												</div>
												<div  class='datosdiv'>
													<label>Direccion</label>
													<p><?php echo $direccion; ?></p>
												</div>
												<div  class='datosdiv'>
													<label>Telefono</label>
													<p><?php echo $telefono; ?></p>
												</div>
											</div>
						<?php
								$expediente = get_post_meta( $id_denuncia ,'expediente', true );
						?>
											<div class="col"  style='width:50%;'>
												<h4>Numero de expediente</h4>
												<div  class='datosdiv'>
													<label>Codigo</label>
													<input type="text" name='nroexpediente' id='nroexpediente' placeholder='xxxxxx/E/xxx'  data-id_denuncia='<?php echo $id_denuncia; ?>'  value='<?php echo $expediente; ?>' style='border: 1px solid grey; text-align: center;'>
												</div>
												<h4>Procedencia de denuncia</h4>
												<p><?php echo $procedencia[0]->name; ?></p>
												<h4>Estado de denuncia</h4>
												
												<select name="estado" id='estado' data-id_denuncia='<?php echo $id_denuncia; ?>' style='border: none; color: white; padding: 5px; width: 50%;'>
																<?php  

																	print_r($estado);
																	//Genero la estrucutra de los diferentes tipos de denuncia que se pueden lograr
																	$terms_estados = get_terms( array(
																		'taxonomy' => 'estado',
																		'hide_empty' => false,
																		'parent'   => 0
																	) );
																		foreach ( $terms_estados as $terms_estado ) {
																			$id_estado = $terms_estado->term_id;
																			$name_estado = $terms_estado->name;

																	
																?>
																	<option value="<?php echo $id_estado; ?>" <?php if( $id_estado == $estado[0]->term_id ){ echo 'selected'; } ?> ><?php echo $name_estado; ?></option>
																<?php  
																
																			$terms_subestados = get_terms( array(
																				'taxonomy' => 'estado',
																				'hide_empty' => false,
																				'parent'   => $id_estado
																			) );
																			
																			foreach ( $terms_subestados as $terms_subestado ){
																				$subestado_id = $terms_subestado->term_id;
																				$subestado_name =  $terms_subestado->name;
																?>
																			<option value="<?php echo $subestado_id; ?>" <?php if( $estado[1]->term_id ){ if (( $subestado_id == $estado[1]->term_id ) OR ( $subestado_id == $estado[0]->term_id ) ){ echo 'selected'; }} ?> >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $subestado_name; ?></option>
																		<?php  
																			}}
																?>
												</select><br><br>
											</div>
										</div>
											<div class="row" style='margin:20px;'>
												<h4 style='text-align:center; margin:auto; margin-bottom:10px;'>Historial de eventos</h4>			
												<table class="table table-sm" id='tablelisthistorial'>
													<thead>
														<tr>
															<th>
																Nuevo estado
															</th>
															<th>
																Observacion
															</th>
															<th>
																Fecha y hora
															</th>
															<th>
																Usuario
															</th>
														</tr>
													</thead>
													<tbody id='tbodylisthistorial'>
														<?php 

														select_eventos( $id_denuncia );

														?>

													</tbody>
												</table>
												<form method='GET' action='/atencionusuarios/administrador/newpdf/' target="_blank">
													<input type="hidden" name='nrodenuncia' value='<?php echo $id_denuncia; ?>'>
													<button type='submit'class='buttonmas buttonmaspage' id='prepage'>Imprimir denuncia</button>
												</form>
											</div>
										</div>
									</div>
									<div class="tab-pane <?php if( $type == 'file' ){ echo 'active'; } ?>" id="tabsNavigationSimpleIcons2">
										<div class="text-center">
											<h4>Publicas (Solo imagenes) </h4>
											<div class="image-gallery sort-destination full-width">
						<?php
								//Tomo los atachmente de la denuncia y genero una array para el envio de informacion
								$attacheds = get_attached_media( '' , $id_denuncia );
								foreach ($attacheds as $attached){
									//print_r($attached);
									$img_src = wp_get_attachment_image_src($attached->ID, 'small');
									$attachment_metadata = wp_get_attachment_metadata( $attached->ID );
									$attached_id    = $attached->ID;
									$attached_user  = get_the_author_meta( 'email',  $attached->post_author );
									$attached_date  = $attached->post_date;
									if( isset( $img_src[0] ) ){ 
									$attached_guid  = $img_src[0]; }
									$attached_type  = $attachment_metadata['attachment_type']; 
									if ( ( $attached_type == 'Fiscalizacion' ) OR ( $attached_type == 'FotoDenunciante' ) ){ 
						?>	
													<div class="isotope-item">
														<div class="image-gallery-item">
															<a href="<?php echo $attached_guid; ?>" target='_blank'>
																<span class="thumb-info thumb-info-centered-info thumb-info-no-borders">
																	<span class="thumb-info-wrapper">
																		<img src="<?php echo $attached_guid; ?>" class="img-fluid" alt="">
																		<span class="thumb-info-title">
																			<span class="thumb-info-inner"><?php echo $attached_user; ?></span>
																			<span class="thumb-info-type"><?php echo $attached_date; ?></span>
																		</span>
																		<span class="thumb-info-action">
																			<span class="thumb-info-action-icon"><i class="fas fa-plus"></i></span>
																		</span>
																	</span>
																</span>
															</a>
															<?php	
															$user = wp_get_current_user();
															if( ! empty( $user ) && in_array( "usuariosjefe", (array) $user->roles ) ) { 	    ?>
																<div class="delete" data-id_attachment='<?php echo $attached_id; ?>' >
																		<span class="thumb-info-action-icon">Borrar <i class="fas fa-ban"></i></span>
																</div>
															<?php	 }	    ?>
														</div>
													</div>
						<?php	} }	    ?>
												</div>
										<form method='POST' id="loadpublic" enctype="multipart/form-data" >
											<input type="hidden" name="MAX_FILE_SIZE" value="30000" />
												<?php	
											$user = wp_get_current_user();
											if( ! empty( $user ) &&  ! in_array( "control", (array) $user->roles ) ) { ?>
											<label>Realiza la carga de la imagen</label> <br>
											<input type = "file" name = "files[]" class = "files-data form-control" multiple 
												style='     border: none;
															text-align: center!important;
															margin: auto;
															padding-left: 40%;' />
											<input type="hidden" name='public' id='public' value='public'>
											<input type="hidden" name='post_id' id='post_id' value='<?php echo $id_denuncia; ?>'>
											<div class='containerloader'>
												<img src="http://localhost/atencionusuarios/wp-content/uploads/2020/10/loading-45.gif" class="loader" alt="">
											</div>
												<button type='submit' class='buttonmas' >Cargar</button>
											<?php }  ?>
										</form>
											<h4 style='margin-top:15px;'>Privadas</h4>
											<div class="image-gallery sort-destination full-width">
						<?php
								//Tomo los atachmente de la denuncia y genero una array para el envio de informacion
								$attacheds = get_attached_media( '' , $id_denuncia );
								foreach ($attacheds as $attached){
									$img_src = wp_get_attachment_image_src($attached->ID, 'small');
									$attachment_metadata = wp_get_attachment_metadata( $attached->ID );
									$attached_id    = $attached->ID;
									$attached_user  = get_the_author_meta( 'email',  $attached->post_author );
									$attached_date  = $attached->post_date;
									if( isset( $img_src[0] ) ){ 
									$attached_guid  = $img_src[0]; }
									$attached_type  = $attachment_metadata['attachment_type']; 
									
									if ( ( $attached_type == 'Otros' ) ){ 
						?>	
													<div class="isotope-item">
														<div class="image-gallery-item">
																<?php 	if ( ( $attached->post_mime_type == 'image/jpeg' ) OR ( $attached->post_mime_type == 'image/png' ) OR ( $attached->post_mime_type == 'image/jpg' ) ) {  ?>
																	<a href="<?php echo $attached_guid; ?>" target='_blank'>
																		<span class="thumb-info thumb-info-centered-info thumb-info-no-borders">
																			<span class="thumb-info-wrapper">
																				<img src="<?php echo $attached_guid; ?>" class="img-fluid" alt="">
																				<span class="thumb-info-title">
																					<span class="thumb-info-inner"><?php echo $attached_user; ?></span>
																					<span class="thumb-info-type"><?php echo $attached_date; ?></span>
																				</span>
																				<span class="thumb-info-action">
																					<span class="thumb-info-action-icon"><i class="fas fa-plus"></i></span>
																				</span>
																			</span>
																		</span>
																	</a>
																	<?php	
																		$user = wp_get_current_user();
																		if( ! empty( $user ) && in_array( "usuariosjefe", (array) $user->roles ) ) { 	    ?>
																			<div class="delete" data-id_attachment='<?php echo $attached_id; ?>' >
																					<span class="thumb-info-action-icon">Borrar <i class="fas fa-ban"></i></span>
																			</div>
																	<?php	 }	    ?>
																<?php	 }else{ 
																	$url = wp_get_attachment_url( $attached_id )
																?>
																	<a href="<?php echo $url; ?>" target='_blank'>
																		<span class="thumb-info thumb-info-centered-info thumb-info-no-borders">
																			<span class="thumb-info-wrapper">
																				<img src="http://localhost/atencionusuarios/wp-content/uploads/2020/10/yGa0X.png" class="img-fluid" alt="">
																				<span class="thumb-info-title">
																					<span class="thumb-info-inner"><?php echo $attached_user; ?></span>
																					<span class="thumb-info-type"><?php echo $attached_date; ?></span>
																				</span>
																			</span>
																			<span class="thumb-info-action">
																					<span class="thumb-info-action-icon"><i class="fas fa-plus"></i></span>
																			</span>
																		</span>
																	</a>
																	<?php	
																		$user = wp_get_current_user();
																		if( ! empty( $user ) && in_array( "usuariosjefe", (array) $user->roles ) ) { 	    ?>
																			<div class="delete" data-id_attachment='<?php echo $attached_id; ?>' >
																					<span class="thumb-info-action-icon">Borrar <i class="fas fa-ban"></i></span>
																			</div>
																	<?php	 }	    ?>
																<?php }	?>

														</div>
													</div>
						<?php	} }	    ?>
												</div>
										<form method='POST' id="loadprivate" enctype="multipart/form-data" >
											<input type="hidden" name="MAX_FILE_SIZE" value="30000" />
												<label>Realiza la carga de la imagen</label> <br>
												<input type = "file" name = "files[]" class = "files-data form-control" multiple 
												style='     border: none;
															text-align: center!important;
															margin: auto;
															padding-left: 40%;' />
											<input type="hidden" name='private' id='private' value='private'>
											<input type="hidden" name='post_id' id='post_id' value='<?php echo $id_denuncia; ?>'>
											<div class='containerloader'>
												<img src="http://localhost/atencionusuarios/wp-content/uploads/2020/10/loading-45.gif" class="loader" alt="">
											</div>
											<button type='submit' class='buttonmas' >Cargar</button>
										</form>
										</div>
									</div>
									<div class="tab-pane <?php if( $type == 'comment' ){ echo 'active'; } ?>" id="tabsNavigationSimpleIcons4">
										<div class="text-center">
											<h4>Publicos</h4>
													<div class='commentscontainer'>
															<ul class="comments" id='commentsmainpublic'>
																	<?php
																	//Traigo el user id
																	$user_id = get_current_user_id();

																	//Tomo los comentarios de la id den
																	$args = array(
																		'post_id' => $id_denuncia, 
																		'orderby' => 'date',
																		'order'   => 'ASC'
																	);
																	$comments = get_comments( $args );  //array
																	
																	foreach ( $comments as $comment ){ 
																		if ( $comment->comment_type == 'public' ){ 
																			//print_r($comment);
																	?>  
																		<li>
																			<div class="comment" data-appear-animation="maskUp" data-appear-animation-delay="200">
																				<div class="comment-block">
																					<?php	
																						$user = wp_get_current_user();
																						if( ! empty( $user ) && in_array( "usuariosjefe", (array) $user->roles ) ) { 	    ?>
																							<div class="deletecomment" data-id_comment='<?php echo $comment->comment_ID; ?>' >
																								<span class="thumb-info-action-icon">Borrar <i class="fas fa-ban"></i></span>
																							</div>
																					<?php	 }	    ?>
																					<span class="comment-by">
																						<strong class="text-dark"><?php echo $comment->comment_author; ?></strong>
																					</span>
																					<p><?php echo $comment->comment_content; ?></p>
																					<span class="date float-right"><?php echo $comment->comment_date; ?></span>
																				</div>
																			</div>
																		</li>
																<?php	}}	?>  
																</ul>
																<form class="custom-form-simple-validation rounded" id="commentpublic"  post="commentpublic" method="POST" >         
																		<input type="hidden" name='id_denuncia' id='id_denuncia' value='<?php echo $id_denuncia; ?>'>
																		<input type="hidden" name='user_id' id='user_id' value='<?php echo $user_id; ?>'>
																		<input type="hidden" name='public' id='public' value='public'>
																		<?php	
																				$user = wp_get_current_user();
																				if( ! empty( $user ) &&  ! in_array( "control", (array) $user->roles ) ) { 	?>	
																		<div class="form-row">
																			<div class="form-group col mb-4">
																				<textarea maxlength="5000" data-msg-required="Please enter your message." rows="4" class="form-control border-0 custom-box-shadow-1 py-3 px-4 h-auto text-3 text-color-dark" name="message" id="message" placeholder="Comment" required></textarea>
																			</div>
																		</div>
																		<div class="form-row">
																			<div class="form-group col mb-0">
																				<button type="submit" class="btn btn-secondary btn-outline text-color-dark font-weight-semibold border-width-4 custom-link-effect-1 text-1 text-xl-3 d-inline-flex align-items-center px-4 py-3" data-loading-text="Loading...">CARGAR <i class="custom-arrow-icon ml-5"></i></button>
																			</div>
																		</div>
																		<?php	 }	    ?>
																</form>
													</div>
											<h4>Privados</h4>
													<div  class='commentscontainer'>
															<ul class="comments" id='commentsmainprivate'>
																	<?php

																	//Tomo los comentarios de la id den
																	$args = array(
																		'post_id' => $id_denuncia, 
																		'orderby' => 'date',
																		'order'   => 'ASC'
																	);
																	$comments = get_comments( $args );  //array
																	
																	foreach ( $comments as $comment ){ 
																		if ( $comment->comment_type == 'private' ){ 
																	?>  
																		<li>
																			<div class="comment" data-appear-animation="maskUp" data-appear-animation-delay="200">
																				<div class="comment-block">
																					<?php	
																						$user = wp_get_current_user();
																						if( ! empty( $user ) && in_array( "usuariosjefe", (array) $user->roles ) ) { 	    ?>
																							<div class="deletecomment" data-id_comment='<?php echo $comment->comment_ID; ?>' >
																								<span class="thumb-info-action-icon">Borrar <i class="fas fa-ban"></i></span>
																							</div>
																					<?php	 }	    ?>
																					<span class="comment-by">
																						<strong class="text-dark"><?php echo $comment->comment_author; ?></strong>
																					</span>
																					<p><?php echo $comment->comment_content; ?></p>
																					<span class="date float-right"><?php echo $comment->comment_date; ?></span>
																				</div>
																			</div>
																		</li>
																<?php	}}	?>  
																</ul>
																<form class="custom-form-simple-validation rounded" id="commentprivate"  post="commentpublic" method="POST" >         
																		<input type="hidden" name='id_denuncia' id='id_denuncia' value='<?php echo $id_denuncia; ?>'>
																		<input type="hidden" name='user_id' id='user_id' value='<?php echo $user_id; ?>'>
																		<input type="hidden" name='private' id='private' value='private'>
																		<div class="form-row">
																			<div class="form-group col mb-4">
																				<textarea maxlength="5000" data-msg-required="Please enter your message." rows="4" class="form-control border-0 custom-box-shadow-1 py-3 px-4 h-auto text-3 text-color-dark" name="message" id="message" placeholder="Comment" required></textarea>
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
						</div>
					</div>