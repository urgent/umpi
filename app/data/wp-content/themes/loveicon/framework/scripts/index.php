<?php
class Loveicon_Scripts {

	public function __construct() {
		 add_action( 'wp_enqueue_scripts', array( $this, 'loveicon_enqueue_scripts' ) );
	}
	public function loveicon_enqueue_scripts() {
		wp_enqueue_script( 'aos', LOVEICON_JS_URL . 'aos.js', array( 'jquery' ), time(), true );
		wp_enqueue_script( 'appear', LOVEICON_JS_URL . 'appear.js', array( 'jquery' ), time(), true );
		wp_enqueue_script( 'bootstrap', LOVEICON_JS_URL . 'bootstrap.bundle.min.js', array( 'jquery' ), time(), true );
		wp_enqueue_script( 'bootstrap-select', LOVEICON_JS_URL . 'bootstrap-select.min.js', array( 'jquery' ), time(), true );
		wp_enqueue_script( 'isotope', LOVEICON_JS_URL . 'isotope.js', array( 'jquery' ), time(), true );
		wp_enqueue_script( 'bxslider', LOVEICON_JS_URL . 'bxslider.min.js', array( 'jquery' ), time(), true );
		wp_enqueue_script( 'countdown', LOVEICON_JS_URL . 'countdown.min.js', array( 'jquery' ), time(), true );
		wp_enqueue_script( 'countTo', LOVEICON_JS_URL . 'countTo.js', array( 'jquery' ), time(), true );
		wp_enqueue_script( 'easing', LOVEICON_JS_URL . 'easing.min.js', array( 'jquery' ), time(), true );
		wp_enqueue_script( 'enllax', LOVEICON_JS_URL . 'enllax.min.js', array( 'jquery' ), time(), true );
		wp_enqueue_script( 'fancybox', LOVEICON_JS_URL . 'fancybox.js', array( 'jquery' ), time(), true );
		wp_enqueue_script( 'magnific-popup', LOVEICON_JS_URL . 'magnific-popup.min.js', array( 'jquery' ), time(), true );
		wp_enqueue_script( 'paroller', LOVEICON_JS_URL . 'paroller.min.js', array( 'jquery' ), time(), true );
		wp_enqueue_script( 'knob', LOVEICON_JS_URL . 'knob.js', array( 'jquery' ), time(), true );
		wp_enqueue_script( 'owl', LOVEICON_JS_URL . 'owl.js', array( 'jquery' ), time(), true );
		wp_enqueue_script( 'pagenav', LOVEICON_JS_URL . 'pagenav.js', array( 'jquery' ), time(), true );
		wp_enqueue_script( 'parallax', LOVEICON_JS_URL . 'parallax.min.js', array( 'jquery' ), time(), true );
		wp_enqueue_script( 'scrollbar', LOVEICON_JS_URL . 'scrollbar.js', array( 'jquery' ), time(), true );
		wp_enqueue_script( 'slick', LOVEICON_JS_URL . 'slick.js', array( 'jquery' ), time(), true );
		wp_enqueue_script( 'timePicker', LOVEICON_JS_URL . 'timePicker.js', array( 'jquery' ), time(), true );
		wp_enqueue_script( 'validation', LOVEICON_JS_URL . 'validation.js', array( 'jquery' ), time(), true );
		wp_enqueue_script( 'wow', LOVEICON_JS_URL . 'wow.js', array( 'jquery' ), time(), true );
		wp_enqueue_script( 'tween-max', LOVEICON_JS_URL . 'TweenMax.min.js', array( 'jquery' ), time(), true );
		wp_enqueue_script( 'sidebar-content', LOVEICON_JS_URL . 'sidebar-content.js', array( 'jquery' ), time(), true );
		wp_enqueue_script( 'loveicon-custom', LOVEICON_JS_URL . 'custom.js', array( 'jquery' ), time(), true );
	}
}
$loveicon_scripts = new Loveicon_Scripts();
