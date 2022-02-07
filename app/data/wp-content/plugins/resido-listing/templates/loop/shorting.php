<?php
/**
 * Ordering
 *
 * This template can be overridden by copying it to yourtheme/resido-listings/loop/orderby.php.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
global $wp_query;
$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
$s_new = '';
$s_old = '';
$s_hig = '';
$s_def = '';
if ( isset( $_COOKIE['sort_by_order'] ) && ! empty( $_COOKIE['sort_by_order'] ) ) {
	if ( $_COOKIE['sort_by_order'] == 'new_listing' ) {
		$s_new = 'selected';
	} elseif ( $_COOKIE['sort_by_order'] == 'old_listing' ) {
		$s_old = 'selected';
	} elseif ( $_COOKIE['sort_by_order'] == 'high_rated' ) {
		$s_hig = 'selected';
	} else {
		$s_def = 'selected';
	}
}
?>
<div class="item-shorting-box">
	<div class="item-shorting clearfix">
		<div class="left-column pull-left">
			<h4 class="m-0">
				<span class="change_item_count">
					<?php
					if ( isset( $post_on_page ) && ! empty( $post_on_page ) ) {
						echo esc_html__( 'Showing ', 'resido-listing' );
						echo $post_on_page;
					}
					?>
				</span>
				<?php echo esc_html__( ' of ', 'resido-listing' ); ?>
				<?php
				echo $wp_query->found_posts;
				echo esc_html__( ' Results', 'resido-listing' );
				?>
			</h4>
		</div>
	</div>
	<div class="item-shorting-box-right">
		<div class="shorting-by">
			<select name="sort_by_order" id="sort_by_order" class="form-control">
				<option <?php echo $s_def; ?> value="default"><?php echo esc_html__( 'Default', 'resido-listing' ); ?>
				</option>
				<option <?php echo $s_new; ?> value="new_listing">
					<?php echo esc_html__( 'New Listings', 'resido-listing' ); ?></option>
				<option <?php echo $s_old; ?> value="old_listing">
					<?php echo esc_html__( 'Old Listings', 'resido-listing' ); ?></option>
				<option <?php echo $s_hig; ?> value="high_rated">
					<?php echo esc_html__( 'High Rated', 'resido-listing' ); ?></option>
			</select>
		</div>
		<ul class="shorting-list">
			<li><a class="grid-view <?php echo esc_html( $grid_class ); ?>" href="#"><i class="ti-layout-grid2"></i></a>
			</li>
			<li><a class="list-view <?php echo esc_html( $list_class ); ?>" href="#"><i class="ti-view-list"></i></a></li>
		</ul>
		<input type="hidden" id="paged_var" name="paged" value="<?php echo esc_html( $paged ); ?>">
	</div>
</div>
