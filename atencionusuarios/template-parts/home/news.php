<?php if ( have_posts() ) { ?>

<div class="container container-lg">
                    <div class="row pt-3 mt-4">
                        <div class="col">
                            <div class="overflow-hidden mb-2">
                                <span class="d-block font-weight-bold custom-text-color-grey-1 text-center line-height-1 mb-0 appear-animation" data-appear-animation="maskUp" data-appear-animation-delay="300">RESOURCES</span>
                            </div>
                            <div class="overflow-hidden mb-5">
                                <h2 class="text-color-dark font-weight-bold text-center text-8 line-height-2 mb-0 appear-animation" data-appear-animation="maskUp" data-appear-animation-delay="500">The Porto Blog</h2>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-center pb-3 pt-4 mb-5">
                    <?php
                            //Traigo los ultimos 3 posts
                            $i=0;
                            $lastposts = get_posts( array(
                                'posts_per_page' => 10
                            ) );
                             
                            foreach ( $lastposts as $post ) :
                                if ( $i<3 ) {
                            setup_postdata( $post ); 
                            //has_post_thumbnail ()? Figure?
                            if (true) {  
                                ?>

                        <div class="col-md-7 col-lg-4 pr-lg-0 appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="450">
                            <article class="card custom-post-style-1 border-0">
                                <header class="overlay overlay-show">
                                    <?php    the_post_thumbnail( 'thumbnail' );  ?>
                                    <h4 class="font-weight-bold text-6 position-absolute bottom-0 left-0 z-index-2 ml-4 mb-4 pb-2 pl-2 pr-5 mr-5">
                                        <a href="<?php the_permalink(); ?>" class="text-color-light text-decoration-none"><?php the_title(); ?></a>
                                    </h4>
                                </header>
                                <div class="card-body">
                                    <ul class="list list-unstyled custom-font-secondary pb-1 mb-2">

                                        <li class="list-inline-item line-height-1 mr-1 mb-0"><?php the_date(); ?></li>
                                        <li class="list-inline-item line-height-1 mb-0"><strong><?php the_author(); ?></strong></li>
                                    </ul>
                                    <p class="custom-text-size-1 mb-2"><?php the_content(); ?></p>
                                    <a href="<?php the_permalink(); ?>" class="text-color-primary font-weight-bold text-decoration-underline custom-text-size-1">Read More...</a>
                                </div>
                            </article>
                        </div>
                        <?php } $i=$i+1; } endforeach; ?>


                        </div>
                    </div>
                </div>

<?php 	}   ?>