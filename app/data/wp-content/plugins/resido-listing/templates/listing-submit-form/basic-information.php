<div class="form-submit">
  <h3><?php echo esc_html__('Basic Information', 'resido-listing'); ?></h3>
  <div class="submit-section">
    <div class="row">

      <div class="form-group col-md-12">
        <label><?php echo esc_html__('Property Title', 'resido-listing'); ?><span class="tip-topdata" data-tip="<?php echo esc_html__('Property Title', 'resido-listing'); ?>"><i class="ti-help"></i></span></label>
        <input class="form-control" required name="rltitle" type="text" value="" placeholder="Title">
      </div>

      <div class="form-group col-md-4">
        <label><?php echo esc_html__('Status', 'resido-listing'); ?></label>
        <select id="status" name="rlstatus" class="form-control">
          <?php $rlisting_status = get_terms(
            array(
              'taxonomy' => 'rlisting_status',
              'hide_empty' => false,
            )
          );
          if (!empty($rlisting_status)) {
            foreach ($rlisting_status as $key => $single) {
              if ($single->name == $rlstatus_name[0]) {
                echo '<option selected value="' . $single->term_id . '">' . $single->name . '</option>';
              } else {
                echo '<option value="' . $single->term_id . '">' . $single->name . '</option>';
              }
            }
          }
          ?>
        </select>
      </div>


      <div class="form-group col-md-4">
        <label><?php echo esc_html__('Property Type', 'resido-listing'); ?></label>
        <select id="ptypes" name="rlcat" class="form-control">
          <?php $rlisting_category = get_terms(
            array(
              'taxonomy' => 'rlisting_category',
              'hide_empty' => false,
            )
          );
          var_dump($rlisting_category);
          if (!empty($rlisting_category)) {
            foreach ($rlisting_category as $key => $single) {
              if ($single->name == $term_name[0]) {
                echo '<option selected value="' . $single->term_id . '">' . $single->name . '</option>';
              } else {
                echo '<option value="' . $single->term_id . '">' . $single->name . '</option>';
              }
            }
          }
          ?>
        </select>
      </div>

      <div class="form-group col-md-4">
        <label><?php echo esc_html__('Price', 'resido-listing'); ?></label>
        <input class="form-control" required name="rlisting_sale_or_rent" type="text" value="" placeholder="<?php echo esc_html__('199', 'resido-listing'); ?>">
      </div>

      <div class="form-group col-md-4">
        <label><?php echo esc_html__('Price Postfix', 'resido-listing'); ?></label>
        <input class="form-control" required name="rlisting_price_postfix" type="text" value="" placeholder="<?php echo esc_html__('monthly', 'resido-listing'); ?>">
      </div>

      <div class="form-group col-md-4">
        <label><?php echo esc_html__('Area Size', 'resido-listing'); ?></label>
        <input class="form-control" required name="rlisting_area_size" type="text" value="" placeholder="2400">
      </div>

      <div class="form-group col-md-4">
        <label><?php echo esc_html__('Area Size Postfix', 'resido-listing'); ?></label>
        <input class="form-control" required name="rlisting_area_size_postfix" type="text" value="" placeholder="<?php echo esc_html__('sqft', 'resido-listing'); ?>">
      </div>

      <div class="form-group col-md-4">
        <label><?php echo esc_html__('Bedrooms', 'resido-listing'); ?></label>
        <input class="form-control" required name="rlisting_bedrooms" type="text" value="" placeholder="<?php echo esc_html__('Bedrooms', 'resido-listing'); ?>">
      </div>

      <div class="form-group col-md-4">
        <label><?php echo esc_html__('Bathrooms', 'resido-listing'); ?></label>
        <input class="form-control" required name="rlisting_bathrooms" type="text" value="" placeholder="<?php echo esc_html__('Bathrooms', 'resido-listing'); ?>">
      </div>

      <div class="form-group col-md-4">
        <label><?php echo esc_html__('Garage', 'resido-listing'); ?></label>
        <input class="form-control" required name="rlisting_garage" type="text" value="" placeholder="<?php echo esc_html__('Garage', 'resido-listing'); ?>">
      </div>

    </div>
  </div>
</div>