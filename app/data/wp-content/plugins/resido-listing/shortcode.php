<?php
class Shortcode
{



	/**
	 * Initializes the class
	 */
	function __construct()
	{
		add_shortcode('listing-home-search-form', array($this, 'home_search_form'));
		add_shortcode('listing-resistration-form', array($this, 'resido_resistration_form'));
		add_shortcode('listing-submit-page', array($this, 'resido_add_listing_page'));
		add_shortcode('listing-user-dashboard', array($this, 'resido_user_dashboard'));
		add_shortcode('listing-login-form', array($this, 'get_login_form'));
		add_shortcode('listing-reset-form', array($this, 'get_reset_password_form'));
		add_shortcode('classical-list-item', array($this, 'resido_classical_list_item'));
		add_shortcode('slide-box-list-item', array($this, 'resido_slide_box_list_item'));
	}

	public function resido_slide_box_list_item()
	{
		$listing_option       = resido_listing_option();
		$listing_avatar_image = isset($listing_option['listing_avatar_image']) ? $listing_option['listing_avatar_image'] : 1;
		$term_name            = wp_get_object_terms(get_the_ID(), 'rlisting_category', array('fields' => 'names'));
		$currentStatus        = '';
		$listing_item_price   = isset($listing_option['listing_item_price']) ? $listing_option['listing_item_price'] : 'yes';
		$currency_symbol      = isset($listing_option['currency_symbol']) ? $listing_option['currency_symbol'] : '$';
		ob_start();
?>

		<div class="list-slide-box">
			<div class="modern-list ml-2">
				<?php
				if (!empty($currentStatus) && $currentStatus != 'Closed') {
					echo '<div class="list-badge now-open">' . __('Now Open', 'resido-listing') . '</div>';
				} else {
					echo '<div class="list-badge now-close">' . __('Closed', 'resido-listing') . '</div>';
				}
				?>
				<div class="grid-category-thumb">

					<a href="<?php the_permalink(); ?>" class="overlay-cate">
						<?php
						$featured_img_url = get_the_post_thumbnail_url(get_the_ID(), 'rlisting_home_size');
						$image_id         = get_post_thumbnail_id();
						$image_alt        = get_post_meta($image_id, '_wp_attachment_image_alt', true);
						?>
						<img src="<?php echo esc_url($featured_img_url); ?>" class="img-responsive" alt="<?php echo $image_alt; ?>" />
					</a>
					<div class="listing-price-info">
						<?php
						// resido_listing_price_tag($listing_item_price, $currency_symbol);
						?>
					</div>
					<div class="property_meta">
						<div class="list-rates">
							<?php

							$comments = get_comments(array('post_id' => get_the_ID()));
							if (!empty($comments)) {
								$comments       = count($comments);
								$average        = resido_get_average_rate(get_the_ID());
								$averageRounded = ceil($average);

								if ($averageRounded) {
									$active_comment_rate = $averageRounded;
									for ($x = 1; $x <= $active_comment_rate; $x++) {
										echo '<i class="ti-star filled"></i>';
									}
									$inactive_comment_rate = 5 - $active_comment_rate;
									if ($inactive_comment_rate > 0) {
										for ($x = 1; $x <= $inactive_comment_rate; $x++) {
											echo '<i class="ti-star"></i>';
										}
									}
							?>
							<?php
								}
								if (!is_nan($averageRounded)) {
									echo '<a href="#" class="tl-review">(' . $comments . ' ' . __('Reviews', 'resido-listing') . ')</a>';
								}
							}

							?>

						</div>
						<h4 class="lst-title">
							<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>

							<?php
							$varified = get_post_meta(get_the_ID(), 'varified');
							if ($varified) {
								echo ' <span class="veryfied-author"></span>';
							}
							?>
						</h4>
					</div>
				</div>
				<div class="modern-list-content">

					<?php
					$listing_terms = wp_get_object_terms(get_the_ID(), 'rlisting_category');
					if ($listing_terms) {
						$cat_icon = get_option("rlisting_category_{$listing_terms[0]->term_id}_icon");
						if (empty($cat_icon)) {
							$cat_icon = 'ti-briefcase bg-a';
						}
						if (isset($listing_terms[0]->term_id)) {
							$rurl = get_term_link($listing_terms[0]->term_id, 'rlisting_category');
						} else {
							$rurl = '#';
						}
					?>
						<div class="listing-cat">
							<a href="
						<?php
						echo $rurl;
						?>
				" class="cat-icon cl-1">
								<i class="<?php echo $cat_icon; ?>"></i><?php echo $term_name[0]; ?></a>
							<span class="more-cat">+<?php echo resido_get_number_of_post_by_tex($term_name[0]); ?></span>
						</div>
					<?php

					}

					?>

					<?php
					$author_class = '';
					if ($listing_avatar_image) {
						$author_class = 'author-avater';
					}
					?>
					<div class="<?php echo $author_class; ?>">
						<?php
						if ($listing_avatar_image) {
							echo resido_get_avat('60');
						}
						?>
					</div>
				</div>
			</div>
		</div>

	<?php
		return ob_get_clean();
	}

