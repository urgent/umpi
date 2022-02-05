<?php
/**
 * Displays the donate button to be displayed on campaign pages.
 *
 * Override this template by copying it to yourtheme/charitable/campaign-loop/donate-modal.php
 *
 * @author  Studio 164a
 * @package Charitable/Templates/Campaign
 * @since   1.2.3
 * @version 1.6.29
 */

$campaign = $view_args['campaign'];

?>
<div class="campaign-donation">
	<a data-trigger-modal="charitable-donation-form-modal-loop"
		data-campaign-id="<?php echo $campaign->ID; ?>"
		class="<?php echo esc_attr( charitable_get_button_class( 'donate' ) ); ?>"
		href="<?php echo esc_url( charitable_get_permalink( 'campaign_donation_page', array( 'campaign_id' => $campaign->ID ) ) ); ?>"
		aria-label="<?php esc_attr_e( sprintf( _x( 'Make a donation to %s', 'make a donation to campaign', 'charitable' ), get_the_title( $campaign->ID ) ) ); ?>">
		<?php _e( 'Donate', 'charitable' ); ?>
	</a>
</div>
