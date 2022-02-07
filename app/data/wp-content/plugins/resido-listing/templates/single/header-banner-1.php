			<!-- ================================ Start Banner =================================== -->
			<?php
			$bg_image_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
			?>
			<section class="page-title-banner" style="background-image:url(<?php echo $bg_image_url; ?>);">
				<div class="container">
					<div class="row m-0 align-items-end detail-swap">
						<div class="tr-list-wrap">
							<div class="tr-list-detail">
								<div class="tr-list-thumb">
									<?php
									global $post;
									echo resido_get_avat('90');
									?>
								</div>
								<div class="tr-list-info">
									<h4 class="veryfied-list"><?php echo get_the_title(); ?></h4>
									<p><?php listing_meta_field('address'); ?></p>
								</div>
							</div>
							<div class="listing-detail_right">
								<div class="listing-detail-item">
									<?php
									global $current_user;
									if (!is_user_logged_in()) {
										echo '<a href="#" data-toggle="modal" data-target="#login" class="btn btn-list"><i class="ti-heart"></i>' . __('Favorite', 'resido-listing') . '</a>';
									} else {
										$user_meta = get_user_meta($current_user->ID, '_favorite_posts');
										if (in_array(get_the_ID(), $user_meta)) {
											echo '<a href="javascript:void(0)" data-userid="' . $current_user->ID . '" data-postid="' . get_the_ID() . '" class="btn btn-list live_single_2 like-bitt" id="like_listing' . get_the_ID() . '"><i class="ti-heart"></i>' . __('Favorite', 'resido-listing') . '</a>';
										} else {
											echo '<a href="javascript:void(0)" data-userid="' . $current_user->ID . '" data-postid="' . get_the_ID() . '" class="btn btn-list live_single_2" id="like_listing' . get_the_ID() . '"><i class="ti-heart"></i>' . __('Favorite', 'resido-listing') . '</a>';
										}
									}
									?>
								</div>
								<div class="listing-detail-item">
									<div class="share-opt-wrap">
										<button type="button" class="btn btn-list" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
											<i class="ti-share"></i><?php _e('Share', 'resido-listing'); ?>
										</button>

										<?php

										resido_user_share_opt();

										?>

									</div>
								</div>
								<div class="listing-detail-item">
									<a href="#review_message" class="btn btn-list snd-msg">
										<i class="ti-write"></i><?php echo esc_html__('Review', 'resido-listing'); ?>
									</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>
			<!-- ================================ End Banner ========================================= -->
			<!-- ================================ List Overview ===================================== -->
			<section class="p-0">
				<div class="container">
					<div class="row align-items-center">
						<div class="col-lg-12 col-md-12 col-sm-12">
							<div class="rixel-bar">
								<?php
								$comments = get_comments(array('post_id' => $post->ID, 'status' => 'approve'));
								if (count($comments) > 0) {
								?>
									<div class="rixel-bar-left">
										<div class="rate-overall rate-high">
											<div class="overrate-box">
												<?php
												echo resido_get_average_rate(get_the_ID());
												$comments = get_comments(array('post_id' => $post->ID, 'status' => 'approve'));
												$total_ratting = resido_get_average_ratting_name(get_the_ID());
												$service = $total_ratting['service'];
												$money = $total_ratting['money'];
												$cleanlinessh = $total_ratting['cleanliness'];
												$location = $total_ratting['location'];
												?>
											</div>
											<div class="overrate-box-caption">
												<span><?php echo esc_html__('Very Good', 'resido-listing'); ?></span>
												<a href="#comments-wrap" class="rating-link"><?php echo count($comments); ?>
													<?php echo esc_html__('reviewers rated', 'resido-listing'); ?></a>
											</div>
										</div>
										<div class="separate-rated">

											<?php

											if ($service) {
											?>
												<div class="singlewise-rated">
													<h6 class="sngl-rated rated-good"><?php echo round($service, 1); ?></h6>
													<span class="rate-status"><?php echo esc_html__('Services', 'resido-listing'); ?></span>
												</div>

											<?php

											}

											?>


											<?php

											if ($money) {
											?>

												<div class="singlewise-rated">
													<h6 class="sngl-rated rated-poor"><?php echo round($money, 1); ?></h6>
													<span class="rate-status"><?php echo esc_html__('Price', 'resido-listing'); ?></span>
												</div>
											<?php

											}

											?>

											<?php

											if ($cleanlinessh) {
											?>

												<div class="singlewise-rated">
													<h6 class="sngl-rated rated-mid"><?php echo round($cleanlinessh, 1); ?></h6>
													<span class="rate-status"><?php echo esc_html__('Quality', 'resido-listing'); ?></span>
												</div>

											<?php

											}

											?>

											<?php

											if ($location) {
											?>

												<div class="singlewise-rated">
													<h6 class="sngl-rated rated-high"><?php echo round($location, 1); ?></h6>
													<span class="rate-status"><?php echo esc_html__('Location', 'resido-listing'); ?></span>
												</div>
											<?php
											}
											?>
										</div>
									</div>
								<?php
								}
								?>
								<div class="rixel-bar-right">
									<div class="auth-call-wrap">
										<div class="call-ic-box">
											<i class="lni-phone-handset"></i>
										</div>
										<div class="call-ic-box-caption">
											<span><?php echo esc_html__('Call Now', 'resido-listing'); ?></span>
											<h5 class="aut-call">
												<a href="tel:<?php listing_meta_field('mobile'); ?>"><?php listing_meta_field('mobile'); ?></a>
											</h5>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>
			<!-- ================================ List Overview ===================================== -->