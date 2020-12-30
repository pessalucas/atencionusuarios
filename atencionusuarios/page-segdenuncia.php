<!DOCTYPE html>
<html lang="en">
<head>
	<?php get_template_part( 'template-parts/common/head' ); ?>
</head>
<body>
	<?php get_template_part( 'template-parts/common/header' ); ?>
  
	<?php ente_get_template_part( 'template-parts/common/page-header', 
            array(
				'title'       => 'Listado de denuncias',
				'tag1'        => 'Home',
                'tag2'        => 'SegDenuncias',
                'tag3'        => 'ListadoDenuncias',

			) ); ?>

    <?php get_template_part( 'template-parts/denuncia/denuncia-listadenuncias' ); ?>

	<?php get_template_part( 'template-parts/common/footer' ); ?>
	<?php get_template_part( 'template-parts/common/footerscripts' ); ?>

</body>
</html>

