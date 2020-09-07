<form class="contact-form" method="POST" id="login" action="login">
	<div class="contact-form-success alert alert-success d-none mt-4">
		<strong>Correcto!</strong>
		<span class="mail-error-message text-1 d-block"></span>
	</div>

	<div class="contact-form-error alert alert-danger d-none mt-4">
		<strong>Error!</strong>
		<span class="mail-error-message text-1 d-block"></span>
	</div>
	<p class="status"></p>
	<div class="form-row row-gutter-sm">
		<div class="form-group col-lg-6 mb-4">
		<label for="username">Usuarios:</label>
			<input type="text" value="" data-msg-required="Usuario." maxlength="100" class="form-control border-0 custom-box-shadow-1 py-3 px-4 h-auto text-3 text-color-dark" name="username" id="username" required placeholder="Usuario.">
		</div>
		<div class="form-group col-lg-6 mb-4">
		<label for="password">Contraseña:</label>
			<input type="text" value="" data-msg-required="Domicilio." maxlength="100" class="form-control border-0 custom-box-shadow-1 py-3 px-4 h-auto text-3 text-color-dark" name="password" id="password" required placeholder="Contraseña.">
		</div>
	</div>
	<div class="form-row">
		<div class="form-group col mb-0">
			<button type="submit" class="btn btn-secondary btn-outline text-color-dark font-weight-semibold border-width-4 custom-link-effect-1 text-1 text-xl-3 d-inline-flex align-items-center px-4 py-3" data-loading-text="Loading...">Inicio<i class="custom-arrow-icon ml-5"></i></button>
		</div>
	</div>
</form>
