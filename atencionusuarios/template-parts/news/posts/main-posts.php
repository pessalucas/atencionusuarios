<?php
/**
 * Main de posts o noticias individuales.
 *
 * @package atencionusuarios
 */

if ( have_posts() ) {

     the_post();

     $post_id=get_the_ID();
     //Obtengo el url de la imagen destacada
     $featured_img_url = get_the_post_thumbnail_url($post_id,'full'); 

?>


<section class="section bg-color-transparent border-0 py-4 m-0">
                    <div class="container container-lg my-5">
                        <div class="row">
                            <div class="col-lg-9 appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="700">
           
                            <article>
                                    <div class="card border-0 border-radius-0 mb-5">
                                        <div class="card-body p-0 z-index-1">
                                            <div class="post-image pb-4">
                                                <img class="card-img-top border-radius-0" src="<?php echo $featured_img_url; ?>" alt="Card Image">
                                            </div>

                                            <p class="text-uppercase text-3 mb-3 text-color-default custom-font-secondary"><time pubdate datetime="2020-01-10"><?php the_date(); ?></time> <span class="opacity-3 d-inline-block px-2">|</span> <?php the_author(); ?> </p>

                                            <div class="card-body p-0">
                                                <h2><?php the_title(); ?></h2>
                                                <p><?php the_content(); ?></p>
                
                                                <hr class="my-5">

                                                <div class="post-block post-author">
                                                    <h3 class="text-color-dark text-capitalize font-weight-bold text-5 m-0 mb-3">Compartir redes sociales</h3>
                                                    <div class="img-thumbnail img-thumbnail-no-borders d-block pb-3">
                                                        <a href="blog-post.html">
                                                            <img src="img/avatars/avatar.jpg" class="rounded-circle" alt="">
                                                        </a>
                                                    </div>
                                                </div>

                                                <hr class="my-5">

                                              


                                            </div>
                                        </div>
                                    </div>
                                </article>
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
                                                <li><a href="<?php echo  $category->slug ?>"><?php echo  $category->name ?></a></li>
                                                <?php endforeach; ?> 
                                		</ul>
                                		</ul>
                                	</div>
                                </aside>
                            </div>
                        </div>

                        <a href="javascript:history.back()">Volver atras...</a>
                    </div>
</section>


<?php

}
?>