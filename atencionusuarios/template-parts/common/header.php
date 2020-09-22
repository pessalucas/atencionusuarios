<?php  
/*

*	Header con parametro de sub directorio asignable

*/
$subdirectory='/atencionusuarios/';
?>
<header id="header" class="header-effect-shrink" data-plugin-options="{'stickyEnabled': true, 'stickyEffect': 'shrink', 'stickyEnableOnBoxed': true, 'stickyEnableOnMobile': true, 'stickyChangeLogo': true, 'stickyStartAt': 120, 'stickyHeaderContainerHeight': 90}">
				<div class="header-body border-top-0 box-shadow-none">
					<div class="header-container container container-lg">
						<div class="header-row">
							<div class="header-column">
								<div class="header-row">
									<div class="header-logo">
										<a href="<?php echo $subdirectory; ?>home">
											<img alt="Porto" width="50" height="50" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/common/logo.png">
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
													<li>
														<a class="nav-link" href="<?php echo $subdirectory; ?>elente/" id='elente'>
															¿Que es el Ente?
														</a>
                                                    </li>
                                                    <li>
														<a class="nav-link" href="<?php echo $subdirectory; ?>news/" id='news'>
															Noticias
														</a>
													</li>
													<li class="dropdown">
														<a class="dropdown-item dropdown-toggle" href="<?php echo $subdirectory; ?>denuncias/" id='denuncias'>
															Denuncias
														</a>
														<ul class="dropdown-menu">
															<li>
																<a class="nav-link" href="<?php echo $subdirectory; ?>denuncias/" id='denuncias'>
																	Nueva denuncia
																</a>
															</li>
															<li>
																<a class="nav-link" href="<?php echo $subdirectory; ?>segdenuncia/" id='segdenuncia'>
																	Seguimiento de denuncia
																</a>
															</li>
														</ul>
													</li>
													<li>
														<a class="nav-link" href="#footer" id='contact'>
															Contacto
														</a>
													</li>
												</ul>
											</nav>
										</div>
										<button class="btn header-btn-collapse-nav" data-toggle="collapse" data-target=".header-nav-main nav">
											<i class="fas fa-bars"></i>
										</button>
									</div>
									<div class="d-none d-sm-inline-flex order-1 order-lg-2 ml-2">
										<ul class="header-extra-info d-flex">
											<li class="d-flex flex-column">
												<span class="d-block font-weight-semibold text-color-dark text-2 line-height-3">NUMERO</span>
												<a href="tel:+1234567890" class="font-weight-bold text-color-primary text-5">800-123-4567</a>
											</li>
										</ul>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</header>
