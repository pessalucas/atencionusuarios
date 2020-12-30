<!DOCTYPE html>
<html lang="en">
<head>
	<?php get_template_part( 'template-parts/common/head' ); ?>
</head>
<body>
    
    <?php get_template_part( 'template-parts/common/header' ); ?>


<?php 
	//Obtengo slug de la categoria
	$urlrelative = $_SERVER['REQUEST_URI'];

	//El 27 corresponde al lugar desde donde chequea url 
	$urlrelativecut = substr($urlrelative,27,100);
	$slug = str_replace("/","",$urlrelativecut);

	//Convierto el slug en id category. Si vale 0 
	if ( ! $id_category = get_category_by_slug( $slug ) ){ $id_category=0;
		}else{	$id_category=$id_category->term_id;	}
?>
    
    <?php ente_get_template_part( 'template-parts/common/page-header', 
            array(
				'title'       => 'Noticias',
				'tag1'        => 'Home',
				'tag2'        => 'News',
				'tag3'        =>  $slug,
			) ); ?>


	<?php 
	ente_get_template_part( 'template-parts/news/categories/categories-news', 
            array(
				'category'       => $id_category,
			) ); ?>


	
	<?php get_template_part( 'template-parts/common/footer' ); ?>
	<?php get_template_part( 'template-parts/common/footerscripts' ); ?>
</body>
</html>