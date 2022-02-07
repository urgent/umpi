<div class="form-submit">
    <h3><?php echo esc_html_e('Floor Plan', 'resido-listing') ?></h3>
    <div class="form-group submit-section">
        <div class="row form-group">
            <div class="col-md-2 col-xs-6">
                <input placeholder="Number of Floor" id="floor_counter" type="number" name="listing_floor_count" class="form-control" value="">
            </div>
            <div class="col-md-10 col-xs-6">
                <a href="JavaScript:Void(0);" class="btn btn-theme" id="run_counter"><?php _e('Confirm', 'resido-listing'); ?></a>
            </div>
        </div>

        <div class="floor_list">
            <?php
            if (isset($current_post->rlisting_flor_plan) && !empty($current_post->rlisting_flor_plan)) {
                foreach ($current_post->rlisting_flor_plan as $key => $rlisting_flor_plan) {
                    if (!isset($rlisting_flor_plan['rlisting_floor_title'])) {
                        $rlisting_flor_plan['rlisting_floor_title'] = '';
                    }
                    if (!isset($rlisting_flor_plan['rlisting_floor_size'])) {
                        $rlisting_flor_plan['rlisting_floor_size'] = '';
                    }
                    if (!isset($rlisting_flor_plan['rlisting_size_postfix'])) {
                        $rlisting_flor_plan['rlisting_size_postfix'] = '';
                    }
                    if (!isset($rlisting_flor_plan['rlisting_floor_image'])) {
                        $rlisting_flor_plan['rlisting_floor_image'] = '';
                    }
            ?>
                    <div class="row">
                        <div class="form-group col-md-4"><label><?php echo esc_html__('Floor Title', 'resido-listing') ?></label>
                            <input type="text" name="rlfloor_title[]" class="form-control" value="<?php echo esc_html($rlisting_flor_plan['rlisting_floor_title']); ?>">
                        </div>
                        <div class="form-group col-md-4"><label><?php echo esc_html__('Floor Size', 'resido-listing') ?></label>
                            <input type="text" name="rlfloor_size[]" class="form-control" value="<?php echo esc_html($rlisting_flor_plan['rlisting_floor_size']); ?>">
                        </div>
                        <div class="form-group col-md-4"><label><?php echo esc_html__('Size Postfix', 'resido-listing') ?></label>
                            <input type="text" name="rlfloor_postfix[]" class="form-control" value="<?php echo esc_html($rlisting_flor_plan['rlisting_size_postfix']); ?>">
                        </div>
                        <div>
                            <label><?php _e('Upload Media', 'resido-listing'); ?></label>
                            <br>
                            <?php
                            if ($rlisting_flor_plan['rlisting_floor_image']) {
                                echo '<img id="frontend-image" src="' . wp_get_attachment_image_url($rlisting_flor_plan['rlisting_floor_image'], 'thumbnail') . '" alt="img" class="gallary_iamge_with"" />';
                            }
                            ?>
                            <input type="hidden" id="rlisting_floor_image<?php echo esc_attr($key); ?>" name="rlisting_floor_image[]" value="<?php echo esc_html($rlisting_flor_plan['rlisting_floor_image']); ?>" />
                            <input data-id="rlisting_floor_image<?php echo esc_attr($key); ?>" id="rlfloor-button<?php echo esc_attr($key); ?>" name="rlfloor-button[]" class="rlfloor-btn" type="file">
                            <label for="rlfloor-button<?php echo esc_attr($key); ?>" class="drop_img_lst dropzone dz-clickable" id="single-logo">
                                <i class="ti-gallery"></i>
                                <span class="dz-default dz-message">
                                    <?php echo esc_html__('Drop files here to upload', 'resido-listing'); ?>
                                </span>
                            </label>
                        </div>
                    </div>
            <?php }
            }
            ?>

            <!-- This portion from ajax -->
        </div>
    </div>
</div>