
<section class="section custom-section-full-width bg-color-transparent border-0 mt-1 mb-1" style="background-image: url(img/demos/it-services/backgrounds/dots-background-4.png); background-repeat: no-repeat; background-position: top right;">
	<div class="container container-lg mt-3">
		<div class="row justify-content-center">
			<div class="col-lg-10">
				<div class="overflow-hidden mb-2">
					<span class="d-block font-weight-bold custom-text-color-grey-1 text-center line-height-1 mb-0 appear-animation" data-appear-animation="maskUp" data-appear-animation-delay="300">Registrate</span>
				</div>
				<div class="overflow-hidden mb-4">
					<h2 class="text-color-dark font-weight-bold text-center text-8 line-height-2 mb-0 appear-animation" data-appear-animation="maskUp" data-appear-animation-delay="500">¿Como podemos ayudarte?</h2>
				</div>
				<p class="custom-text-size-1 text-center mb-5 appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="700">Registrate y realiza tu denuncia en pocos pasos.</p>
			</div>
		</div>
		<div class="row mb-4">
			<div class="col appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="900">
				<form class="contact-form" method="POST" id="register" action="register">
				
					<div class="contact-form-success alert alert-success d-none mt-4">
						<strong>Te has registrado correctamente!</strong>
					</div>

					<div class="contact-form-error alert alert-danger d-none mt-4">
						<strong>Error!</strong>
						<span class="mail-error-message text-1 d-block"></span>
					</div>
					<p class="status"></p>

					<div class="form-row row-gutter-sm">
						<div class="form-group col-lg-6 mb-4">
							<input type="text" value="" data-msg-required="Nombre y apellido." maxlength="100" class="form-control border-0 custom-box-shadow-1 py-3 px-4 h-auto text-3 text-color-dark" name="name" id="name" required placeholder="Nombre y apellido.">
						</div>
						<div class="form-group col-lg-6 mb-4">
							<input type="text" value="" data-msg-required="Telefono." maxlength="100" class="form-control border-0 custom-box-shadow-1 py-3 px-4 h-auto text-3 text-color-dark" name="phone" id="phone" required placeholder="Telefono.">
						</div>
					</div>
					<div class="form-row row-gutter-sm">
						<div class="form-group col-lg-6 mb-4">
							<input type="email" value="" data-msg-required="Dirección de correo electronico." data-msg-email="Please enter a valid email address." maxlength="100" class="form-control border-0 custom-box-shadow-1 py-3 px-4 h-auto text-3 text-color-dark" name="email" id="email" required placeholder="Dirección de correo electronico.">
						</div>
						<div class="form-group col-lg-6 mb-4">
							<input type="text" value="" data-msg-required="DNI" maxlength="100" class="form-control border-0 custom-box-shadow-1 py-3 px-4 h-auto text-3 text-color-dark" name="dni" id="dni" required placeholder="DNI">
						</div>
					</div>
					<div class="form-row row-gutter-sm">
						<div class="form-group col-lg-6 mb-4">
							<input type="text" value="" data-msg-required="Usuario." maxlength="100" class="form-control border-0 custom-box-shadow-1 py-3 px-4 h-auto text-3 text-color-dark" name="username" id="username" required placeholder="Usuario.">
						</div>
						<div class="form-group col-lg-6 mb-4">
							<input type="text" value="" data-msg-required="Contraseña." maxlength="100" class="form-control border-0 custom-box-shadow-1 py-3 px-4 h-auto text-3 text-color-dark" name="password" id="password" required placeholder="Contraseña.">
						</div>
					</div>
					<div class="form-row row-gutter-sm">
						<div class="form-group col-lg-6 mb-4">
							<input type="text" value="" data-msg-required="Domicilio." maxlength="100" class="form-control border-0 custom-box-shadow-1 py-3 px-4 h-auto text-3 text-color-dark" name="address" id="address" required placeholder="Domicilio.">
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col mb-0">
                        <?php //do_action('register_form'); ?>
							<button type="submit" class="btn btn-secondary btn-outline text-color-dark font-weight-semibold border-width-4 custom-link-effect-1 text-1 text-xl-3 d-inline-flex align-items-center px-4 py-3" data-loading-text="Loading...">Actualizar <i class="custom-arrow-icon ml-5"></i></button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</section>


