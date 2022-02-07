<div class="form-submit">
    <h3><?php echo esc_html_e('Additional Information', 'resido-listing') ?></h3>
    <div class="form-group submit-section">
        <div class="row form-group">
            <div class="col-md-2 col-xs-6">
                <input placeholder="Number of Row" id="feature_ft_counter" type="number" name="listing_feature_count" class="form-control" value="">
            </div>
            <div class="col-md-10 col-xs-6">
                <a href="JavaScript:Void(0);" class="btn btn-theme" id="run_ft_counter"><?php _e('Confirm', 'resido-listing'); ?></a>
            </div>
        </div>

        <div class="features_list">
            <?php
            if (isset($current_post->rlisting_short_details) && !empty($current_post->rlisting_short_details)) {
                foreach ($current_post->rlisting_short_details as $key => $short_details) { ?>
                    <div class="row">
                        <div class="form-group col-md-4"><label><?php echo esc_html__('Title', 'resido-listing') ?></label>
                            <input type="text" name="rlisting_short_title[]" class="form-control" value="<?php echo esc_html($short_details['rlisting_short_title']); ?>">
                        </div>
                        <div class="form-group col-md-4"><label><?php echo esc_html__('Value', 'resido-listing') ?></label>
                            <input type="text" name="rlisting_short_value[]" class="form-control" value="<?php echo esc_html($short_details['rlisting_short_value']); ?>">
                        </div>
                    </div>
            <?php }
            }
            ?>

            <!-- This portion from ajax -->
        </div>
    </div>
</div>