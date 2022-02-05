<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package loveicon
 */
get_header();
	if (is_active_sidebar('sidebar-1')) :
		$blog_post_list_class = 'col-xl-8';
	else :
		$blog_post_list_class = 'col-xl-12';
	endif;

	$blog_single_base_css   = loveicon_get_options( 'blog_single_base_css' );
	$blog_single_base_class = 'base-blog-single';
	if($blog_single_base_css == 1 ) :
		$blog_single_base_class = '';
	endif;

    $blog_single_breadcrumb_class = 'blog-single-breadcrumb-active';
    $blog_single_breadcrumb_switch   = loveicon_get_options( 'blog_single_breadcrumb_switch' );
    if($blog_single_breadcrumb_switch == 1) :
        $blog_single_breadcrumb_class = '';
	endif;
	
	$blog_featured_img_url = get_the_post_thumbnail_url(get_the_ID(),'full');
	$blog_featured_img_url_class = '';
	if( $blog_featured_img_url == ''):
		$blog_featured_img_url_class = 'no-bg-on-single-blog';
	endif;
?>
	<section class="blog-details-area <?php echo esc_attr($blog_single_base_class . ' ' . $blog_single_breadcrumb_class); ?>">
		<div class="container">
			<div class="row text-right-rtl">
				<div class="<?php echo esc_attr($blog_post_list_class); ?> ">
					<?php
						if (have_posts()) :
							
							while (have_posts()) :
								the_post();
								get_template_part('template-parts/single/content', get_post_format());
							endwhile;
						endif;
					?>
				</div> 
				<?php if (is_active_sidebar('sidebar-1')) { ?>
					<div class="col-xl-4">
						<div class="sidebar-content-box">
							<?php get_sidebar(); ?>
						</div>
					</div>
				<?php } ?>
				
			</div>
		</div>
	</section>
<?php
get_footer();