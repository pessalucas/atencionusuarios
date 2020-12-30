<!DOCTYPE html>
<html lang="en">
<head>
	<?php get_template_part( 'template-parts/common/head' ); ?>
</head>
<body>
	<?php get_template_part( 'template-parts/common/header' ); ?>
  
    <?php ente_get_template_part( 'template-parts/common/page-header', 
            array(
				'title'       => 'Denuncia',
				'tag1'        => 'Home',
                'tag2'        => 'Denuncia',

			) ); ?>

	<?php get_template_part( 'template-parts/denuncia/denuncia-main' ); ?>

	<?php get_template_part( 'template-parts/common/footer' ); ?>
	<?php get_template_part( 'template-parts/common/footerscripts' ); ?>


</body>
</html>

