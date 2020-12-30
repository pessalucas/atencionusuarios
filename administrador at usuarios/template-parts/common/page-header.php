<?php
//Obtengo las variables enviadas.

$title = ente_get_var( 'title', true );
$tag=array();
$tag['1'] = ente_get_var( 'tag1', true );
$tag['2'] = ente_get_var( 'tag2', true );
$tag['3']  = ente_get_var( 'tag3', true );
$tag['4']  = ente_get_var( 'tag4', true );
$tag['5']  = ente_get_var( 'tag5', true );

?>

				<section class="page-header page-header-modern bg-color-light-scale-1 page-header-md">
					<div class="container">
						<div class="row">
							<div class="col-md-8 order-2 order-md-1 align-self-center p-static">
								<h1 class="text-dark"><?php echo $title;  ?></h1>
							</div>
							<div class="col-md-4 order-1 order-md-2 align-self-center">
								<ul class="breadcrumb d-block text-md-right">
                                        <?php foreach($tag as $tagaux):  
                                                if($tagaux!=1){ 
                                            ?>
                                            <li><a href="/<?php echo $tagaux; ?>/"><?php echo $tagaux; ?></a></li>
                                        <?php } endforeach;  ?>
								</ul>
							</div>
						</div>
					</div>
				</section>