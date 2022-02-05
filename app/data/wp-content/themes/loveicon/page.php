<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package loveicon
 */
get_header();
	$blog_single_base_css   = loveicon_get_options( 'blog_single_base_css' );
	$blog_single_base_class = 'base-blog-single';
	if($blog_single_base_css == 1 ) :
		$blog_single_base_class = '';
    endif;
    $no_comment_area_page = '';
    if (!have_comments()) {
        $no_comment_area_page = 'no-comment-area';
	}
	$page_single_col = '12';
	$loveicon_theme_metabox_page_col = get_post_meta( get_the_ID(), 'loveicon_theme_metabox_page_col', true );
	if($loveicon_theme_metabox_page_col == 'on') :
		$page_single_col = '8';
	endif;
	$loveicon_theme_metabox_page_extra_class = get_post_meta( get_the_ID(), 'loveicon_theme_metabox_page_extra_class', true );
?>
	<section class="blog-details-area">
		<div class="container">
			<div class="row text-right-rtl">
				<?php 
					if($loveicon_theme_metabox_page_col == 'on') :
						do_action('page_advance_content_left');
					endif;
				?>
				<div class="col-lg-<?php echo esc_attr($page_single_col); ?> col-md-12 col-sm-12 text-right-rtl">
					<?php
						if (have_posts()) :
							while (have_posts()) :
								the_post();
								get_template_part( 'template-parts/content', 'page' );
							endwhile;
						endif;
					?>
				</div> 
				<?php 
					if($loveicon_theme_metabox_page_col == 'on') :
						do_action('page_advance_content_right');
					endif;
				?>
			</div>
		</div>
	</section>
<?php
get_footer();