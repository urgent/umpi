<?php
get_header();

$author_id = $post->post_author;
$author_name = get_the_author_meta('display_name', $author_id);
$current_user = wp_get_current_user();
$user_id = $current_user->ID;
$usr_img_url = get_avatar_url($user_id);
$rcity = '';
$rstate = '';
$rcity = get_user_meta($user_id, 'rcity', true);
$rstate = get_user_meta($user_id, 'rstate', true);
$query_variable = get_query_var('dashboard');
?>

<!-- ============================ Page Title Start================================== -->
<div class="image-cover page-title">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <h2 class="ipt-title"><?php echo esc_html__('Agent Details', 'resido-listing'); ?></h2>
                <span class="ipn-subtitle">
                    <?php
                    the_title();
                    echo esc_html(' From ');
                    listing_meta_field('agent_address');
                    ?></span>
            </div>
        </div>
    </div>
</div>
<!-- ============================ Agent Name Start================================== -->
<section class="agent-page p-0 gray-simple">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="agency agency-list overlio-40">
                    <div class="agency-avatar">
                        <?php if (has_post_thumbnail()) { ?>
                            <img src="<?php echo get_the_post_thumbnail_url(get_the_ID()); ?>" alt="">
                        <?php } else { ?>
                            <img src="<?php echo plugins_url('resido-listing') . '/assets/img/placeholder.png'; ?>" alt="">
                        <?php  } ?>
                    </div>
                    <div class="agency-content">
                        <div class="agency-name">
                            <h4><?php the_title() ?></h4>
                            <?php
                            if (get_post_meta(get_the_ID(), 'rlisting_agent_address', true) != '') { ?>
                                <span><i class="lni-map-marker"></i><?php listing_meta_field('agent_address'); ?></span>
                            <?php } ?>
                        </div>
                        <div class="agency-desc">
                            <?php echo the_content(); ?>
                        </div>
                        <div class="prt-detio">
                            <?php
                            $agent_args = array(
                                'post_type' => 'rlisting',
                                'post_status' => array('publish'),
                                'posts_per_page' => -1, // no limit,
                                'meta_query' => array(
                                    array(
                                        'key' => 'rlisting_rlagentinfo',
                                        'value' => get_the_ID(),
                                        'compare' => '='
                                    )
                                ),
                            );
                            $agent_count_query = new WP_Query($agent_args);
                            if ($agent_count_query->post_count > 1) {
                                $property_text = __('Properties', 'resido-listing');
                            } else {
                                $property_text = __('Property', 'resido-listing');
                            }
                            ?>
                            <span><?php echo esc_html($agent_count_query->post_count . ' ' . $property_text); ?></span>
                        </div>
                        <?php
                        echo get_post_meta(get_the_ID(), 'rlisting_agent_social', true);
                        ?>
                        <div class="clearfix"></div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>

