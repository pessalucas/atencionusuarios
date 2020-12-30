<?php
/**
 * FormBox: Formulario de cambio de contrasena.
 *
 * @package AtencionUsuarios
 */

?>
<div class="featured-box featured-box-primary text-left mt-5">
	<div class="box-content">
		<h4 class="color-primary font-weight-semibold text-4 text-uppercase mb-3">Cambio de contraseña</h4>
		<form id="frmChangePass" method="POST" action="frmChangePass" class="needs-validation">
			<div class="form-row">
				<div class="form-group col">
					<label class="font-weight-bold text-dark text-2">Nueva contraseña</label>
					<input type="password" name="password1" id="password1" class="form-control form-control-lg" required />
				</div>
			</div>
			<div class="form-row">
				<div class="form-group col">
					<label class="font-weight-bold text-dark text-2">Repetir nueva contraseña</label>
					<input type="password" name="password2" id="password2" class="form-control form-control-lg" required />
				</div>
			</div>
			<div class="form-row">
				<div class="form-group col-lg-9">
				<div class='containerloader'>
					<img src="http://localhost/atencionusuarios/wp-content/uploads/2020/10/toptal-blog-image-1489080120310-07bfc2c0ba7cd0aee3b6ba77f101f493.gif" class="loader" alt="">
				</div>
				<div class="form-group col" id="changepassError"></div>
				</div>
				<div class="form-group col-lg-3">
					<input type="submit" value="Actualizar" class="btn btn-primary btn-modern float-right" data-loading-text="Cargando..." />
				</div>
			</div>
		</form>
	</div>
</div>