	public function resido_classical_list_item()
	{
		$listing_option       = resido_listing_option();
		$term_name            = wp_get_object_terms(get_the_ID(), 'rlisting_category', array('fields' => 'names'));
		$currentStatus        = '';
		$listing_avatar_image = isset($listing_option['listing_avatar_image']) ? $listing_option['listing_avatar_image'] : 1;
		global $current_user;
		$listing_item_price = isset($listing_option['listing_item_price']) ? $listing_option['listing_item_price'] : 'yes';
		$currency_symbol    = isset($listing_option['currency_symbol']) ? $listing_option['currency_symbol'] : '$';
		ob_start();

	?>

		<div class="property_item classical-list">
			<div class="image">
				<a href="<?php the_permalink(); ?>" class="listing-thumb">
					<?php
					$featured_img_url = get_the_post_thumbnail_url(get_the_ID(), 'rlisting_home_size_1');
					$image_id         = get_post_thumbnail_id();
					$image_alt        = get_post_meta($image_id, '_wp_attachment_image_alt', true);
					?>
					<img src="<?php echo esc_url($featured_img_url); ?>" class="img-responsive" alt="<?php echo $image_alt; ?>" />
				</a>
				<div class="listing-price-info">
					<?php
					$is_featured = get_post_meta(get_the_ID(), 'featured');
					if ($is_featured) {
						echo '<span class="pricetag">' . __('Featured', 'resido-listing') . '</span>';
					}
					?>
					<?php
					// resido_listing_price_tag($listing_item_price, $currency_symbol);
					?>
				</div>
				<?php
				if (!is_user_logged_in()) {
					echo '<a href="#" data-toggle="modal" data-target="#login" class="tag_t"><i class="ti-heart"></i></a>';
				} else {
					$user_meta = get_user_meta($current_user->ID, '_favorite_posts');
					if (in_array(get_the_ID(), $user_meta)) {
						echo '<a href="javascript:void(0)" data-userid="' . $current_user->ID . '" data-postid="' . get_the_ID() . '" class="tag_t active"  id="tag_t"' . get_the_ID() . '"><i class="ti-heart"></i>' . __('Save', 'resido-listing') . '</a>';
					} else {
						echo '<a href="javascript:void(0)" data-userid="' . $current_user->ID . '" data-postid="' . get_the_ID() . '" class="tag_t" id="tag_t' . get_the_ID() . '"><i class="ti-heart"></i>' . __('Save', 'resido-listing') . '</a>';
					}
				}
				?>
				<?php
				$avgrate = resido_get_average_rate(get_the_ID());
				if ($avgrate) {
					echo '<span class="list-rate great">' . $avgrate . '</span>';
				}
				?>
			</div>

			<div class="proerty_content">
				<?php
				$author_class = 'without-author-avatar';
				if ($listing_avatar_image) {
					$author_class = 'author-avater';
				}
				?>
				<div class="<?php echo $author_class; ?>">
					<?php
					if ($listing_avatar_image) {
						echo resido_get_avat('60');
					}
					?>
				</div>
				<div class="proerty_text">
					<h3 class="captlize">
						<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
						<?php
						$varified = get_post_meta(get_the_ID(), 'varified', true);
						if ($varified) {
							echo ' <span class="veryfied-author"></span>';
						}
						?>
					</h3>
				</div>
				<?php the_excerpt(); ?>
				<div class="property_meta">
					<div class="list-fx-features">
						<div class="listing-card-info-icon">
							<span class="inc-fleat inc-add"><?php echo resido_get_city_and_country_tax(); ?></span>
						</div>
						<div class="listing-card-info-icon">
							<a href="tel:<?php echo listing_meta_field('mobile'); ?>">
								<span class="inc-fleat inc-call">
									<?php echo listing_meta_field('mobile'); ?> </span>
							</a>
						</div>
					</div>
				</div>
			</div>
			<div class="listing-footer-info">

				<?php
				$listing_terms = wp_get_object_terms(get_the_ID(), 'rlisting_category');

				if ($listing_terms) {
					$cat_icon = get_option("rlisting_category_{$listing_terms[0]->term_id}_icon");
					if (empty($cat_icon)) {
						$cat_icon = 'ti-briefcase bg-a';
					}
				?>
					<div class="listing-cat">
						<a href="
					<?php
					echo get_term_link($listing_terms[0]->term_id, 'rlisting_category');
					?>
				" class="cat-icon cl-1"><i class="<?php echo $cat_icon; ?>"></i><?php echo $term_name[0]; ?></a>
						<span class="more-cat">+<?php echo resido_get_number_of_post_by_tex($term_name[0]); ?></span>
					</div>

				<?php
				}

				?>

				<?php
				if (!empty($currentStatus) && $currentStatus != 'Closed') {
					echo '<span class="place-status">' . __('Open', 'resido-listing') . '</span>';
				} else {
					echo '<div class="place-status closed">' . __('Closed', 'resido-listing') . '</div>';
				}
				?>
			</div>
		</div>
	<?php
		return ob_get_clean();
	}

	public function resido_user_dashboard()
	{
		$value       = get_query_var('dashboard');
		$editlisting = get_query_var('editlisting');

		ob_start();
	?>
		<!-- ============================ Dashboard Start ================================== -->

		<div class="alert alert-success" role="alert">
			<?php echo 'Please Select the Page Attributes [Template] to Dashboard <br>Go to edit page and from the right side, choose the <b>Page Attributes - Template - Dashboard </b>'; ?>
		</div>

		<!-- ============================ Dashboard End ================================== -->
		<?php

		return ob_get_clean();
	}

