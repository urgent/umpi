<?php
get_header();
// $term_name			= wp_get_object_terms(get_the_ID(), 'rlisting_category', array('fields' => 'names'));
$featured_image_url	= get_the_post_thumbnail_url(get_the_ID(), 'full');
$galleryImage		= listing_meta_fields('gallery-image');
require __DIR__ . '/single/listing-single-temp-init.php';
$title_top		= resido_get_options('title_top');
$title_top_img	= resido_get_options('title_top_img');
$top_breadcrumb = resido_get_options('top_breadcrumb');
$top_breadcrumb_slider = resido_get_options('top_breadcrumb_slider');
$rlisting_status = wp_get_object_terms(get_the_ID(), 'rlisting_status', array('fields' => 'names'));

// query vars
$get_listing_layout = get_query_var('editlisting');
if (isset($get_listing_layout) && $get_listing_layout != '') {
	if ($get_listing_layout == 3) {
		$top_breadcrumb_slider = 0;
		$title_top = 0;
		$top_breadcrumb = 1;
	} else if ($get_listing_layout == 2) {
		$top_breadcrumb_slider = 1;
		$title_top = 1;
		$top_breadcrumb = 0;
	} else {
		$top_breadcrumb_slider = 3;
		$title_top = 0;
		$top_breadcrumb = 0;
	}
}


if ($top_breadcrumb == '1') { ?>
	<!-- ============================ Property Header Info Start================================== -->
	<section class="bg-title">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-lg-11 col-md-12">

					<div class="property_block_wrap style-4">
						<div class="prt-detail-title-desc">
							<?php if ($rlisting_status) {
								foreach ($rlisting_status as $key => $single_rlisting_status) { ?>
									<span class="prt-types sale"><?php echo esc_html($single_rlisting_status); ?></span>
							<?php }
							} ?>
							<h3 class="text-light"><?php the_title(); ?></h3>
							<span><i class="lni-map-marker"></i>
								<?php
								if (get_post_meta(get_the_ID(), 'rlisting_address', true)) { ?>
									<span><?php listing_meta_field('address'); ?></span>
								<?php }; ?>
							</span>
							<h3 class="prt-price-fix">
								<?php
								resido_currency_html();
								if (get_listing_meta_field('price_postfix')) {
								?>
									<sub>/<?php listing_meta_field('price_postfix'); ?></sub>
								<?php } ?>
							</h3>
							<?php do_action('resido_single_user_share'); ?>
						</div>
					</div>

				</div>
			</div>
		</div>
	</section>
	<!-- ============================ Property Header Info Start================================== -->
<?php }
if ($top_breadcrumb_slider) {
?>
	<!-- ============================ Hero Banner Start================================== -->
	<div class="featured_slick_gallery gray">
		<div class="featured_slick_gallery-slide">
			<?php
			if (empty($galleryImage) && $featured_image_url) {
			?>
				<a href="<?php echo esc_url($featured_image_url); ?>" class="item-slick">
					<img src="<?php echo esc_url($featured_image_url); ?>" alt="Alt" />
				</a>
				<?php
			}

			if (!empty($galleryImage)) {
				foreach ($galleryImage as $image_id) {
					$image_url = wp_get_attachment_url($image_id);
				?>
					<div class="featured_slick_padd">
						<a class="mfp-gallery" href="<?php echo esc_url($image_url); ?>">
							<img src="<?php echo esc_url($image_url); ?>" class="img-fluid mx-auto" alt="Alt" />
						</a>
					</div>
			<?php
				}
			}
			?>
		</div>

	</div>
	<!-- ============================ Hero Banner End ================================== -->
<?php } ?>
<?php if ($title_top == '1') { ?>
	<!-- ============================ Property Header Info Start================================== -->
	<section class="gray-simple rtl p-0">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-lg-11 col-md-12">
					<div class="property_block_wrap style-3">
						<?php if ($title_top_img == '1') { ?>
							<div class="ft-flex-thumb">
								<img src="<?php echo esc_url($featured_image_url); ?>" alt="Alt" />
							</div>
						<?php } else { ?>
							<div class="pbw-flex-1">
								<div class="pbw-flex-thumb">
									<img src="<?php echo plugins_url() . '/resido-listing/assets/img/agency-1.png'; ?>" class="img-fluid" alt="" />
								</div>
							</div>
						<?php } ?>
						<div class="pbw-flex">
							<?php do_action('rlisting_single_title'); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- ============================ Property Header Info Start================================== -->
<?php } ?>

