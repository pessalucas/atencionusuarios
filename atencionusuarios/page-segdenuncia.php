<!DOCTYPE html>
<html lang="en">
<head>
	<?php get_template_part( 'template-parts/common/head' ); ?>
</head>
<body>
	<?php get_template_part( 'template-parts/common/header' ); ?>
  
    <?php ente_get_template_part( 'template-parts/common/page-header', 
            array(
				'title'       => 'Seguimiento de denuncias',
				'tag1'        => 'Home',
                'tag2'        => 'SegDenuncias',

			) ); ?>

                <p>Login con FB</p>
	<?php get_template_part( 'template-parts/users/login-profile' ); ?>


    <?php get_template_part( 'template-parts/users/register-profile' ); ?>


	<?php get_template_part( 'template-parts/common/footer' ); ?>
	<?php get_template_part( 'template-parts/common/footerscripts' ); ?>


</body>
</html>

