<!-- Single Property -->
<div class="single-items <?php echo $settings['column']; ?>">
    <div class="property-listing property-2">
        <?php
        $galleryImage = listing_meta_field_gallery('gallery-image');
        if (!empty($galleryImage)) {
        ?>
            <div class="listing-img-wrapper">
                <div class="list-img-slide">
                    <div class="click">
                        <?php foreach ($galleryImage as $image_id) {
                            $image_url = wp_get_attachment_url($image_id);
                        ?>
                            <div>
                                <a href="<?php the_permalink(); ?>"><img src="<?php echo esc_url($image_url); ?>" class="img-fluid mx-auto" alt="" /></a>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        <?php } ?>

        <div class="listing-detail-wrapper">
            <div class="listing-short-detail-wrap">
                <div class="listing-short-detail">
                    <?php if ($rlisting_status) : ?>
                        <span class="property-type"><?php echo $rlisting_status[0]; ?></span>
                    <?php endif; ?>
                    <h4 class="listing-name verified">
                        <a href="<?php the_permalink(); ?>" class="prt-link-detail"><?php the_title() ?></a>
                    </h4>
                </div>
                <div class="listing-short-detail-flex">
                    <h6 class="listing-card-info-price">
                        <?php
                        if (!isset(resido_listing_option()['currency_symbol'])) {
                            echo esc_html('$');
                        } else {
                            echo esc_html(resido_listing_option()['currency_symbol']);
                        }
                        listing_meta_field('sale_or_rent'); ?></h6>
                </div>
            </div>
        </div>
        <div class="price-features-wrapper">
            <div class="list-fx-features">
                <?php if (!empty(get_post_meta(get_the_ID(), 'rlisting_bedrooms', true))) { ?>
                    <div class="listing-card-info-icon">
                        <div class="inc-fleat-icon">
                            <img src="<?php echo plugins_url() . '/resido-listing/elementor/assets/img/bed.svg'; ?>" width="13" alt="" />
                        </div><?php listing_meta_field('bedrooms'); ?> <?php echo esc_html__("Beds", 'resido-listing'); ?>
                    </div>
                <?php }
                if (!empty(get_post_meta(get_the_ID(), 'rlisting_bathrooms', true))) { ?>
                    <div class="listing-card-info-icon">
                        <div class="inc-fleat-icon">
                            <img src="<?php echo plugins_url() . '/resido-listing/elementor/assets/img/bathtub.svg'; ?>" width="13" alt="" />
                        </div><?php listing_meta_field('bathrooms'); ?> <?php echo esc_html__("Bath", 'resido-listing'); ?>
                    </div>
                <?php }
                if (!empty(get_post_meta(get_the_ID(), 'rlisting_area_size', true))) { ?>
                    <div class="listing-card-info-icon">
                        <div class="inc-fleat-icon">
                            <img src="<?php echo plugins_url() . '/resido-listing/elementor/assets/img/move.svg'; ?>" width="13" alt="" />
                        </div><?php listing_meta_field('area_size'); ?><?php listing_meta_field('area_size_postfix'); ?>
                    </div>
                <?php } ?>
            </div>
        </div>

        <div class="listing-detail-footer">
            <?php if (!empty(get_post_meta(get_the_ID(), 'rlisting_address', true))) { ?>
                <div class="footer-first">
                    <div class="foot-location"><img src="<?php echo plugins_url() . '/resido-listing/elementor/assets/img/pin.svg'; ?>" width="18" alt="" /><?php listing_meta_field('address'); ?></div>
                </div>
            <?php } ?>
            <div class="footer-flex">
                <a href="<?php the_permalink(); ?>" class="prt-view"><?php echo esc_html__("View", 'resido-listing'); ?></a>
            </div>
        </div>

    </div>
</div>
<!-- End Single Property -->