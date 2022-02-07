<div class="form-submit">
  <h3><?php echo esc_html__('Detailed Information', 'resido-listing'); ?></h3>
  <div class="submit-section">
    <div class="row">

      <div class="form-group col-md-12">
        <label><?php echo esc_html__('Description', 'resido-listing'); ?></label>
        <?php
        $content = $current_post->post_content;
        $editor_id = 'rldescription';
        $settings = array(
          'wpautop' => false, // Whether to use wpautop for adding in paragraphs. Note that the paragraphs are added automatically when wpautop is false.
          'media_buttons' => true, // Whether to display media insert/upload buttons
          'textarea_name' => $editor_id, // The name assigned to the generated textarea and passed parameter when the form is submitted.
          'textarea_rows' => 10, // The number of rows to display for the textarea
          'tabindex' => '', // The tabindex value used for the form field
          'editor_css' => '', // Additional CSS styling applied for both visual and HTML editors buttons, needs to include <style> tags, can use "scoped"
          'editor_class' => 'form-control h-120', // Any extra CSS Classes to append to the Editor textarea
          'teeny' => false, // Whether to output the minimal editor configuration used in PressThis
          'dfw' => false, // Whether to replace the default fullscreen editor with DFW (needs specific DOM elements and CSS)
          'tinymce' => true, // Load TinyMCE, can be used to pass settings directly to TinyMCE using an array
          'quicktags' => true, // Load Quicktags, can be used to pass settings directly to Quicktags using an array. Set to false to remove your editor's Visual and Text tabs.
          'drag_drop_upload' => true, // Enable Drag & Drop Upload Support (since WordPress 3.9)
        );

        wp_editor($content, 'rldescription', $settings);
        ?>
      </div>

      <div class="form-group col-md-12">
        <label><?php echo esc_html__('Listing Amenity', 'resido-listing'); ?></label>
        <div class="o-features">
          <ul class="no-ul-list third-row">
            <?php

            $term_ids = array();
            if (!empty($rlisting_features)) {
              foreach ($rlisting_features as $key => $value) {
                // code...
                $term_ids[] = $value->term_id;
              }
              // code...
            }
            // print_r($term_ids);
            $rlisting_features = get_terms(
              array(
                'taxonomy' => 'rlisting_features',
                'hide_empty' => false,
              )
            );

            if (!empty($rlisting_features)) {
              foreach ($rlisting_features as $key => $single) {
                $checked = '';
                if (in_array($single->term_id, $term_ids)) {
                  $checked = 'checked';
                }

            ?>
                <li>
                  <input id="a-<?php echo $key; ?>" <?php echo $checked; ?> class="checkbox-custom" name="rlamenity[]" type="checkbox" value="<?php echo $single->term_id; ?>">
                  <label for="a-<?php echo $key; ?>" class="checkbox-custom-label"><?php echo $single->name; ?></label>
                </li>
            <?php
              }
            }
            ?>

          </ul>
        </div>
      </div>

    </div>
  </div>
</div>