<!-- ============================ Property Detail Start ================================== -->
<section class="gray-simple">
    <div class="container">
        <div class="row">

            <!-- property main detail -->
            <div class="col-lg-8 col-md-12 col-sm-12">

                <?php
                $rlisting_agent_information = get_post_meta(get_the_ID(), 'rlisting_agent_information', true);
                if ($rlisting_agent_information != '') { ?>
                    <div class="block-wrap">
                        <div class="block-header">
                            <h4 class="block-title"><?php echo esc_html__('Agent Info', 'resido-listing'); ?></h4>
                        </div>
                        <div class="block-body">
                            <?php echo get_post_meta(get_the_ID(), 'rlisting_agent_information', true); ?>
                        </div>
                    </div>
                <?php }
                ?>


                <div class="block-wraps">
                    <div class="block-wraps-header">
                        <?php $terms = get_terms('rlisting_status', array(
                            'hide_empty' => true,
                        )); ?>
                        <div class="block-header">
                            <ul class="nav nav-tabs customize-tab" id="myTab" role="tablist">
                                <?php
                                foreach ($terms as $key => $term) {
                                    if ($key == 0) {
                                        $active_class = 'active';
                                    } else {
                                        $active_class = null;
                                    }
                                ?>
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link <?php echo esc_html($active_class); ?>" id="<?php echo esc_html($term->slug); ?>-tab" data-bs-toggle="tab" href="#<?php echo esc_html($term->slug); ?>" role="tab" aria-controls="<?php echo esc_html($term->slug); ?>" aria-selected="true"><?php echo esc_html($term->name); ?></a>
                                    </li>
                                <?php }  ?>
                            </ul>
                        </div>

                        <div class="block-body">
                            <div class="tab-content" id="myTabContent">

                                <?php
                                foreach ($terms as $key => $term) {
                                    if ($key == 0) {
                                        $active_class = 'active';
                                    } else {
                                        $active_class = null;
                                    }
                                ?>

                                    <div class="tab-pane fade show <?php echo esc_html($active_class); ?>" id="<?php echo esc_html($term->slug); ?>" role="tabpanel" aria-labelledby="<?php echo esc_html($term->slug); ?>-tab">
                                        <!-- row -->
                                        <div class="row">
                                            <?php

                                            $args = array(
                                                'post_type' => 'rlisting',
                                                'post_status' => array('publish'),
                                                'posts_per_page' => -1, // no limit,
                                                'tax_query' => array(
                                                    array(
                                                        'taxonomy' => 'rlisting_status',
                                                        'terms' => $term->slug,
                                                        'field' => 'slug',
                                                    ),
                                                ),
                                                'meta_query' => array(
                                                    array(
                                                        'key' => 'rlisting_rlagentinfo',
                                                        'value' => get_the_ID(),
                                                        'compare' => '='
                                                    )
                                                ),
                                            );
                                            $wp_query = new WP_Query($args);
                                            if ($wp_query->have_posts()) {
                                                while ($wp_query->have_posts()) {
                                                    $wp_query->the_post();
                                                    $term_name = wp_get_object_terms(get_the_ID(), 'rlisting_category', array('fields' => 'names'));
                                                    $term_ID = wp_get_object_terms(get_the_ID(), 'rlisting_category');
                                                    $rlisting_status = wp_get_object_terms(get_the_ID(), 'rlisting_status', array('fields' => 'names'));
                                                    $layout_val = '';
                                                    if (isset($listing_option['listing_layout_view']) && $listing_option['listing_layout_view']) {
                                                        $layout_val = $listing_option['listing_layout_view'];
                                                    }
                                                    $column = "col-lg-6 col-md-6"; ?>
                                                    <div class="<?php echo esc_attr__($column, 'resido-listing'); ?>">
                                                        <div class="property-listing property-2">
                                                            <div class="listing-img-wrapper">
                                                                <div class="list-img-slide">
                                                                    <div class="click">
                                                                        <?php if (has_post_thumbnail(get_the_ID())) { ?>
                                                                            <div><a href="<?php the_permalink(); ?>">
                                                                                    <?php the_post_thumbnail(); ?></a>
                                                                            </div>
                                                                            <?php }
                                                                        $galleryImage = listing_meta_field_gallery('gallery-image');
                                                                        if (!empty($galleryImage)) {
                                                                            foreach ($galleryImage as $image_id) {
                                                                                $image_url = wp_get_attachment_url($image_id);
                                                                            ?>
                                                                                <div><a href="<?php the_permalink(); ?>">
                                                                                        <img src="<?php echo esc_url($image_url); ?>" class="img-fluid mx-auto" alt="" /></a>
                                                                                </div>
                                                                        <?php
                                                                            }
                                                                        }
                                                                        ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="listing-detail-wrapper">
                                                                <div class="listing-short-detail-wrap">
                                                                    <?php if ($layout_val == 'classic') { ?>
                                                                        <!-- Classical Layout -->
                                                                        <div class="listing-short-detail">
                                                                            <h4 class="listing-name verified"><a href="<?php the_permalink(); ?>" class="prt-link-detail"><?php the_title() ?></a>
                                                                            </h4>
                                                                            <div class="property-reviews">
                                                                                <?php
                                                                                $average = resido_get_average_rate(get_the_ID());
                                                                                $averageRounded = ceil($average);
                                                                                if ($averageRounded) {
                                                                                    $active_comment_rate = $averageRounded;
                                                                                    for ($x = 1; $x <= $active_comment_rate; $x++) {
                                                                                        echo '<i class="fa fa-star filled"></i>';
                                                                                    }
                                                                                    $inactive_comment_rate = 5 - $active_comment_rate;
                                                                                    if ($inactive_comment_rate > 0) {
                                                                                        for ($x = 1; $x <= $inactive_comment_rate; $x++) {
                                                                                            echo '<i class="fa fa-star"></i>';
                                                                                        }
                                                                                    }
                                                                                }
                                                                                ?>
                                                                            </div>
                                                                        </div>
                                                                        <!-- Classical Layout -->
                                                                    <?php } else {
                                                                    ?>
                                                                        <!-- Grid Layout -->
                                                                        <div class="listing-short-detail">
                                                                            <span class="property-type"><?php echo $rlisting_status[0]; ?></span>
                                                                            <h4 class="listing-name verified">
                                                                                <a href="<?php the_permalink(); ?>" class="prt-link-detail"><?php the_title() ?></a>
                                                                            </h4>
                                                                        </div>
                                                                        <!-- Grid Layout -->
                                                                    <?php } ?>
                                                                    <div class="listing-short-detail-flex">
                                                                        <h6 class="listing-card-info-price">
                                                                            <?php resido_currency_html(); ?>
                                                                        </h6>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="price-features-wrapper">
                                                                <div class="list-fx-features">
                                                                    <div class="listing-card-info-icon">
                                                                        <div class="inc-fleat-icon">
                                                                            <img src="<?php echo plugins_url() . '/resido-listing/elementor/assets/img/bed.svg'; ?>" width="13" alt="" />
                                                                        </div>
                                                                        <?php listing_meta_field('bedrooms');
                                                                        echo esc_html__('Beds', 'resido-listing'); ?>
                                                                    </div>
                                                                    <div class="listing-card-info-icon">
                                                                        <div class="inc-fleat-icon">
                                                                            <img src="<?php echo plugins_url() . '/resido-listing/elementor/assets/img/bathtub.svg'; ?>" width="13" alt="" />
                                                                        </div>
                                                                        <?php listing_meta_field('bathrooms');
                                                                        echo esc_html__('Bath', 'resido-listing'); ?>
                                                                    </div>
                                                                    <div class="listing-card-info-icon">
                                                                        <div class="inc-fleat-icon">
                                                                            <img src="<?php echo plugins_url() . '/resido-listing/elementor/assets/img/move.svg'; ?>" width="13" alt="" />
                                                                        </div>
                                                                        <?php listing_meta_field('area_size'); ?><?php listing_meta_field('area_size_postfix'); ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="listing-detail-footer">
                                                                <div class="footer-first">
                                                                    <?php if (get_post_meta(get_the_ID(), "rlisting_address", true)) { ?>
                                                                        <div class="foot-location">
                                                                            <img src="<?php echo plugins_url() . '/resido-listing/elementor/assets/img/pin.svg'; ?>" width="18" alt="" /><?php listing_meta_field('address'); ?>
                                                                        </div>
                                                                    <?php } ?>
                                                                </div>
                                                                <div class="footer-flex">
                                                                    <a href="<?php the_permalink(); ?>" class="prt-view"><?php echo esc_html_e('View', 'resido-listing'); ?></a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- End Single Property -->
                                            <?php
                                                }
                                            };
                                            wp_reset_query();
                                            ?>
                                        </div>
                                        <!-- // row -->

                                        <div class="row">
                                            <div class="col-lg-12 col-md-12 col-sm-12 text-center">
                                                <a href="<?php echo get_post_type_archive_link('rlisting'); ?>" class="btn btn-theme-light-2 rounded"><?php echo esc_html_e('Explore More Property', 'resido-listing') ?></a>
                                            </div>
                                        </div>

                                    </div>
                                <?php }  ?>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <!-- property Sidebar -->
            <div class="col-lg-4 col-md-12 col-sm-12">
                <!-- Like And Share -->
                <div class="details-sidebar">
                    <?php if (is_active_sidebar('listing_single')) { ?>
                        <?php dynamic_sidebar('listing_single'); ?>
                    <?php } ?>

                </div>
            </div>

        </div>
    </div>
</section>
<!-- ============================ Property Detail End ================================== -->
<?php
get_footer();
