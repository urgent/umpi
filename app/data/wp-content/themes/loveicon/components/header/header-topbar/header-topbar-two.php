<?php
$header_top_bar_slider      = loveicon_get_options( 'header_top_bar_slider' );
$header_top_bar_social      = loveicon_get_options( 'header_top_bar_social' );
$header_top_bar_button_text = loveicon_get_options( 'header_top_bar_button_text' );
$header_top_bar_button_url  = loveicon_get_options( 'header_top_bar_button_url' );
$header_top_bar_map         = loveicon_get_options( 'header_top_bar_map' );
$header_top_bar_phone       = loveicon_get_options( 'header_top_bar_phone' );
$header_top_bar_lang        = loveicon_get_options( 'header_top_bar_lang' );
?>
<div class="header-top-two">
	<div class="auto-container">
		<div class="outer-box clearfix">

			<div class="header-top-two_left pull-left">
				<div class="header-social-link-2">
					<div class="title">
						<h5>
							<?php
								echo esc_html__( 'Follow Us', 'loveicon' );
							?>
						</h5>
					</div>
					<?php if ( isset( $header_top_bar_social ) && ! empty( $header_top_bar_social ) ) : ?>
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
					<?php endif; ?>
				</div>    
			</div>

			<div class="header-top-two_right pull-right">
				<div class="header-contact-info-1">
					<ul>
						<li>
							<p><span class="flaticon-phone-call"></span><?php echo sprintf( __( '%s', 'loveicon' ), $header_top_bar_phone ); ?></p>
						</li>
						<li>
							<p><span class="flaticon-placeholder"></span><?php echo sprintf( __( '%s', 'loveicon' ), $header_top_bar_map ); ?></p>
						</li>
					</ul>
				</div>
				<div class="language-select-box float-right">
					<div class="icon">
						<span class="flaticon-earth-grid-symbol"></span>
					</div>
					<div class="select-box">
						<select class="selectpicker" name="language">
							<?php echo sprintf( __( '%s', 'loveicon' ), $header_top_bar_lang ); ?>
						</select>
					</div>
				</div>
			</div>

		</div>
	</div>    
</div>
