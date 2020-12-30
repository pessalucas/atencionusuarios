<?php
/**
 * FormBox: Formulario de login.
 *
 * @package AtencionUsuarios
 */

?>
<div class="featured-box featured-box-primary text-left mt-5">
	<div class="box-content">
		<h4 class="color-primary font-weight-semibold text-4 text-uppercase mb-3">Ya tengo una cuenta</h4>
		<form id="frmSignIn" method="post" action="" class="needs-validation">
			<div class="form-row">
				<div class="form-group col">
					<label class="font-weight-bold text-dark text-2">Correo eléctronico</label>
					<input type="email" name="email" class="form-control form-control-lg" required />
				</div>
			</div>
			<div class="form-row">
				<div class="form-group col">
					<label class="font-weight-bold text-dark text-2">Contraseña</label>
					<input type="password" name="password" class="form-control form-control-lg" required>
				</div>
			</div>
			
			<div class="form-row">
				<div class="form-group col-lg-6">
					<div class="custom-control custom-checkbox">
						<input type="checkbox" class="custom-control-input" id="rememberme" name="rememberme">
						<label class="custom-control-label text-2" for="rememberme">Mantener sesión</label>
					</div>
				</div>
				<div class="form-group col-lg-6">
					<input type="submit" value="Ingresar" class="btn btn-primary btn-modern float-right" data-loading-text="Cargando..." />
				</div>
				<div class="form-group col" id="loginError"></div>
			</div>
		</form>
			<div class="row">
					<button class="btn btn-modern btn-primary" data-toggle="modal" data-target="#formModal">
						Recuperar contraseña
					</button>
			</div>
	</div>
</div>


									<div class="modal fade" id="formModal" tabindex="-1" role="dialog" aria-labelledby="formModalLabel" aria-hidden="true">
										<div class="modal-dialog">
											<div class="modal-content">
												<div class="modal-header">
													<h4 class="modal-title" id="formModalLabel">Recuperar contraseña</h4>
													<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
												</div>
												<div class="modal-body">
													<form id="formnewpass" class="" novalidate="novalidate">
														
														<div class="form-group row align-items-center">
															<label class="col-sm-3 text-left text-sm-right mb-0">Email</label>
															<div class="col-sm-9">
																<input type="email" name="email" class="form-control" placeholder="Escribi tu mail..." required/>
															</div>
														</div>
														<div class="modal-footer">
															<button type="button" class="btn btn-light" data-dismiss="modal">Cerrar</button>
															<button type="submit" class="btn btn-primary">Enviar al email</button>
														</div>
														<div class='containerloader'>
															<img src="http://localhost/atencionusuarios/wp-content/uploads/2020/10/toptal-blog-image-1489080120310-07bfc2c0ba7cd0aee3b6ba77f101f493.gif" class="loader" alt="">
														</div>
														<div class="modal-footer" id='errordiv'>
														</div>
													</form>
												</div>
												
											</div>
										</div>
									</div>
