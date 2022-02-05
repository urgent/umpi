<?php
$header_mdl_bar_slider      = loveicon_get_options( 'header_mdl_bar_slider' );
$header_top_bar_slider      = loveicon_get_options( 'header_top_bar_slider' );
$header_top_bar_social      = loveicon_get_options( 'header_top_bar_social' );
$header_top_bar_button_text = loveicon_get_options( 'header_top_bar_button_text' );
$header_top_bar_button_url  = loveicon_get_options( 'header_top_bar_button_url' );
$header_top_bar_map         = loveicon_get_options( 'header_top_bar_map' );
$header_top_bar_phone       = loveicon_get_options( 'header_top_bar_phone' );
$header_top_bar_lang        = loveicon_get_options( 'header_top_bar_lang' );
?>
<div class="header-top-four">
	<div class="container">
		<div class="outer-box clearfix">

			<div class="header-top-four_left pull-left">
				<div class="header-contact-info-1 header-contact-info-2">
					<ul>
						<li>
							<p><span class="flaticon-phone-call"></span><?php echo sprintf( __( '%s', 'loveicon' ), $header_top_bar_phone ); ?></p>
						</li>
						<li>
							<p><span class="flaticon-placeholder"></span><?php echo sprintf( __( '%s', 'loveicon' ), $header_top_bar_map ); ?></p>
						</li>
					</ul>
				</div>   
			</div>

			<?php if ( isset( $header_top_bar_social ) && ! empty( $header_top_bar_social ) ) : ?>
				<div class="header-top-four_right pull-right">
					<div class="header-social-link-3">
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
					<div class="btns-box">
						<a class="btn-one" href="<?php echo esc_url( $header_top_bar_button_url ); ?>"><span class="txt"><i class="arrow1 fa fa-check-circle"></i><?php echo sprintf( __( '%s', 'loveicon' ), $header_top_bar_button_text ); ?></span></a>
					</div>

				</div>
			<?php endif; ?>

		</div>
	</div>    
</div>

<?php if ( isset( $header_top_bar_slider ) && ! empty( $header_top_bar_slider ) ) : ?>
	<div class="header-latest-news">
		<div class="container">
			<div class="outer-box">
				<div class="header-latest-news_content">
					<div class="icon">
						<img src="<?php echo get_template_directory_uri(); ?>/assets/images/icon/arrow-2.png" alt="<?php echo esc_attr( 'arrow' ); ?>"> 
						<h5>
							<?php
								echo esc_html__( 'Latest News', 'loveicon' );
							?>
						</h5>
					</div>
					<div class="header-latest-news_content-inner text-right-rtl">
						<div class="theme_carousel header-latest-news_carousel owl-theme owl-carousel" data-options='{"loop": true, "margin": 0, "autoheight":true, "lazyload":true, "nav": true, "dots": false, "autoplay": true, "autoplayTimeout": 6000, "smartSpeed": 300, "responsive":{ "0" :{ "items": "1" }, "600" :{ "items" : "1" }, "768" :{ "items" : "1" } , "1139":{ "items" : "1" }, "1200":{ "items" : "1" }}}'>
							<?php
							foreach ( $header_mdl_bar_slider as $items ) {
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
			</div>
		</div>
	</div>
<?php endif; ?>
