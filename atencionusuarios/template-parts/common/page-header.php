<?php
//Obtengo las variables enviadas.

$title = ente_get_var( 'title', true );
$tag1 = ente_get_var( 'tag1', true );
$tag2 = ente_get_var( 'tag2', true );
$tag3  = ente_get_var( 'tag3', true );
$tag4  = ente_get_var( 'tag4', true );
$tag5  = ente_get_var( 'tag5', true );

?>


<section class="page-header page-header-modern custom-page-header-style-1 bg-color-primary page-header-lg mb-0">
                    <div class="container container-lg py-5">
                        <div class="row">
                            <div class="col-md-8 order-2 order-md-1 align-self-center p-static">
                                <h1 class="font-weight-extra-bold text-14 appear-animation" data-appear-animation="fadeInRightShorter" data-appear-animation-delay="200"><?php echo $tittle;  ?></h1>
                            </div>
                            <div class="col-md-4 order-1 order-md-2 align-self-center">
                                <ul class="breadcrumb d-block text-md-right breadcrumb-light appear-animation" data-appear-animation="fadeInRightShorter" data-appear-animation-delay="400">
                                    <li><a href="#"><?php echo $tag1;  ?> </a></li>
                                    <li class="active"><?php echo $tag2;  ?> </li>
                                </ul>
                            </div>
                        </div>
                    </div>
</section>