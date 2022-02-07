<div class="form-submit">
  <h3><?php echo esc_html__('Location', 'resido-listing'); ?></h3>
  <div class="submit-section">
    <div class="row">
      <div class="form-group col-md-6">
        <label><?php echo esc_html__('Country', 'resido-listing'); ?></label>
        <select id="lcountry" name="rlcountry" class="form-control">
          <option selected value=""><?php echo esc_html__('Select City', 'resido-listing'); ?></option>
          <?php
          $rlisting_country  = resido_get_listing_meta($editpostid, 'rlisting_country');
          $rlisting_location = get_terms(
            array(
              'taxonomy'   => 'rlisting_location',
              'hide_empty' => false,
              'parent'     => 0,
            )
          );
          if (!empty($rlisting_location)) {
            foreach ($rlisting_location as $single) {
              if ($rlisting_country == $single->term_id) {
                echo '<option selected value="' . $single->term_id . '">' . $single->name . '</option>';
              } else {
                echo '<option value="' . $single->term_id . '">' . $single->name . '</option>';
              }
            }
          }
          ?>
        </select>
      </div>
      <div class="form-groupcol-lg-6 col-md-6">
        <label><?php echo esc_html__('City', 'resido-listing'); ?></label>
        <select id="lcity" name="rlcity" class="form-control">
          <option selected value=""><?php echo esc_html__('No city selected', 'resido-listing'); ?></option>
          <?php
          $rlisting_city     = resido_get_listing_meta($editpostid, 'rlisting_city');
          $rlisting_location = get_terms(
            array(
              'taxonomy'   => 'rlisting_location',
              'hide_empty' => false,
              'parent'     => $rlisting_country,
            )
          );

          if (!empty($rlisting_location)) {
            foreach ($rlisting_location as $single) {
              if ($rlisting_city == $single->term_id) {
                echo '<option selected value="' . $single->term_id . '">' . $single->name . '</option>';
              } else {
                echo '<option value="' . $single->term_id . '">' . $single->name . '</option>';
              }
            }
          }
          ?>
        </select>
      </div>

      <div class="col-lg-12 col-md-12">
        <div class="form-group">
          <label><?php echo esc_html__('Property Address', 'resido-listing'); ?></label>
          <input class="form-control" required name="rlisting_address" type="text" placeholder="<?php echo esc_html__('Address', 'resido-listing'); ?>">
        </div>
      </div>

      <div class="col-lg-12 col-md-12">
        <div class="form-group">
          <label><?php echo esc_html__('Google Map Iframe', 'resido-listing'); ?></label>
          <textarea class="form-control" name="rl_map_iframe" id="" cols="30" rows="10"></textarea>
        </div>
      </div>

      <div class="col-lg-6 col-md-6">
        <div class="form-group">
          <label><?php echo esc_html__('Latitude', 'reveal-listing'); ?></label>
          <input class="form-control" name="rllatitude" value="" type="text" placeholder="40.4980073">
        </div>
      </div>

      <div class="col-lg-6 col-md-6">
        <div class="form-group">
          <label><?php echo esc_html__('Longitude', 'reveal-listing'); ?></label>
          <input class="form-control" value="" name="rllongitude" type="text" placeholder="51.4980073">
        </div>
      </div>

      <div class="col-lg-12 col-md-12">
        <div class="map-container">
          <div id="singleMap" data-latitude="" data-longitude="" data-mapTitle="Our Location"></div>
        </div>
      </div>

    </div>
  </div>
</div>