<?php
$header_top_bar_slider = loveicon_get_options( 'header_top_bar_slider' );
$header_top_bar_social = loveicon_get_options( 'header_top_bar_social' );
?>
<div class="header-top">
		<div class="container">
			<div class="outer-box clearfix">
				<?php if ( isset( $header_top_bar_slider ) && ! empty( $header_top_bar_slider ) ) : ?>
					<div class="header-top_left pull-left">
						<div class="icon">
							<img src="<?php echo get_template_directory_uri(); ?>/assets/images/icon/arrow-1.png" alt="<?php echo esc_attr( 'arrow' ); ?>">    
						</div>
						<div class="header-top_left-content">
							<div class="theme_carousel header-top_left-carousel owl-theme owl-carousel" data-options='{"loop": true, "margin": 0, "autoheight":true, "lazyload":true, "nav": true, "dots": false, "autoplay": true, "autoplayTimeout": 6000, "smartSpeed": 300, "responsive":{ "0" :{ "items": "1" }, "600" :{ "items" : "1" }, "768" :{ "items" : "1" } , "1139":{ "items" : "1" }, "1200":{ "items" : "1" }}}'>
								
								
								<?php
								foreach ( $header_top_bar_slider as $items ) {
									?>
											<div class="single-item">
												<p><?php echo wp_kses( $items['title'], 'code_contxt' ); ?></p>
											</div>
										<?php
								}
								?>
							</div>    
						</div>
					</div>
				<?php endif; ?>

				<?php if ( isset( $header_top_bar_social ) && ! empty( $header_top_bar_social ) ) : ?>
					<div class="header-top_right pull-right">
						<div class="header-social-link-1">
							<ul class="clearfix">
								<?php
								foreach ( $header_top_bar_social as $social ) {
									?>
											<li>
												<a href="<?php echo esc_url( $social['title'] ); ?>">
													<img src="<?php echo esc_url( $social['image'] ); ?>" alt="<?php echo esc_attr( $social['url'] ); ?>"/>
												</a>
											</li>
										<?php
								}
								?>
							</ul>
						</div>
					</div>
				<?php endif; ?>

			</div>
		</div>    
	</div>
