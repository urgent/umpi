	<!-- Statics Info -->
	<div class="tr-single-box">
		<div class="tr-single-header">
			<h4><i class="ti-bar-chart"></i> <?php echo esc_html__('Statics Info', 'resido-listing'); ?></h4>
		</div>
		<div class="tr-single-body">
			<ul class="extra-service half">
				<li>
					<div class="icon-box-icon-block">
						<div class="icon-box-round">
							<i class="ti-star"></i>
						</div>
						<div class="icon-box-text">
							<?php
							$average_rate = resido_get_average_rate(get_the_ID());
							echo $average_rate ? $average_rate : '0';
							?> <?php echo esc_html__('Rating', 'resido-listing'); ?>
						</div>
					</div>
				</li>
				<li>
					<div class="icon-box-icon-block">
						<div class="icon-box-round">
							<i class="ti-bookmark"></i>
						</div>
						<div class="icon-box-text">
							<?php
							$users = get_users(
								array(
									'meta_query' => array(
										array(
											'key' => '_favorite_posts',
											'value' => get_the_ID(),
										),
									),
								)
							);
							$users = count($users);
							echo $users ? $users : '0';

							?>
							<?php echo esc_html__('Bookmark', 'resido-listing'); ?>
						</div>
					</div>
				</li>

				<li>
					<div class="icon-box-icon-block">
						<div class="icon-box-round">
							<i class="ti-eye"></i>
						</div>
						<div class="icon-box-text">
							<?php
							$views_count = get_post_meta(get_the_ID(), 'post_views_count', true);
							echo $views_count ? $views_count : '0';
							?>
						</div>
					</div>
				</li>

				<li>
					<div class="icon-box-icon-block">
						<div class="icon-box-round">
							<i class="ti-comment-alt"></i>
						</div>
						<div class="icon-box-text">
							<?php
							$single_comments = get_comments(array('post_id' => get_the_ID()));
							$comments = (int) count($single_comments);
							echo $comments ? $comments : '0';
							?>
							<?php echo esc_html__('Comments', 'resido-listing'); ?>
						</div>
					</div>
				</li>
			</ul>
		</div>
	</div>