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
				'title'       => 'Nueva denuncia',
				'tag1'        => 'Home',
                'tag2'        => 'nuevadenuncia',

			) ); ?>

	<?php get_template_part( 'template-parts/denuncia/denuncia-nueva' ); ?>


	<?php get_template_part( 'template-parts/common/footer' ); ?>
	<?php get_template_part( 'template-parts/common/footerscripts' ); ?>
</body>
</html>