<?php if (resido_get_average_rate(get_the_ID())) { ?>


	<!-- Review Block Wrap -->
	<div class="rating-overview">
		<div class="rating-overview-box">
			<span class="rating-overview-box-total"><?php echo resido_get_average_rate(get_the_ID()); ?></span>
			<span class="rating-overview-box-percent"><?php _e('out of 5.0', 'resido-listing'); ?></span>
			<div class="star-rating" data-rating="5">
				<?php
				$average = resido_get_average_rate(get_the_ID());
				$averageRounded = ceil($average);
				if ($averageRounded) {
					$active_comment_rate = $averageRounded;
					for ($x = 1; $x <= $active_comment_rate; $x++) {
						echo '<i class="fa fa-star filled"></i>';
					}
					$inactive_comment_rate = 5 - $active_comment_rate;
					if ($inactive_comment_rate > 0) {
						for ($x = 1; $x <= $inactive_comment_rate; $x++) {
							echo '<i class="fa fa-star"></i>';
						}
					}
				}
				?>
			</div>
		</div>
		<?php
		$total_ratting = resido_get_average_ratting_name(get_the_ID());
		$service_width = '';
		$money_width = '';
		$cleanliness_width = '';
		$location_width = '';

		if ($total_ratting['service']) {
			$service_width = ($total_ratting['service'] * 100) / 5;
		}

		if ($total_ratting['money']) {
			$money_width = ($total_ratting['money'] * 100) / 5;
		}

		if ($total_ratting['cleanliness']) {
			$cleanliness_width = ($total_ratting['cleanliness'] * 100) / 5;
		}

		if ($total_ratting['location']) {
			$location_width = ($total_ratting['location'] * 100) / 5;
		}

		if ($service_width < 30) {
			$service_width_class = "poor";
		} else if ($service_width < 60) {
			$service_width_class = "mid";
		} else {
			$service_width_class = "high";
		}
		if ($money_width < 30) {
			$money_width_class = "poor";
		} else if ($money_width < 60) {
			$money_width_class = "mid";
		} else {
			$money_width_class = "high";
		}
		if ($cleanliness_width < 30) {
			$cleanliness_width_class = "poor";
		} else if ($cleanliness_width < 60) {
			$cleanliness_width_class = "mid";
		} else {
			$cleanliness_width_class = "high";
		}
		if ($location_width < 30) {
			$location_width_class = "poor";
		} else if ($location_width < 60) {
			$location_width_class = "mid";
		} else {
			$location_width_class = "high";
		}

		?>
		<div class="rating-bars">
			<?php
			if ($service_width) { ?>
				<div class="rating-bars-item">
					<span class="rating-bars-name"><?php _e('Service', 'resido-listing'); ?></span>
					<span class="rating-bars-inner">
						<span class="rating-bars-rating <?php echo $service_width_class; ?>" data-rating="<?php echo round($total_ratting['service'], 1); ?>">
							<span class="rating-bars-rating-inner" style="width: <?php echo round($service_width); ?>%;"></span>
						</span>
						<strong>
							<?php echo round($total_ratting['service'], 1); ?>
						</strong>
					</span>
				</div>
			<?php }
			if ($money_width) { ?>
				<div class="rating-bars-item">
					<span class="rating-bars-name"><?php _e('Price', 'resido-listing'); ?></span>
					<span class="rating-bars-inner">
						<span class="rating-bars-rating <?php echo $money_width_class; ?>" data-rating="<?php echo round($total_ratting['money'], 1); ?>">
							<span class="rating-bars-rating-inner" style="width: <?php echo round($money_width); ?>%;"></span>
						</span>
						<strong><?php echo round($total_ratting['money'], 1); ?></strong>
					</span>
				</div>
			<?php }
			if ($cleanliness_width) { ?>
				<div class="rating-bars-item">
					<span class="rating-bars-name"><?php _e('Quality', 'resido-listing'); ?></span>
					<span class="rating-bars-inner">
						<span class="rating-bars-rating <?php echo $cleanliness_width_class; ?>" data-rating="<?php echo round($total_ratting['cleanliness'], 1); ?>">
							<span class="rating-bars-rating-inner" style="width: <?php echo round($cleanliness_width); ?>%;"></span>
						</span>
						<strong><?php echo round($total_ratting['cleanliness'], 1); ?></strong>
					</span>
				</div>
			<?php }
			if ($location_width) { ?>
				<div class="rating-bars-item">
					<span class="rating-bars-name"><?php _e('Location', 'resido-listing'); ?></span>
					<span class="rating-bars-inner">
						<span class="rating-bars-rating <?php echo $location_width_class; ?>" data-rating="<?php echo round($total_ratting['location'], 1); ?>">
							<span class="rating-bars-rating-inner" style="width:<?php echo round($location_width); ?>%;"></span>
						</span>
						<strong><?php echo round($total_ratting['location'], 1); ?></strong>
					</span>
				</div>
			<?php } ?>
		</div>
	</div>

<?php
}
