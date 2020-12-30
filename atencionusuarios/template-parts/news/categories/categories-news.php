<?php
/**
 * Main de Categorias.
 *
 * @package atencionusuarios
 */


//Obtengo las variables enviadas.
$id_category = ente_get_var( 'category', true );


//No tiene sentido, solo si la pagina tiene contenido
if ( have_posts() ) {

?>
  <section class="section bg-color-transparent border-0 py-4 m-0">
                    <div class="container container-lg my-5">
                        <div class="row">
                            <div class="col-lg-9 appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="700">
                                
                                <div class="">
                                    <div class="row row-gutter-sm justify-content-center mb-5" id='category-news'>
                                    <?php

                                        //Traigo primer pagina de noticias
                                        $query_post=new WP_Query(array(
                                            'posts_per_page'    => '6',
                                            'post_type'         => 'post',
                                            'paged'             => '1',
                                            'cat'               => $id_category 
                                        ));

                                        $numeropost = $query_post->found_posts;
                                        //Cuento cuantas paginas escribio
                                        $count=0;
                                        while ( $query_post->have_posts() ) {

                                            //Obtengo la informacion de los posts
                                            $query_post->the_post();
                                            $post_id = get_the_ID();
                                            
                                            //Obtengo el url de la imagen destacada
                                            $featured_img_url = get_the_post_thumbnail_url($post_id,'full'); 
		                            ?>
                                    
                                        <div class="col-lg-6 isotope-item text-left">
                                            <article class="card custom-post-style-1 border-0">
                                                <header class="overlay overlay-show">
                                                    <img class="img-fluid" src="<?php echo $featured_img_url; ?>" alt="Blog Post Thumbnail 1">
                                                    <h4 class="font-weight-bold text-6 position-absolute bottom-0 left-0 z-index-2 ml-4 mb-4 pb-2 pl-2 pr-5 mr-5">
                                                        <a href="<?php the_permalink(); ?>" class="text-color-light text-decoration-none"><?php the_title(); ?></a>
                                                    </h4>
                                                </header>
                                                <div class="card-body">
                                                    <ul class="list list-unstyled custom-font-secondary pb-1 mb-2">
                                                            <li class="list-inline-item line-height-1 mr-1 mb-0"><?php the_date(); ?></li>
                                                            <li class="list-inline-item line-height-1 mb-0"><strong><?php the_author(); ?></strong></li>
                                                    </ul>
                                                    <p class="custom-text-size-1 mb-2"><?php the_excerpt(); ?></p>
                                                    <a href="<?php the_permalink(); ?>" class="text-color-primary font-weight-bold text-decoration-underline custom-text-size-1">Leer mas...</a>
                                                </div>
                                            </article>
                                        </div>
                                        <?php
                                        $count++;
                                        }
		                                ?>
                                    </div>
                                </div>

                            </div>

                            <div class="col-lg-3 pt-4 pt-lg-0 appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="900">
                                <aside class="sidebar">
                                	<div class="px-3 mt-4">
                                		<h3 class="text-color-quaternary text-capitalize font-weight-bold text-5 m-0">Categorías</h3>
                                		<ul class="nav nav-list flex-column mt-2 mb-0 p-relative right-9">
                                            <?php
                                            $categories = get_categories( array(
                                                    'orderby' => 'name',
                                                    'order'   => 'ASC'
                                                ) );
                                                foreach( $categories as $category ):  ?> 
                                                <li><a href="<?php echo get_category_link($category->term_id) ?>"><?php echo  $category->name ?></a></li>
                                                <?php endforeach; ?> 
                                		</ul>
                                		</ul>
                                	</div>
                                </aside>
                            </div>
                        </div>

<?php
//Si son menos de 6 no muestro el boton para traer mas noticias
if( $numeropost == 6){ 
?>
                        <form  method="POST" id="loadnews" action="loadnews" style='text-align:center;'>
                            <input type="hidden" value="<?php echo $id_category; ?>" name="category" id="category">
                            <button type="submit" class="mb-1 mt-1 mr-1 btn btn-light" style='margin: auto; width:200px;'><i class="fas fa-sync" style='margin-right:10px;'></i><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">   Mas noticias</font></font></button>
                        </form>
<?php
}
?>
                    </div>
</section>

<?php
}
?>