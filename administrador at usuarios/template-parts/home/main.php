<?php 
/*
** Main del Home. Searcher de denuncias y listado.
*
*/

function AsignarColorEstado( $NuevoEstado ){
	//Asigno el background correspondiente.
	if( $NuevoEstado == 'Pre-Abierto' ){
		$SelectorEstado = "#DC143C";
	}else if( $NuevoEstado == 'Abierto' ){
		$SelectorEstado = "#8B0000";
	}else if(( $NuevoEstado == 'Cerrado' )||( $NuevoEstado == 'Pendiente' )||( $NuevoEstado == 'Resuelto' )){
		$SelectorEstado = "#FFD700";
	}else if(( $NuevoEstado == 'Fiscalización 1era' )||( $NuevoEstado == 'Fiscalización Nro' )){
		$SelectorEstado = "#FF8C00";
	}else if(( $NuevoEstado == 'Programado 1era' )||( $NuevoEstado == 'Programado Nro' )){
		$SelectorEstado = "#FF7F50";
	}else if(( $NuevoEstado == 'Sumario' )||( $NuevoEstado == 'Generado' )||( $NuevoEstado == 'Pendiente' )){
		$SelectorEstado = "#006400";
	}else{
		$SelectorEstado = "grey";
	}
	return $SelectorEstado;
}

?>

