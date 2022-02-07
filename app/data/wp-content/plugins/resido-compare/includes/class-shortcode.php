<?php
class CompareShortCode
{

	public function __construct()
	{
		add_shortcode('resido_compare_result', [$this, 'compare_result']);
	}

	public function compare_result($atts)
	{
		if (isset($_SESSION['products']) || isset($_POST['tDta'])) {

			if (!empty($_POST['tDta'])) {
				$td = $_POST['tDta'];
				$_SESSION['products'][] = $td;
			}

			if (isset($_POST['tDelete'])) {
				if (($key = array_search($_POST['tDelete'], $_SESSION['products'])) !== false) {
					unset($_SESSION['products'][$key]);
				}
			}

			$listing_option = resido_listing_option();
			$feats = get_term_list();

			$comp_count = count(array_unique($_SESSION['products']));

			switch ($comp_count) {
				case '1':
					$comp_column = "col-lg-6";
					break;
				case '2':
					$comp_column = "col-lg-4";
					break;
				case '3':
					$comp_column = "col-lg-3";
					break;
				default:
					$comp_column = "col-sm";
					break;
			}
?>
			<!-- Compare Property -->
			<section>
				<div class="container">
					<div class="pricing pricing-5">

						<div class="row">
							<div class="<?php echo $comp_column; ?> text-center d-lg-block d-md-none d-sm-none d-none">
								<div class="comp-property-blank">
									<h2><?php echo esc_html_e('Property Comparison Features', 'resido-listing') ?></h2>
								</div>
								<ul>
									<li>
										<span><?php echo esc_html__('Area', 'resido-compare'); ?></span>
									</li>
									<li>
										<span><?php echo esc_html__('Bedrooms', 'resido-compare'); ?></span>
									</li>
									<li>
										<span><?php echo esc_html__('Bathrooms', 'resido-compare'); ?></span>
									</li>
									<?php if (!empty($listing_option['select_ff'])) {
										foreach ($listing_option['select_ff'] as $key => $value) {
									?>
											<li>
												<span><?php echo $feats[$value]; ?></span>
											</li>
									<?php
										}
									} ?>

								</ul>
							</div>

							<?php

							$_SESSION['products']   = array_unique($_SESSION['products']);
							$args                   = array(
								'post_type' => 'rlisting',
								'post__in'  => $_SESSION['products'],
							);
							$query = new WP_Query($args);

							$compare_size = count($query->posts);

							$i = 1;
							while ($query->have_posts()) :
								$query->the_post();
								$status       = 'publish';
								$curent_time  = current_time('d');
								$post_time    = get_the_date('d');
								$diff_time    = $curent_time - $post_time;
								$dataId       = get_the_ID();
								// $drive        = carleader_listings_meta('model_drive');
							?>

								<div class="<?php echo $comp_column; ?> text-center">
									<div class="comp-property">
										<a href="<?php the_permalink(); ?>">
											<div class="clp-img">

												<?php
												if (has_post_thumbnail()) {
													the_post_thumbnail();
												} else { ?>
													<img src="<?php echo plugins_url('resido-listing') . '/assets/img/placeholder.png'; ?>" alt=""><?php
																																				}
																																					?>
												<?php if ($comp_count > 1) { ?>
													<form action="<?php echo home_url('comparing'); ?>" method="POST">
														<input name="tDelete" class="tDelete" type="hidden" value="<?php echo $dataId; ?>">
														<button class="remove-comp-btn" type="submit"><span class="remove-from-compare"><i class="ti-close"></i></span></button>
													</form>
												<?php } ?>

											</div>

											<div class="clp-title">
												<h4><?php the_title(); ?></h4>
												<span>
													<?php
													echo $listing_option['currency_symbol'];
													listing_meta_field('sale_or_rent');
													?>
												</span>
											</div>
										</a>
									</div>
									<ul>
										<li>
											<?php
											listing_meta_field('area_size');
											listing_meta_field('area_size_postfix');
											?>
											<span class="show-mb"></span>
										</li>
										<li>
											<?php listing_meta_field('bedrooms'); ?>
											<span class="show-mb"><?php echo esc_html__('Bedrooms', 'resido-compare'); ?></span>
										</li>
										<li>
											<?php listing_meta_field('bathrooms'); ?>
											<span class="show-mb"><?php echo esc_html__('Bathrooms', 'resido-compare'); ?></span>
										</li>

										<?php if (!empty($listing_option['select_ff'])) {
											foreach ($listing_option['select_ff'] as $key => $value) {
												if (!empty($value)) {
													if (has_term(array($value), 'rlisting_features')) {
										?>
														<li>
															<div class="checkmark"></div>
															<span class="show-mb"><?php echo $value; ?></span>
														</li>
													<?php
													} else {
													?>
														<li>
															<div class="crossmark"></div>
															<span class="show-mb"><?php echo $value; ?></span>
														</li>
										<?php
													}
												}
											}
										} ?>
									</ul>
								</div>
							<?php
								$i++;
							endwhile;
							wp_reset_postdata();
							?>

						</div>
					</div>
				</div>
			</section>

			<!-- Compare Property -->

		<?php
		} else {
		?>

			<div class="row">
				<div class="col-lg-12 col-md-12">
					<div class="alert alert-success" role="alert">
						<p><?php echo esc_html_e('Not Found Any Property To Compare', 'resido-listing'); ?></p>
					</div>
				</div>
			</div>

<?php
		}
	}
}
new CompareShortCode();
