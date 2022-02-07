<?php

class Resido_Compare_ClassGeneral
{

	/**
	 * __construct
	 *
	 * @return void
	 */
	public function __construct()
	{
	}

	public static function fotter_pop()
	{     ?>
		<div id="compareSlide" class="layout-slide">
			<div class="slide-content">
				<div class="slide-title">
					<h6 class="title"><?php echo esc_html__('Compare Vehicles:', 'resido-compare'); ?></h6>
					<a class="btn-close-slide icon-close"></a>
				</div>
				<div class="tt-wrapper-col">


				</div>
			</div>
		</div>
<?php
	}

	public static function carleader_compare_option($option)
	{
		$options = get_option('carleader_compare_options');
		$return  = isset($options[$option]) ? $options[$option] : false;
		return $return;
	}
}
new Resido_Compare_ClassGeneral();
