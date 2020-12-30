<!DOCTYPE html>
<html lang="en">
<head>
	<?php get_template_part( 'template-parts/common/head' ); ?>
</head>
<body>
    
    <?php get_template_part( 'template-parts/common/header' ); ?>

	<?php ente_get_template_part( 'template-parts/common/page-header', 
            array(
				'title'       => 'Denuncias',
				'tag1'        => 'Home'
			) ); ?>

	<?php get_template_part( 'template-parts/home/main' ); ?>

	<?php get_template_part( 'template-parts/common/footer' ); ?>
	
	<?php get_template_part( 'template-parts/common/footerscripts' ); ?>
</body>
</html>
