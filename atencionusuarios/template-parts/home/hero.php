<?php
//Obtengo las variables enviadas.

$label       = ente_get_var( 'label', true );
$title       = ente_get_var( 'title', true );
$description = ente_get_var( 'description', true );
$link        = ente_get_var( 'link', true );

?>

<div role="main" class="main mainhero">

                <div class="slider-container rev_slider_wrapper" style="height: 600px;">
					<div id="revolutionSlider" class="slider rev_slider" data-version="5.4.8" data-plugin-revolution-slider data-plugin-options="{'delay': 9000, 'gridwidth': 1110, 'gridheight': [750,750,750,1250], 'responsiveLevels': [4096,1200,992,500]}">
						<ul>
							<li class="slide-overlay slide-overlay-level-7" data-transition="fade">

								<img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/hero/callcenter.jpg"  
									alt=""
									data-bgposition="center center" 
									data-bgfit="cover" 
									data-bgrepeat="no-repeat" 
									data-kenburns="on"
									data-duration="9000"
									data-ease="Linear.easeNone"
									data-scalestart="115"
									data-scaleend="100"
									data-rotatestart="0"
									data-rotateend="0"
									data-offsetstart="0 -200"
									data-offsetend="0 200"
									data-bgparallax="0"
									class="rev-slidebg">


								<div class="tp-caption tp-caption-overlay-opacity top-label font-weight-semibold"
									data-frames='[{"delay":1000,"speed":1000,"sfxcolor":"#212529","sfx_effect":"blockfromleft","frame":"0","from":"z:0;","to":"o:1;","ease":"Power3.easeInOut"},{"delay":"wait","speed":500,"sfxcolor":"#212529","sfx_effect":"blocktoleft","frame":"999","to":"z:0;","ease":"Power4.easeOut"}]'
									data-x="left" data-hoffset="['0','30','30','30']"
									data-y="center" data-voffset="['-65','-65','-69','-73']"
									data-fontsize="['18','18','18','30']"
									data-paddingtop="['10','10','10','12']"
									data-paddingbottom="['10','10','10','12']"
									data-paddingleft="['18','18','18','18']"
									data-paddingright="['18','18','18','18']">Controlemos juntos</div>

								<h1 class="tp-caption tp-caption-overlay-opacity main-label"
									data-frames='[{"delay":1300,"speed":1000,"sfxcolor":"#212529","sfx_effect":"blockfromleft","frame":"0","from":"z:0;","to":"o:1;","ease":"Power3.easeInOut"},{"delay":"wait","speed":500,"sfxcolor":"#212529","sfx_effect":"blocktoleft","frame":"999","to":"z:0;","ease":"Power4.easeOut"}]'
									data-x="left" data-hoffset="['0','30','30','30']"
									data-y="center"
									data-fontsize="['50','50','50','60']"
									data-letterspacing="0"
									data-paddingtop="['10','10','10','10']"
									data-paddingbottom="['10','10','10','10']"
									data-paddingleft="['18','18','18','18']"
									data-paddingright="['18','18','18','18']">los servicios públicos</h1>



								<div class="tp-caption font-weight-light text-color-light ws-normal"
									data-frames='[{"from":"opacity:0;","speed":300,"to":"o:1;","delay":2000,"split":"chars","splitdelay":0.05,"ease":"Power2.easeInOut"},{"delay":"wait","speed":1000,"to":"y:[100%];","mask":"x:inherit;y:inherit;s:inherit;e:inherit;","ease":"Power2.easeInOut"}]'
									data-x="left" data-hoffset="['3','35','35','35']"
									data-y="center" data-voffset="['65','65','65','95']"
									data-width="['690','690','690','800']"
									data-fontsize="['18','18','18','35']"
									data-lineheight="['29','29','29','40']">Tu denuncia hace la diferencia</div>


								<a class="tp-caption btn btn-outline btn-primary font-weight-bold"
									href="<?php echo home_url(); ?>/elente/"
									data-frames='[{"delay":3000,"speed":2000,"frame":"0","from":"y:50%;opacity:0;","to":"y:0;o:1;","ease":"Power3.easeInOut"},{"delay":"wait","speed":300,"frame":"999","to":"opacity:0;fb:0;","ease":"Power3.easeInOut"}]'
									data-x="left" data-hoffset="['0','30','30','30']"
									data-y="center" data-voffset="['140','140','140','245']"
									data-paddingtop="['15','15','15','30']"
									data-paddingbottom="['15','15','15','30']"
									data-paddingleft="['40','40','40','50']"
									data-paddingright="['40','40','40','50']"
									data-fontsize="['13','13','13','25']"
									data-lineheight="['20','20','20','25']">Saber más</a>

								<a class="tp-caption btn btn-primary font-weight-bold herobutton"
									href="<?php echo home_url(); ?>/denuncias/"
									data-frames='[{"delay":3000,"speed":2000,"frame":"0","from":"y:50%;opacity:0;","to":"y:0;o:1;","ease":"Power3.easeInOut"},{"delay":"wait","speed":300,"frame":"999","to":"opacity:0;fb:0;","ease":"Power3.easeInOut"}]'
									data-x="left" data-hoffset="['185','185','220','340']"
									data-y="center" data-voffset="['140','140','140','245']"
									data-paddingtop="['16','16','16','31']"
									data-paddingbottom="['16','16','16','31']"
									data-paddingleft="['40','40','40','50']"
									data-paddingright="['40','40','40','50']"
									data-fontsize="['13','13','13','25']"
									data-lineheight="['20','20','20','25']">Realizar denuncia <i class="fas fa-arrow-right ml-1"></i></a>

							</li>
							<li class="slide-overlay slide-overlay-level-7" data-transition="fade">
								<img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/hero/subte.jpg"  
									alt=""
									data-bgposition="center center" 
									data-bgfit="cover" 
									data-bgrepeat="no-repeat" 
									data-kenburns="on"
									data-duration="9000"
									data-ease="Linear.easeNone"
									data-scalestart="115"
									data-scaleend="100"
									data-rotatestart="0"
									data-rotateend="0"
									data-offsetstart="0 400px"
									data-offsetend="0 -400px"
									data-bgparallax="0"
									class="rev-slidebg">

								<div class="tp-caption tp-caption-overlay-opacity top-label font-weight-semibold"
									data-frames='[{"delay":1000,"speed":1000,"sfxcolor":"#212529","sfx_effect":"blockfromleft","frame":"0","from":"z:0;","to":"o:1;","ease":"Power3.easeInOut"},{"delay":"wait","speed":500,"sfxcolor":"#212529","sfx_effect":"blocktoleft","frame":"999","to":"z:0;","ease":"Power4.easeOut"}]'
									data-x="left" data-hoffset="['550','550','550','450']"
									data-y="center" data-voffset="['-65','-65','-69','-73']"
									data-fontsize="['18','18','18','30']"
									data-paddingtop="['10','10','10','12']"
									data-paddingbottom="['10','10','10','12']"
									data-paddingleft="['18','18','18','18']"
									data-paddingright="['18','18','18','18']">Contáctanos</div>

								<div class="tp-caption tp-caption-overlay-opacity main-label"
									data-frames='[{"delay":1300,"speed":1000,"sfxcolor":"#212529","sfx_effect":"blockfromleft","frame":"0","from":"z:0;","to":"o:1;","ease":"Power3.easeInOut"},{"delay":"wait","speed":500,"sfxcolor":"#212529","sfx_effect":"blocktoleft","frame":"999","to":"z:0;","ease":"Power4.easeOut"}]'
									data-x="left" data-hoffset="['550','550','550','450']"
									data-y="center"
									data-fontsize="['50','50','50','60']"
									data-paddingtop="['10','10','10','12']"
									data-paddingbottom="['10','10','10','12']"
									data-paddingleft="['18','18','18','18']"
									data-paddingright="['18','18','18','18']">0800-222-ENTE (3683)</div>

								<div class="tp-caption font-weight-light text-color-light ws-normal"
									data-frames='[{"from":"opacity:0;","speed":300,"to":"o:1;","delay":2000,"split":"chars","splitdelay":0.05,"ease":"Power2.easeInOut"},{"delay":"wait","speed":1000,"to":"y:[100%];","mask":"x:inherit;y:inherit;s:inherit;e:inherit;","ease":"Power2.easeInOut"}]'
									data-x="left" data-hoffset="['550','550','550','450']"
									data-y="center" data-voffset="['65','65','65','105']"
									data-width="['600','600','600','600']"
									data-fontsize="['18','18','18','30']"
									data-lineheight="['29','29','29','40']">Tu denuncia hace la diferencia</div>

								<a class="tp-caption btn btn-primary font-weight-bold herobutton"
									href="<?php echo home_url(); ?>/denuncias/"
									data-frames='[{"delay":3000,"speed":2000,"frame":"0","from":"y:50%;opacity:0;","to":"y:0;o:1;","ease":"Power3.easeInOut"},{"delay":"wait","speed":300,"frame":"999","to":"opacity:0;fb:0;","ease":"Power3.easeInOut"}]'
									data-x="left" data-hoffset="['550','550','550','450']"
									data-y="center" data-voffset="['140','140','140','235']"
									data-paddingtop="['16','16','16','31']"
									data-paddingbottom="['16','16','16','31']"
									data-paddingleft="['40','40','40','50']"
									data-paddingright="['40','40','40','50']"
									data-fontsize="['13','13','13','25']"
									data-lineheight="['20','20','20','25']">Realizar denuncia <i class="fas fa-arrow-right ml-1"></i></a>

							</li>
						</ul>
					</div>
				</div>

    <section class="section section-height-4 custom-section-full-width custom-section-pull-top-1 bg-color-transparent border-0 position-relative z-index-1 pb-0 pb-xl-5 mb-0" style="background-image: url(img/demos/it-services/backgrounds/dots-background-1.png); background-repeat: no-repeat; background-position: top left;">
        <div class="container container-lg mt-2 mb-xl-5">
            <div class="row">
                <div class="col-xl-7 pb-5 pb-xl-0 mb-5 mb-xl-0">
                    <div class="custom-overlapping-cards">
                        <div class="card border-0 box-shadow-1 pl-2 appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="300">
                            <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/hero/parada.jpg" class="card-img-top rounded-0 img-fluid" alt="IT Consulting">
                            <div class="card-body pt-4">
                                <h4 class="custom-heading-bar font-weight-bold text-color-dark text-5">COMPROMISO</h4>
                                <p class="custom-font-secondary text-4 mb-3">El organismo sigue operativo durante la pandemia <strong class="text-color-dark">controlando los servicios públicos escenciales</strong>.</p>
                            </div>
                        </div>
                        <div class="card-transform">
                            <div class="card border-0 box-shadow-1 pr-2 appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="500">
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/hero/flor.jpg" class="card-img-top rounded-0 img-fluid" alt="IT Support">
                                <div class="card-body pt-4">
                                    <h4 class="custom-heading-bar custom-heading-bar-right font-weight-bold text-color-dark text-right text-5">20 AÑOS CON VOS, UNA <br> CIUDAD CON VOZ</h4>
                                    <p class="text-right custom-font-secondary text-4 pl-4 ml-3 mb-3">Orgullosos de defender tus derechos.</p>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
                <div class="col-xl-5">
                    <span class="d-block custom-text-color-grey-1 font-weight-bold mb-1 appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="700"><?php echo $label; ?></span>
                    <h2 class="text-color-dark font-weight-bold text-8 line-height-2 negative-ls-1 pb-3 mb-4 appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="900"><?php echo $title; ?></h2>
                    <p class="custom-text-size-1 pb-3 mb-4 appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="1100"><?php echo $description; ?></p>
                    <a href="<?php echo $link; ?>" class="d-flex align-items-center custom-link-effect-1 text-color-primary font-weight-bold text-decoration-none text-4 appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="1300" target='_blank'>Conocer más<i class="custom-arrow-icon ml-2"></i></a>
                </div>
            </div>
        </div>
    </section>

    <div class="container container-lg mt-5">
        <div class="row">
            <div class="col">
                <hr class="my-5">
            </div>
        </div>
    </div>
</div>