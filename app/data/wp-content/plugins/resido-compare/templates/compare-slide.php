<?php
$td = '';
function carleader_car_test_ajax()
{
	if (!empty($_POST['tDta'])) {
		$td = $_POST['tDta'];
	} else {
		$td = '';
	}
	$_SESSION['products'][] = $td;
	$_SESSION['products']   = array_unique($_SESSION['products']);
	$args                   = array(
		'post_type'      => 'carleader-listing',
		'posts_per_page' => 3,
		'post__in'       => $_SESSION['products'],
	);
	$query                  = new WP_Query($args);
?>
	<div class="col-value">
		<ul>
			<li><?php echo esc_html__('Price:', 'resido-compare'); ?></li>
			<li><?php echo esc_html__('Make:', 'resido-compare'); ?></li>
			<li><?php echo esc_html__('Model:', 'resido-compare'); ?></li>
			<li><?php echo esc_html__('MILEAGE:', 'resido-compare'); ?></li>
			<li><?php echo esc_html__('FUEL TYPE:', 'resido-compare'); ?></li>
			<li><?php echo esc_html__('YEAR:', 'resido-compare'); ?></li>
			<li><?php echo esc_html__('TRANSMission:', 'resido-compare'); ?></li>
			<li><?php echo esc_html__('Drive Type:', 'resido-compare'); ?></li>
			<li><?php echo esc_html__('Color:', 'resido-compare'); ?></li>
			<li><?php echo esc_html__('Int. Color:', 'resido-compare'); ?></li>
			<li><?php echo esc_html__('VIN:', 'resido-compare'); ?></li>
			<li><?php echo esc_html__('Engine:', 'resido-compare'); ?></li>
			<li><?php echo esc_html__('Stock number:', 'resido-compare'); ?></li>
		</ul>
	</div>
	<?php
	while ($query->have_posts()) :
		$query->the_post();
		$status       = carleader_listings_meta('condition');
		$make         = carleader_listings_meta('make_display');
		$curent_time  = current_time('d');
		$post_time    = get_the_date('d');
		$diff_time    = $curent_time - $post_time;
		$miles        = carleader_listings_meta('miles');
		$model_name   = carleader_listings_meta('model_name');
		$price        = carleader_listings_meta('price');
		$old_price    = carleader_listings_meta('old_price');
		$fuel_type    = carleader_listings_meta('model_engine_fuel');
		$transmission = carleader_listings_meta('model_transmission_type');
		$drive        = carleader_listings_meta('drivetrain');
		$color        = carleader_listings_meta('color');
		$int_color    = carleader_listings_meta('int_color');
		$hp           = carleader_listings_meta('hp');
		$est_loan     = carleader_listings_meta('loan_payment');
		$year         = carleader_listings_meta('model_year');
		$vin          = carleader_listings_meta('vin');
		$engine       = carleader_listings_meta('engine');
		$stock        = carleader_listings_meta('stock');

		if ($drive == 'awd') {
			$drive = esc_html__('All-Wheel Drive', 'resido-listing');
		} elseif ($drive == 'fwd') {
			$drive = esc_html__('Four-WHEEL DRIVE', 'resido-listing');
		} elseif ($drive == 'frwd') {
			$drive = esc_html__('Front-Wheel Drive', 'resido-listing');
		} elseif ($drive == 'rwd') {
			$drive = esc_html__('Rear-Wheel Drive', 'resido-listing');
		}
		if ($transmission == 'at') {
			$transmission = esc_html__('Automatic Transmission', 'resido-listing');
		} elseif ($transmission == 'mt') {
			$transmission = esc_html__('Manual Transmission', 'resido-listing');
		} elseif ($transmission == 'am') {
			$transmission = esc_html__('Automated Manual Transmission', 'resido-listing');
		} elseif ($transmission == 'cvt') {
			$transmission = esc_html__('Continuously Variable Transmission', 'resido-listing');
		}
	?>
		<div class="col-item">
			<a href="#" class="item-close"><i class="icon-close"></i></a>
			<div id="divid" class="pidclass" style="display: none;"><?php echo get_the_ID(); ?></div>
			<div class="img-obj"><?php the_post_thumbnail(); ?></div>
			<ul>
				<li class="value-item value-select"><?php echo carleader_listings_price($price); ?></li>
				<li class="value-item"><?php the_title(); ?></li>
				<li class="value-item"><?php echo $model_name; ?></li>
				<li class="value-item"><?php echo carleader_listings_miles($miles); ?></li>
				<li class="value-item"><?php echo $fuel_type; ?></li>
				<li class="value-item"><?php echo $year; ?></li>
				<li class="value-item"><?php echo $transmission; ?></li>
				<li class="value-item"><?php echo $drive; ?></li>
				<li class="value-item"><?php echo $color; ?></li>
				<li class="value-item"><?php echo $int_color; ?></li>
				<li class="value-item"><?php echo $vin; ?></li>
				<li class="value-item"><?php echo $engine; ?></li>
				<li class="value-item"><?php echo $stock; ?></li>
			</ul>
		</div>
<?php
	endwhile;
	exit();
}
add_action('wp_ajax_car_test_ajax', 'carleader_car_test_ajax');
add_action('wp_ajax_nopriv_car_test_ajax', 'carleader_car_test_ajax');