	/**
	 * Shortcode handler class
	 *
	 * @param  array  $atts
	 * @param  string $content
	 *
	 * @return string
	 */
	public function home_search_form($atts, $content = '')
	{
		$listing_option       = resido_listing_option();
		$location_auto_search = isset($listing_option['location_auto_search']) ? $listing_option['location_auto_search'] : 'yes';
		$location_id          = '';
		if ($location_auto_search == 'yes') {
			$location_id = 'location';
		}

		$home_keyword_search  = isset($listing_option['home_keyword_search']) ? $listing_option['home_keyword_search'] : 'yes';
		$home_location_search = isset($listing_option['home_location_search']) ? $listing_option['home_location_search'] : 'yes';

		$keyword          = 'col-lg-4 col-md-4';
		$location         = 'col-lg-3 col-md-3';
		$category         = 'col-lg-3 col-md-3';
		$button           = 'col-lg-2 col-md-2';
		$keyword_location = '';

		if ($home_keyword_search == 'no' && $home_location_search == 'yes') {
			$location         = 'col-lg-5 col-md-5';
			$category         = 'col-lg-5 col-md-5';
			$keyword_location = 'keyword-location';
		} elseif ($home_keyword_search == 'yes' && $home_location_search == 'no') {
			$keyword          = 'col-lg-5 col-md-5';
			$category         = 'col-lg-5 col-md-5';
			$keyword_location = 'keyword-location';
		} elseif ($home_keyword_search == 'no' && $home_location_search == 'no') {
			$category         = 'col-lg-8 col-md-8';
			$button           = 'col-lg-4 col-md-4';
			$keyword_location = 'only_category';
		}
		if (!function_exists('rlisting_get_meta_list')) {
			function rlisting_get_meta_list($attr)
			{
				$all_post_ids = get_posts( // Get all post of rlisting
					array(
						'fields'         => 'ids',
						'posts_per_page' => -1,
						'post_type'      => 'rlisting',
					)
				);
				$meta_val_arr = array(); // assign null array variable
				foreach ($all_post_ids as $key => $post_id) { // get every meta value from all post id
					$meta_price = get_post_meta($post_id, $attr, true);
					array_push($meta_val_arr, $meta_price);
				}
				$sort_meta_val_arr = array_unique($meta_val_arr);
				sort($sort_meta_val_arr); // sort the sort_meta_val_arr value
				return $sort_meta_val_arr;
			}
		}

		if (isset($atts['style']) && $atts['style'] == 'style4') {
		?>
			<form method="get" id="advanced-searchform" role="search" action="<?php echo esc_url(home_url($listing_option['listing_slug'] . '/?type=2')); ?>">
				<div class="pk-input-group">
					<input type="hidden" name="search" value="advanced">
					<input type="text" class="form-control" value="" placeholder="<?php echo esc_html__('Search for a Property', 'resido-listing'); ?>" name="s" id="name" />
					<input type="submit" class="btn btn-black" id="searchsubmit" value="<?php echo esc_html__('Go & Search', 'resido-listing'); ?>" />
				</div>
			</form>
		<?php
		} elseif (isset($atts['style']) && $atts['style'] == 'style3') {
		?>
			<form method="get" id="advanced-searchform" role="search" action="<?php echo esc_url(home_url($listing_option['listing_slug'] . '/?type=2')); ?>">
				<div class="full-search-2 eclip-search italian-search hero-search-radius shadow">
					<div class="hero-search-content">

						<div class="row">
							<input type="hidden" name="search" value="advanced">
							<div class="col-lg-4 col-md-4 col-sm-12 b-r">
								<div class="form-group borders">
									<div class="input-with-icon">
										<input type="text" class="form-control" value="" placeholder="<?php echo esc_html__('Keywords...', 'resido-listing'); ?>" name="s" id="name" />
										<i class="ti-search"></i>
									</div>
								</div>
							</div>


							<div class="col-lg-3 col-md-3 col-sm-12">
								<div class="form-group borders">
									<div class="input-with-icon">
										<select data-placeholder="<?php echo esc_html__('Select Category', 'resido-listing'); ?>" name="listing_cate" class="form-control listing_cate">
											<option value=""><?php echo esc_html__('Select Category', 'resido-listing'); ?></option>
											<?php
											$rlisting_category = get_terms(
												array(
													'taxonomy'   => 'rlisting_category',
													'hide_empty' => false,
												)
											);

											if (!empty($rlisting_category)) {
												foreach ($rlisting_category as $single) {
													echo '<option value="' . $single->slug . '">' . $single->name . '</option>';
												}
											}
											?>
										</select>
										<i class="ti-briefcase"></i>
									</div>
								</div>
							</div>


							<div class="col-lg-3 col-md-3 col-sm-12">
								<div class="form-group">
									<i class="ti-location-pin"></i>
									<div class="input-with-icon-style2">
										<select id="list_loc" name="listing_loc" class="form-control">
											<option value=""><?php echo esc_html__('All Cities', 'resido-listing'); ?></option>
											<?php
											$rlisting_location = get_terms(
												array(
													'taxonomy'   => 'rlisting_location',
													'hide_empty' => false,
												)
											);

											if (!empty($rlisting_location)) {
												foreach ($rlisting_location as $single) {
													if ($single->parent != 0) {
														$parent = get_term_by('id', $single->parent, 'rlisting_location');
														echo '<option value="' . $single->slug . '">' . $single->name . ',' . $parent->name . '</option>';
													}
												}
											}
											?>
										</select>
									</div>
								</div>
							</div>

							<div class="col-lg-2 col-md-2 col-sm-12">
								<div class="form-group">
									<input type="submit" class="btn search-btn search_sbmtfrm" id="searchsubmit" value="<?php echo esc_html__('Search', 'resido-listing'); ?>" />
								</div>
							</div>

						</div>

					</div>
				</div>
			</form>
		<?php
		} elseif (isset($atts['style']) && $atts['style'] == 'style2') {
		?>
			<!-- Style 2 -->
			<form method="get" id="advanced-searchform" role="search" action="<?php echo esc_url(home_url($listing_option['listing_slug'] . '/?type=2')); ?>">
				<div class="full-search-2 eclip-search italian-search hero-search-radius shadow-hard mt-5">
					<div class="hero-search-content">
						<div class="row">
							<input type="hidden" name="search" value="advanced">
							<div class="col-lg-4 col-md-4 col-sm-12 b-r">
								<div class="form-group">
									<div class="choose-propert-type">
										<?php
										$rlisting_category = get_terms(
											array(
												'taxonomy' => 'rlisting_status',
												'hide_empty' => false,
											)
										);
										?>
										<ul>
											<?php
											if (!empty($rlisting_category)) {
												foreach ($rlisting_category as $key => $single) {
													if ($single->parent == 0) {
														if ($key == 0) {
															$checked = 'checked';
														} else {
															$checked = null;
														}
											?>
														<li>
															<input value="<?php echo $single->slug; ?>" id="<?php echo $single->slug; ?>" class="checkbox-custom" name="rlisting_st" type="radio" <?php echo $checked; ?>>
															<label for="<?php echo $single->slug; ?>" class="checkbox-custom-label"><?php echo $single->name; ?></label>
														</li>
											<?php
													}
												}
											}
											?>
										</ul>
									</div>
								</div>
							</div>

							<div class="col-lg-6 col-md-5 col-sm-12 p-0 elio">
								<div class="form-group">
									<div class="input-with-icon">
										<input type="text" class="form-control" value="" placeholder="<?php echo esc_html__('Search for a Property', 'resido-listing'); ?>" name="s" id="name" />
										<img src="<?php echo plugins_url() . '/resido-listing/elementor/assets/img/pin.svg'; ?>" width="20" alt="<?php esc_attr_e('resido_pin', 'resido-listing'); ?>">
									</div>
								</div>
							</div>

							<div class="col-lg-2 col-md-3 col-sm-12">
								<div class="form-group">
									<input type="submit" class="btn search-btn search_sbmtfrm" id="searchsubmit" value="<?php _e('Search', 'resido-listing'); ?>" />
								</div>
							</div>


						</div>
					</div>
				</div>
			</form>
			<!-- Style 2 -->
		<?php
		} else {
			if (isset($listing_option['listing_slug'])) {
				$listing_slug = $listing_option['listing_slug'];
			} else {
				$listing_slug = 'listings';
			}
		?>
			<!-- search Form -->
			<div class="hero-search-content side-form">

				<form method="get" id="advanced-searchform" role="search" action="<?php echo esc_url(home_url($listing_slug . '/?type=2')); ?>">
					<input type="hidden" name="search" value="advanced">
					<div class="row">
						<div class="col-lg-12 col-md-12 col-sm-12">
							<div class="form-group">
								<div class="input-with-icon">
									<input type="text" class="form-control b-r" value="" placeholder="<?php _e('Keywords...', 'resido-listing'); ?>" name="s" id="name" />
									<img src="<?php echo plugins_url() . '/resido-listing/elementor/assets/img/pin.svg'; ?>" width="18" alt="<?php esc_attr_e('resido_pin', 'resido-listing'); ?>" />
								</div>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-lg-6 col-md-6 col-sm-6">
							<div class="form-group">
								<label><?php echo esc_html__('Min Price', 'resido-listing'); ?></label>
								<select id="minprice" name="listing_minprice" class="form-control">
									<option value="">&nbsp;</option>
									<?php
									$minp_val = rlisting_get_meta_list('rlisting_sale_or_rent');
									foreach ($minp_val as $key => $meta_val) {
										echo '<option value="' . $meta_val . '">' . $meta_val . '</option>';
									}
									?>
								</select>
							</div>
						</div>
						<div class="col-lg-6 col-md-6 col-sm-6">
							<div class="form-group">
								<label><?php echo esc_html__('Max Price', 'resido-listing'); ?></label>
								<select id="maxprice" name="listing_maxprice" class="form-control">
									<option value="">&nbsp;</option>
									<?php
									$maxp_val = rlisting_get_meta_list('rlisting_sale_or_rent');
									foreach ($maxp_val as $key => $meta_val) {
										echo '<option value="' . $meta_val . '">' . $meta_val . '</option>';
									}
									?>

								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-6 col-md-6 col-sm-6">
							<div class="form-group">
								<label><?php echo esc_html__('Property Type', 'resido-listing'); ?></label>
								<select data-placeholder="<?php _e('Select Category', 'resido-listing'); ?>" name="listing_cate" class="form-control listing_cate">
									<option value=""><?php _e('Select Category', 'resido-listing'); ?></option>
									<?php
									$rlisting_category = get_terms(
										array(
											'taxonomy'   => 'rlisting_category',
											'hide_empty' => false,
										)
									);

									if (!empty($rlisting_category)) {
										foreach ($rlisting_category as $single) {
											echo '<option value="' . $single->slug . '">' . $single->name . '</option>';
										}
									}
									?>
								</select>
							</div>
						</div>

						<div class="col-lg-6 col-md-6 col-sm-6">
							<div class="form-group">
								<label><?php echo esc_html__('Bed Rooms', 'resido-listing'); ?></label>
								<select id="bedrooms" name="listing_beds" class="form-control">
									<option value="">&nbsp;</option>
									<?php
									$bed_val = rlisting_get_meta_list('rlisting_bedrooms');
									foreach ($bed_val as $key => $meta_val) {
										echo '<option value="' . $meta_val . '">' . $meta_val . '</option>';
									}
									?>
								</select>
							</div>
						</div>

					</div>

					<div class="row">
						<div class="col-lg-12 col-md-12 col-sm-12">
							<div class="form-group">
								<label><?php echo esc_html__('Property Location', 'resido-listing'); ?></label>
								<select id="list_loc" name="listing_loc" class="form-control">
									<option value=""><?php _e('All Cities', 'resido-listing'); ?></option>
									<?php
									$rlisting_location = get_terms(
										array(
											'taxonomy'   => 'rlisting_location',
											'hide_empty' => false,
										)
									);

									if (!empty($rlisting_location)) {
										foreach ($rlisting_location as $single) {
											if ($single->parent != 0) {
												$parent = get_term_by('id', $single->parent, 'rlisting_location');
												echo '<option value="' . $single->slug . '">' . $single->name . ',' . $parent->name . '</option>';
											}
										}
									}
									?>
								</select>
							</div>
						</div>
					</div>

					<div class="hero-search-action">
						<input type="submit" class="btn search-btn search_sbmtfrm" id="searchsubmit" value="<?php _e('Search Result', 'resido-listing'); ?>" />
					</div>
				</form>
			</div>
			<!-- search Form -->
		<?php
		}
		?>

	<?php
	}

