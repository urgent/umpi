<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package loveicon
 */

get_header();
?>
<section class="error-page-area">
	<div class="container">
		<div class="row">
			<div class="col-xl-12">
				<div class="error-content text-center " >
					<h4><?php esc_html_e( 'Page Not Found', 'loveicon' ); ?></h4>
					<div class="title thm_clr1"><?php esc_html_e( '404', 'loveicon' ); ?></div>
					<p><?php esc_html_e( 'We’re unable to find a page you are looking for, Try later or click the button.', 'loveicon' ); ?></p>
					<div class="btns-box">
						<a class="btn-one" href="<?php echo esc_url( get_home_url() ); ?>"><span class="txt"><?php esc_html_e( 'Back to Home', 'loveicon' ); ?></span></a>
					</div>
				</div>    
			</div>
		</div>       
	</div>
</section>
<?php
get_footer();
