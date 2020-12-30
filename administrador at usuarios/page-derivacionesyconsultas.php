<!DOCTYPE html>
<html lang="en">
<head>
	<?php get_template_part( 'template-parts/common/head' ); ?>
</head>
<body>
	<?php get_template_part( 'template-parts/common/header' ); ?>
  
    <?php ente_get_template_part( 'template-parts/common/page-header', 
            array(
				'title'       => 'Derivaciones y consultas',
				'tag1'        => 'Home',
                'tag2'        => 'derivacionesyconsultas',

			) ); ?>

	<?php get_template_part( 'template-parts/derivacionesyconsultas/main' );  ?>

	<?php get_template_part( 'template-parts/common/footer' ); ?>
	<?php get_template_part( 'template-parts/common/footerscripts' ); ?>
</body>
</html>

