<?php
class Loveicon_Style {
	public function __construct() {
		add_action( 'wp_enqueue_scripts', array( $this, 'loveicon_enqueue_style' ), 20 );
	}
	public function loveicon_enqueue_style() {

		wp_enqueue_style( 'aos', LOVEICON_CSS_URL . 'aos.css', false, time() );
		wp_enqueue_style( 'bootstrap', LOVEICON_CSS_URL . 'bootstrap.min.css', false, time() );
		wp_enqueue_style( 'imp', LOVEICON_CSS_URL . 'imp.css', false, time() );
		wp_enqueue_style( 'loveicon-custom-animate', LOVEICON_CSS_URL . 'custom-animate.css', false, time() );
		wp_enqueue_style( 'flaticon', LOVEICON_CSS_URL . 'flaticon.css', false, time() );
		wp_enqueue_style( 'font-awesome', LOVEICON_CSS_URL . 'font-awesome.min.css', false, time() );
		wp_enqueue_style( 'owl', LOVEICON_CSS_URL . 'owl.css', false, time() );
		wp_enqueue_style( 'magnific-popup', LOVEICON_CSS_URL . 'magnific-popup.css', false, time() );
		wp_enqueue_style( 'scrollbar', LOVEICON_CSS_URL . 'scrollbar.css', false, time() );
		wp_enqueue_style( 'hiddenbar', LOVEICON_CSS_URL . 'hiddenbar.css', false, time() );
		wp_enqueue_style( 'icomoon', LOVEICON_CSS_URL . 'icomoon.css', false, time() );
		wp_enqueue_style( 'loveicon-header-section', LOVEICON_CSS_URL . '/module-css/header-section.css', false, time() );
		wp_enqueue_style( 'loveicon-breadcrumb-section', LOVEICON_CSS_URL . '/module-css/breadcrumb-section.css', false, time() );
		wp_enqueue_style( 'loveicon-blog-section', LOVEICON_CSS_URL . '/module-css/blog-section.css', false, time() );
		wp_enqueue_style( 'loveicon-footer-section', LOVEICON_CSS_URL . '/module-css/footer-section.css', false, time() );
		wp_enqueue_style( 'loveicon-about-section', LOVEICON_CSS_URL . '/module-css/about-section.css', false, time() );
		wp_enqueue_style( 'loveicon-event-section', LOVEICON_CSS_URL . '/module-css/event-section.css', false, time() );
		wp_enqueue_style( 'loveicon-cause-section', LOVEICON_CSS_URL . '/module-css/cause-section.css', false, time() );
		wp_enqueue_style( 'loveicon-color', LOVEICON_CSS_URL . 'color.css', false, time() );
		wp_enqueue_style( 'loveicon-theme-color', LOVEICON_CSS_URL . 'color/theme-color.css', false, time() );
		wp_enqueue_style( 'animate', LOVEICON_CSS_URL . 'animate.css', false, time() );
		wp_enqueue_style( 'bootstrap-select', LOVEICON_CSS_URL . 'bootstrap-select.min.css', false, time() );
		wp_enqueue_style( 'date-picker', LOVEICON_CSS_URL . 'date-picker.css', false, time() );
		wp_enqueue_style( 'bxslider', LOVEICON_CSS_URL . 'bxslider.css', false, time() );
		wp_enqueue_style( 'fancybox', LOVEICON_CSS_URL . 'fancybox.min.css', false, time() );
		wp_enqueue_style( 'm-customScrollbar', LOVEICON_CSS_URL . 'm-customScrollbar.css', false, time() );
		wp_enqueue_style( 'slick', LOVEICON_CSS_URL . 'slick.css', false, time() );
		wp_enqueue_style( 'timePicker', LOVEICON_CSS_URL . 'timePicker.css', false, time() );
		wp_enqueue_style( 'bootstrap-touchspin', LOVEICON_CSS_URL . 'bootstrap-touchspin.css', false, time() );
		wp_enqueue_style( 'loveicon-style', get_stylesheet_uri(), null, time() );
		wp_enqueue_style( 'loveicon-responsive', LOVEICON_CSS_URL . 'responsive.css', false, time() );
		wp_enqueue_style( 'loveicon-theme-style', LOVEICON_CSS_URL . 'theme-style.css', false, time() );
		if ( function_exists( 'loveicon_daynamic_styles' ) ) {
			wp_add_inline_style( 'loveicon-theme-style', loveicon_daynamic_styles() );
		}

		$loveicon_custom_inline_style = '';
		if ( function_exists( 'loveicon_get_custom_styles' ) ) {
			$loveicon_custom_inline_style = loveicon_get_custom_styles();
		}
		wp_add_inline_style( 'loveicon-theme-style', $loveicon_custom_inline_style );

	}
}
$loveicon_style = new Loveicon_Style();