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
				'description' => 'El Ente Único Regulador de Servicios Públicos de la Ciudad Autónoma de Buenos Aires fue reconocido internacionalmente por la Workflow Management Coalition entre las mejores implementaciones de BPM (Business Process Management) del mundo, a partir del desarrollo del Plan de Modernización que llevo a cabo el Organismo. ',
				'link'      => 'https://adnciudad.com/index.php/legiscaba/9417-20-anos-de-un-organismo-que-supo-reconvertirse',
			) ); ?>
	<?php get_template_part( 'template-parts/home/main' ); ?>
	
	<?php get_template_part( 'template-parts/common/action-denuncia' ); ?>

    <?php //get_template_part( 'template-parts/home/module-news' ); ?>

	<?php get_template_part( 'template-parts/common/footer' ); ?>
	
	<?php get_template_part( 'template-parts/common/footerscripts' ); ?>

</body>
</html>