	public function get_reset_password_form()
	{
	?>

		<div class="modal fade" id="reset" tabindex="-1" role="dialog" aria-labelledby="resetrmodal">
			<div class="modal-dialog modal-dialog-centered login-pop-form" role="document">
				<div class="modal-content" id="resetrmodal">
					<span class="mod-close" data-bs-dismiss="modal" aria-hidden="true"><i class="ti-close"></i></span>
					<div class="modal-body">
						<h4 class="center"><?php _e('Reset YOUR PASSWORD', 'resido-listing'); ?></h4>
						<div class="login-form">
							<p class="status"></p>
							<form class="ajax-auth" id="forgot_password" action="forgot_password" method="post">
								<label><?php _e('Username or E-mail:', 'resido-listing'); ?><br> </label>
								<div class="form-group">
									<div class="input-with-icon">
										<input name="user_login" id="user_login" class="form-control" type="text" />
									</div>
								</div>
								<?php wp_nonce_field('ajax-forgot-nonce', 'forgotsecurity'); ?>
								<div class="form-group">
									<input type="submit" class="btn btn-md full-width pop-login submit_button" value="<?php _e('Get New Password', 'resido-listing'); ?>" tabindex="100">
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>

	<?php

	}

	public function get_login_form()
	{
		$listing_option     = resido_listing_option();
		$login_redirect_url = isset($listing_option['login_redirect_url']) ? $listing_option['login_redirect_url'] : '';
	?>
		<div class="modal fade" id="login" tabindex="-1" role="dialog" aria-labelledby="registermodal">
			<div class="modal-dialog modal-dialog-centered login-pop-form" role="document">
				<div class="modal-content" id="registermodal">
					<span class="mod-close" data-bs-dismiss="modal" aria-hidden="true"><i class="ti-close"></i></span>
					<div class="modal-body">
						<h4 class="modal-header-title"><?php _e('Log', 'resido-listing'); ?> <span class="theme-cl"><?php _e('In', 'resido-listing'); ?></span></h4>
						<div class="login-form" id="resido-login-form">
							<span id="log_message"></span>
							<form action="#" method="post" id="myForm">
								<div class="form-group">
									<label><?php _e('User Name', 'resido-listing'); ?></label>
									<div class="input-with-icon">
										<input type="text" name="rlusername" class="form-control" placeholder="<?php echo esc_html__('Username', 'resido-listing'); ?>">
										<i class="ti-user"></i>
									</div>
								</div>
								<div class="form-group">
									<label><?php _e('Password', 'resido-listing'); ?></label>
									<div class="input-with-icon">
										<input type="password" name="rlpassword" class="form-control" placeholder="*******">
										<i class="ti-unlock"></i>
									</div>
								</div>
								<?php wp_nonce_field('resido_log_form', 'login_form'); ?>
								<input type="hidden" name="action" value="resido_user_login">
								<input type="hidden" name="redirect_to" value="<?php echo $login_redirect_url; ?>">
								<div class="form-group">
									<input type="submit" name="login_submit" value="<?php esc_attr_e('Login', 'resido'); ?>" class="btn btn-md full-width pop-login">
								</div>
							</form>
						</div>
						<div class="text-center">
							<p class="mt-1">
								<a href="JavaScript:Void(0);" id="forgot_pass" class="link" data-bs-toggle="modal" data-bs-target="#reset"><?php _e('Forgot password?', 'resido-listing'); ?></a>
							</p>
						</div>

						<?php
						$registration_on_off = isset($listing_option['registration_on_off']) ? $listing_option['registration_on_off'] : 'yes';
						if ($registration_on_off == 'yes') {
						?>
							<div class="text-center">
								<?php _e('Don\'t have an account', 'resido-listing'); ?>
								<a href="JavaScript:Void(0);" id="login_to_resistration" class="link" data-bs-toggle="modal" data-bs-target="#signup">
									<?php _e('Registration', 'resido-listing'); ?></a>
							</div>
						<?php
						}
						?>

					</div>
				</div>
			</div>
		</div>
	<?php

	}

