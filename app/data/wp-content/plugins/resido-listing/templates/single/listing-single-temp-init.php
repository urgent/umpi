<?php


class Resido_Single_Init
{

    public static function resido_single_user_share()
    {
        $listing_option = resido_listing_option();
        $share_facebook = isset($listing_option['share_facebook']) ? $listing_option['share_facebook'] : 1;
        $share_twitter = isset($listing_option['share_twitter']) ? $listing_option['share_twitter'] : 1;
        $share_linked_in = isset($listing_option['share_instagram']) ? $listing_option['share_instagram'] : 1;

        $facebook = "http://www.facebook.com/sharer.php?u=" . get_the_permalink();
        $twitter = "http://twitter.com/home?status=" . get_the_title() . '  ' . get_the_permalink();
        $linked_in = "http://linkedin.com/shareArticle?mini=true&url=" . get_the_permalink() . "&title=" . get_the_title();
        $telegram = "https://t.me/share/url?url=" . get_the_permalink() . "&text=" . get_the_title();
        $vk = "http://vk.com/share.php?url=" . get_the_permalink();
?>
        <div class="pbwts-social">
            <ul>
                <li><?php echo esc_html__('Share:', 'resido-listing') ?></li>
                <?php
                if ($listing_option['share_facebook']) { ?>
                    <li><a href="<?php echo esc_url($facebook); ?>" target="_blank"><i class="ti-facebook"></i></a>
                    <li>
                    <?php }
                if ($listing_option['share_twitter']) { ?>
                    <li><a href="<?php echo esc_url($twitter); ?>" target="_blank"><i class="ti-twitter"></i></a>
                    <li>
                    <?php }
                if ($listing_option['share_linked_in']) { ?>
                    <li><a href="<?php echo esc_url($linked_in); ?>" target="_blank"><i class="ti-linkedin"></i></a>
                    <li>
                    <?php }
                if ($listing_option['share_whatsapp']) { ?>
                    <li><a href="whatsapp://send?text=<?php echo get_the_permalink(); ?>" target="_blank"><i class="lni-whatsapp"></i></a>
                    <li>
                    <?php }
                if ($listing_option['share_telegram']) { ?>
                    <li><a href="<?php echo esc_url($telegram); ?>" target="_blank"><i class="lni-telegram"></i></a>
                    <li>
                    <?php }
                if ($listing_option['share_vk']) { ?>
                    <li><a href="<?php echo esc_url($vk); ?>" target="_blank"><i class="lni-vk"></i></a>
                    <li>
                    <?php } ?>
            </ul>
        </div>
    <?php
    }

    public static function rlisting_single_title()
    {
        $rlisting_status = wp_get_object_terms(get_the_ID(), 'rlisting_status', array('fields' => 'names'));
        $bed_text = __('Beds', 'resido-listing');
        $bath_text = __('Bath', 'resido-listing');
    ?>
        <div class="prt-detail-title-desc lstng-pg-title-desc">
            <?php if ($rlisting_status) {
                foreach ($rlisting_status as $key => $rlisting_state) { ?>
                    <span class="prt-types sale"><?php echo $rlisting_state; ?></span>
            <?php }
            } ?>
            <h3><?php the_title(); ?></h3>
            <?php
            if (get_post_meta(get_the_ID(), 'rlisting_address', true)) { ?>
                <span class="lstng-pg-address"><i class="lni-map-marker"></i> <?php listing_meta_field('address'); ?></span>
            <?php }; ?>
            <h3 class="prt-price-fix"><?php resido_currency_html(); ?>
                <?php if (get_listing_meta_field('price_postfix')) { ?>
                    <sub>/<?php listing_meta_field('price_postfix'); ?></sub>
                <?php } ?>
            </h3>
            <div class="list-fx-features">
                <?php if (get_listing_meta_field('bedrooms')) { ?>
                    <div class="listing-card-info-icon">
                        <div class="inc-fleat-icon"><img src="<?php echo plugins_url() . '/resido-listing/elementor/assets/img/bed.svg'; ?>" width="13" alt=""></div><?php listing_meta_field('bedrooms'); ?> <?php echo esc_html__($bed_text, 'resido-lisitng'); ?>
                    </div>
                <?php }
                if (get_listing_meta_field('bathrooms')) { ?>
                    <div class="listing-card-info-icon">
                        <div class="inc-fleat-icon"><img src="<?php echo plugins_url() . '/resido-listing/elementor/assets/img/bathtub.svg'; ?>" width="13" alt=""></div><?php listing_meta_field('bathrooms'); ?> <?php echo esc_html__($bath_text, 'resido-lisitng'); ?>
                    </div>
                <?php }
                if (get_listing_meta_field('area_size') || get_listing_meta_field('area_size_postfix')) { ?>
                    <div class="listing-card-info-icon">
                        <div class="inc-fleat-icon"><img src="<?php echo plugins_url() . '/resido-listing/elementor/assets/img/move.svg'; ?>" width="13" alt=""></div><?php listing_meta_field('area_size'); ?> <?php listing_meta_field('area_size_postfix'); ?>
                    </div>
                <?php } ?>
            </div>
        </div>
        <?php
    }

