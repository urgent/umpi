<?php

namespace Resido\Helper\Elementor\Widgets;

use Elementor\Utils;
use Elementor\Controls_Manager;
use Elementor\Widget_Base;
use Elementor\Plugin;
use \Elementor\Repeater;

class Price_Table extends Widget_Base
{


	public function get_name()
	{
		return 'price_table';
	}
	public function get_title()
	{
		return __('Price Table', 'resido-core');
	}
	public function get_icon()
	{
		return 'sds-widget-ico';
	}
	public function get_categories()
	{
		return array('resido');
	}

	protected function _register_controls()
	{

		$this->start_controls_section(
			'general',
			array(
				'label' => esc_html__('General', 'resido-core'),
			)
		);

		$this->add_control(
			'heading',
			array(
				'label' => __('Header', 'resido-core'),
				'type'  => \Elementor\Controls_Manager::TEXT,
			)
		);

		$this->add_control(
			'title',
			array(
				'label'     => __('Title', 'resido-core'),
				'separator' => 'after',
				'type'      => \Elementor\Controls_Manager::TEXT,
			)
		);

		$this->add_control(
			'column',
			array(
				'label'   => esc_html__('Column', 'resido-core'),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'col-lg-6 col-md-6' => esc_html__('2', 'resido-core'),
					'col-lg-4 col-md-6' => esc_html__('3', 'resido-core'),
					'col-lg-3 col-md-6' => esc_html__('4', 'resido-core'),
				),
				'default' => 'col-lg-4 col-md-4',

			)
		);

		$this->add_control(
			'per_page',
			array(
				'label'   => esc_html__('Posts Per Page', 'resido-core'),
				'type'    => Controls_Manager::TEXT,
				'default' => '3',
			)
		);

		$this->add_control(
			'order',
			array(
				'label'   => __('Order', 'resido-core'),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'desc',
				'options' => array(
					'desc' => __('DESC', 'resido-core'),
					'asc'  => __('ASC', 'resido-core'),
				),
			)
		);

		$this->add_control(
			'button_label',
			array(
				'label'     => __('Label', 'resido-core'),
				'separator' => 'before',
				'type'      => \Elementor\Controls_Manager::TEXT,
			)
		);

		$this->end_controls_section();

		resido_public_heading_control($this, 'h4');

		resido_public_title_control($this, 'p');
	}
	protected function render()
	{
		$settings = $this->get_settings_for_display();

		// Header Func inp
		$public_header_tag = $settings['public_header_tag'];
		$heading           = $settings['heading'];
		$this->add_render_attribute('heading', 'class', 'typo-header-text');
		$this->add_inline_editing_attributes('heading', 'none');
		// Header Func inp

		// title Func inp
		$public_title_tag = $settings['public_title_tag'];
		$title            = $settings['title'];
		$this->add_render_attribute('title', 'class', 'typo-title-text');
		$this->add_inline_editing_attributes('title', 'none');
		// title Func inp

		$button_label = $settings['button_label'];

		$listing_option  = resido_listing_option();
		$currency_symbol = isset($listing_option['currency_symbol']) ? $listing_option['currency_symbol'] : '$';
		$args            = array(
			'posts_per_page' => $settings['per_page'],
			'post_type'      => 'pricing_plan',
			'order'          => $settings['order'],
			'no_found_rows'  => true,
		);

		$query = new \WP_Query($args);
?>

		<!-- ============================ Price Table Start ================================== -->
		<section>
			<div class="container">

				<div class="row justify-content-center">
					<div class="col-lg-7 col-md-10 text-center">
						<div class="sec-heading center">
							<!-- Header Func outp -->
							<<?php echo $public_header_tag; ?> <?php echo $this->get_render_attribute_string('heading'); ?>>
								<?php echo $heading; ?>
							</<?php echo $public_header_tag; ?>>
							<!-- Title Func outp -->
							<<?php echo $public_title_tag; ?> <?php echo $this->get_render_attribute_string('title'); ?>>
								<?php echo $title; ?>
							</<?php echo $public_title_tag; ?>>
						</div>
					</div>
				</div>

				<div class="row">

					<?php
					if ($query->have_posts()) :
						while ($query->have_posts()) :
							$query->the_post();
							$price 			= get_post_meta(get_the_ID(), '_price', true);
							$custom_url 	= get_post_meta(get_the_ID(), 'rlisting_pricing_custom_url', true);

					?>
							<!-- Single Package -->
							<div class="<?php echo $settings['column']; ?>">
								<div class="pricing-wrap <?php echo get_post_meta(get_the_ID(), 'rlisting_bg_type', true); ?>">
									<div class="pricing-header">
										<h4 class="pr-value"><sup><?php echo $currency_symbol; ?></sup><?php echo esc_html($price); ?></h4>
										<h4 class="pr-title"><?php the_title(); ?></h4>
									</div>
									<div class="pricing-body">
										<?php the_content(); ?>
									</div>

									<?php
									if ($button_label) {

										if (isset($custom_url) && !empty($custom_url)) {
									?><div class="pricing-bottom">
												<a href="<?php echo esc_html($custom_url); ?>" class="btn-pricing"><?php echo esc_html($button_label); ?></a>
											</div>
											<?php
										} else {
											if (!is_user_logged_in()) { ?>
												<div class="pricing-bottom">
													<a href="JavaScript:Void(0);" class="btn btn-theme-light-2 rounded" data-bs-toggle="modal" data-bs-target="#login"><?php echo esc_html($button_label); ?></a>
												</div>
											<?php } else { ?>
												<div class="pricing-bottom">
													<a href="javascript:void(0)" class="btn-pricing add-to-cart-custom" data-price="<?php echo $price; ?>" data-product_id="<?php echo get_the_ID(); ?>"><?php echo esc_html($button_label); ?></a>
												</div>
									<?php
											}
										}
									}
									?>

								</div>
							</div>

					<?php
						endwhile;
					endif;
					?>


				</div>

			</div>
		</section>
		<!-- ============================ Price Table End ================================== -->

<?php
	}
	protected function content_template()
	{
	}
}
