<?php
/**
 * FormBox: Formulario de actualizacion de ususario.
 *
 * @package AtencionUsuarios
 */

	//Si el usuario esta logueado muestro el template
	if( $user_id=get_current_user_id() ){ 

	//Traigo informacion generica
	$user_info=get_userdata( $user_id );

	//Utilizo para traer info extra a post
	$user_dni = get_user_meta( $user_id, 'dni', true );
	$user_telefono = get_user_meta( $user_id, 'telefono', true );
	$user_direccion = get_user_meta( $user_id, 'direccion', true );

?>

<div class="featured-box featured-box-primary text-left mt-5">
	<div class="box-content">
		<h4 class="color-primary font-weight-semibold text-4 text-uppercase mb-3">Actualizar informacion del perfil</h4>
		<form method="POST" id="frmUpdate" action="frmUpdate" class="needs-validation">
			<div class="form-row">
				<div class="form-group col-lg-6">
					<label class="font-weight-bold text-dark text-2">Nombre</label>
					<input type="text" name="firstname" value="<?php echo $user_info->first_name;?>" maxlength="40" class="form-control form-control-lg" required>
				</div>
				<div class="form-group col-lg-6">
					<label class="font-weight-bold text-dark text-2">Apellido</label>
					<input type="text" name="lastname" value="<?php echo $user_info->last_name;?>" maxlength="40" class="form-control form-control-lg" required>
				</div>
			</div>
			<div class="form-row">
				<div class="form-group col">
					<label class="font-weight-bold text-dark text-2">Correo eléctronico / Usuario</label>
					<input type="email" name="email" value="<?php echo $user_info->user_email; ?>" class="form-control form-control-lg" required readonly>
				</div>
			</div>
			<div class="form-row">
				<div class="form-group col-lg-6">
					<label class="font-weight-bold text-dark text-2">Telefono</label>
					<input type="tel" name="phone" value="<?php echo $user_telefono; ?>" data-rule-digits="true" class="form-control form-control-lg" required>
				</div>
				<div class="form-group col-lg-6">
					<label class="font-weight-bold text-dark text-2">DNI</label>
					<input type="number" name="dni" value="<?php echo $user_dni; ?>" data-rule-digits="true" class="form-control form-control-lg" required>
				</div>
			</div>
			<div class="form-row">
				<div class="form-group col">
					<label class="font-weight-bold text-dark text-2">Domicilio</label>
					<input type="text" name="address" value="<?php echo $user_direccion; ?>" class="form-control form-control-lg" required>
				</div>
			</div>
			<div class="form-row">
				<div class="form-group col-lg-9">
				<div class='containerloader'>
						<img src="http://localhost/atencionusuarios/wp-content/uploads/2020/10/toptal-blog-image-1489080120310-07bfc2c0ba7cd0aee3b6ba77f101f493.gif" class="loader" alt="">
				</div>
				<div class="form-group col" id="updateError"></div>
				</div>
				<div class="form-group col-lg-3">
					<input type="submit" value="Actualizar" class="btn btn-primary btn-modern float-right" data-loading-text="Cargando...">
				</div>
			</div>
		</form>
	</div>
</div>

<?php
    }
?>