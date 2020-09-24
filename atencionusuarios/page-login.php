<?php
/**
 * Pagina de login.
 *
 * @package AtencionUsuarios
 */

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<?php get_template_part( 'template-parts/common/head' ); ?>
</head>
<body>
	<?php get_template_part( 'template-parts/common/header' ); ?>

	<div role="main" class="main">
		<section class="page-header page-header-classic">
			<div class="container">
				<div class="row">
					<div class="col">
						<ul class="breadcrumb">
							<li><a href="<?php echo esc_url( home_url() ); ?>">Home</a></li>
						</ul>
					</div>
				</div>
				<div class="row">
					<div class="col p-static">
						<span class="page-header-title-border visible"></span>
						<h1 data-title-border=""><?php the_title(); ?></h1>
					</div>
				</div>
			</div>
		</section>
		<div class="container">
			<div class="row">
				<div class="col">
					<div class="featured-boxes">
						<div class="row">
							<div class="col-md-6">
								<?php get_template_part( 'template-parts/auth/form-login' ); ?>
							</div>
							<div class="col-md-6">
								<?php get_template_part( 'template-parts/auth/form-register' ); ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<?php get_template_part( 'template-parts/common/footer' ); ?>
	<?php get_template_part( 'template-parts/common/footerscripts' ); ?>
</body>
</html>
