<?php
$term_name = wp_get_object_terms(get_the_ID(), 'rlisting_category', array('fields' => 'names'));
$term_ID = wp_get_object_terms(get_the_ID(), 'rlisting_category');
$rlisting_status = wp_get_object_terms(get_the_ID(), 'rlisting_status', array('fields' => 'names'));
$listing_option = resido_listing_option();

// From elementor widget to create border and no-shadow for slide
$inner_class = "";
$column = "";
if (isset($settings['column']) && $settings['column']) {
    $column = $settings['column'];
} else {
    $column = "col-lg-12 col-md-12";
}
// From elementor widget to create border and no-shadow for slide
?>
<div class="single-items <?php echo esc_attr__($column, 'resido-listing'); ?>">
    <div class="property-listing property-2 <?php echo $inner_class; ?>">
        <div class="listing-img-wrapper">
            <div class="list-img-slide">
                <div class="click">
                    <?php if (has_post_thumbnail(get_the_ID())) { ?>
                        <div><a href="<?php the_permalink(); ?>"> <?php the_post_thumbnail(); ?></a></div>
                    <?php } else { ?>
                        <div><a href="<?php the_permalink(); ?>"><img src="<?php echo plugins_url('resido-listing') . '/assets/img/placeholder.png'; ?>" alt=""></a></div>
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
                <div class="listing-short-detail">
                    <?php if ($rlisting_status) {
                        foreach ($rlisting_status as $key => $single_rlisting_status) { ?>
                            <span class="property-type"><?php echo $single_rlisting_status; ?></span>
                        <?php } ?>
                    <?php } ?>
                    <h4 class="listing-name verified">
                        <a href="<?php the_permalink(); ?>" class="prt-link-detail"><?php the_title() ?></a>
                    </h4>
                </div>
                <div class="listing-short-detail-flex">
                    <h6 class="listing-card-info-price">
                        <?php
                        echo esc_html($listing_option['currency_symbol']);
                        listing_meta_field('sale_or_rent');
                        ?>
                    </h6>
                </div>
            </div>
        </div>
        <div class="price-features-wrapper">
            <div class="list-fx-features">
                <div class="listing-card-info-icon">
                    <div class="inc-fleat-icon">
                        <img src="<?php echo plugins_url() . '/resido-listing/elementor/assets/img/bed.svg'; ?>" width="13" alt="" />
                    </div><?php listing_meta_field('bedrooms');
                            echo esc_html__(' Beds', 'resido-listing'); ?>
                </div>
                <div class="listing-card-info-icon">
                    <div class="inc-fleat-icon">
                        <img src="<?php echo plugins_url() . '/resido-listing/elementor/assets/img/bathtub.svg'; ?>" width="13" alt="" />
                    </div><?php listing_meta_field('bathrooms');
                            echo esc_html__(' Bath', 'resido-listing'); ?>
                </div>
                <div class="listing-card-info-icon">
                    <div class="inc-fleat-icon">
                        <img src="<?php echo plugins_url() . '/resido-listing/elementor/assets/img/move.svg'; ?>" width="13" alt="" />
                    </div><?php listing_meta_field('area_size'); ?><?php listing_meta_field('area_size_postfix'); ?>
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
                <a href="<?php the_permalink(); ?>" class="prt-view"><?php echo esc_html__("View", 'resido-listing'); ?></a>
            </div>
        </div>
    </div>
    <!-- End Single Property -->
</div>