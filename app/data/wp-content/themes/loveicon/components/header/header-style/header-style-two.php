<?php
$header_menu_sidebar     = loveicon_get_options( 'header_menu_sidebar' );
$header_menu_search      = loveicon_get_options( 'header_menu_search' );
$header_menu_button_text = loveicon_get_options( 'header_menu_button_text' );
$header_menu_button_url  = loveicon_get_options( 'header_menu_button_url' );
?>
<div class="header-bottom-two">
	<div class="auto-container">
		<div class="outer-box clearfix">
			<div class="header-bottom-two_left pull-left">
				<?php do_action( 'loveicon_header_logo_ready' ); ?>
			</div>
			<div class="header-bottom-two_right pull-right">
				<div class="nav-outer style2 clearfix">
					<!--Mobile Navigation Toggler-->
					<div class="mobile-nav-toggler">
						<div class="inner">
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</div>
					</div>
					<!-- Main Menu -->
					<nav class="main-menu style2 navbar-expand-md navbar-light">
						<div class="collapse navbar-collapse show clearfix" id="navbarSupportedContent">
							<?php do_action( 'loveicon_header_menu_ready' ); ?>
						</div>
					</nav>                        
					<!-- Main Menu End-->
				</div> 
				<?php if ( $header_menu_button_text || $header_menu_sidebar || $header_menu_search ) : ?>
					<div class="header-right_buttom style2">
						<?php if ( $header_menu_search == 1 ) : ?>
							<div class="outer-search-box-style1">
								<div class="seach-toggle"><span class="flaticon-magnifiying-glass"></span></div>
								<ul class="search-box">
									<li>
										<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
											<div class="form-group">
												<input type="search" id="<?php echo esc_attr( uniqid( 'search-form-' ) ); ?>" class="search-field" placeholder="<?php esc_attr_e( 'Search ...', 'loveicon' ); ?>" value="<?php echo get_search_query(); ?>" name="s" required="required"/>
												<button type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
											</div>
										</form>
									</li>
								</ul>
							</div>
						<?php endif; ?>
						<?php if ( $header_menu_button_text ) : ?>
							<div class="btns-box">
								<a class="btn-one" href="<?php echo esc_url( $header_menu_button_url ); ?>"><span class="txt"><i class="arrow1 fa fa-check-circle"></i><?php echo wp_kses( $header_menu_button_text, 'code_contxt' ); ?></span></a>
							</div>
						<?php endif; ?>
						<?php if ( $header_menu_sidebar == 1 ) : ?>
							<div class="side-content-button">
								<a class="navSidebar-button" href="#_">
									<ul>
										<li></li>
										<li></li>
										<li></li>
									</ul>
									<ul>
										<li></li>
										<li></li>
										<li></li>
									</ul>
									<ul>
										<li></li>
										<li></li>
										<li></li>
									</ul>
								</a>
							</div>
						<?php endif; ?>
					</div> 
				<?php endif; ?>
			</div> 
		</div>
	</div>    
</div> 
