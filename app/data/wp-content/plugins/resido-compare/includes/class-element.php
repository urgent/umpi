<?php
class CompareElement
{











	public function __construct()
	{
		add_shortcode('resido_compare', [$this, 'compare_function']);
	}

	function compare_function($atts)
	{

		$compare_page_id = Resido_Compare_ClassGeneral::carleader_compare_option('compare_page');
		$compare_style   = Resido_Compare_ClassGeneral::carleader_compare_option('compare_style');

		if ($compare_style == false) {
			$compare_style = 'newpage';
		}

		if ($compare_page_id == 0) {
			$slug = 'comparing';
		} else {

			$compare_page = get_post($compare_page_id);
			$slug         = $compare_page->post_name;
		}
		$btnclass = 'compare_bt';

		if ($compare_style == 'popup') {
			$btnclass = 'compare_bt_pop compare-toggle';
		}

		if (!empty($atts['device'])) {
			if ($atts['device'] == 'mobile') {

				if ($compare_style == 'popup') {
					$btnclass .= ' compare_bt_pop compare-toggle';
				} else {
					$btnclass = 'compare_bt_mob';
				}
			}
		}

		if ($compare_style == 'newpage') {
			if (!empty($atts['prod_id'])) {
				$form_ir = 'comapreForm_' . $atts['prod_id'];
				if ($atts['device'] == 'mobile') {

					$form_ir = $form_ir . '_mob';
				}
				if ($atts['page'] == 'single') {

					$form_ir = $form_ir . '_single';
				}
			} else {
				$form_ir = 'comapreForm';
			}
?>

			<form id="<?php echo $form_ir; ?>" action="<?php echo home_url($slug); ?>" method="POST" class="comapreForm">

			<?php } ?>

			<?php
			if (!empty($atts['prod_id'])) {
			?>

				<input name="tDta" class="tDta" type="hidden" value="<?php echo $atts['prod_id']; ?>">
				<?php
				if ($atts['page'] == 'archive') {
				?>
					<a href="javascript:void(0)" title="<?php echo esc_html__('COMPARE', 'resido-compare'); ?>" class="tooltip  <?php echo $btnclass; ?>" data-product_id="<?php echo $atts['prod_id']; ?>"><i class="icon-compare"></i></a>
				<?php
				} elseif ($atts['page'] == 'single') {
				?>
					<a href="javascript:void(0)" class=" btn btn-color02 ee <?php echo $btnclass; ?>" data-product_id="<?php echo $atts['prod_id']; ?>"><i class="icon-compare"></i><?php echo esc_html__('compare', 'resido-compare'); ?></a>
				<?php } ?>
			<?php
			} else {
			?>
				<input name="headcompare" class="headcompare" type="hidden" value="<?php echo 'head'; ?>">
				<a href="javascript:void(0)" title="<?php echo esc_html__('COMPARE', 'resido-compare'); ?>" class="  tt-dropdown-toggle <?php echo $btnclass; ?>" data-product_id="<?php echo 0; ?>"><i class="icon-compare"></i>
				</a>
			<?php
			}
			?>
			<?php
			if ($compare_style == 'newpage') {
			?>

			</form>
		<?php } ?>
<?php
	}
}
new CompareElement();