<form method="POST" id='formsearch' class='searcher'>
	<div class="row rowadapt">
		<div class="col-3">
				<input type="text" id='nrodenuncia' name='nrodenuncia' placeholder='Nro Denuncia' style='margin-left:10px; width:250px'><br>
				<input type="text" name="calle" id="calle" placeholder='Calle' style='margin-left:10px; margin-top:10px; width:250px'><br>
				<input type="text" name="email" id="email" placeholder='xxx@xxx.com' style='margin-left:10px; margin-top:10px; width:250px'>
		</div>
		<div class="col-3">
			<label>Fecha, desde</label><br>
				<input type="date" id='fechadesde' name='fechadesde' style='margin-left:15px; width:250px' ><br>
			<label>Fecha, hasta</label><br>
				<input type="date" id='fechahasta' name='fechahasta' style='margin-left:15px; width:250px'><br>
		</div>
		<div class="col-3">
			<label>Servicio</label><br>
				<select name="servicio" id='servicio' style='margin-left:15px; width:250px'>
					<option value="">Todos</option>
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
			?>
					<option value="<?php echo $servicios_id; ?>"><?php echo $servicios_name; ?></option>
			<?php 	}}	?>
				</select><br>
			<label>Procedencia</label><br>
				<select name="procedencia" id="procedencia" style='margin-left:15px; width:250px'>
						<option value="">Todas</option>
				<?php	
					//Genero la estrucutra de los diferentes tipos de denuncia que se pueden lograr
					$terms_procedencias = get_terms( array(
						'taxonomy' => 'procedencia',
						'hide_empty' => false,
						'parent'   => 0
					) );

					foreach ( $terms_procedencias as $terms_procedencia ){
						$procedencia_id = $terms_procedencia->term_id;
						$procedencia_name =  $terms_procedencia->name;
				?>
					<option value="<?php echo $procedencia_id; ?>"><?php echo $procedencia_name; ?></option>
				<?php } ?>
				</select><br>
		</div>
		<div class="col-3">
			<label>Barrios</label><br>
				<select name="barrios" id="barrios" style='margin-left:15px; width:250px'>
					<option value="">Todos</option>
					<option value="Agronomía">Agronomía</option>
					<option value="Almagro">Almagro</option>
					<option value="Balvanera">Balvanera</option>
					<option value="Barracas">Barracas</option>
					<option value="Belgrano">Belgrano</option>
					<option value="Boedo">Boedo</option>
					<option value="Caballito">Caballito</option>
					<option value="Chacarita">Chacarita</option>
					<option value="Coghlan">Coghlan</option>
					<option value="Colegiales">Colegiales</option>
					<option value="Constitución">Constitución</option>
					<option value="Flores">Flores</option>
					<option value="Floresta">Floresta</option>
					<option value="La Boca">La Boca</option>
					<option value="La Paternal">La Paternal</option>
					<option value="Liniers">Liniers</option>
					<option value="Mataderos">Mataderos</option>
					<option value="Monte Castro">Monte Castro</option>
					<option value="Monserrat">Monserrat</option>
					<option value="Nueva Pompeya">Nueva Pompeya</option>
					<option value="Núñez">Núñez</option>
					<option value="Palermo">Palermo</option>
					<option value="Parque Avellaneda">Parque Avellaneda</option>
					<option value="Parque Chacabuco">Parque Chacabuco</option>
					<option value="Parque Chas">Parque Chas</option>
					<option value="Parque Patricios">Parque Patricios</option>
					<option value="Puerto Madero">Puerto Madero</option>
					<option value="Recoleta">Recoleta</option>
					<option value="Retiro">Retiro</option>
					<option value="Saavedra">Saavedra</option>
					<option value="San Cristóbal">San Cristóbal</option>
					<option value="San Nicolás">San Nicolás</option>
					<option value="San Telmo">San Telmo</option>
					<option value="Vélez Sársfield">Vélez Sársfield</option>
					<option value="Versalles">Versalles</option>
					<option value="Villa Crespo">Villa Crespo</option>
					<option value="Villa del Parque">Villa del Parque</option>
					<option value="Villa Devoto">Villa Devoto</option>
					<option value="Villa General Mitre">Villa General Mitre</option>
					<option value="Villa Lugano">Villa Lugano</option>
					<option value="Villa Luro">Villa Luro</option>
					<option value="Villa Ortúzar">Villa Ortúzar</option>
					<option value="Villa Pueyrredón">Villa Pueyrredón</option>
					<option value="Villa Real">Villa Real</option>
					<option value="Villa Riachuelo">Villa Riachuelo</option>
					<option value="Villa Santa Rita">Villa Santa Rita</option>
					<option value="Villa Soldati">Villa Soldati</option>
					<option value="Villa Urquiza">Villa Urquiza</option>
				</select><br>
			<label>Comuna</label><br>
				<select name="comuna" id="comuna" style='margin-left:15px; width:250px'>
					<option value="">Todas</option>
				<?php 
					//Genero la estrucutra de los diferentes tipos de denuncia que se pueden lograr
					$terms_comunas = get_terms( array(
						'taxonomy' => 'comuna',
						'hide_empty' => false,
						'parent'   => 0
					) );

					foreach ( $terms_comunas as $terms_comuna ){
						$comuna_id = $terms_comuna->term_id;
						$comuna_name =  $terms_comuna->name;
				?>
					<option value="<?php echo $comuna_id; ?>"><?php echo $comuna_name; ?></option>
				<?php } ?>
				</select><br>
				<label><input type="checkbox" id="export" name='export' value="export"> Lista completa para exportar excel.</label><br>
				<p style="margin:5px; padding:4px;">
					<a href="#" class="buttoncarga" id="submitExport">
						<i class="fa fa-download"></i> Exportar a Excel
					</a>
        		</p>
		</div>
	</div>

	<div class="row" style='display:flex; justify-content:space-around; margin-top: 10px;'>
		<button type='submit' name='todos' id='todos' class='buttonssearch' style='background-color:grey;'>Buscar<span class='postscantidad'></span></button>
	</div>
	<div class="row" style='display:flex; justify-content:space-around;'>
			<?php
				//Conteo de posts de denuncia abiertos y pre abiertos
					$args = array(
					'post_type' => 'denuncia',
					'tax_query' => array(
						array(
						'taxonomy' => 'estado',
						'field' => 'slug',
						'terms' => 'pre-abierto'
						)
					)
				);
				$query = new WP_Query( $args ); 
			?>
		<button type='submit' name='pre-abierto' id='pre-abierto' class='buttonssearch' style='background-color:#DC143C;'>Pre-Abierto <span class='postscantidad' >(<?php echo $query->found_posts; ?>)</span></button>
			<?php
				//Conteo de posts de denuncia abiertos y pre abiertos
					$args = array(
					'post_type' => 'denuncia',
					'tax_query' => array(
						array(
						'taxonomy' => 'estado',
						'field' => 'slug',
						'terms' => 'abierto'
						)
					)
				);
				$query = new WP_Query( $args ); 
			?>
		<button type='submit' name='abierto' id='abierto'  class='buttonssearch' style='background-color:#8B0000;'>Abierto <span class='postscantidad' >(<?php echo $query->found_posts; ?>)</span></button>
		<button type='submit' name='programado-1era' id='programado-1era'  class='buttonssearch' style='background-color:#FF7F50;'>Programado 1era<span class='postscantidad'></span></button>
		<button type='submit' name='fiscalizacion-1era' id='fiscalizacion-1era'  class='buttonssearch' style='background-color:#FF8C00;'>Fiscalizacion 1era<span class='postscantidad'></span></button>
		<button type='submit' name='programado-nro' id='programado-nro' class='buttonssearch' style='background-color:#FF7F50;'>Programado Nro<span class='postscantidad'></span></button>
		<button type='submit' name='fiscalizacion-nro' id='fiscalizacion-nro'  class='buttonssearch' style='background-color:#FF8C00;'>Fiscalizacion Nro<span class='postscantidad'></span></button>
		<button type='submit' name='comunicacion-externa' id='comunicacion-externa' class='buttonssearch' style='background-color:grey;'>Com Externa<span class='postscantidad'></span></button>
	</div>
	<div class="row" style='display:flex; justify-content:space-around;'>
		<button type='submit' name='sumario' id='sumario'  class='buttonssearch' style='background-color:#006400;'>Sumario<span class='postscantidad'></span></button>
		<button type='submit' name='pendiente' id='pendiente'  class='buttonssearch' style='background-color:#B22222;'>Pendiente<span class='postscantidad'></span></button>
		<button type='submit' name='generado' id='generado'  class='buttonssearch' style='background-color:#006400;'>Generado<span class='postscantidad'></span></button>
		<button type='submit' name='cerrado' id='cerrado' class='buttonssearch' style='background-color:#FFD700;'>Cerrado<span class='postscantidad'></span></button>
		<button type='submit' name='pendiente-2' id='pendiente-2'  class='buttonssearch' style='background-color: #B22222;'>Pendiente<span class='postscantidad'></span></button>
		<button type='submit' name='resuelto' id='resuelto'  class='buttonssearch' style='background-color:#006400;'>Resuelto<span class='postscantidad'></span></button>
		<button type='submit' name='no-corresponde' id='no-corresponde'  class='buttonssearch' style='background-color: #8B0000;'>No corresponde<span class='postscantidad'></span></button>
	</div>
