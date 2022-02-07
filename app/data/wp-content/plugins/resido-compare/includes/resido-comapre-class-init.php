<?php

class Resido_Compare_Init
{


	/**
	 * __construct
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->resido_compare_require_all();
		$this->resido_compare_actions();
	}

	/**
	 * Sds_require_all require all files
	 *
	 * @return void
	 */
	private function resido_compare_require_all()
	{

		include_once RESIDO_COMPARE_PLUGIN_DIR . 'includes/resido-comapre-class-activate.php';
		include_once RESIDO_COMPARE_PLUGIN_DIR . 'includes/resido-comapre-class-genarals.php';
		include_once RESIDO_COMPARE_PLUGIN_DIR . 'includes/resido-comapre-class-settings.php';
		include_once RESIDO_COMPARE_PLUGIN_DIR . 'includes/resido-comapre-class-ajax.php';
		include_once RESIDO_COMPARE_PLUGIN_DIR . 'includes/resido-comapre-class-actions.php';
		include_once RESIDO_COMPARE_PLUGIN_DIR . 'includes/class-scripts.php';
		include_once RESIDO_COMPARE_PLUGIN_DIR . 'includes/class-element.php';
		$compare_style = Resido_Compare_ClassGeneral::carleader_compare_option('compare_style');
		if ($compare_style == false) {
			$compare_style = 'newpage';
		}

		if ($compare_style == 'popup') {
			include_once RESIDO_COMPARE_PLUGIN_DIR . 'templates/compare-slide.php';
		} else {

			include_once RESIDO_COMPARE_PLUGIN_DIR . 'includes/class-shortcode.php';
		}
	}

	private function resido_compare_actions()
	{

		new Resido_Compare_Actions();
	}
}

new Resido_Compare_Init();
