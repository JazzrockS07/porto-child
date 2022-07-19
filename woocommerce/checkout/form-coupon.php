<?php
/**
 * Checkout coupon form
 *
 * @version     3.4.4
 */

defined( 'ABSPATH' ) || exit;

$porto_woo_version = porto_get_woo_version_number();
$checkout_ver      = porto_checkout_version();

if ( !( version_compare($porto_woo_version, '2.5', '<') ? WC()->cart->coupons_enabled() : wc_coupons_enabled() ) ) { // @codingStandardsIgnoreLine.
	return;
}

?>


			<form class="checkout_coupon" method="post" style="display:none">
				<div class="featured-box align-left">
					<div class="box-content">
						<p><?php esc_html_e( 'If you have a coupon code, please apply it below.', 'woocommerce' ); ?></p>
						<p class="form-row form-row-first">
							<input type="text" name="coupon_code" class="input-text py-0" placeholder="<?php esc_attr_e( 'Coupon code', 'woocommerce' ); ?>" id="coupon_code" value="" />
						</p>
						<p class="form-row form-row-last">
							<button type="submit" class="btn button wc-action-btn wc-action-sm" name="apply_coupon" value="<?php esc_attr_e( 'Apply coupon', 'woocommerce' ); ?>"><?php esc_html_e( 'Apply coupon', 'woocommerce' ); ?></button>
						</p>
						<div class="clear"></div>
						<div class="coupon-notice-checkout">אין כפל הנחה להנחות כמות עם קופון</div>
					</div>
				</div>
			</form>


