<!DOCTYPE html>
<html lang="en">
<head>
	<?php get_template_part( 'template-parts/common/head' ); ?>
</head>
<body>
    
    <?php get_template_part( 'template-parts/common/header' ); ?>

    <?php ente_get_template_part( 'template-parts/home/hero', 
            array(
				'label'       => 'PREMIO',
				'title'       => 'WfMC Global Awards for Excellence in Business Process Management 2019',
				'description' => 'El Ente Único Regulador de los Servicios Públicos de la Ciudad Autónoma de Buenos Aires fue seleccionado ganador en los WfMC Global Awards for Excellence in Business Process Management 2019, entre las mejores implementaciones de BPM (Business Process Management) del Mundo y cross a todas las categorías, por la implementación de los sistemas pertinentes al proceso de Modernización realizado en el 2018 por el Organismo.',
				'button'      => 'link',
			) ); ?>
	<?php get_template_part( 'template-parts/home/main' ); ?>
	
	<?php get_template_part( 'template-parts/common/action-denuncia' ); ?>

    <?php get_template_part( 'template-parts/home/module-news' ); ?>

	<?php get_template_part( 'template-parts/common/footer' ); ?>
	
	<?php get_template_part( 'template-parts/common/footerscripts' ); ?>
</body>
</html>
