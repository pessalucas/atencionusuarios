<?php
/**
 * Modulo de noticias en home.
 *
 * @package atencionusuarios
 */

if ( have_posts() ) {
	?>
	<div class="container container-lg">
		<div class="row pt-3 mt-4">
			<div class="col">
				<div class="overflow-hidden mb-2">
					<span class="d-block font-weight-bold custom-text-color-grey-1 text-center line-height-1 mb-0 appear-animation" data-appear-animation="maskUp" data-appear-animation-delay="300">BLOG</span>
				</div>
				<div class="overflow-hidden mb-5">
					<h2 class="text-color-dark font-weight-bold text-center text-8 line-height-2 mb-0 appear-animation" data-appear-animation="maskUp" data-appear-animation-delay="500">El Ente News</h2>
				</div>
			</div>
		</div>
		<div class="row justify-content-center pb-3 pt-4 mb-5">
		<?php
		$query_post=new WP_Query(array(
			'posts_per_page' => '3',
			'post_type' => 'post'
		));

		while ( $query_post->have_posts() ) {

			//Obtengo la informacion de los posts
			$query_post->the_post();
			$post_id=get_the_ID();

			//Obtengo el url de la imagen destacada
			$featured_img_url = get_the_post_thumbnail_url($post_id,'full'); 

		?>
			<div class="col-md-7 col-lg-4 pr-lg-0 appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="450">
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

		}
		?>
		</div>
    </div>
    <?php
		}
		?>

