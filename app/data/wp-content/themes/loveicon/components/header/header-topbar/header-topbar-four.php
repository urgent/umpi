<?php
$header_top_bar_slider      = loveicon_get_options( 'header_top_bar_slider' );
$header_top_bar_social      = loveicon_get_options( 'header_top_bar_social' );
$header_top_bar_button_text = loveicon_get_options( 'header_top_bar_button_text' );
$header_top_bar_button_url  = loveicon_get_options( 'header_top_bar_button_url' );
$header_top_bar_map         = loveicon_get_options( 'header_top_bar_map' );
$header_top_bar_phone       = loveicon_get_options( 'header_top_bar_phone' );
$header_top_bar_lang        = loveicon_get_options( 'header_top_bar_lang' );
$header_top_bar_menu        = loveicon_get_options( 'header_top_bar_menu' );
?>
<div class="header-top-five">
	<div class="auto-container">
		<div class="outer-box clearfix">

			<div class="header-top-five_left pull-left">
				<div class="header-contact-info-3">
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
			
			<?php if ( isset( $header_top_bar_menu ) && ! empty( $header_top_bar_menu ) ) : ?>
				<div class="header-top-five_right pull-right">
					<div class="header-top-menu1">
						<ul>
							<?php
							foreach ( $header_top_bar_menu as $menu ) {
								?>
										<li>
											<a href="<?php echo esc_url( $menu['title'] ); ?>">
										<?php echo sprintf( __( '%s', 'loveicon' ), $menu['description'] ); ?>
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
