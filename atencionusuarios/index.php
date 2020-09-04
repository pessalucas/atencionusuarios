<!DOCTYPE html>
<html lang="en">
<head>
	<?php get_template_part( 'template-parts/common/head' ); ?>
</head>
<body>
	<?php get_template_part( 'template-parts/common/header' ); ?>

	<?php get_template_part( 'template-parts/users/testing-profile' ); ?>

	<?php get_template_part( 'template-parts/common/footer' ); ?>
	<?php get_template_part( 'template-parts/common/footerscripts' ); ?>

	<script src="<?php echo get_stylesheet_directory_uri(); ?>/resources/scripts/Login.js"></script>
</body>
</html>