<!-- ============================ Property Detail Start ================================== -->
<section class="gray-simple">
	<div class="container">
		<div class="row">

			<!-- property main detail -->
			<div class="col-lg-8 col-md-12 col-sm-12">
				<?php

				$layout = resido_get_options('single_listing_layout')['enabled'];
				if ($layout) : foreach ($layout as $key => $value) {
						switch ($key) {
							case 'title_block':
								echo '<div class="property_block_wrap style-2 p-4">';
								do_action('rlisting_single_title');
								echo '</div>';
								break;
							case 'additional':
								do_action('listing_single_additional');
								break;
							case 'description':
								do_action('listing_single_description');
								break;
							case 'features':
								do_action('listing_single_features');
								break;
							case 'video':
								do_action('listing_single_video');
								break;
							case 'floor_plan':
								do_action('listing_single_floorplan');
								break;
							case 'location':
								do_action('listing_single_location');
								break;
							case 'gallery':
								do_action('listing_single_gallery');
								break;
							case 'rating-overview':
								do_action('rating_overview');
								break;
								// case 'listings-nearby-info':
								// 	do_action('listings_single_nearby');
								// 	break;
							case 'comments-template':
								do_action('comments_template');
								break;
							case 'comments-form':
								do_action('comments_form');
								break;
						}
					}
				endif;
				?>

			</div>

			<!-- property Sidebar -->
			<div class="col-lg-4 col-md-12 col-sm-12">

				<!-- Like And Share -->
				<div class="like_share_wrap b-0">
					<ul class="like_share_list">
						<li class="social_share_list"><a href="JavaScript:Void(0);" class="btn btn-likes"><i class="fas fa-share"></i><?php echo esc_html__('Share', 'resido-listing'); ?></a>
							<?php resido_user_share_opt(); ?>
						</li>
						<li><?php
							global $current_user;
							if (!is_user_logged_in()) {
								echo '<a href="JavaScript:Void(0);" data-bs-toggle="modal" data-bs-target="#login" class="btn btn-list live_single_2"><i class="far fa-heart"></i>' . __('Save', 'resido-listing') . '</a>';
							} else {
								$user_meta = get_user_meta($current_user->ID, '_favorite_posts');
								if (in_array(get_the_ID(), $user_meta)) {
									echo '<a href="javascript:void(0)" data-userid="' . $current_user->ID . '" data-postid="' . get_the_ID() . '" class="btn btn-list live_single_2" id="like_listing' . get_the_ID() . '"><i class="save_class_sdbr fas fa-heart"></i>' . __('Saved', 'resido-listing') . '</a>';
								} else {
									echo '<a href="javascript:void(0)" data-userid="' . $current_user->ID . '" data-postid="' . get_the_ID() . '" class="btn btn-list live_single_2" id="like_listing' . get_the_ID() . '"><i class="save_class_sdbr far fa-heart"></i>' . __('Save', 'resido-listing') . '</a>';
								}
							}
							?></li>
					</ul>
					<?php
					if (class_exists('Resido_Compare_ClassGeneral')) { ?>
						<div class="compare_section">
							<form action="<?php echo home_url('comparing'); ?>" method="POST" class="comapreForm">
								<input name="tDta" class="tDta" type="hidden" value="<?php echo get_the_ID(); ?>">
								<a href="javascript:void(0)" title="<?php echo esc_html__('compare', 'resido-compare'); ?>" class="compare-bt-single"><i class="ti-control-shuffle"></i><?php echo esc_html_e('Add to Compare', 'resido-listing') ?></a>
							</form>
						</div>
					<?php } ?>

				</div>

				<div class="details-sidebar">

					<?php if (is_active_sidebar('listing_single')) { ?>
						<?php dynamic_sidebar('listing_single'); ?>
					<?php } ?>

				</div>
			</div>

		</div>
	</div>
</section>
<!-- ============================ Property Detail End ================================== -->
<?php
get_footer();
