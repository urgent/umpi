<?php
class loveicon_Int {
	/**
	 * top bar search compatibility.
	 */
	public static function loveicon_search_popup() {
		$header_top_bar_search = loveicon_get_options( 'header_top_bar_search' );
		?>
		<?php if ( $header_top_bar_search == 1 ) : ?>
				<div id="search-popup" class="search-popup">
					<div class="close-search">
						<span>
							<?php
								echo esc_html__( 'Close', 'loveicon' );
							?>
					</span></div>
					<div class="popup-inner">
						<div class="overlay-layer"></div>
						<div class="search-form">
							<form role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
								<div class="form-group">
									<fieldset>
										<input type="search"  id="<?php echo esc_attr( uniqid( 'search-form-' ) ); ?>" class="search-field form-control"
										 placeholder="<?php esc_attr_e( 'Search', 'loveicon' ); ?>" value="<?php echo get_search_query(); ?>" name="s" required="required"/>
										<button class="theme-btn style-four submit-btn-ri-fat" type="submit">
											<?php echo esc_html__( 'search now', 'loveicon' ); ?>
										</button>
									</fieldset>
								</div>
							</form>
						</div>
					</div>
				</div>
		<?php endif; ?>
		<?php
	}
	/**
	 * preloader compatibility.
	 */
	public static function loveicon_preloader() {
		$preloader_on_off = loveicon_get_options( 'preloader_on_off' );
		?>
		<?php if ( $preloader_on_off ) : ?>
			<div class="loader-wrap">
				<div class="preloader"><div class="preloader-close">Preloader Close</div></div>
				<div class="layer layer-one"><span class="overlay"></span></div>
				<div class="layer layer-two"><span class="overlay"></span></div>        
				<div class="layer layer-three"><span class="overlay"></span></div>        
			</div>
		<?php endif; ?>
		<?php
	}
	/**
	 * slide menu compatibility.
	 */
	public static function loveicon_slide_menu() {
		$header_menu_sidebar = loveicon_get_options( 'header_menu_sidebar' );
		?>
		<?php if ( $header_menu_sidebar == '1' ) :
			$mobile_menu_logo    = loveicon_get_options( 'mobile_menu_logo' );	
			$header_menu_sidebar_title    = loveicon_get_options( 'header_menu_sidebar_title' );	
			$header_menu_sidebar_content    = loveicon_get_options( 'header_menu_sidebar_content' );	
			$header_menu_sidebar_quet_title    = loveicon_get_options( 'header_menu_sidebar_quet_title' );	
			$header_menu_sidebar_quet_shortcode    = loveicon_get_options( 'header_menu_sidebar_quet_shortcode' );	
		?>
			<div class="xs-sidebar-group info-group info-sidebar">
				<div class="xs-overlay xs-bg-black"></div>
				<div class="xs-sidebar-widget">
					<div class="sidebar-widget-container">
						<div class="widget-heading">
							<a href="#" class="close-side-widget">X</a>
						</div>
						<div class="sidebar-textwidget">
							<div class="sidebar-info-contents">
								<div class="content-inner text-right-rtl">
									<div class="logo">
										<?php if ( isset( $mobile_menu_logo['url'] ) && $mobile_menu_logo['url'] != '' ) : ?>
											<a href="<?php echo esc_url( home_url( '/' ) ); ?>" ><img src="<?php echo esc_url( $mobile_menu_logo['url'], 'loveicon' ); ?>"  alt="<?php esc_attr_e( 'Logo', 'loveicon' ); ?>"></a>
										<?php else : ?>
											<a href="<?php echo esc_url( home_url( '/' ) ); ?>" ><img src="<?php echo esc_url( LOVEICON_IMG_URL . 'mobilemenu-logo.png' ); ?>" alt="<?php esc_attr_e( 'Logo', 'loveicon' ); ?>"></a>
										<?php endif; ?>
									</div>
									<div class="content-box">
										<h4><?php echo wp_kses($header_menu_sidebar_title, 'code_contxt'); ?></h4>
										<p><?php echo wp_kses($header_menu_sidebar_content, 'code_contxt'); ?></p>
									</div>
									<div class="form-inner">
										<h4><?php echo wp_kses($header_menu_sidebar_quet_title, 'code_contxt'); ?></h4>
										<?php echo do_shortcode( $header_menu_sidebar_quet_shortcode ) ?>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		<?php endif; ?>
		<?php
	}
	/**
	 * back to top compatibility.
	 */
	public static function loveicon_back_to_top() {
		$back_to_top_on_off = loveicon_get_options( 'back_to_top_on_off' );
		?>
		<?php if ( $back_to_top_on_off == '1' ) : ?>
			<button class="scroll-top scroll-to-target" data-target="html">
				<span class="fa fa-angle-up"></span>
			</button> 
		<?php endif; ?>
		<?php
	}
	/**
	 * header logo compatibility.
	 */
	public static function loveicon_header_logo() {
		?>
				
			<div class="logo">
				<?php
					$loveicon_theme_metabox_header_logo = get_post_meta(get_the_ID(), 'loveicon_theme_metabox_header_logo', array( 'size' => 'full' ));
					
					if(!empty($loveicon_theme_metabox_header_logo)) {
						?>
							<a  class="nav-brand"  href="<?php echo esc_url(home_url('/')); ?>">
								<img src="<?php echo esc_url( wp_get_attachment_url( $loveicon_theme_metabox_header_logo ) );?>" alt="<?php esc_attr_e('Logo', 'loveicon') ?>">
							</a>
						<?php
					} else {
						if (has_custom_logo()) {
							the_custom_logo();
						} elseif (!has_custom_logo()) {
							?>
							<a class="nav-brand" href="<?php echo esc_url(home_url('/')); ?>">
								<img src="<?php echo esc_url( LOVEICON_IMG_URL . 'logo.png' ); ?>" alt="<?php esc_attr_e( 'Logo', 'loveicon' ); ?>">
							</a> 
							<?php
						}
					}
				?>
			</div>
		<?php
	}

