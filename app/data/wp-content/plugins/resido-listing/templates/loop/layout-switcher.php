<?php

/**
 * Layout Switcher
 *
 * This template can be overridden by copying it to yourtheme/resido-listings/loop/layout-switcher.php.
 */
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
// global $wp_query;
?>
<ul class="shorting-list">
    <li><a class="grid-view <?php echo esc_html($grid_class); ?>" href="#"><i class="ti-layout-grid2"></i></a></li>
    <li><a class="list-view <?php echo esc_html($list_class); ?>" href="#"><i class="ti-view-list"></i></a></li>
</ul>
<input type="hidden" id="layout" name="layout" value="<?php echo esc_html($layout_view); ?>">