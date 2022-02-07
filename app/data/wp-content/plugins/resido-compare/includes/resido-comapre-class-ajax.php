<?php

class Resido_Compare_ClassAjaxFunc
{

	public static function carleader_compare_car_item_remove()
	{

		$delDta = $_POST['ptDta'];
		$data   = 0;
		if (($key = array_search($delDta, $_SESSION['products'])) !== false) {
			unset($_SESSION['products'][$key]);
		}
		$_SESSION['products'] = array_filter($_SESSION['products']);
		if (empty($_SESSION['products'])) {
			unset($_POST['tDta']);
			unset($_SESSION['products']);
			$data = 1;
		}
		echo $data;
		exit();
	}
}

new Resido_Compare_ClassAjaxFunc();
