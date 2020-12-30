<?php  
/*

*	Header con parametro de sub directorio asignable

*/
?>
<header id="header" class="header-effect-shrink" data-plugin-options="{'stickyEnabled': true, 'stickyEffect': 'shrink', 'stickyEnableOnBoxed': true, 'stickyEnableOnMobile': true, 'stickyChangeLogo': true, 'stickyStartAt': 120, 'stickyHeaderContainerHeight': 90}">
				<div class="header-body border-top-0 box-shadow-none">
					<div class="header-container container container-lg">
						<div class="header-row">
							<div class="header-column">
								<div class="header-row">
									<div class="header-logo">

										<a href="<?php if (  is_user_logged_in() ) { echo home_url().'/home'; }else{ echo home_url().'/login' ; } ?>">
											<img alt="Ente" width="220" height="70" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/header/logo.png">
										</a>
									</div>
								</div>
							</div>
							<div class="header-column justify-content-end">
								<div class="header-row">
									<div class="header-nav header-nav-line header-nav-bottom-line header-nav-bottom-line-effect-1 order-2 order-lg-1">
										<div class="header-nav-main header-nav-main-square header-nav-main-dropdown-no-borders header-nav-main-effect-2 header-nav-main-sub-effect-1">
											<nav class="collapse">
												<ul class="nav nav-pills" id="mainNav">
													<?php if (  is_user_logged_in() ) { ?> 
													<li>
														<a class="nav-link" href="<?php echo home_url( ); ?>/home/" id='denuncias'>
															Denuncias
														</a>
                                                    </li>
													<li>
														<a class="nav-link" href="<?php echo home_url( ); ?>/derivacionesyconsultas/" id='denuncias'>
														    Derivaciones y consultas
														</a>
                                                    </li>
                                                    <li>
														<a class="nav-link" href="<?php echo home_url( ); ?>/nuevadenuncia/" id='nuevadenuncia'>
															Nueva Denuncia
														</a>
													</li>
													
														<li>
															<a class="nav-link" href="<?php 
															$login_page = home_url().'/login/';
															echo wp_logout_url( $login_page ); ?>" id='logout'>
																Salir
															</a>
														</li>
														<?php }else{ ?>
														<li>
															<a class="nav-link" href="<?php echo home_url( ); ?>/login/" id='login'>
																Inicia sesión
															</a>
														</li>
													<?php } ?>
												</ul>
											</nav>
										</div>
										<button class="btn header-btn-collapse-nav" data-toggle="collapse" data-target=".header-nav-main nav">
											<i class="fas fa-bars"></i>
										</button>
									</div>
									<div class="d-none d-sm-inline-flex order-1 order-lg-2 ml-2">
										<ul class="header-extra-info d-flex">
											<li>
											<a href="https://www.facebook.com/entedelaciudad/">
												<i class="fab fa-facebook"></i>
											</a>
											</li>
											<li>
											<a href="https://twitter.com/EntedelaCiudad">
												<i class="fab fa-twitter-square"></i>
											</a>
											</li>
											<li>
											<a href="https://www.instagram.com/entedelaciudadok/">
												<i class="fab fa-instagram-square"></i>
											</a>
											</li>
										</ul>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</header>

	<?php 
			//Cambio la global para operar wordpress y sus funciones sobre el sitio At Usuarios
				global $switched;
				switch_to_blog(1); 
	?> 

			