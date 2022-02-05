<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package loveicon
 */

$footer_base_css  = loveicon_get_options( 'footer_base_css' );
$footer_copyright             = loveicon_get_options( 'footer_copyright' );

	$footer_left_widget_elementor = loveicon_get_options('footer_left_widget_elementor');
	
	$footer_base_css_class = 'base-footer';
	if ( $footer_base_css == 1 ) :
		$footer_base_css_class = '';
	endif;
?>
	<?php get_template_part( 'components/footer/footer-top' ); ?>
	<footer class="footer-area <?php echo esc_attr( $footer_base_css_class ); ?>">
		<div class="footer-bottom">
			<div class="auto-container">
				<div class="footer-bottom_content_box text-center">
					<div class="copyright-text">
						<p>
						<?php
						if ( $footer_copyright != '' ) :
							echo wp_kses( $footer_copyright, 'code_contxt' );
						else :
							esc_html_e( '&copy; Copyright 2021 by Loveicon', 'loveicon' );
						endif;
						?>
						</p>
					</div>
				</div>
			</div>
		</div>
	</footer>
	<?php do_action( 'loveicon_slide_menu_ready' ); ?>
	<?php do_action( 'loveicon_back_to_top_ready' ); ?>
</div>
<?php wp_footer(); ?>
</body>
</html>
