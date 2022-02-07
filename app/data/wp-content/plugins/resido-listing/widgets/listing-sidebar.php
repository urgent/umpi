<?php
add_action('widgets_init', 'resido_listing_sidebar_widgets');

function resido_listing_sidebar_widgets()
{
	register_widget('Listing_Sidebar_Area');
}

class Listing_Sidebar_Area extends WP_Widget
{

	private $defaults = array();

	function __construct()
	{
		$this->defaults = array(
			'title'             => esc_html__('Resido Listing Area', 'resido-listing'),
			'your_checkbox_var' => '',
		);
		WP_Widget::__construct('resido-listing-sidebar', esc_html__('Resido Listing Area', 'resido-listing'));
	}

	function update($new_instance, $old_instance)
	{
		$defaults                      = $this->defaults;
		$instance                      = $old_instance;
		$instance['title']             = esc_attr($new_instance['title']);
		$instance['your_checkbox_var'] = $new_instance['your_checkbox_var'];
		return $instance;
	}

	function form($instance)
	{
		$instance = wp_parse_args((array) $instance, $this->defaults);
		$title    = isset($instance['title']) ? esc_attr($instance['title']) : '';
?>
		<p>
			<input class="checkbox" type="checkbox" <?php checked($instance['your_checkbox_var'], 'on'); ?> id="<?php echo $this->get_field_id('your_checkbox_var'); ?>" name="<?php echo $this->get_field_name('your_checkbox_var'); ?>" />
			<label for="<?php echo $this->get_field_id('your_checkbox_var'); ?>">
				<?php echo esc_html__('Label of your checkbox variable', 'resido-listing'); ?>
			</label>
		</p>
	<?php
	}
	function widget($args, $instance)
	{
		$instance = wp_parse_args((array) $instance, $this->defaults);
		extract($args);
		$your_checkbox_var = $instance['your_checkbox_var'] ? 'true' : 'false';
		echo $args['before_widget'];
		if (!empty($instance['title'])) {
			echo $args['before_title'] . apply_filters('widget_title', $instance['title']) . $args['after_title'];
		}

		$rkeyword = '';
		$location = '';

		if (isset($_GET['s'])) {
			$rkeyword = $_GET['s'];
		}

		if (isset($_GET['location'])) {
			$location = $_GET['location'];
		}

		$listing_option                  = resido_listing_option();
		$sidebar_keyword_search          = isset($listing_option['sidebar_keyword_search']) ? $listing_option['sidebar_keyword_search'] : 'yes';
		$sidebar_location_search         = isset($listing_option['sidebar_location_search']) ? $listing_option['sidebar_location_search'] : 'yes';
		$sidebar_category_search         = isset($listing_option['sidebar_category_search']) ? $listing_option['sidebar_category_search'] : 'yes';
		$sidebar_radius_search           = isset($listing_option['sidebar_radius_search']) ? $listing_option['sidebar_radius_search'] : 'yes';
		$sidebar_radius_search           = isset($listing_option['sidebar_radius_search']) ? $listing_option['sidebar_radius_search'] : 'yes';
		$sidebar_advance_features_search = isset($listing_option['sidebar_advance_features_search']) ? $listing_option['sidebar_advance_features_search'] : 'yes';
		$sidebar_moderation_search       = isset($listing_option['sidebar_moderation_search']) ? $listing_option['sidebar_moderation_search'] : 'yes';

	?>

		<div id="listing_search">


			<?php
			if ($sidebar_keyword_search == 'yes') {
			?>
				<div class="form-group">
					<div class="input-with-icon">
						<input type="text" class="form-control" value="<?php echo $rkeyword; ?>" name="s" id="name" placeholder="<?php _e('Keyword', 'resido-listing'); ?>">
						<i class="ti-search"></i>
					</div>
				</div>
			<?php
			}
			?>


			<?php
			if ($sidebar_location_search == 'yes') {
			?>
				<div class="form-group">
					<div class="input-with-icon">
						<input type="text" class="form-control" value="<?php echo $location; ?>" placeholder="<?php _e('Where', 'resido-listing'); ?>" name="location" id="location" />
						<i class="ti-target">
						</i>
					</div>
					<input type="hidden" class="form-control" name="lat" id="lat" value="23.746875">
					<input type="hidden" class="form-control" name="lat" id="long" value="90.412824">
				</div>
			<?php
			}
			?>


			<?php
			if ($sidebar_category_search == 'yes') {
			?>

				<div class="form-group">
					<div class="input-with-icon">
						<select name="listing_cate" data-placeholder="<?php _e('Select Category', 'resido-listing'); ?>" id="list-category" class="form-control">
							<option value="">&nbsp;</option>
							<?php

							$queried_object = get_queried_object();
							$search_cats    = '';
							if (is_tax('rlisting_category')) {
								$search_cats = $queried_object->slug;
							} else {
								if (isset($_GET['listing_cate'])) {
									$search_cats = $_GET['listing_cate'];
								}
							}

							$rlisting_category = get_terms(
								array(
									'taxonomy'   => 'rlisting_category',
									'hide_empty' => false,
								)
							);
							if (!empty($rlisting_category)) {
								foreach ($rlisting_category as $single) {
									if (!empty($search_cats) && $search_cats == $single->slug) {
										echo '<option selected value="' . $single->slug . '">' . $single->name . '</option>';
									} else {
										echo '<option value="' . $single->slug . '">' . $single->name . '</option>';
									}
								}
							}
							?>
						</select>
						<i class="ti-briefcase"></i>
					</div>
				</div>

			<?php
			}
			?>


			<?php
			if ($sidebar_radius_search == 'yes') {
				wp_enqueue_script('rangeslider');
			?>

				<div class="range-slider">
					<input type="checkbox" id="is_radius" name="is_radius" value="0">
					<label><?php _e('Radius around', 'resido-listing'); ?> <span id="distance"> </span> km</label>
					<input type="range" min="1" max="100" value="50" class="slider" id="search_distance">
				</div>
			<?php
			}
			?>


			<?php
			if ($sidebar_advance_features_search == 'yes') {
			?>

				<div class="ameneties-features">
					<label><?php _e('Advance Features', 'resido-listing'); ?></label>
					<ul class="no-ul-list">
						<?php
						$rlisting_features = get_terms(
							array(
								'taxonomy'   => 'rlisting_features',
								'hide_empty' => false,
							)
						);

						if (!empty($rlisting_features)) {
							foreach ($rlisting_features as $key => $single) {
						?>
								<li>
									<input id="rlisting_features<?php echo $key; ?>" class="rlisting_features checkbox-custom" name="rlisting_features[]" type="checkbox" value="<?php echo $single->slug; ?>">
									<label for="rlisting_features<?php echo $key; ?>" class="checkbox-custom-label"><?php echo $single->name; ?></label>
								</li>
						<?php
							}
						}
						?>
					</ul>
				</div>

			<?php
			}
			?>

		</div>
<?php
		echo $args['after_widget'];
	}
}
