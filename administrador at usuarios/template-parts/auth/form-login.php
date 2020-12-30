<?php
/**
 * FormBox: Formulario de login.
 *
 * @package AtencionUsuarios
 */

?>
<div class="featured-box featured-box-primary text-left mt-5">
	<div class="box-content">
		<h4 class="color-primary font-weight-semibold text-4 text-uppercase mb-3">Inicio de sesion</h4>
		<form id="frmSignIn" method="post" action="" class="needs-validation">
			<div class="form-row">
				<div class="form-group col">
					<label class="font-weight-bold text-dark text-2">Correo eléctronico</label>
					<input type="email" name="email" class="form-control form-control-lg" required />
				</div>
			</div>
			<div class="form-row">
				<div class="form-group col">
					<a class="float-right" href="<?php echo esc_url( home_url( 'recuperar-contrasena' ) ); ?>">Olvide mi contraseña</a>
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
	</div>
</div>