	/**
	 * header menu compatibility.
	 */
	public static function loveicon_header_menu() {
		?>
			
						<?php
							if ( has_nav_menu( 'primary' ) ) {
								wp_nav_menu(
									array(
										'theme_location' => 'primary',
										'menu_class'     => 'navigation clearfix',
										'container'      => 'ul',
									)
								);
							} else {
								wp_nav_menu(
									array(
										'menu_class' => 'navigation clearfix',
										'container'  => 'ul',
									)
								);
							}
						?>
				
		<?php
	}
	/**
	 * sticky header compatibility.
	 */
	public static function loveicon_sticky_header() {
		$sticky_header_logo = loveicon_get_options( 'sticky_header_logo' );
		$sticky_header_on   = loveicon_get_options( 'sticky_header_on' );
		if ( $sticky_header_on == 1 ) :
			?>
				<div class="sticky-header">
					<div class="container">
						<div class="clearfix">
							<!--Logo-->
							<div class="logo float-left">
								<?php if ( isset( $sticky_header_logo['url'] ) && $sticky_header_logo['url'] != '' ) : ?>
									<a class="img-responsive" href="<?php echo esc_url( home_url( '/' ) ); ?>" ><img src="<?php echo esc_url( $sticky_header_logo['url'], 'loveicon' ); ?>" alt="<?php esc_attr_e( 'Logo', 'loveicon' ); ?>"></a>
								<?php else : ?>
									<a class="img-responsive" href="<?php echo esc_url( home_url( '/' ) ); ?>" ><img src="<?php echo esc_url( LOVEICON_IMG_URL . 'sticky-logo.png' ); ?>" alt="<?php esc_attr_e( 'Logo', 'loveicon' ); ?>"></a>
								<?php endif; ?>
							</div>
							<!--Right Col-->
							<div class="right-col float-right">
								<!-- Main Menu -->
								<nav class="main-menu clearfix">
								<!--Keep This Empty / Menu will come through Javascript-->
								</nav>   
							</div>
						</div>
					</div>
				</div>
			<?php
		endif;
	}
	/**
	 * mobile menu compatibility.
	 */
	public static function loveicon_mobile_menu() {
		$mobile_menu_social  = loveicon_get_options( 'mobile_menu_social' );
		$mobile_menu_logo    = loveicon_get_options( 'mobile_menu_logo' );
		?>
			<div class="mobile-menu">
				<div class="menu-backdrop"></div>
				<div class="close-btn"><span class="icon fa fa-times-circle"></span></div>
				<nav class="menu-box">
					<div class="nav-logo">
						<?php if ( isset( $mobile_menu_logo['url'] ) && $mobile_menu_logo['url'] != '' ) : ?>
							<a href="<?php echo esc_url( home_url( '/' ) ); ?>" ><img src="<?php echo esc_url( $mobile_menu_logo['url'], 'loveicon' ); ?>"  alt="<?php esc_attr_e( 'Logo', 'loveicon' ); ?>"></a>
						<?php else : ?>
							<a href="<?php echo esc_url( home_url( '/' ) ); ?>" ><img src="<?php echo esc_url( LOVEICON_IMG_URL . 'mobilemenu-logo.png' ); ?>" alt="<?php esc_attr_e( 'Logo', 'loveicon' ); ?>"></a>
						<?php endif; ?>
					</div>
					<div class="menu-outer"><!--Here Menu Will Come Automatically Via Javascript / Same Menu as in Header--></div>
					<?php if ( isset( $mobile_menu_social ) && !empty( $mobile_menu_social ) )  : ?>
					
						<div class="social-links">
							<ul class="clearfix">
								<?php
									foreach ( $mobile_menu_social as $social ) {
										?>
											<li>
												<a href="<?php echo esc_url( $social['title'] ); ?>">
													<img src="<?php echo esc_url( $social['image'] ); ?>" alt="<?php echo esc_attr( $social['url'] );?>"/>
												</a>
											</li>
										<?php
									}
								?>
							</ul>
						</div>
					<?php endif; ?>
				</nav>
			</div>
		<?php
	}
	/**
	 * All header and breadcrumb.
	 */
	public static function loveicon_breadcrumb() {
		$breadcrumb_title = 'loveicon';
		$breadcrumb_class = 'breadcrumb_no_bg';
		if ( is_front_page() && is_home() ) :
			$breadcrumb_title = ''; // deafult blog
			$breadcrumb_class = 'deafult-home-breadcrumb';
	  	elseif ( is_front_page() && ! is_home() ) :
		  $breadcrumb_title = ''; // custom home or deafult
		  $breadcrumb_class = 'custom-home-breadcrumb';
	   	elseif ( is_home() ) :
		   $blog_breadcrumb_switch = loveicon_get_options( 'blog_breadcrumb_switch' );
		   if ( $blog_breadcrumb_switch == '1' ) :

			   $blog_breadcrumb_content = loveicon_get_options( 'blog_breadcrumb_content' );

			   $blog_style = get_query_var( 'blog_style' );
			   if ( ! $blog_style ) {
				   $blog_style = loveicon_get_options( 'blog_style' );
			   }
			   if ( $blog_style == 1 ) :
				   $blog_breadcrumb_content = loveicon_get_options( 'blog_breadcrumb_content' );
			elseif ( $blog_style == 2 ) :
				$blog_breadcrumb_content = loveicon_get_options( 'blog_breadcrumb_content' );
			elseif ( $blog_style == 3 ) :
				$blog_breadcrumb_content = loveicon_get_options( 'blog_breadcrumb_content' );
			endif;

			$breadcrumb_title = $blog_breadcrumb_content;
		else :
			$breadcrumb_title = '';
		endif;
			$breadcrumb_class = 'blog-breadcrumb';
	   	elseif ( is_archive() ) :
			if ( class_exists('woocommerce') && is_woocommerce() ) :
				$breadcrumb_title = esc_html__( ' Shop ', 'loveicon' ); // custom home or deafult
				$breadcrumb_class = 'custom-woocommerce-breadcrumb';	
			else : 
				$breadcrumb_title = get_the_archive_title();
				$breadcrumb_class = 'blog-breadcrumb';
			endif;
	   	elseif ( is_single() ) :
			if ( get_post_type( get_the_ID() ) == 'post' ) :
				$breadcrumb_title = get_the_title();
				$breadcrumb_class = 'blog-single-breadcrumb';
			elseif ( ( get_post_type() == 'campaign' ) && is_single() ) :
				$breadcrumb_title = get_the_title();
				$breadcrumb_class = get_post_type() . '-single-breadcrumb';
			elseif ( ( get_post_type() == 'tribe_events' ) && is_single() ) :
				$breadcrumb_title = esc_html__( 'Event Details ', 'loveicon' ); // custom home or deafult
				$breadcrumb_class = get_post_type() . '-single-breadcrumb';
			else :
				// post type
				$breadcrumb_title = get_post_type() . esc_html__( ' Details', 'loveicon' );
				$breadcrumb_class = get_post_type() . '-single-breadcrumb';
			endif;
	   	elseif ( is_404() ) :
		   $breadcrumb_title = esc_html__( 'Error Page', 'loveicon' );
		   $breadcrumb_class = 'blog-breadcrumb';
	   	elseif ( is_search() ) :
		   if ( have_posts() ) :
			   $breadcrumb_title = esc_html__( 'Search Results for: ', 'loveicon' ) . get_search_query();
			   $breadcrumb_class = 'blog-breadcrumb';
		else :
			$breadcrumb_title = esc_html__( 'Nothing Found', 'loveicon' );
			$breadcrumb_class = 'blog-breadcrumb';
		endif;
	   	elseif ( ! is_home() && ! is_front_page() && ! is_search() && ! is_404() ) :
		   $breadcrumb_title = get_the_title();
		   $breadcrumb_class = 'page-breadcrumb';
	   	endif;
	   		$breadcrumb_active_class = 'breadcrumb-not-active';
	   	if ( function_exists( 'bcn_display' ) ) :
		   $breadcrumb_active_class = '';
	   	endif;
		?>
		<?php
		$loveicon_show_breadcrumb      = get_post_meta( get_the_ID(), 'loveicon_theme_metabox_show_breadcrumb', true );
		$header_menu_style            = loveicon_get_options( 'header_menu_style' );
		$breadcrumb_class_with_header = 'breadcrumb-class-with-header-one';
		if ( $header_menu_style == '2' ) :
			$breadcrumb_class_with_header = '';
		endif;

		?>
		<?php if ( $loveicon_show_breadcrumb != 'off' ) : ?>
			<?php if ( isset( $breadcrumb_title ) && ! empty( $breadcrumb_title ) ) : ?>
				<section class="breadcrumb-area <?php echo esc_attr( $breadcrumb_class . ' ' . $breadcrumb_active_class . ' ' . $breadcrumb_class_with_header ); ?>">
					<div class="container">
						<div class="row">
							<div class="col-xl-12">
								<div class="inner-content text-center">
									<div class="parallax-scene parallax-scene-1">
										<div data-depth="0.20" class="parallax-layer shape wow zoomInRight" data-wow-duration="2000ms">
											<div class="shape1">
												<img class="float-bob" src="<?php echo get_template_directory_uri(); ?>/assets/images/shape/breadcrumb-shape1.png" alt="<?php echo esc_attr( 'shape' );?>">
											</div>  
										</div>
									</div>
									<div class="parallax-scene parallax-scene-1">
										<div data-depth="0.20" class="parallax-layer shape wow zoomInRight" data-wow-duration="2000ms">
											<div class="shape2">
												<img class="zoominout" src="<?php echo get_template_directory_uri(); ?>/assets/images/shape/breadcrumb-shape2.png" alt="<?php echo esc_attr( 'shape' );?>">
											</div>  
										</div>
									</div>
									<div class="title">
									<h2><?php echo sprintf( __( '%s', 'loveicon' ), $breadcrumb_title ); ?></h2>
									</div>
									<div class="border-box"></div>
									<?php if ( function_exists( 'bcn_display' ) ) : ?>
										<div class="breadcrumb-menu">
											<ul>
												<?php bcn_display(); ?>
											</ul>    
										</div>
									<?php endif; ?>
								</div>
							</div>
						</div>
					</div>
				</section>
			<?php endif; ?>
		<?php endif; ?>
		<?php
	}
	/**
	 * loveicon search popup compatibility.
	 */
	public static function loveicon_blog_social() {
		?>
				<li>
					<a onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo esc_url( get_permalink() ); ?>"><span class="fab fa-facebook-f"></span></a>
				</li>
				<li>
					<a onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;" href="https://twitter.com/home?status=<?php echo urlencode( get_the_title() ); ?>-<?php echo esc_url( get_permalink() ); ?>"><span class="fab fa-twitter"></span></a>
				</li>
				<li>
					<a onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;" href="https://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo esc_url( get_permalink() ); ?>" target="_blank">
						<span class="fab fa-linkedin-in"></span>
					</a>
				</li>
				<li>
					<a onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;" href="http://www.stumbleupon.com/submit?url=<?php echo esc_url( get_permalink() ); ?>&amp;text=<?php echo urlencode( get_the_title() ); ?>"><span class="fab fa-mix"></span></a>
				</li>
		<?php
	}
	/**
	 * autor box compatibility.
	 */
	public static function loveicon_authore_box() {
		$blog_authore_switch = loveicon_get_options('blog_authore_switch');
		if($blog_authore_switch == 1 ) : 
			global $post;
			$display_name = get_the_author_meta('display_name', $post->post_author);
			$user_description = get_the_author_meta('user_description', $post->post_author);
			$user_avatar = get_avatar($post->post_author, 150);
			if (isset($display_name) ||  isset($user_description) || isset($user_avatar)) {
		?>
				<div class="author-box-holder">
					<div class="inner-box">
						<div class="img-box">
							<?php echo wp_kses_post($user_avatar); ?>
						</div>
						<div class="text-box">
							<h3><?php echo wp_kses_post(ucfirst($display_name)); ?> <span><?php echo esc_html__( '(Author)', 'loveicon' ); ?></span></h3>
							<?php echo wp_kses_post($user_description); ?>
						</div>
					</div>
				</div>
		<?php } else {
		?>
			<div class="no-author-box"></div>
			<?php
		}
		endif;
	}
	/**
	 * loveicon compatibility.
	 */
	public static function loveicon_kses_allowed_html( $tags, $context ) {
		switch ( $context ) {
			case 'code_contxt':
				$tags = array(
					'iframe' => array(
						'allowfullscreen' => array(),
						'frameborder'     => array(),
						'height'          => array(),
						'width'           => array(),
						'src'             => array(),
						'class'           => array(),
					),
					'li'     => array(
						'class' => array(),
					),
					'h5'     => array(
						'class' => array(),
					),
					'span'   => array(
						'class' => array(),
					),
					'a'      => array(
						'href' => array(),
					),
					'i'      => array(
						'class' => array(),
					),
					'br'     => array(
						'class' => array(),
					),
					'p'      => array(),
					'em'     => array(),
					'strong' => array(),
				);
				return $tags;
			case 'author_avatar':
				$tags = array(
					'img' => array(
						'class'  => array(),
						'height' => array(),
						'width'  => array(),
						'src'    => array(),
						'alt'    => array(),
					),
				);
				return $tags;
			default:
				return $tags;
		}
	}
}
	$loveicon_int = new loveicon_Int();
