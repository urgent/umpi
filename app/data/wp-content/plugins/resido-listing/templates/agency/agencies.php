<?php
get_header('listing');
$listing_option = get_option('resido_listings_options');
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$wp_query = new WP_Query([
    'post_type' => 'ragencies',
    'post_status' => 'publish',
    'paged' => $paged,
]);
$agency_breadcrumb           = resido_get_options('agency_breadcrumb');
$archive_page_title         = resido_get_options('agency_archive_page_title');
$archive_page_subtitle      = resido_get_options('agency_archive_page_subtitle');
?>
<!-- ============================ Page Title Start================================== -->
<?php if (isset($agency_breadcrumb) && $agency_breadcrumb == 1) { ?>
    <div class="page-title">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-12 col-md-12">
                    <h2 class="ipt-title"><?php esc_html_e($archive_page_title, 'resido-listing') ?></h2>
                    <span class="ipn-subtitle"><?php esc_html_e($archive_page_subtitle, 'resido-listing') ?></span>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<!-- ============================ Agent List Start ================================== -->
<section class="bg-light">
    <div class="container">
        <div class="row">
            <?php if ($wp_query->have_posts()) {
                while ($wp_query->have_posts()) {
                    $wp_query->the_post();
            ?>
                    <!-- Single Agent -->
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="agents-grid">
                            <div class="agents-grid-wrap">

                                <div class="fr-grid-thumb">
                                    <a href="<?php the_permalink(); ?>">
                                        <?php if (has_post_thumbnail()) { ?>
                                            <img src="<?php echo get_the_post_thumbnail_url(get_the_ID()); ?>" class="img-fluid mx-auto" alt="" />
                                        <?php } else { ?>
                                            <img src="<?php echo plugins_url('resido-listing') . '/assets/img/placeholder.png'; ?>" alt="">
                                        <?php  } ?>
                                    </a>
                                </div>

                                <div class="fr-grid-deatil">
                                    <div class="fr-grid-deatil-flex">
                                        <h5 class="fr-can-name"><a href="<?php the_permalink(); ?>"><?php the_title() ?></a></h5>
                                        <?php
                                        $agency_args = array(
                                            'post_type' => 'rlisting',
                                            'post_status' => array('publish'),
                                            'posts_per_page' => -1, // no limit,
                                            'meta_query' => array(
                                                array(
                                                    'key' => 'rlisting_rlagencyinfo',
                                                    'value' => get_the_ID(),
                                                    'compare' => '='
                                                )
                                            ),
                                        );
                                        $agency_count_query = new WP_Query($agency_args);
                                        if ($agency_count_query->post_count > 1) {
                                            $property_text = esc_html__('Properties', 'resido-listing');
                                        } else {
                                            $property_text = esc_html__('Property', 'resido-listing');
                                        }
                                        ?>
                                        <span class="agent-property"><?php echo esc_html($agency_count_query->post_count . ' ' . $property_text); ?></span>
                                    </div>
                                    <div class="fr-grid-deatil-flex-right">
                                        <div class="agent-email"><a href="<?php the_permalink(); ?>"><i class="ti-email"></i></a></div>
                                    </div>
                                </div>
                            </div>
                            <div class="fr-grid-info">
                                <ul>
                                    <?php
                                    if (get_post_meta(get_the_ID(), 'rlisting_agency_cell', true) != '') { ?>
                                        <li><strong><?php echo esc_html__('Call:', 'resido-listing') ?></strong><?php listing_meta_field('agency_cell'); ?></li>
                                    <?php } ?>
                                </ul>
                            </div>
                            <div class="fr-grid-footer">
                                <?php
                                if (get_post_meta(get_the_ID(), 'rlisting_agency_address', true) != '') { ?>
                                    <div class="fr-grid-footer-flex">
                                        <span class="fr-position"><i class="lni-map-marker"></i><?php listing_meta_field('agency_address'); ?></span>
                                    </div>
                                <?php } ?>
                                <div class="fr-grid-footer-flex-right">
                                    <a href="<?php the_permalink(); ?>" class="prt-view" tabindex="0"><?php echo esc_html__('View', 'resido-listing'); ?></a>
                                </div>
                            </div>
                        </div>
                    </div>
            <?php
                }
            }
            wp_reset_query();
            ?>
            <!-- Pagination -->
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <ul class="pagination p-center">
                        <?php
                        the_posts_pagination(
                            array(
                                'mid_size'  => 2,
                                'prev_text' => '<span class="ti-arrow-left"></span>',
                                'next_text' => '<span class="ti-arrow-right"></span>',
                            )
                        );
                        ?>
                    </ul>
                </div>
            </div>
            <!-- Pagination -->
        </div>
    </div>
</section>

<!-- =================== Sidebar Search ==================== -->

<?php
get_footer();
