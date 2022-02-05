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
    if (is_active_sidebar('sidebar-1')) :
        $blog_post_list_class = 'col-xl-8';
    else :
        $blog_post_list_class = 'col-xl-12';
    endif;
    $blog_list_base_css   = loveicon_get_options( 'blog_list_base_css' );
    $blog_list_base_class = 'base-blog-list';
    if($blog_list_base_css == 1 ) :
        $blog_list_base_class = '';
    endif;
    $blog_breadcrumb_class = 'blog-breadcrumb-active';
    $blog_breadcrumb_switch   = loveicon_get_options( 'blog_breadcrumb_switch' );
    if($blog_breadcrumb_switch == 1) :
        $blog_breadcrumb_class = '';
    endif;
?>
    <section class="blog-page-two <?php echo esc_attr($blog_breadcrumb_class); ?>">
        <div class="container">
            <div class="row text-right-rtl">
                <div class="<?php echo esc_attr($blog_post_list_class); ?>">
                    <div class="blog2-content-box blog-post-list-me">
                        <?php
                            if (have_posts()) :
                                
                                while (have_posts()) :
                                    the_post();
                                    get_template_part('template-parts/blog-layout/blog-standard-content');

                                endwhile;
                            else :
                                get_template_part('template-parts/content', 'none');
                            endif;
                        ?>
                        <?php if(get_the_posts_pagination()) : ?>
                            <div class="row">
                                <div class="col-xl-12">
                                    <?php
                                        the_posts_pagination(array(
                                            'mid_size' => 2,
                                            'prev_text' => '<i class="fa fa-long-arrow-left"></i>',
                                            'next_text' => '<i class="fa fa-long-arrow-right"></i>',
                                            
                                        ));
                                    ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>    
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
<?php get_footer();

