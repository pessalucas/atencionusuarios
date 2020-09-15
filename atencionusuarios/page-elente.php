<!DOCTYPE html>
<html lang="en">
<head>
	<?php get_template_part( 'template-parts/common/head' ); ?>
</head>
<body>
    
    <?php get_template_part( 'template-parts/common/header' ); ?>

    
    <?php ente_get_template_part( 'template-parts/common/page-header', 
            array(
				'title'       => '¿Que es el Ente?',
				'tag1'        => 'home',
                'tag2'        => 'elente',

			) ); ?>

    <?php get_template_part( 'template-parts/elente/main-elente' ); ?>

    <?php get_template_part( 'template-parts/common/action-denuncia' ); ?>

	
	<?php get_template_part( 'template-parts/common/footer' ); ?>
	<?php get_template_part( 'template-parts/common/footerscripts' ); ?>
</body>
</html>