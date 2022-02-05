<?php echo sprintf(
	__(
		'%1$s provides free support for 6 months for every LICENSE you purchase. You are also able to extend support through subscriptions via ThemeForest. 
              Our support center will handle all supports from our company website. Follow these steps to get access to your support. 
              %2$s community are given below. You are also able to extend support through subscriptions via ThemeForest . Our support center will handle all supports from our company website .
					Follow these steps to get access to your support . % s community are given below . ',
		'loveicon'
	),
	$this->dashboard_Name,
	$this->dashboard_Name
)
?>
			  </p>
			</div>
			<div class="support-message" style="font-weight:bold">
			<p>
			<?php
			esc_html_e(
				'Please remember ! Our support time is Monday to Friday 8.00AM to 05.00PM( GMT 6 + ) . We\'re very grateful for your patience during the off days.',
				'loveicon'
			);
			?>
				</p>
			</div>
		  </div>
		  <div class="feature-section col three-col">
			<div class="col">
			  <h3><span class="dashicons dashicons-sos"></span><?php esc_html_e( 'Submit A Ticket', 'loveicon' ); ?></h3>
			  <p><?php esc_html_e( 'Register your purchase first and get access to our support service and other resources to let us provide you our excellent support.', 'loveicon' ); ?></p>
			  <a href="http://support.smartdatasoft.com/support/" class="button button-large button-primary avada-large-button" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'Submit a ticket', 'loveicon' ); ?></a> </div>
			<div class="col">
			  <h3><span class="dashicons dashicons-book"></span><?php esc_html_e( 'Documentation', 'loveicon' ); ?></h3>
			  <p><?php esc_html_e( 'If you want to get the whole ball of wax of our theme, this is the place for you to check. It has an incredible reserve of information for different aspects of life.', 'loveicon' ); ?></p>
			  <a href="<?php echo esc_url( $this->doc_url ); ?>" class="button button-large button-primary avada-large-button" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'Documentation', 'loveicon' ); ?></a> </div>
			<div class="col last-feature">
			  <h3><span class="dashicons dashicons-video-alt3"></span><?php esc_html_e( 'Video Tutorials', 'loveicon' ); ?><p>
				<?php	esc_html_e( 'Video tutorials are one of the best ways to learn something, right? We provide tutorials in our youtube channel. Subscribe and get access to a library of high definition, easily narrated video tutorials. Dont forget to click the bell button to get notified every time we upload a video.', 'loveicon' ); ?>
				</p>
			  <a href="https://www.youtube.com/user/smartdatasoft/playlists/" class="button button-large button-primary avada-large-button" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'Video Tutorials', 'loveicon' ); ?></a> </div>
		  </div>
		</div>
	  </div>
	</div>
  </div>
</div>