	public function resido_resistration_form()
	{
		$listing_option            = resido_listing_option();
		$registration_redirect_url = isset($listing_option['registration_redirect_url']) ? $listing_option['registration_redirect_url'] : '';
	?>
		<div class="modal fade signup" id="signup" tabindex="-1" role="dialog" aria-labelledby="sign-up">
			<div class="modal-dialog modal-dialog-centered login-pop-form" role="document">
				<div class="modal-content" id="sign-up">
					<span class="mod-close" data-bs-dismiss="modal" aria-hidden="true"><i class="ti-close"></i></span>
					<div class="modal-body">
						<h4 class="modal-header-title"> <?php _e('Sign', 'resido-listing'); ?> <span class="theme-cl"><?php _e('Up', 'resido-listing'); ?></span></h4>
						<div class="login-form">
							<span id="res_message"></span>
							<form action="#" method="post" id="resido-registration-form">
								<div class="row">
									<div class="col-lg-6 col-md-6">
										<div class="form-group">
											<div class="input-with-icon"><input name="first_name" class="form-control" required type="text" placeholder="<?php echo esc_html__('First name', 'resido-listing'); ?>" />
												<i class="ti-user"></i>
											</div>
										</div>
									</div>
									<div class="col-lg-6 col-md-6">
										<div class="form-group">
											<div class="input-with-icon"><input name="last_name" class="form-control" type="text" placeholder="<?php echo esc_html__('Last name', 'resido-listing'); ?>" />
												<i class="ti-user"></i>
											</div>
										</div>
									</div>
									<div class="col-lg-6 col-md-6">
										<div class="form-group">
											<div class="input-with-icon"><input name="user_name" class="form-control" required type="text" placeholder="<?php echo esc_html__('Username', 'resido-listing'); ?>" />
												<i class="ti-user"></i>
											</div>
										</div>
									</div>
									<div class="col-lg-6 col-md-6">
										<div class="form-group">
											<div class="input-with-icon"><input name="email" class="form-control" required type="email" placeholder="<?php echo esc_html__('Email', 'resido-listing'); ?>" />
												<i class="ti-email"></i>
											</div>
										</div>
									</div>
									<div class="col-lg-6 col-md-6">
										<div class="form-group">
											<div class="input-with-icon"><input name="password" class="form-control" required type="password" placeholder="<?php echo esc_html__('Password', 'resido-listing'); ?>" />
												<i class="ti-unlock"></i>
											</div>
										</div>
									</div>
									<div class="col-lg-6 col-md-6">
										<div class="form-group">
											<div class="input-with-icon"><input name="conf_password" class="form-control" required type="password" placeholder="<?php echo esc_html__('Confirm Password', 'resido-listing'); ?>" />
												<i class="ti-unlock"></i>
											</div>
										</div>
									</div>
								</div>
								<?php wp_nonce_field('resido_resgis_form'); ?>
								<input type="hidden" name="action" value="resido_user_registration">
								<input type="hidden" name="redirect_to" value="<?php echo $registration_redirect_url; ?>">
								<div id="singup_message"></div>
								<div class="form-group"><button class="btn btn-md full-width pop-login" type="submit"><?php _e('Sign Up', 'resido-listing'); ?></button></div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	<?php
	}