</form>


								<table class="table table-hover" id='export_to_excel'>
										<thead>
											<tr>
												<th>
													Nro
												</th>
												<th>
													Servicio / Empresa
												</th>
												<th>
													Anomalia
												</th>
												<th>
													Dirección
												</th>
												<th>
													Observaciones
												</th>
												<th>
													Fecha
												</th>
												<th>
													Estado
												</th>
												<th>
													Acción
												</th>
											</tr>
										</thead>
										<tbody id='listado-denuncias'>
				<?php 
				
				   //Traigo los posts asociados por orden de fecha descreciente
				   $query = new WP_Query( array( 
					'posts_per_page'    => '30',
					'paged'             => '1',
					'post_type'         => 'denuncia', 
					'orderby'           => 'date',
					'order'             => 'DESC'
					) );
					//Verifico si posee denuncias asociadas
					if ( $posts = $query->posts ) {
						foreach( $posts as $denuncia ){
							
							//Traigo info asociada al post, meta y taxonomys.
							$direccion = get_post_meta( $denuncia->ID, 'direccion', true );
							$vereda    = get_post_meta( $denuncia->ID, 'vereda', true );
							$barrio    = get_post_meta( $denuncia->ID, 'barrio', true );
							$servicios = get_the_terms( $denuncia->ID, 'servicios' );
							$obs       = get_post_meta( $denuncia->ID, 'obs', true );
							$fecha     = get_the_date( 'd M Y', $denuncia->ID );

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
							$data_anomalia  = get_term_by('id', $ids_anomalia[0] , 'servicios');
							$data_grupoanomalia  = get_term_by('id', $ids_anomalia[1] , 'servicios');
							$data_servicios = get_term_by('id', $ids_anomalia[2] , 'servicios');

							//Traigo la empresa asociada al post
							$data_empresa = get_the_terms( $denuncia->ID, 'empresa' );

							//Traigo la comuna asociada al post
							$data_comuna = get_the_terms( $denuncia->ID, 'comuna' );

							//Traigo estado asociada al post
							$data_estado = get_the_terms( $denuncia->ID, 'estado' );
					
							?>
								<tr>
									<td>
										<?php echo $denuncia->ID; ?>
									</td>
									<td>
										<?php echo $data_servicios->name; ?>
										
										<?php if (  $data_empresa ) { ?>
											<p  style='border-top: 1px solid grey; color: #212529; font-size: 12px;' >
											<?php echo $data_empresa[0]->name; ?>
											</p>
										<?php	} ?>
										
									</td>
									<td>
										<?php echo $data_grupoanomalia->name; ?>
										<br>
										<?php echo $data_anomalia->name; ?>
									</td>
									<td>
										<?php 
										if ( $direccion ){ 
											if ( $vereda ){ echo $direccion . ' - ' .$vereda; }else{ echo $direccion; } 
										?>
										<br>
										<?php echo $barrio; ?>
										<br>
										<?php echo $data_comuna[0]->name; } ?>
									</td>
									<td>
										<?php echo $obs; ?>
									</td>
									<td style='min-width: 96px;'>
										<?php echo $denuncia->post_date; ?>
									</td>
									<?php 
									if( isset ( $data_estado[1] ) ){ 
										$colorEstado = AsignarColorEstado( $data_estado[1]->name );
									}else{
										$colorEstado = AsignarColorEstado( $data_estado[0]->name );
									}
								 ?>
									<td style='position:relative;'>
									<p style='position:absolute; top: 15px; text-align: center;  padding: 4px;  color: white; background-color: <?php echo $colorEstado; ?>'>
                            			<?php if( isset ( $data_estado[1] ) ){ echo $data_estado[0]->name . '<br>-' . $data_estado[1]->name;  }else{ echo $data_estado[0]->name; } ?>
									</p>
									<?php if( isset ( $data_estado[1] ) ){ echo $data_estado[0]->name . '<br>-' . $data_estado[1]->name;  }else{ echo $data_estado[0]->name; } ?>
									</td>
									<td>
										<form action="http://localhost/atencionusuarios/administrador/denunciapost" method='GET'>
											<input type="hidden" value='<?php echo $denuncia->ID; ?>' name='id'>
											<input type="hidden" value='data' name='type'>
											<button type='submit'  class='buttonmas' style='margin: 3px;'><i class="icon-featured fas fa-user" style='font-size:12px; width:20px; height:auto; margin:5px;'></i></button>
										</form>

										<form action="http://localhost/atencionusuarios/administrador/denunciapost" method='GET'>
											<input type="hidden" value='<?php echo $denuncia->ID; ?>' name='id'>
											<input type="hidden" value='file' name='type'>
											<button type='submit' class='buttonmas'  style='margin: 3px;'><i class="icon-featured fas fa-file" style='font-size:12px; width:20px; height:auto; margin:5px;'></i></button>
										</form>

										<form action="http://localhost/atencionusuarios/administrador/denunciapost" method='GET'>
											<input type="hidden" value='<?php echo $denuncia->ID; ?>' name='id'>
											<input type="hidden" value='comment' name='type'>
											<button type='submit' class='buttonmas'  style='margin: 3px;'><i class="icon-featured fas fa-adjust" style='font-size:10px; width:20px; height:auto; margin:5px;'></i></button>
										</form>
									</td>
								</tr>
							<?php 
							
						}	}

				?>
										</tbody>
									</table>
								

	<form method='POST' id='nextpage'>
		<input type="hidden" id='nrodenuncia' name='nrodenuncia' value=''>
		<input type="hidden" id='fechadesde' name='fechadesde' value=''>
		<input type="hidden" id='fechahasta' name='fechahasta' value=''>
		<input type="hidden" id='barrios' name='barrios' value=''>
		<input type="hidden" id='comuna' name='comuna' value=''>
		<input type="hidden" id='servicio' name='servicio' value=''>
		<input type="hidden" id='procedencia' name='procedencia' value=''>
		<input type="hidden" id='calle' name='calle' value=''>
		<input type="hidden" id='email' name='email' value=''>
		<input type="hidden" id='estado' name='estado' value='todos'>
		<input type="hidden" id='pagina' name='pagina' value='1'>
		<button type='submit'class='buttonmas buttonmaspage' id='prepage'>Pagina Anterior</button>
		<button type='submit'class='buttonmas buttonmaspage' id='proxpage'>Proxima Pagina</button>
	</form>

        <form action="../html/wp-admin/process.php" method="post" target="_blank" id="formExport">
            <input type="hidden" id="data_to_send" name="data_to_send" />
        </form>