    public static function listing_single_additional()
    {
        $single_listing_checkbox = resido_get_options('single_listing_checkbox');
        $short_details = listing_meta_fields('short_details');
        if (!empty($short_details)) {
        ?>
            <!-- Single Block Wrap -->
            <div class="property_block_wrap style-2">

                <div class="property_block_wrap_header">
                    <a data-bs-toggle="collapse" data-parent="#features" data-bs-target="#clOne" aria-controls="clOne" href="javascript:void(0);" aria-expanded="true" class="collapsed">
                        <h4 class="property_block_title"><?php echo esc_html__('Detail & Features', 'resido-listing'); ?></h4>
                    </a>
                </div>
                <div id="clOne" class="panel-collapse collapse<?php if ($single_listing_checkbox[2]) {
                                                                    echo ' show';
                                                                } ?>" aria-labelledby="clOne">
                    <div class="block-body">
                        <ul class="deatil_features">
                            <?php
                            foreach ($short_details[0] as $key => $detail) {
                            ?>
                                <li><strong><?php echo $detail['rlisting_short_title']; ?>:</strong><?php echo $detail['rlisting_short_value']; ?></li>
                            <?php
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
        <?php
        }
    }

    public static function listing_single_description()
    {
        $single_listing_checkbox = resido_get_options('single_listing_checkbox');
        ?>
        <!-- Single Block Wrap -->
        <div class="property_block_wrap style-2">
            <div class="property_block_wrap_header">
                <a data-bs-toggle="collapse" data-parent="#dsrp" data-bs-target="#clTwo" aria-controls="clTwo" href="javascript:void(0);" aria-expanded="true" class="collapsed">
                    <h4 class="property_block_title"><?php echo esc_html__('Description', 'resido-listing'); ?></h4>
                </a>
            </div>
            <div id="clTwo" class="panel-collapse collapse<?php if ($single_listing_checkbox[3]) {
                                                                echo ' show';
                                                            } ?>">
                <div class="block-body">
                    <?php
                    if (have_posts()) {
                        $counter = 1;
                        while (have_posts()) {
                            the_post();
                            the_content();
                        } // end while
                    } // end if
                    ?>
                </div>
            </div>
        </div>
        <?php
    }

    public static function listing_single_features()
    {
        $single_listing_checkbox    = resido_get_options('single_listing_checkbox');
        $rlisting_features          = get_the_terms(get_the_ID(), 'rlisting_features');

        $features_data = array();
        foreach ($rlisting_features as $rlisting_feature) {
            if ($rlisting_feature->parent == 0) {
                $features_data[$rlisting_feature->term_id] = array('parent' => $rlisting_feature->name);
                $features_child = get_term_children($rlisting_feature->term_id, 'rlisting_features');
                if (!empty($features_child)) {
                    foreach ($features_child as $key => $child) {
                        $child_name[$child] = get_term($child)->name;
                    }
                    $features_data[$rlisting_feature->term_id]['child'] = array();
                    $features_data[$rlisting_feature->term_id]['child'] = $child_name;
                }
            }
        }



        if (!empty($rlisting_features)) {
        ?>
            <!-- Single Block Wrap -->
            <div class="property_block_wrap style-2">
                <div class="property_block_wrap_header">
                    <a data-bs-toggle="collapse" data-parent="#amen" data-bs-target="#clThree" aria-controls="clThree" href="javascript:void(0);" aria-expanded="true" class="collapsed">
                        <h4 class="property_block_title"><?php echo esc_html__('Ameneties', 'resido-listing') ?></h4>
                    </a>
                </div>
                <div id="clThree" class="panel-collapse collapse<?php if ($single_listing_checkbox[4]) {
                                                                    echo ' show';
                                                                } ?>">
                    <div class="block-body">
                        <ul class="avl-features third color">
                            <?php
                            // foreach ($rlisting_features as $cat) {
                            //     echo '<li>' . $cat->name . '</li>';
                            // }

                            foreach ($features_data as $key => $feature) {
                                echo '<li>' . $feature['parent'];
                                if (isset($feature['child']) && !empty($feature['child'])) {
                                    echo '<ul class="inner-feat">';
                                    foreach ($feature['child'] as $child) {
                                        echo '<li>' . $child . '</li>';
                                    }
                                    echo '</ul>';
                                }
                                echo '</li>';
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
        <?php
        }
    }

    public static function listing_single_video()
    {
        $rlisting_video_link    = get_post_meta(get_the_ID(), 'rlisting_videolink', true);
        $rlisting_videoiframe    = get_post_meta(get_the_ID(), 'rlisting_videoiframe', true);
        $v_image_id             = get_post_meta(get_the_ID(), 'rlisting_v_image', true);
        $v_image_url            = wp_get_attachment_url($v_image_id);
        $single_listing_checkbox = resido_get_options('single_listing_checkbox');
        //
        if (!$v_image_url) {
            $v_image_url = plugins_url('resido-listing') . '/assets/img/placeholder.png';
        }
        if ($rlisting_video_link) {
        ?>
            <!-- Single Block Wrap -->
            <div class="property_block_wrap style-2">
                <div class="property_block_wrap_header">
                    <a data-bs-toggle="collapse" data-parent="#vid" data-bs-target="#clFour" aria-controls="clFour" href="javascript:void(0);" aria-expanded="true" class="collapsed">
                        <h4 class="property_block_title"><?php echo esc_html__('Property video', 'resido-listing'); ?></h4>
                    </a>
                </div>
                <div id="clFour" class="panel-collapse collapse<?php if ($single_listing_checkbox[5]) {
                                                                    echo ' show';
                                                                } ?>">
                    <div class="block-body">
                        <div class="property_video">
                            <div class="thumb">
                                <img class="pro_img img-fluid w100" src="<?php echo $v_image_url; ?>" alt="img">
                                <div class="overlay_icon">
                                    <div class="bb-video-box">
                                        <a href="<?php echo esc_url($rlisting_video_link); ?>" class="theme-cl" target="_blank">
                                            <div class="bb-video-box-inner">
                                                <div class="bb-video-box-innerup"><i class="ti-control-play"></i>
                                                </div>
                                            </div>
                                    </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php
        }
        if (empty($rlisting_video_link) && $rlisting_videoiframe) {
        ?>
            <!-- Single Block Wrap -->
            <div class="property_block_wrap style-2">
                <div class="property_block_wrap_header">
                    <a data-bs-toggle="collapse" data-parent="#vid" data-bs-target="#clFour" aria-controls="clFour" href="javascript:void(0);" aria-expanded="true" class="collapsed">
                        <h4 class="property_block_title"><?php echo esc_html__('Property video', 'resido-listing'); ?></h4>
                    </a>
                </div>
                <div id="clFour" class="panel-collapse collapse<?php if ($single_listing_checkbox[5]) {
                                                                    echo ' show';
                                                                } ?>">
                    <div class="block-body">
                        <?php echo $rlisting_videoiframe; ?>
                    </div>
                </div>
            </div>
        <?php
        }
    }

    public static function listing_single_floorplan()
    {
        $flor_plans = listing_meta_fields('flor_plan');
        $single_listing_checkbox = resido_get_options('single_listing_checkbox');
        if (!empty($flor_plans)) {
        ?>
            <!-- Single Block Wrap -->
            <div class="property_block_wrap style-2">
                <div class="property_block_wrap_header">
                    <a data-bs-toggle="collapse" data-parent="#floor" data-bs-target="#clFive" aria-controls="clFive" href="javascript:void(0);" aria-expanded="true" class="collapsed">
                        <h4 class="property_block_title"><?php echo esc_html__('Floor Plan', 'resido-listing'); ?></h4>
                    </a>
                </div>
                <div id="clFive" class="panel-collapse collapse<?php if ($single_listing_checkbox[6]) {
                                                                    echo ' show';
                                                                } ?>">
                    <div class="block-body">
                        <div class="accordion" id="floor-option">
                            <?php
                            foreach ($flor_plans[0] as $key => $plan) {
                                //exit;
                                if (isset($plan['rlisting_floor_title'])) {
                                    $floor_title = $plan['rlisting_floor_title'];
                                } else {
                                    $floor_title = "Untitled";
                                }

                                if (isset($plan['rlisting_floor_size'])) {
                                    $floor_size = $plan['rlisting_floor_size'];
                                } else {
                                    $floor_size = "Undefined";
                                }

                                if (isset($plan['rlisting_size_postfix'])) {
                                    $size_postfix = $plan['rlisting_size_postfix'];
                                } else {
                                    $size_postfix = "";
                                }

                                $floor_image_id = '';
                                if (isset($plan['rlisting_floor_image'])) {
                                    $floor_image_id = $plan['rlisting_floor_image'];
                                }
                                $image_url = wp_get_attachment_url($floor_image_id);
                                $floor_title_id = str_replace(' ', '', $floor_title);
                                $floor_id = strtolower($floor_title_id);

                                if ($image_url) { ?>
                                    <div class="card">
                                        <div class="card-header" id="<?php echo esc_attr($floor_id); ?>">
                                            <h2 class="mb-0">
                                                <button type="button" class="btn btn-link" data-bs-toggle="collapse" data-bs-target="#firstfloor<?php echo $key; ?>" aria-controls="<?php echo esc_attr($floor_id); ?>">
                                                    <?php echo esc_html__($floor_title, 'resido-listing'); ?><span><?php echo $floor_size; ?> <?php echo $size_postfix; ?></span></button>
                                            </h2>
                                        </div>
                                        <div id="firstfloor<?php echo $key; ?>" class="collapse" aria-labelledby="<?php echo esc_attr($floor_id); ?>" data-parent="#floor-option">
                                            <div class="card-body">
                                                <img src="<?php echo $image_url; ?>" class="img-fluid" alt="" />
                                            </div>
                                        </div>
                                    </div>
                                <?php } else { ?>
                                    <div class="card">
                                        <div class="card-header" id="<?php echo esc_attr($floor_id); ?>">
                                            <h2 class="mb-0">
                                                <button type="button" class="btn btn-link" aria-controls="<?php echo esc_attr($floor_id); ?>">
                                                    <?php echo $floor_title; ?><span><?php echo $floor_size; ?> <?php echo $size_postfix; ?></span></button>
                                            </h2>
                                        </div>
                                    </div>

                            <?php }
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>

        <?php
        }
    }

    public static function listing_single_location()
    {
        $map_coordinates = get_listing_meta_field('map_coordinates');
        if ($map_coordinates) {
            $explode = explode(',', $map_coordinates);
        }
        $map_iframe = get_listing_meta_field('map_iframe');
        $single_listing_checkbox = resido_get_options('single_listing_checkbox');
        ?>
        <!-- Single Block Wrap -->
        <div class="property_block_wrap style-2">
            <div class="property_block_wrap_header">
                <a data-bs-toggle="collapse" data-parent="#loca" data-bs-target="#clSix" aria-controls="clSix" href="javascript:void(0);" aria-expanded="true" class="collapsed">
                    <h4 class="property_block_title"><?php echo esc_html__('Location', 'resido-listing'); ?></h4>
                </a>
            </div>
            <div id="clSix" class="panel-collapse collapse<?php if ($single_listing_checkbox[7]) {
                                                                echo ' show';
                                                            } ?>">
                <div class="block-body">
                    <?php if ($map_iframe) { ?>
                        <div class="map-container">
                            <?php echo $map_iframe; ?>

                        </div>
                    <?php } else { ?>
                        <!-- Map from API -->
                        <div id="singleMap" data-latitude="<?php echo $explode[0]; ?>" data-longitude="<?php echo $explode[1]; ?>"></div>
                        <!-- Map from API -->
                    <?php } ?>


                </div>
            </div>
        </div>
        <?php
    }


    public static function listing_single_gallery()
    {
        $galleryImage = listing_meta_fields('gallery-image');
        $single_listing_checkbox = resido_get_options('single_listing_checkbox');
        if (!empty($galleryImage)) {
        ?>
            <!-- Single Block Wrap -->
            <div class="property_block_wrap style-2">

                <div class="property_block_wrap_header">
                    <a data-bs-toggle="collapse" data-parent="#clSev" data-bs-target="#clSev" aria-controls="clOne" href="javascript:void(0);" aria-expanded="true" class="collapsed">
                        <h4 class="property_block_title"><?php echo esc_html__('Gallery', 'resido-listing'); ?></h4>
                    </a>
                </div>

                <div id="clSev" class="panel-collapse collapse<?php if ($single_listing_checkbox[8]) {
                                                                    echo ' show';
                                                                } ?>">
                    <div class="block-body">
                        <ul class="list-gallery-inline">
                            <?php
                            if (!empty($galleryImage)) {
                                foreach ($galleryImage as $image_id) {
                                    $image_url = wp_get_attachment_url($image_id);
                            ?>
                                    <li>
                                        <a href="<?php echo esc_url($image_url); ?>" class="mfp-gallery">
                                            <img src="<?php echo esc_url($image_url); ?>" class="img-fluid mx-auto" alt="" />
                                        </a>
                                    </li>
                            <?php
                                }
                            }

                            ?>
                        </ul>
                    </div>
                </div>
            </div>
        <?php }
    }


    public static function rating_overview()
    {
        if (resido_get_average_rate(get_the_ID())) { ?>


            <!-- Review Block Wrap -->
            <div class="rating-overview">
                <div class="rating-overview-box">
                    <span class="rating-overview-box-total"><?php echo resido_get_average_rate(get_the_ID()); ?></span>
                    <span class="rating-overview-box-percent"><?php _e('out of 5.0', 'resido-listing'); ?></span>
                    <div class="star-rating" data-rating="5">
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
                <?php
                $total_ratting = resido_get_average_ratting_name(get_the_ID());
                $service_width = '';
                $money_width = '';
                $cleanliness_width = '';
                $location_width = '';

                if ($total_ratting['service']) {
                    $service_width = ($total_ratting['service'] * 100) / 5;
                }

                if ($total_ratting['money']) {
                    $money_width = ($total_ratting['money'] * 100) / 5;
                }

                if ($total_ratting['cleanliness']) {
                    $cleanliness_width = ($total_ratting['cleanliness'] * 100) / 5;
                }

                if ($total_ratting['location']) {
                    $location_width = ($total_ratting['location'] * 100) / 5;
                }

                if ($service_width < 40) {
                    $service_width_class = "poor";
                } else if ($service_width < 80) {
                    $service_width_class = "mid";
                } else {
                    $service_width_class = "high";
                }
                if ($money_width < 40) {
                    $money_width_class = "poor";
                } else if ($money_width < 80) {
                    $money_width_class = "mid";
                } else {
                    $money_width_class = "high";
                }
                if ($cleanliness_width < 40) {
                    $cleanliness_width_class = "poor";
                } else if ($cleanliness_width < 80) {
                    $cleanliness_width_class = "mid";
                } else {
                    $cleanliness_width_class = "high";
                }
                if ($location_width < 40) {
                    $location_width_class = "poor";
                } else if ($location_width < 80) {
                    $location_width_class = "mid";
                } else {
                    $location_width_class = "high";
                }

                ?>
                <div class="rating-bars">
                    <?php
                    if ($service_width) { ?>
                        <div class="rating-bars-item">
                            <span class="rating-bars-name"><?php _e('Service', 'resido-listing'); ?></span>
                            <span class="rating-bars-inner">
                                <span class="rating-bars-rating <?php echo $service_width_class; ?>" data-rating="<?php echo round($total_ratting['service'], 1); ?>">
                                    <span class="rating-bars-rating-inner" style="width: <?php echo round($service_width); ?>%;"></span>
                                </span>
                                <strong>
                                    <?php echo round($total_ratting['service'], 1); ?>
                                </strong>
                            </span>
                        </div>
                    <?php }
                    if ($money_width) { ?>
                        <div class="rating-bars-item">
                            <span class="rating-bars-name"><?php _e('Price', 'resido-listing'); ?></span>
                            <span class="rating-bars-inner">
                                <span class="rating-bars-rating <?php echo $money_width_class; ?>" data-rating="<?php echo round($total_ratting['money'], 1); ?>">
                                    <span class="rating-bars-rating-inner" style="width: <?php echo round($money_width); ?>%;"></span>
                                </span>
                                <strong><?php echo round($total_ratting['money'], 1); ?></strong>
                            </span>
                        </div>
                    <?php }
                    if ($cleanliness_width) { ?>
                        <div class="rating-bars-item">
                            <span class="rating-bars-name"><?php _e('Quality', 'resido-listing'); ?></span>
                            <span class="rating-bars-inner">
                                <span class="rating-bars-rating <?php echo $cleanliness_width_class; ?>" data-rating="<?php echo round($total_ratting['cleanliness'], 1); ?>">
                                    <span class="rating-bars-rating-inner" style="width: <?php echo round($cleanliness_width); ?>%;"></span>
                                </span>
                                <strong><?php echo round($total_ratting['cleanliness'], 1); ?></strong>
                            </span>
                        </div>
                    <?php }
                    if ($location_width) { ?>
                        <div class="rating-bars-item">
                            <span class="rating-bars-name"><?php _e('Location', 'resido-listing'); ?></span>
                            <span class="rating-bars-inner">
                                <span class="rating-bars-rating <?php echo $location_width_class; ?>" data-rating="<?php echo round($total_ratting['location'], 1); ?>">
                                    <span class="rating-bars-rating-inner" style="width:<?php echo round($location_width); ?>%;"></span>
                                </span>
                                <strong><?php echo round($total_ratting['location'], 1); ?></strong>
                            </span>
                        </div>
                    <?php } ?>
                </div>
            </div>

        <?php
        }
    }

    public static function listings_single_nearby()
    {
        $single_listing_checkbox = resido_get_options('single_listing_checkbox');
        ?>
        <!-- Single Block Wrap -->
        <div class="property_block_wrap style-2">

            <div class="property_block_wrap_header">
                <a data-bs-toggle="collapse" data-parent="#nearby" data-bs-target="#clNine" aria-controls="clNine" href="javascript:void(0);" aria-expanded="true" class="collapsed">
                    <h4 class="property_block_title"><?php echo esc_html__('Nearby', 'resido-listing'); ?></h4>
                </a>
            </div>

            <div id="clNine" class="panel-collapse collapse show">
                <div class="block-body">

                    <!-- Schools -->
                    <div class="nearby-wrap">
                        <div class="nearby_header">
                            <div class="nearby_header_first">
                                <h5>Schools Around</h5>
                            </div>
                            <div class="nearby_header_last">
                                <div class="nearby_powerd">
                                    Powerd by <img src="assets/img/edu.png" class="img-fluid" alt="" />
                                </div>
                            </div>
                        </div>
                        <div class="neary_section_list">

                            <div class="neary_section">
                                <div class="neary_section_first">
                                    <h4 class="nearby_place_title">Green Iseland School<small>(3.52 mi)</small></h4>
                                </div>
                                <div class="neary_section_last">
                                    <div class="nearby_place_rate">
                                        <i class="fa fa-star filled"></i>
                                        <i class="fa fa-star filled"></i>
                                        <i class="fa fa-star filled"></i>
                                        <i class="fa fa-star filled"></i>
                                        <i class="fa fa-star"></i>
                                    </div>
                                    <small class="reviews-count">(421 Reviews)</small>
                                </div>
                            </div>

                            <div class="neary_section">
                                <div class="neary_section_first">
                                    <h4 class="nearby_place_title">Ragni Intermediate College<small>(0.52 mi)</small></h4>
                                </div>
                                <div class="neary_section_last">
                                    <div class="nearby_place_rate">
                                        <i class="fa fa-star filled"></i>
                                        <i class="fa fa-star filled"></i>
                                        <i class="fa fa-star filled"></i>
                                        <i class="fa fa-star filled"></i>
                                        <i class="fa fa-star-half filled"></i>
                                    </div>
                                    <small class="reviews-count">(470 Reviews)</small>
                                </div>
                            </div>

                            <div class="neary_section">
                                <div class="neary_section_first">
                                    <h4 class="nearby_place_title">Rose Wood Primary Scool<small>(0.47 mi)</small></h4>
                                </div>
                                <div class="neary_section_last">
                                    <div class="nearby_place_rate">
                                        <i class="fa fa-star filled"></i>
                                        <i class="fa fa-star filled"></i>
                                        <i class="fa fa-star filled"></i>
                                        <i class="fa fa-star filled"></i>
                                        <i class="fa fa-star"></i>
                                    </div>
                                    <small class="reviews-count">(204 Reviews)</small>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- Hotel & Restaurant -->
                    <div class="nearby-wrap">
                        <div class="nearby_header">
                            <div class="nearby_header_first">
                                <h5>Food Around</h5>
                            </div>
                            <div class="nearby_header_last">
                                <div class="nearby_powerd">
                                    Powerd by <img src="assets/img/food.png" class="img-fluid" alt="" />
                                </div>
                            </div>
                        </div>
                        <div class="neary_section_list">

                            <div class="neary_section">
                                <div class="neary_section_first">
                                    <h4 class="nearby_place_title">The Rise hotel<small>(2.42 mi)</small></h4>
                                </div>
                                <div class="neary_section_last">
                                    <div class="nearby_place_rate">
                                        <i class="fa fa-star filled"></i>
                                        <i class="fa fa-star filled"></i>
                                        <i class="fa fa-star filled"></i>
                                        <i class="fa fa-star filled"></i>
                                        <i class="fa fa-star filled"></i>
                                    </div>
                                    <small class="reviews-count">(105 Reviews)</small>
                                </div>
                            </div>

                            <div class="neary_section">
                                <div class="neary_section_first">
                                    <h4 class="nearby_place_title">Blue Ocean Bar & Restaurant<small>(1.52 mi)</small></h4>
                                </div>
                                <div class="neary_section_last">
                                    <div class="nearby_place_rate">
                                        <i class="fa fa-star filled"></i>
                                        <i class="fa fa-star filled"></i>
                                        <i class="fa fa-star filled"></i>
                                        <i class="fa fa-star filled"></i>
                                        <i class="fa fa-star"></i>
                                    </div>
                                    <small class="reviews-count">(40 Reviews)</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }

    public static function comments_template()
    {
        $comments = get_comments(array(
            'post_id' => get_the_ID(),
            'order' => 'ASC',
            'status' => 'approve',
            'include_unapproved' => array(is_user_logged_in() ? get_current_user_id() : wp_get_unapproved_comment_author_email()),
        ));
        $single_listing_checkbox = resido_get_options('single_listing_checkbox');

        if ($comments) :
        ?>
            <!-- Single Reviews Block -->
            <div class="property_block_wrap style-2">

                <div class="property_block_wrap_header">
                    <a data-bs-toggle="collapse" data-parent="#rev" data-bs-target="#clEight" aria-controls="clEight" href="javascript:void(0);" aria-expanded="true" class="collapsed">
                        <h4 class="property_block_title"><?php echo esc_html__(get_comments_number() . ' Reviews', 'resido-listing'); ?></h4>
                    </a>
                </div>
                <div id="clEight" class="panel-collapse collapse<?php if ($single_listing_checkbox[9]) {
                                                                    echo ' show';
                                                                } ?>">
                    <div class="block-body">
                        <div class="author-review">
                            <div class="comment-list">
                                <ul>
                                    <?php foreach ($comments as $comment) {
                                        $total_rate = array();
                                    ?>
                                        <!-- Single Thing -->
                                        <li class="article_comments_wrap" id="comment-<?php echo esc_html($comment->comment_ID); ?>">
                                            <article>
                                                <div class="article_comments_thumb">
                                                    <?php echo get_avatar($comment, $size = '80'); ?>
                                                </div>
                                                <div class="comment-details">
                                                    <div class="comment-meta">
                                                        <div class="comment-left-meta">
                                                            <h4 class="author-name"><?php echo esc_html($comment->comment_author); ?></h4>
                                                            <div class="comment-date"><?php echo esc_html($comment->comment_date); ?></div>
                                                        </div>
                                                    </div>
                                                    <div class="comment-text">
                                                        <p>
                                                            <?php echo esc_html($comment->comment_content); ?>
                                                        </p>
                                                    </div>
                                                </div>
                                            </article>
                                        </li>
                                        <!-- Single Thing -->
                                    <?php } ?>
                                </ul>
                            </div>
                        </div>
                        <!-- <a href="#" class="resido_loadmore reviews-checked theme-cl"><i class="fas fa-arrow-alt-circle-down mr-2"></i>See More Reviews</a> -->
                    </div>
                </div>

            </div>
            <!-- Single Reviews Block -->

        <?php
        endif;
    }

    public static function comments_form()
    {
        $user = wp_get_current_user();
        $single_listing_checkbox = resido_get_options('single_listing_checkbox');
        $commenter = wp_get_current_commenter();
        $resido_user_identity = $user->display_name;
        $req = get_option('require_name_email');
        $listing_option = resido_listing_option();
        $post_id = get_the_ID();
        ?>
        <div class="review-form-box form-submit" id="respond">
            <form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">
                <!-- Single Write a Review -->
                <div class="property_block_wrap style-2">
                    <div class="property_block_wrap_header">
                        <a data-bs-toggle="collapse" data-parent="#comment" data-bs-target="#clTen" aria-controls="clTen" href="javascript:void(0);" aria-expanded="true" class="collapsed">
                            <h4 class="property_block_title"><?php echo esc_html__('Write a Review', 'resido-listing'); ?></h4>
                        </a>
                    </div>
                    <div id="clTen" class="panel-collapse collapse<?php if ($single_listing_checkbox[10]) {
                                                                        echo ' show';
                                                                    } ?>">
                        <div class="block-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="row">
                                        <?php
                                        $ratting_service = isset($listing_option['ratting_service']) ? $listing_option['ratting_service'] : 1;
                                        $ratting_price = isset($listing_option['ratting_price']) ? $listing_option['ratting_price'] : 1;
                                        $ratting_quality = isset($listing_option['ratting_quality']) ? $listing_option['ratting_quality'] : 1;
                                        $ratting_location = isset($listing_option['ratting_location']) ? $listing_option['ratting_location'] : 1;
                                        if ($ratting_service) {
                                        ?>
                                            <div class="col-lg-6 col-md-6 col-sm-12">
                                                <label><?php echo esc_html__('Service?', 'resido-listing'); ?></label>
                                                <div class="rate-stars">
                                                    <input type="radio" id="st1" name="rservice" value="5" checked>
                                                    <label for="st1"></label>
                                                    <input type="radio" id="st2" name="rservice" value="4">
                                                    <label for="st2"></label>
                                                    <input type="radio" id="st3" name="rservice" value="3">
                                                    <label for="st3"></label>
                                                    <input type="radio" id="st4" name="rservice" value="2">
                                                    <label for="st4"></label>
                                                    <input type="radio" id="st5" name="rservice" value="1">
                                                    <label for="st5"></label>
                                                </div>
                                            </div>

                                        <?php
                                        }
                                        if ($ratting_price) {
                                        ?>
                                            <div class="col-lg-6 col-md-6 col-sm-12">
                                                <label><?php echo esc_html__('Price?', 'resido-listing'); ?></label>
                                                <div class="rate-stars">
                                                    <input type="radio" name="rmoney" id="vst1" value="5" checked>
                                                    <label for="vst1"></label>
                                                    <input type="radio" name="rmoney" id="vst2" value="4">
                                                    <label for="vst2"></label>
                                                    <input type="radio" name="rmoney" id="vst3" value="3">
                                                    <label for="vst3"></label>
                                                    <input type="radio" name="rmoney" id="vst4" value="2">
                                                    <label for="vst4"></label>
                                                    <input type="radio" name="rmoney" id="vst5" value="1" required>
                                                    <label for="vst5"></label>
                                                </div>
                                            </div>
                                        <?php
                                        }
                                        if ($ratting_quality) {
                                        ?>
                                            <div class="col-lg-6 col-md-6 col-sm-12">
                                                <label><?php echo esc_html__('Quality?', 'resido-listing'); ?></label>
                                                <div class="rate-stars">
                                                    <input type="radio" name="rcleanliness" id="cst1" value="5" checked>
                                                    <label for="cst1"></label>
                                                    <input type="radio" name="rcleanliness" id="cst2" value="4">
                                                    <label for="cst2"></label>
                                                    <input type="radio" name="rcleanliness" id="cst3" value="3">
                                                    <label for="cst3"></label>
                                                    <input type="radio" name="rcleanliness" id="cst4" value="2">
                                                    <label for="cst4"></label>
                                                    <input type="radio" name="rcleanliness" id="cst5" value="1" required>
                                                    <label for="cst5"></label>
                                                </div>
                                            </div>
                                        <?php
                                        }
                                        if ($ratting_location) {
                                        ?>
                                            <div class="col-lg-6 col-md-6 col-sm-12">
                                                <label><?php echo esc_html__('Location?', 'resido-listing'); ?></label>
                                                <div class="rate-stars">
                                                    <input type="radio" name="rlocation" id="lst1" value="5" checked>
                                                    <label for="lst1"></label>
                                                    <input type="radio" name="rlocation" id="lst2" value="4">
                                                    <label for="lst2"></label>
                                                    <input type="radio" name="rlocation" id="lst3" value="3">
                                                    <label for="lst3"></label>
                                                    <input type="radio" name="rlocation" id="lst4" value="2">
                                                    <label for="lst4"></label>
                                                    <input type="radio" name="rlocation" id="lst5" value="1" required>
                                                    <label for="lst5"></label>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-12">
                                    <?php
                                    $ratting_average_ratting = isset($listing_option['ratting_average_ratting']) ? $listing_option['ratting_average_ratting'] : 1;
                                    if ($ratting_average_ratting) {
                                    ?>
                                        <div class="avg-total-pilx">
                                            <h4 class="high user_commnet_avg_rate"><?php echo esc_html('5') ?></h4>
                                            <span><?php echo esc_html__('Average Ratting', 'resido-listing'); ?></span>
                                        </div>
                                    <?php

                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="block-body">
                            <form class="simple-form">
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <div class="form-group">
                                            <textarea id="comment" required name="comment" class="form-control ht-80" placeholder="<?php _e('Messages', 'resido-listing'); ?>" aria-required="true"></textarea>
                                        </div>
                                    </div>
                                    <?php if (!is_user_logged_in()) { ?>
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <div class="form-group">
                                                <input id="author" class="form-control" required name="author" type="text" placeholder="<?php _e('Your Name', 'resido-listing'); ?>" value="" aria-required="true">
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <div class="form-group">
                                                <input id="email" name="email" required class="form-control" type="email" placeholder="<?php _e('Your Email', 'resido-listing'); ?>" value="" aria-required="true">
                                            </div>
                                        </div>
                                    <?php } ?>
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <div class="form-group review-submit-btn">
                                            <input name="submit" type="submit" id="submit" class="btn btn-theme-light-2 rounded" value="<?php _e('Submit Review', 'resido-listing'); ?>">
                                            <input type="hidden" name="comment_post_ID" value="<?php echo $post_id; ?>" id="comment_post_ID">
                                            <input type="hidden" name="comment_parent" id="comment_parent" value="0">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- Comment Form -->
                </div>
                <!-- Single Write a Review -->
            </form>
        </div> <!-- #respond -->
<?php
    }
    // end
}
$resido_single_init = new Resido_Single_Init();

add_action('resido_single_user_share', array('Resido_Single_Init', 'resido_single_user_share'));
add_action('rlisting_single_title', array('Resido_Single_Init', 'rlisting_single_title'));
add_action('listing_single_additional', array('Resido_Single_Init', 'listing_single_additional'));
add_action('listing_single_description', array('Resido_Single_Init', 'listing_single_description'));
add_action('listing_single_features', array('Resido_Single_Init', 'listing_single_features'));
add_action('listing_single_video', array('Resido_Single_Init', 'listing_single_video'));
add_action('listing_single_floorplan', array('Resido_Single_Init', 'listing_single_floorplan'));
add_action('listing_single_location', array('Resido_Single_Init', 'listing_single_location'));
add_action('listing_single_gallery', array('Resido_Single_Init', 'listing_single_gallery'));
add_action('rating_overview', array('Resido_Single_Init', 'rating_overview'));
add_action('listings_single_nearby', array('Resido_Single_Init', 'listings_single_nearby'));
add_action('comments_template', array('Resido_Single_Init', 'comments_template'));
add_action('comments_form', array('Resido_Single_Init', 'comments_form'));
