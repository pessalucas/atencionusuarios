<!DOCTYPE html>
<html lang="en">
<head>
	<?php get_template_part( 'template-parts/common/head' ); ?>
</head>
<body>
	<?php get_template_part( 'template-parts/common/header' ); ?>

	<?php get_template_part( 'template-parts/users/login-profile' ); ?>

	<?php get_template_part( 'template-parts/users/register-profile' ); ?>

	<?php get_template_part( 'template-parts/common/footer' ); ?>
	<?php get_template_part( 'template-parts/common/footerscripts' ); ?>
</body>
</html>

<?php
/* Por algun motivo no me permite entrar desde localhost/page-login.php 
Me redirije a index.php. 

page-id.php
page-{slug}.php
page.php
index.php