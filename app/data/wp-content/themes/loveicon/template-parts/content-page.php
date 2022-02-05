<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package loveicon
 */

?>
<div class="blog-details-content custom-blog-sinlge page-content-area">
	<div class="single-blog-style1 single-blog-style2">
		<div class="text-holder">
			<div class="blog-details-text-area">
				<?php the_content(); ?>
			</div>
			<?php
				wp_link_pages(
					array(
						'before' => '<div class="page-links post-single-link">',
						'after'  => '</div>',
					)
				);
			?>
		</div> 
	</div>
	<?php
		if ( comments_open() || get_comments_number() ) :
			comments_template();
		endif;
	?>
</div>

