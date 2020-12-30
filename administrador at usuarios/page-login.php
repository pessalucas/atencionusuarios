<?php
/**
 * Pagina de login.
 *
 * @package AtencionUsuarios
 */

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<?php get_template_part( 'template-parts/common/head' ); ?>
</head>
<body>
	<?php get_template_part( 'template-parts/common/header' ); ?>
	<?php ente_get_template_part( 'template-parts/common/page-header', 
            array(
				'title'       => 'Iniciar sesión',
				'tag1'        => 'Home',
                'tag2'        => 'Login',

			) ); ?>

	<div role="main" class="main">
		<div class="container">
			<div class="row">
				<div class="col">
					<div class="featured-boxes">
						<div class="row">
							<div class="col-md-6" stlye='margin:auto;'>
								<?php get_template_part( 'template-parts/auth/form-login' ); ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<?php get_template_part( 'template-parts/common/footer' ); ?>
	<?php get_template_part( 'template-parts/common/footerscripts' ); ?>
</body>
</html>
