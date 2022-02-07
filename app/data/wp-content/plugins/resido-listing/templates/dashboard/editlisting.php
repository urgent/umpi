 <?php

  $editpostid = get_query_var('editlisting');

  if (isset($_POST['rlsupdate']) && $_POST['rlsupdate']) {

    if (!wp_verify_nonce($_REQUEST['_wpnonce'], 'listing-add-listing')) {
      return true;
    }

    $rlisting_sale_or_rent = sanitize_text_field($_POST['rlisting_sale_or_rent']);
    $rlisting_price_postfix = sanitize_text_field($_POST['rlisting_price_postfix']);
    $rlisting_area_size = sanitize_text_field($_POST['rlisting_area_size']);
    $rlisting_area_size_postfix = sanitize_text_field($_POST['rlisting_area_size_postfix']);
    $rlisting_bedrooms = sanitize_text_field($_POST['rlisting_bedrooms']);
    $rlisting_bathrooms = sanitize_text_field($_POST['rlisting_bathrooms']);
    $rlisting_garage = sanitize_text_field($_POST['rlisting_garage']);
    $rltitle = sanitize_text_field($_POST['rltitle']);
    $rlstatus = sanitize_text_field($_POST['rlstatus']);
    $rlcat = sanitize_text_field($_POST['rlcat']);
    $rldescription = wp_kses_post($_POST['rldescription']);
    $rlcountry = sanitize_text_field($_POST['rlcountry']);
    $rlcity = sanitize_text_field($_POST['rlcity']);
    $rlisting_address = sanitize_text_field($_POST['rlisting_address']);
    $rllatitude = sanitize_text_field($_POST['rllatitude']);
    $rllongitude = sanitize_text_field($_POST['rllongitude']);
    $rlisting_map_iframe = $_POST['rl_map_iframe'];
    $rlisting_video_iframe = $_POST['rlvideoiframe'];
    $rlname = sanitize_text_field($_POST['rlname']);
    $rlemail = sanitize_text_field($_POST['rlemail']);
    $rlphone = sanitize_text_field($_POST['rlphone']);
    $rlagencyinfo = sanitize_text_field($_POST['rlagencyinfo']);
    $rlagentinfo = sanitize_text_field($_POST['rlagentinfo']);
    $rlvideolink = sanitize_text_field($_POST['rlvideolink']);

    $rlamenity = '';
    if (isset($_POST['rlamenity']) && !empty($_POST['rlamenity'])) {
      $rlamenity = $_POST['rlamenity'];
    }

    $hierarchical_tax = array($rlcat); // Array of tax ids.
    $rlstatus_tax = array($rlstatus); // Array of tax ids.

    $rllocation = array($rlcountry, $rlcity);

    $post_arr = array(
      'ID' => $editpostid,
      'post_title' => $rltitle,
      'post_content' => $rldescription,
      'post_type' => 'rlisting',
    );

    wp_update_post($post_arr);

    //$term_obj = wp_get_object_terms( $current_post->ID , 'rlisting_category' );
    wp_set_post_terms($editpostid, $hierarchical_tax, 'rlisting_category');
    wp_set_post_terms($editpostid, $rlstatus_tax, 'rlisting_status');
    wp_set_post_terms($editpostid, $rllocation, 'rlisting_location');
    wp_set_post_terms($editpostid, $rlamenity, 'rlisting_features');
    update_post_meta($editpostid, 'rlisting_sale_or_rent', $rlisting_sale_or_rent);
    update_post_meta($editpostid, 'rlisting_price_postfix', $rlisting_price_postfix);
    update_post_meta($editpostid, 'rlisting_area_size', $rlisting_area_size);
    update_post_meta($editpostid, 'rlisting_area_size_postfix', $rlisting_area_size_postfix);
    update_post_meta($editpostid, 'rlisting_bedrooms', $rlisting_bedrooms);
    update_post_meta($editpostid, 'rlisting_bathrooms', $rlisting_bathrooms);
    update_post_meta($editpostid, 'rlisting_garage', $rlisting_garage);
    update_post_meta($editpostid, 'rlisting_address', $rlisting_address);
    update_post_meta($editpostid, 'rlisting_latitude', $rllatitude);
    update_post_meta($editpostid, 'rlisting_longitude', $rllongitude);
    update_post_meta($editpostid, 'rlisting_map_iframe', $rlisting_map_iframe);
    update_post_meta($editpostid, 'rlisting_videolink', $rlvideolink);
    update_post_meta($editpostid, 'rlisting_video_iframe', $rlisting_video_iframe);

    // Floor Plan Update From Dashboard

    $listing_floor_type = array();
    if (isset($_POST['rlfloor_title']) && !empty($_POST['rlfloor_title'])) {
      foreach ($_POST['rlfloor_title'] as $key => $forva) {
        $listing_floor_type[] = array(
          'rlisting_floor_title' => $_POST['rlfloor_title'][$key],
          'rlisting_floor_size' => $_POST['rlfloor_size'][$key],
          'rlisting_size_postfix' => $_POST['rlfloor_postfix'][$key],
          'rlisting_floor_image' => $_POST['rlisting_floor_image'][$key]
        );
      }
    }

    update_post_meta($editpostid, 'rlisting_flor_plan', $listing_floor_type);
    // Floor Plan Update From Dashboard

    // Additional Details Update From Dashboard

    $short_details = array();
    if (isset($_POST['rlisting_short_title']) && !empty($_POST['rlisting_short_title'])) {
      foreach ($_POST['rlisting_short_title'] as $key => $forva) {
        $short_details[] = array(
          'rlisting_short_title' => $_POST['rlisting_short_title'][$key],
          'rlisting_short_value' => $_POST['rlisting_short_value'][$key],
        );
      }
    }

    update_post_meta($editpostid, 'rlisting_short_details', $short_details);
    // Additional Details Update From Dashboard


    update_post_meta($editpostid, 'rlisting_rlname', $rlname);
    update_post_meta($editpostid, 'rlisting_email', $rlemail);
    update_post_meta($editpostid, 'rlisting_phone', $rlphone);
    update_post_meta($editpostid, 'rlisting_rlagencyinfo', $rlagencyinfo);
    update_post_meta($editpostid, 'rlisting_rlagentinfo', $rlagentinfo);

    $post_id = $editpostid;
    set_post_thumbnail($post_id, $_POST['frontend_rlfeaturedimg']);

    if (isset($_POST['frontend_rlvideoimg_array']) && !empty($_POST['frontend_rlvideoimg_array'])) {
      update_post_meta($post_id, 'rlisting_v_image', $_POST['frontend_rlvideoimg_array']);
    }

    if (isset($_POST['resido_attachment_id_array']) && !empty($_POST['resido_attachment_id_array'])) {
      foreach ($_POST['resido_attachment_id_array'] as $att_id) {
        add_post_meta($post_id, 'rlisting_gallery-image', $att_id);
      }
    }
  }

  $current_post = get_post($editlisting);
  $term_name = wp_get_object_terms($current_post->ID, 'rlisting_category', array('fields' => 'names'));
  $rlstatus_name = wp_get_object_terms($current_post->ID, 'rlisting_status', array('fields' => 'names'));
  $rlisting_features = get_the_terms($editlisting, 'rlisting_features');
  $featured_img_url = get_the_post_thumbnail_url($current_post->ID, 'small');
  ?>
 <!-- =========================== Add Form Start ============================================ -->



 <div class="dashboard-wraper">
   <div class="row">
     <!-- Submit Form -->
     <div class="col-lg-12 col-md-12">

       <div class="submit-page editlisting-div">
         <form action="#" method="post" id="listing-submit-form" class="listing-submit-form dropzone" enctype="multipart/form-data">
           <?php
            include RESIDO_LISTING_PATH . '/templates/listing-submit-form/edit/general-information.php';
            include RESIDO_LISTING_PATH . '/templates/listing-submit-form/edit/featured-image.php';
            include RESIDO_LISTING_PATH . '/templates/listing-submit-form/edit/gallery-image.php';
            include RESIDO_LISTING_PATH . '/templates/listing-submit-form/edit/location-information.php';
            include RESIDO_LISTING_PATH . '/templates/listing-submit-form/edit/business-information.php';
            include RESIDO_LISTING_PATH . '/templates/listing-submit-form/edit/additional-details.php';
            include RESIDO_LISTING_PATH . '/templates/listing-submit-form/edit/video-link.php';
            include RESIDO_LISTING_PATH . '/templates/listing-submit-form/edit/floor-plan.php';
            include RESIDO_LISTING_PATH . '/templates/listing-submit-form/edit/listing-amenity.php';
            include RESIDO_LISTING_PATH . '/templates/listing-submit-form/edit/contact-information.php';

            wp_nonce_field('listing-add-listing'); ?>
           <div class="form-group col-lg-12 col-md-12">
             <label><?php echo esc_html('GDPR Agreement *') ?></label>
             <ul class="no-ul-list">
               <li>
                 <input id="aj-1" class="checkbox-custom" name="aj-1" type="checkbox">
                 <label for="aj-1" class="checkbox-custom-label">
                 <?php echo esc_html__('I consent to having this website store my submitted information so they can respond to my inquiry.', 'resido-listing');
                 $t = "I consent to having this website store my submitted information so they can respond to my inquiry.";
                 $t = __($t);
                 echo html_entity_decode($t, ENT_QUOTES, 'UTF-8'); ?></label>
               </li>
             </ul>
           </div>
           <div class="form-group col-lg-12 col-md-12">
             <?php wp_nonce_field('listing-add-listing', 'submit-listing');
              if ($current_user->roles[0] == 'subscriber') { ?>
               <p><?php echo esc_html('Please upgrade demouser role to update post.'); ?></p>
               <button disabled title="Upgrade user role to post" class="btn btn-theme-light-2 rounded"><?php _e('Submit &#38; Preview', 'resido-listing'); ?></button>
             <?php } else { ?>
               <input class="btn btn-theme-light-2 rounded" type="submit" name="rlsupdate" value="<?php esc_attr_e('Submit &#38; Preview', 'resido-listing'); ?>">
             <?php }; ?>
           </div>
         </form>
       </div>

     </div>
   </div>
 </div>