	<!-- Business Info -->
	<div class="tr-single-box">
	  <div class="tr-single-header">
	    <h4><i class="ti-direction"></i><?php echo esc_html__('Listing Info', 'resido-listing'); ?></h4>
	  </div>

	  <?php

$lat = get_post_meta(get_the_ID(), 'rlisting_latitude', true);
$lot = get_post_meta(get_the_ID(), 'rlisting_longitude', true);
$website = get_post_meta(get_the_ID(), 'rlisting_website', true);
$email = get_post_meta(get_the_ID(), 'rlisting_email', true);
$mobile = get_post_meta(get_the_ID(), 'rlisting_mobile', true);

?>

	  <div class="tr-single-body">
	    <ul class="extra-service">
	      <li>
	        <div class="icon-box-icon-block">
	          <a href="https://www.google.com/maps/search/?api=1&amp;query=<?php echo $lat; ?>,<?php echo $lot; ?>"
	            target="_blank">
	            <div class="icon-box-round">
	              <i class="lni-map-marker"></i>
	            </div>
	            <div class="icon-box-text">
	              <?php
listing_meta_field('address');
?>
	            </div>
	          </a>
	        </div>
	      </li>
	      <li>
	        <div class="icon-box-icon-block">
	          <a href="tel:<?php echo $mobile; ?>">
	            <div class="icon-box-round">
	              <i class="lni-phone-handset"></i>
	            </div>
	            <div class="icon-box-text">
	              <?php
listing_meta_field('mobile');
?>
	            </div>
	          </a>
	        </div>
	      </li>
	      <li>
	        <div class="icon-box-icon-block">
	          <a href="mailto:<?php echo $email; ?>">
	            <div class="icon-box-round">
	              <i class="lni-envelope"></i>
	            </div>
	            <div class="icon-box-text">
	              <?php
listing_meta_field('email');
?>
	            </div>
	          </a>
	        </div>
	      </li>
	      <li>
	        <div class="icon-box-icon-block">
	          <a href="<?php echo esc_url($website); ?>">
	            <div class="icon-box-round">
	              <i class="lni-world"></i>
	            </div>
	            <div class="icon-box-text">
	              <?php
listing_meta_field('website');
?>
	            </div>
	          </a>
	        </div>
	      </li>

	    </ul>

	    <?php

$rlisting_facebook = get_post_meta(get_the_ID(), 'rlisting_facebook', true);
$rlisting_twitter = get_post_meta(get_the_ID(), 'rlisting_twitter', true);
$rlisting_instagram = get_post_meta(get_the_ID(), 'rlisting_instagram', true);
$rlisting_linked_in = get_post_meta(get_the_ID(), 'rlisting_linkedin', true);
$rlisting_vimeo = get_post_meta(get_the_ID(), 'rlisting_vimeo', true);
$rlisting_tumblr = get_post_meta(get_the_ID(), 'rlisting_tumbler', true);
$rlisting_pinterest = get_post_meta(get_the_ID(), 'rlisting_pinterest', true);
$rlisting_envato = get_post_meta(get_the_ID(), 'rlisting_envato', true);

?>

	    <!-- Follow Us Social Icon -->
	    <div class="single-follow-us-social-icon">
	      <h5><?php echo esc_html__('Follow Us', 'resido-listing'); ?></h5>
	      <ul>
	        <?php

if ($rlisting_facebook) {?>

	        <li><a href="<?php echo esc_url($rlisting_facebook); ?>"><i class="ti-facebook"></i></a></li>

	        <?php

}

?>


	        <?php

if ($rlisting_twitter) {?>


	        <li><a href="<?php echo esc_url($rlisting_twitter); ?>"><i class="ti-twitter"></i></a></li>
	        <?php

}

?>

	        <?php

if ($rlisting_instagram) {?>
	        <li><a href="<?php echo esc_url($rlisting_instagram); ?>"><i class="ti-instagram"></i></a></li>

	        <?php

}

?>

	        <?php

if ($rlisting_linked_in) {?>

	        <li><a href="<?php echo esc_url($rlisting_linked_in); ?>"><i class="ti-linkedin"></i></a></li>
	        <?php

}

?>

	        <?php

if ($rlisting_vimeo) {?>
	        <li><a href="<?php echo esc_url($rlisting_vimeo); ?>"><i class="ti-vimeo-alt"></i></a></li>

	        <?php

}

?>

	        <?php

if ($rlisting_tumblr) {?>
	        <li><a href="<?php echo esc_url($rlisting_tumblr); ?>"><i class="ti-tumblr-alt"></i></a></li>

	        <?php

}

?>

	        <?php

if ($rlisting_pinterest) {?>
	        <li><a href="<?php echo esc_url($rlisting_pinterest); ?>"><i class="ti-pinterest"></i></a></li>
	        <?php

}
?> <?php

if ($rlisting_envato) {?>
	        <li><a href="<?php echo esc_url($rlisting_envato); ?>"><i class="lni-envato"></i></a></li>
	        <?php

}
?>

	      </ul>
	    </div>
	  </div>

	</div>