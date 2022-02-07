<?php

class Resido_Compare_ClassScripts
{


	public static function required_scripts()
	{
		wp_enqueue_script('compare-main-script', RESIDO_PLUGIN_URI . 'js/main.js', array('jquery'));
	}
}

new Resido_Compare_ClassScripts();
