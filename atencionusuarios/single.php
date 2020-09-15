<!DOCTYPE html>
<html lang="en">
<head>
	<?php get_template_part( 'template-parts/common/head' ); ?>
</head>
<body>
    
    <?php get_template_part( 'template-parts/common/header' ); ?>

    
    <?php ente_get_template_part( 'template-parts/common/page-header', 
            array(
				'title'       => 'Noticia',
				'tag1'        => 'Home',
                'tag2'        => 'News',
                'tag3'        => 'Posts',

			) ); ?>

    <?php get_template_part( 'template-parts/news/posts/main-posts' ); ?>
    
	<?php get_template_part( 'template-parts/common/action-denuncia' ); ?>
	
	<?php get_template_part( 'template-parts/common/footer' ); ?>
	<?php get_template_part( 'template-parts/common/footerscripts' ); ?>
</body>
</html>