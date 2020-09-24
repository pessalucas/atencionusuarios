<?php
/**
 * FormBox: Formulario de registro.
 *
 * @package AtencionUsuarios
 */

?>
<div class="featured-box featured-box-primary text-left mt-5">
	<div class="box-content">
		<h4 class="color-primary font-weight-semibold text-4 text-uppercase mb-3">Registrar una cuenta</h4>
		<form id="frmSignUp" method="post" action="" class="needs-validation">
			<div class="form-row">
				<div class="form-group col-lg-6">
					<label class="font-weight-bold text-dark text-2">Nombre</label>
					<input type="text" name="firstname" maxlength="40" class="form-control form-control-lg" required>
				</div>
				<div class="form-group col-lg-6">
					<label class="font-weight-bold text-dark text-2">Apellido</label>
					<input type="text" name="lastname" maxlength="40" class="form-control form-control-lg" required>
				</div>
			</div>
			<div class="form-row">
				<div class="form-group col">
					<label class="font-weight-bold text-dark text-2">Correo eléctronico</label>
					<input type="email" name="email" class="form-control form-control-lg" required>
				</div>
			</div>
			<div class="form-row">
				<div class="form-group col-lg-6">
					<label class="font-weight-bold text-dark text-2">Contraseña</label>
					<input type="password" name="password" id="register_password" data-rule-PASSWORD="true" class="form-control form-control-lg" required>
				</div>
				<div class="form-group col-lg-6">
					<label class="font-weight-bold text-dark text-2">Repetir contraseña</label>
					<input type="password" name="password_repeat" data-rule-equalto="#register_password" class="form-control form-control-lg" required>
				</div>
			</div>
			<div class="form-row">
				<div class="form-group col-lg-6">
					<label class="font-weight-bold text-dark text-2">Telefono</label>
					<input type="tel" name="phone" data-rule-digits="true" class="form-control form-control-lg" required>
				</div>
				<div class="form-group col-lg-6">
					<label class="font-weight-bold text-dark text-2">DNI</label>
					<input type="number" name="passport_id" data-rule-digits="true" class="form-control form-control-lg" required>
				</div>
			</div>
			<div class="form-row">
				<div class="form-group col">
					<label class="font-weight-bold text-dark text-2">Domicilio</label>
					<input type="text" name="address" class="form-control form-control-lg" required>
				</div>
			</div>
			<div class="form-row">
				<div class="form-group col-lg-9">
					<div class="custom-control custom-checkbox">
						<input type="checkbox" class="custom-control-input" id="terms" value="" name="terms" required />
						<label class="custom-control-label text-2" for="terms">Estoy de acuerdo con los <a href="#">términos y condiciones</a></label>
					</div>
				</div>
				<div class="form-group col-lg-3">
					<input type="submit" value="Registrarme" class="btn btn-primary btn-modern float-right" data-loading-text="Cargando...">
				</div>
			</div>
			<div class="form-group col" id="registerError"></div>
		</form>
	</div>
</div>
