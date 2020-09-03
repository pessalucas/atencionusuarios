                        <form class="contact-form" action="<?php echo get_stylesheet_directory_uri(); ?>/functions/insert-user.php" method="POST">
                                    <div class="contact-form-success alert alert-success d-none mt-4">
                                        <strong>Te has registrado correctamente!</strong>
                                    </div>

                                    <div class="contact-form-error alert alert-danger d-none mt-4">
                                        <strong>Error!</strong>
                                        <span class="mail-error-message text-1 d-block"></span>
                                    </div>
                                    
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
                                            <input type="text" value="" data-msg-required="Domicilio." maxlength="100" class="form-control border-0 custom-box-shadow-1 py-3 px-4 h-auto text-3 text-color-dark" name="address" id="address" required placeholder="Domicilio.">
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col mb-0">
                                            <button type="submit" class="btn btn-secondary btn-outline text-color-dark font-weight-semibold border-width-4 custom-link-effect-1 text-1 text-xl-3 d-inline-flex align-items-center px-4 py-3" data-loading-text="Loading...">Registrarse <i class="custom-arrow-icon ml-5"></i></button>
                                        </div>
                                    </div>
                                </form>