	public function resido_add_listing_page()
	{
	?>
		<!-- ============================ Submit Property Start ================================== -->
		<section class="gray-simple">
			<div class="container">
				<div class="row">
					<?php if (!is_user_logged_in()) { ?>
						<div class="col-lg-12 col-md-12">
							<div class="alert alert-success" role="alert">
								<p><?php esc_html_e('Please, Sign In before you submit a property. If you don\'t have an account you can create one by', 'resido-listing'); ?>
									<a href="JavaScript:Void(0);" data-bs-toggle="modal" data-bs-target="#login" class="text-success"><?php echo esc_html_e('Clicking Here', 'resido-listing'); ?></a>
								</p>
							</div>
						</div>
						<?php
					} else {
						// ------------------------------------------------------------------------ If Logged In then run the add listing
						$listing_option           = resido_listing_option();
						$add_listing_with_package = isset($listing_option['add_listing_with_package']) ? $listing_option['add_listing_with_package'] : 'yes';

						global $current_user;
						$args        = array(
							'post_type'      => 'rsubscription',
							'post_status'    => array('publish', 'draft'),
							'author'         => $current_user->ID,
							'posts_per_page' => -1,
						);
						$sub_query   = new \WP_Query($args);
						$limit_count = 0;
						if ($sub_query->have_posts()) :
							while ($sub_query->have_posts()) :
								$sub_query->the_post();
								$bpackage_id        = get_post_meta($sub_query->post->ID, 'rlisting_package_id', true);
								$get_renew_ids[]    = get_post_meta($sub_query->post->ID, 'rlisting_package_id', true);
								$limit_count        = $limit_count + (int) get_post_meta($bpackage_id, 'rlisting_list_subn_limit', true);
								$subscription_id    = $sub_query->post->ID;
								$user_rpackage_meta = get_user_meta($current_user->ID, 'rpackage', true);
								if ($user_rpackage_meta != '') {
									$subscription_id = $user_rpackage_meta;
								} else {
									$subscription_id = $sub_query->post->ID;
								}
								if (get_post_status($subscription_id) == 'publish') {
									$post_status = 'publish';
								} else {
									$post_status = 'draft';
								}
							endwhile;
						endif;
						wp_reset_query();

						if (isset($listing_option['enable_subscription']) && $listing_option['enable_subscription'] == 0) {
							$post_status = 'publish';
							$limit_count = resido_total_active_lingting_by_user() + 1;
						}

						// Price plan custom post type list
						if (resido_total_active_lingting_by_user() < $limit_count && $post_status == 'publish') {

							if ($add_listing_with_package != 'yes') {
								$_SESSION['package_id'] = '';
							}

							if (isset($_POST['rlsubmit']) && $_POST['rlsubmit']) {

								if (!wp_verify_nonce($_REQUEST['submit-listing'], 'listing-add-listing')) {
									return true;
								}

								$rlisting_sale_or_rent      = sanitize_text_field($_POST['rlisting_sale_or_rent']);
								$rlisting_price_postfix     = sanitize_text_field($_POST['rlisting_price_postfix']);
								$rlisting_area_size         = sanitize_text_field($_POST['rlisting_area_size']);
								$rlisting_area_size_postfix = sanitize_text_field($_POST['rlisting_area_size_postfix']);
								$rlisting_bedrooms          = sanitize_text_field($_POST['rlisting_bedrooms']);
								$rlisting_bathrooms         = sanitize_text_field($_POST['rlisting_bathrooms']);
								$rlisting_garage            = sanitize_text_field($_POST['rlisting_garage']);

								$rltitle       = sanitize_text_field($_POST['rltitle']);
								$rlstatus      = sanitize_text_field($_POST['rlstatus']);
								$rlcat         = sanitize_text_field($_POST['rlcat']);
								$rldescription = wp_kses_post($_POST['rldescription']);
								$rlcountry     = sanitize_text_field($_POST['rlcountry']);
								$rlcity        = sanitize_text_field($_POST['rlcity']);
								if (isset($_POST['rllatitude']) && $_POST['rllatitude']) {
									$rllatitude = sanitize_text_field($_POST['rllatitude']);
								} else {
									$rllatitude = '40.7';
								}

								if (isset($_POST['rllongitude']) && $_POST['rllongitude']) {
									$rllongitude = sanitize_text_field($_POST['rllongitude']);
								} else {
									$rllongitude = '73.87';
								}

								$rlemail             = sanitize_text_field($_POST['rlemail']);
								$rlmobile            = sanitize_text_field($_POST['rlmobile']);
								$rlwebsite           = sanitize_text_field($_POST['rlwebsite']);
								$rlfax               = sanitize_text_field($_POST['rlfax']);
								$rlisting_address    = sanitize_text_field($_POST['rlisting_address']);
								$rlisting_map_iframe = $_POST['rl_map_iframe'];
								$rlisting_video_iframe = $_POST['rlvideoiframe'];

								$rlvideolink   = sanitize_text_field($_POST['rlvideolink']);

								$rlname       = sanitize_text_field($_POST['rlname']);
								$rlemail      = sanitize_text_field($_POST['rlemail']);
								$rlphone      = sanitize_text_field($_POST['rlphone']);
								$rlagencyinfo = sanitize_text_field($_POST['rlagencyinfo']);
								$rlagentinfo  = sanitize_text_field($_POST['rlagentinfo']);

								$rlamenity = '';
								if (isset($_POST['rlamenity']) && !empty($_POST['rlamenity'])) {
									$rlamenity = $_POST['rlamenity'];
								}

								$rllocation = array($rlcountry, $rlcity);

								$hierarchical_tax = array($rlcat); // Array of tax ids.
								$rlstatus_tax     = array($rlstatus); // Array of tax ids.
								$post_arr         = array(
									'post_title'   => $rltitle,
									'post_content' => $rldescription,
									'post_type'    => 'rlisting',
									'post_status'  => 'publish',
									'post_author'  => get_current_user_id(),
									'tax_input'    => array(
										'rlisting_category' => $hierarchical_tax,
										'rlisting_status' => $rlstatus_tax,
										'rlisting_features' => $rlamenity,
										'rlisting_location' => $rllocation,
									),

									'meta_input'   => array(

										'rlisting_sale_or_rent' => $rlisting_sale_or_rent,
										'rlisting_price_postfix' => $rlisting_price_postfix,
										'rlisting_area_size' => $rlisting_area_size,
										'rlisting_area_size_postfix' => $rlisting_area_size_postfix,
										'rlisting_bedrooms' => $rlisting_bedrooms,
										'rlisting_bathrooms' => $rlisting_bathrooms,
										'rlisting_garage'  => $rlisting_garage,
										'rlisting_address' => $rlisting_address,
										'rlisting_map_iframe' => $rlisting_map_iframe,

										'rlisting_mobile'  => $rlmobile,
										'rlisting_website' => $rlwebsite,
										'rlisting_fax_no'  => $rlfax,
										'rlisting_latitude' => $rllatitude,
										'rlisting_longitude' => $rllongitude,
										'rlisting_videolink' => $rlvideolink,
										'rlisting_video_iframe'    => $rlisting_video_iframe,
										'rlisting_rlname'  => $rlname,
										'rlisting_email'   => $rlemail,
										'rlisting_phone'   => $rlphone,
										'rlisting_rlagencyinfo' => $rlagencyinfo,
										'rlisting_rlagentinfo' => $rlagentinfo,
										'user_package_id'  => $subscription_id,
									),
								);

								$post_id = wp_insert_post($post_arr);
								set_post_thumbnail($post_id, $_POST['frontend_rlfeaturedimg']);

								if (isset($_POST['frontend_rlvideoimg_array']) && $_POST['frontend_rlvideoimg_array']) {
									add_post_meta($post_id, 'rlisting_v_image', $_POST['frontend_rlvideoimg_array']);
								}

								if (isset($_POST['resido_attachment_id_array']) && !empty($_POST['resido_attachment_id_array'])) {
									foreach ($_POST['resido_attachment_id_array'] as $att_id) {
										add_post_meta($post_id, 'rlisting_gallery-image', $att_id);
									}
								}

								$listing_menu_item = array();
								$attach_id         = 0;

								if (isset($_POST['listing-product-title']) && !empty($_POST['listing-product-title'])) {
									$files = $_FILES['listing-product-image'];
									foreach ($_POST['listing-product-title'] as $key => $val) {

										if ($files['name'][$key]) {
											$file = array(
												'name'     => $files['name'][$key],
												'type'     => $files['type'][$key],
												'tmp_name' => $files['tmp_name'][$key],
												'error'    => $files['error'][$key],
												'size'     => $files['size'][$key],
											);

											$_FILES = array('listing-product-image' => $file);
											require_once ABSPATH . 'wp-admin' . '/includes/image.php';
											require_once ABSPATH . 'wp-admin' . '/includes/file.php';
											require_once ABSPATH . 'wp-admin' . '/includes/media.php';
											$attach_id = media_handle_upload('listing-product-image', $post_id);
										}

										$listing_menu_item[] = array(
											'listing-product-image' => $attach_id,
											'listing-product-title' => isset($_POST['listing-product-title'][$key]) ? $_POST['listing-product-title'][$key] : '',
											'listing-product-cate'  => isset($_POST['listing-product-cate'][$key]) ? $_POST['listing-product-cate'][$key] : '',
											'listing-product-details' => isset($_POST['listing-product-details'][$key]) ? $_POST['listing-product-details'][$key] : '',
											'listing-product-percentage-text' => isset($_POST['listing-product-percentage-text'][$key]) ? $_POST['listing-product-percentage-text'][$key] : '',
											'listing-product-link-title' => isset($_POST['listing-product-link-title'][$key]) ? $_POST['listing-product-link-title'][$key] : '',
											'listing-product-title-link' => isset($_POST['listing-product-title-link'][$key]) ? $_POST['listing-product-title-link'][$key] : '',
										);
									}

									add_post_meta($post_id, 'listing-product-list', $listing_menu_item);
								}

						?>
								<script type="text/javascript">
									document.location.href = '<?php echo home_url('dashboard/?dashboard=listings' . $post_id); ?>';
								</script>

								<!-- <script type="text/javascript">
				  document.location.href = '<?php echo home_url('?p=' . $post_id); ?>';
				</script> -->
							<?php

								ob_start();
							}
							?>

							<!-- ============================ Submit Property Start ================================== -->
							<section class="gray-simple">
								<div class="container">
									<div class="row">
										<!-- Submit Form -->
										<div class="col-lg-12 col-md-12">
											<div class="submit-page">
												<form action="#" method="post" id="listing-submit-form" class="listing-submit-form" enctype="multipart/form-data">
													<?php
													resido_get_listing_submit_form_part('basic-information');
													// Detailed Information -->
													resido_get_listing_submit_form_part('details-information');
													// Featured Image
													resido_get_listing_submit_form_part('featured-image');
													// Gallery
													resido_get_listing_submit_form_part('gallery-image');
													// Video Link
													resido_get_listing_submit_form_part('video-link');
													// Location
													resido_get_listing_submit_form_part('location');
													// Business Information -->
													resido_get_listing_submit_form_part('business-information');
													// Contact Information -->
													resido_get_listing_submit_form_part('contact-information');
													?>
													<div class="form-group col-lg-12 col-md-12">
														<label><?php echo esc_html__('GDPR Agreement *', 'resido-listing'); ?></label>
														<ul class="no-ul-list">
															<li>
																<input id="aj-1" class="checkbox-custom" name="aj-1" type="checkbox">
																<label for="aj-1" class="checkbox-custom-label"><?php echo esc_html__('I consent to having this website store my submitted information so they can respond to my inquiry.', 'resido-listing'); ?></label>
															</li>
														</ul>
													</div>
													<div class="form-group col-lg-12 col-md-12">
														<?php
														wp_nonce_field('listing-add-listing', 'submit-listing');
														if ($current_user->roles[0] == 'subscriber') {
														?>
															<p><?php echo esc_html('Please upgrade demouser role to submit post.'); ?></p>
															<button disabled title="Upgrade user role to post" class="btn btn-theme-light-2 rounded"><?php _e('Submit &#38; Preview', 'resido-listing'); ?></button>
														<?php } else { ?>
															<input class="btn btn-theme-light-2 rounded" type="submit" name="rlsubmit" value="<?php _e('Submit &#38; Preview', 'resido-listing'); ?>">
														<?php }; ?>
													</div>
												</form>
											</div>
										</div>
									</div>
								</div>
							</section>
							<!-- ============================ Submit Property End ================================== -->
						<?php
							// ob_get_flush();
						} elseif (isset($post_status) && $post_status == 'draft') {
							$args  = array(
								'posts_per_page' => -1,
								'post_type'      => 'pricing_plan',
							);
							$query = new \WP_Query($args);
						?>
							<section>
								<div class="container">
									<div class="row">
										<?php
										if ($query->have_posts()) :
											while ($query->have_posts()) :
												$query->the_post();
												$price   = get_post_meta(get_the_ID(), '_price', true);
												$bg_type = get_post_meta(get_the_ID(), 'rlisting_bg_type', true);
												if (in_array(get_the_ID(), $get_renew_ids)) {
													$btn_label = 'Renew Plan';
												} else {
													$btn_label = 'Choose Plan';
												}
										?>
												<!-- Price Table -->
												<div class="col-lg-4 col-md-4">
													<div class="pricing-wrap <?php echo $bg_type; ?>">
														<div class="pricing-header">
															<h4 class="pr-value"><sup><?php echo $listing_option['currency_symbol']; ?></sup><?php echo esc_html($price); ?></h4>
															<h4 class="pr-title"><?php the_title(); ?></h4>
														</div>
														<div class="pricing-body">
															<?php the_content(); ?>
														</div>
														<div class="pricing-bottom">
															<a href="javascript:void(0)" class="btn-pricing add-to-cart-custom" data-price="<?php echo $price; ?>" data-product_id="<?php echo get_the_ID(); ?>"><?php echo esc_html($btn_label); ?></a>
														</div>
													</div>
												</div>
												<!-- Price Table -->
										<?php
											endwhile;
										endif;
										?>
									</div>

								</div>
							</section>
						<?php
						} else {
							$args  = array(
								'posts_per_page' => -1,
								'post_type'      => 'pricing_plan',
							);
							$query = new \WP_Query($args);
						?>
							<section>
								<div class="container">
									<div class="row">
										<?php
										if ($query->have_posts()) :
											while ($query->have_posts()) :
												$query->the_post();
												$price   = get_post_meta(get_the_ID(), '_price', true);
												$bg_type = get_post_meta(get_the_ID(), 'rlisting_bg_type', true);
										?>
												<!-- Price Table -->
												<div class="col-lg-4 col-md-4">
													<div class="pricing-wrap <?php echo $bg_type; ?>">
														<div class="pricing-header">
															<h4 class="pr-value"><sup><?php echo $listing_option['currency_symbol']; ?></sup><?php echo esc_html($price); ?></h4>
															<h4 class="pr-title"><?php the_title(); ?></h4>
														</div>
														<div class="pricing-body">
															<?php the_content(); ?>
														</div>
														<div class="pricing-bottom">
															<a href="javascript:void(0)" class="btn-pricing add-to-cart-custom" data-price="<?php echo $price; ?>" data-product_id="<?php echo get_the_ID(); ?>"><?php echo esc_html('Choose Plan'); ?></a>
														</div>

													</div>
												</div>
												<!-- Price Table -->

										<?php
											endwhile;
										endif;
										?>
									</div>

								</div>
							</section>
					<?php
						}
						// ------------------------------------------------------------------------ If Logged In then run the add listing
					}
					?>
				</div>
			</div>
		</section>
<?php
	}
}

new Shortcode();
